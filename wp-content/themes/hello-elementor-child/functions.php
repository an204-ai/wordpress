<?php
/**
 * Hello Elementor Child - EuroStyle Functions
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'EUROSTYLE_CHILD_VERSION', '1.5.8' );

/**
 * Enqueue scripts and styles.
 */
function eurostyle_enqueue_scripts() {
	// Enqueue Google Fonts (Lora for luxury headings with flawless Vietnamese diacritics & full-height numbers, Montserrat for body)
	wp_enqueue_style( 
		'fountainhead-google-fonts', 
		'https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,500;0,600;0,700;1,400;1,600&family=Montserrat:wght@300;400;500;600;700&display=swap', 
		[], 
		null 
	);

	// Enqueue Parent Style
	wp_enqueue_style( 'hello-elementor-theme-style', get_template_directory_uri() . '/style.css', [], HELLO_ELEMENTOR_VERSION );

	// Enqueue Child Style
	wp_enqueue_style( 'fountainhead-child-style', get_stylesheet_directory_uri() . '/style.css', [ 'hello-elementor-theme-style' ], EUROSTYLE_CHILD_VERSION );
}
add_action( 'wp_enqueue_scripts', 'eurostyle_enqueue_scripts', 20 );

/**
 * Register Navigation Menus
 */
function eurostyle_register_menus() {
	register_nav_menus( [
		'eurostyle-main-menu' => __( 'EuroStyle Main Menu', 'hello-elementor-child' ),
		'eurostyle-footer-menu' => __( 'EuroStyle Footer Menu', 'hello-elementor-child' ),
	] );
}
add_action( 'after_setup_theme', 'eurostyle_register_menus' );

/**
 * Register Custom Post Type Dự Án (du_an) using standard WordPress tables (wp_posts & wp_postmeta)
 */
function eurostyle_register_cpt_du_an() {
	$labels = [
		'name'               => __( 'Dự án', 'hello-elementor-child' ),
		'singular_name'      => __( 'Dự án', 'hello-elementor-child' ),
		'add_new'            => __( 'Thêm dự án', 'hello-elementor-child' ),
		'add_new_item'       => __( 'Thêm dự án mới', 'hello-elementor-child' ),
		'edit_item'          => __( 'Sửa dự án', 'hello-elementor-child' ),
		'new_item'           => __( 'Dự án mới', 'hello-elementor-child' ),
		'view_item'          => __( 'Xem dự án', 'hello-elementor-child' ),
		'search_items'       => __( 'Tìm kiếm dự án', 'hello-elementor-child' ),
		'not_found'          => __( 'Không tìm thấy dự án', 'hello-elementor-child' ),
		'menu_name'          => __( 'Dự án', 'hello-elementor-child' ),
	];

	$args = [
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => [ 'slug' => 'du_an', 'with_front' => false ],
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_position'      => 5,
		'menu_icon'          => 'dashicons-portfolio',
		'supports'           => [ 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ],
	];

	register_post_type( 'du_an', $args );
}
add_action( 'init', 'eurostyle_register_cpt_du_an' );

/**
 * Ensure both /du_an/ and /du-an/ reliably open the Projects page without permanent browser caching
 */
add_action( 'template_redirect', function() {
	$uri = trim( parse_url( $_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH ), '/' );
	// If visiting /wordpress/du_an or /du_an (without a single project slug)
	if ( $uri === 'wordpress/du_an' || $uri === 'du_an' ) {
		wp_safe_redirect( home_url( '/du-an/' ), 302 );
		exit;
	}
} );

// Prevent browser from caching redirects
add_action( 'send_headers', function() {
	header( 'Cache-Control: no-cache, must-revalidate, max-age=0' );
} );

/**
 * Load Project Meta Box & Custom Fields
 */
require_once get_stylesheet_directory() . '/inc/project-meta-box.php';
require_once get_stylesheet_directory() . '/inc/brand-marquee.php';
require_once get_stylesheet_directory() . '/inc/contact-manager.php';
require_once get_stylesheet_directory() . '/inc/seo-manager.php';

/**
 * Register Custom Elementor Category & Widgets
 */
add_action( 'elementor/elements/categories_registered', function( $elements_manager ) {
	$elements_manager->add_category(
		'fountainhead-elements',
		[
			'title' => esc_html__( 'Fountainhead Luxury Elements', 'hello-elementor-child' ),
			'icon'  => 'fa fa-gem',
		]
	);
} );

add_action( 'elementor/widgets/register', function( $widgets_manager ) {
	require_once get_stylesheet_directory() . '/inc/widgets/hero-slider-widget.php';
	$widgets_manager->register( new \Fountainhead_Hero_Slider_Widget() );

	require_once get_stylesheet_directory() . '/inc/widgets/featured-projects-widget.php';
	$widgets_manager->register( new \Fountainhead_Featured_Project_Slider_Widget() );
} );

add_filter( 'request', function( $vars ) {
	if ( ! is_admin() && isset( $vars['post_type'] ) && $vars['post_type'] === 'du_an' && ! isset( $vars['name'] ) ) {
		unset( $vars['post_type'] );
		$vars['pagename'] = 'du-an';
	}
	return $vars;
}, 1 );

/**
 * Shortcode for Homepage: Latest News (Tin tức nổi bật)
 * Usage: [eurostyle_home_latest_news limit="3"]
 */
