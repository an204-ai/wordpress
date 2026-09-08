<?php
require_once __DIR__ . '/wp-load.php';

foreach ([9, 11] as $post_id) {
    $elem_raw = get_post_meta($post_id, '_elementor_data', true);
    $elem = json_decode($elem_raw, true);
    echo "=== POST $post_id (" . get_the_title($post_id) . ") ===\n";
    
    function find_service_widgets($elements) {
        foreach ($elements as $el) {
            $widgetType = $el['widgetType'] ?? '';
            $settings = $el['settings'] ?? [];
            if (in_array($widgetType, ['accordion', 'toggle', 'nested-accordion', 'html']) || !empty($settings['tabs']) || !empty($settings['selected_icon'])) {
                echo "Found widgetType: $widgetType (id: {$el['id']})\n";
                if (!empty($settings['tabs'])) {
                    echo "  TABS:\n";
                    foreach ($settings['tabs'] as $t) {
                        echo "    - Tab Title: " . ($t['tab_title'] ?? '') . "\n";
                        echo "      Tab Content: " . substr(strip_tags($t['tab_content'] ?? ''), 0, 100) . "...\n";
                    }
                }
            }
            // Check headings with "Dịch Vụ"
            if ($widgetType === 'heading' && str_contains($settings['title'] ?? '', 'Dịch Vụ')) {
                echo "Found heading: " . $settings['title'] . " (id: {$el['id']})\n";
            }
            if (!empty($el['elements'])) {
                find_service_widgets($el['elements']);
            }
        }
    }
    
    find_service_widgets($elem);
}