function eurostyle_home_latest_news_shortcode( $atts = [] ) {
	$atts = shortcode_atts( [
		'limit' => 3,
	], $atts, 'eurostyle_home_latest_news' );

	$query = new WP_Query( [
		'post_type'      => 'post',
		'post_status'    => 'publish',
		'posts_per_page' => intval( $atts['limit'] ),
		'orderby'        => 'date',
		'order'          => 'DESC',
		'ignore_sticky_posts' => true,
	] );

	if ( ! $query->have_posts() ) {
		return '';
	}

	ob_start();
	?>
	<div class="es-home-news-grid">
		<?php
		while ( $query->have_posts() ) :
			$query->the_post();
			$post_id   = get_the_ID();
			$post_link = get_permalink( $post_id );
			$title     = get_the_title( $post_id );
			$date      = get_the_date( 'd.m.Y', $post_id );
			$cats      = get_the_category( $post_id );
			$cat_name  = ! empty( $cats ) ? $cats[0]->name : __( 'Tin tức', 'hello-elementor-child' );
			$thumb_url = has_post_thumbnail( $post_id )
				? get_the_post_thumbnail_url( $post_id, 'large' )
				: home_url( '/wp-content/uploads/2026/09/tin-tuc-tong-thau.jpg' );
		?>
			<article class="es-home-news-card">
				<a href="<?php echo esc_url( $post_link ); ?>" class="es-home-news-thumb-link" aria-label="<?php echo esc_attr( $title ); ?>">
					<div class="es-home-news-thumb-wrap">
						<img decoding="async" src="<?php echo esc_url( $thumb_url ); ?>" alt="<?php echo esc_attr( $title ); ?>" class="es-home-news-img" loading="lazy" />
					</div>
				</a>
				<div class="es-home-news-meta">
					<span class="es-home-news-date"><?php echo esc_html( $date ); ?></span>
					<span class="es-home-news-dot">•</span>
					<span class="es-home-news-cat"><?php echo esc_html( $cat_name ); ?></span>
				</div>
				<h3 class="es-home-news-title">
					<a href="<?php echo esc_url( $post_link ); ?>">
						<?php echo esc_html( $title ); ?>
					</a>
				</h3>
				<div class="es-home-news-footer">
					<a href="<?php echo esc_url( $post_link ); ?>" class="es-home-news-readmore">
						<span class="es-readmore-line"></span>
						<span class="es-readmore-text"><?php esc_html_e( 'Xem thêm', 'hello-elementor-child' ); ?></span>
						<svg class="es-readmore-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
							<path d="M5 12h14"></path>
							<path d="M12 5l7 7-7 7"></path>
						</svg>
					</a>
				</div>
			</article>
		<?php
		endwhile;
		wp_reset_postdata();
		?>
	</div>
	<?php
	return ob_get_clean();
}
add_shortcode( 'eurostyle_home_latest_news', 'eurostyle_home_latest_news_shortcode' );
add_shortcode( 'fountainhead_home_latest_news', 'eurostyle_home_latest_news_shortcode' );

/**
 * Shortcode for Homepage: Dynamic Featured Projects Grid from Database
 * Usage: [fountainhead_home_projects limit="4"]
 */
function fountainhead_home_projects_shortcode( $atts = [] ) {
	$atts = shortcode_atts( [
		'limit' => 4,
	], $atts, 'fountainhead_home_projects' );

	$query = new WP_Query( [
		'post_type'      => 'du_an',
		'post_status'    => 'publish',
		'posts_per_page' => intval( $atts['limit'] ),
		'orderby'        => 'date',
		'order'          => 'DESC',
	] );

	if ( ! $query->have_posts() ) {
		return '';
	}

	ob_start();
	?>
	<div class="es-home-projects-grid">
		<?php
		while ( $query->have_posts() ) :
			$query->the_post();
			$pid       = get_the_ID();
			$post_link = get_permalink( $pid );
			$title     = get_the_title( $pid );
			$location  = get_post_meta( $pid, '_es_location', true );
			$area      = get_post_meta( $pid, '_es_area', true );
			$year      = get_post_meta( $pid, '_es_year', true );
			
			$thumb_url = has_post_thumbnail( $pid )
				? get_the_post_thumbnail_url( $pid, 'large' )
				: home_url( '/wp-content/uploads/2026/09/du-an-noi-bat-heritage.jpg' );
		?>
			<article class="es-home-project-card">
				<a href="<?php echo esc_url( $post_link ); ?>" class="es-home-proj-media-link" aria-label="<?php echo esc_attr( $title ); ?>">
					<div class="es-home-proj-img-wrap">
						<img decoding="async" src="<?php echo esc_url( $thumb_url ); ?>" alt="<?php echo esc_attr( $title ); ?>" class="es-home-proj-img" loading="lazy" />
						<!-- Dark Translucent Hover Curtain Layer -->
						<div class="es-home-proj-hover-curtain">
							<div class="es-home-proj-hover-content">
								<span class="es-home-proj-explore-btn">
									<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
									<span>Xem chi tiết</span>
								</span>
							</div>
						</div>
					</div>
				</a>
				<div class="es-home-proj-info">
					<h3 class="es-home-proj-title">
						<a href="<?php echo esc_url( $post_link ); ?>">
							<?php echo esc_html( $title ); ?>
						</a>
					</h3>
					<div class="es-home-proj-meta">
						<?php if ( ! empty( $location ) ) : ?>
							<span class="es-home-proj-meta-item"><?php echo esc_html( $location ); ?></span>
						<?php endif; ?>
						<?php if ( ! empty( $area ) ) : ?>
							<span class="es-home-proj-dot">•</span>
							<span class="es-home-proj-meta-item"><?php echo esc_html( $area ); ?></span>
						<?php endif; ?>
					</div>
				</div>
			</article>
		<?php
		endwhile;
		wp_reset_postdata();
		?>
	</div>
	<?php
	return ob_get_clean();
}
add_shortcode( 'fountainhead_home_projects', 'fountainhead_home_projects_shortcode' );
add_shortcode( 'eurostyle_home_projects', 'fountainhead_home_projects_shortcode' );


