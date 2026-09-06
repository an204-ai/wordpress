<?php
/**
 * Project Custom Fields, Taxonomy & Photo Gallery Meta Box
 * Allows uploading actual project photos and custom specifications
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * 1. Register Taxonomy "Danh mục dự án" (Project Categories)
 */
function eurostyle_register_project_taxonomy() {
	$labels = [
		'name'              => 'Danh mục dự án',
		'singular_name'     => 'Danh mục dự án',
		'search_items'      => 'Tìm kiếm danh mục',
		'all_items'         => 'Tất cả danh mục',
		'parent_item'       => 'Danh mục cha',
		'parent_item_colon' => 'Danh mục cha:',
		'edit_item'         => 'Chỉnh sửa danh mục',
		'update_item'       => 'Cập nhật danh mục',
		'add_new_item'      => 'Thêm danh mục mới',
		'new_item_name'     => 'Tên danh mục mới',
		'menu_name'         => 'Danh mục dự án',
	];

	$args = [
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => [ 'slug' => 'danh-muc-du-an' ],
	];

	register_taxonomy( 'danh_muc_du_an', [ 'du_an' ], $args );
}
add_action( 'init', 'eurostyle_register_project_taxonomy', 0 );

/**
 * Seed default project categories if they don't exist
 */
function eurostyle_seed_project_categories() {
	if ( ! taxonomy_exists( 'danh_muc_du_an' ) ) return;

	$default_cats = [
		'khach-san'  => 'Khách sạn & Nghỉ dưỡng',
		'van-phong'  => 'Văn phòng & Trụ sở',
		'thuong-mai' => 'Không gian thương mại',
		'cai-tao'    => 'Cải tạo & Nâng cấp',
	];

	foreach ( $default_cats as $slug => $name ) {
		if ( ! term_exists( $slug, 'danh_muc_du_an' ) ) {
			wp_insert_term( $name, 'danh_muc_du_an', [ 'slug' => $slug ] );
		}
	}
}
add_action( 'init', 'eurostyle_seed_project_categories', 1 );

/**
 * 2. Enqueue Media Scripts in Admin for "du_an" Post Type
 */
function eurostyle_admin_project_scripts( $hook ) {
	global $post_type;
	if ( ( $hook === 'post.php' || $hook === 'post-new.php' ) && $post_type === 'du_an' ) {
		wp_enqueue_media();
	}
}
add_action( 'admin_enqueue_scripts', 'eurostyle_admin_project_scripts' );

/**
 * 3. Add Custom Meta Box for Project Specs & Gallery
 */
function eurostyle_add_project_meta_box() {
	add_meta_box(
		'eurostyle_project_meta_box',
		'Thông tin dự án & Thư viện ảnh thực tế',
		'eurostyle_render_project_meta_box',
		'du_an',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'eurostyle_add_project_meta_box' );

/**
 * 4. Render Meta Box HTML
 */
function eurostyle_render_project_meta_box( $post ) {
	wp_nonce_field( 'eurostyle_save_project_meta', 'eurostyle_project_meta_nonce' );

	$area         = get_post_meta( $post->ID, '_es_area', true );
	$location     = get_post_meta( $post->ID, '_es_location', true );
	$style        = get_post_meta( $post->ID, '_es_style', true );
	$scope        = get_post_meta( $post->ID, '_es_scope', true );
	$year         = get_post_meta( $post->ID, '_es_year', true );

	$sec_title    = get_post_meta( $post->ID, '_es_sec_title', true );
	$sec_desc     = get_post_meta( $post->ID, '_es_sec_desc', true );
	$sec_img      = get_post_meta( $post->ID, '_es_sec_img', true );

	$raw_gallery  = get_post_meta( $post->ID, '_es_gallery', true );
	$gallery_items = [];
	if ( ! empty( $raw_gallery ) ) {
		if ( is_string( $raw_gallery ) ) {
			$decoded = json_decode( $raw_gallery, true );
			$gallery_items = is_array( $decoded ) ? $decoded : array_filter( array_map( 'trim', explode( ',', $raw_gallery ) ) );
		} elseif ( is_array( $raw_gallery ) ) {
			$gallery_items = $raw_gallery;
		}
	}
	?>

	<style>
		.es-meta-wrapper {
			font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
			padding: 12px 6px;
			color: #1e1e1e;
		}
		.es-meta-section {
			background: #ffffff;
			border: 1px solid #e2e8f0;
			border-radius: 10px;
			padding: 24px;
			margin-bottom: 24px;
			box-shadow: 0 2px 8px rgba(0,0,0,0.04);
		}
		.es-meta-section-title {
			font-size: 16px;
			font-weight: 600;
			color: #0f172a;
			margin: 0 0 8px 0;
			padding-bottom: 12px;
			border-bottom: 1px solid #f1f5f9;
			display: flex;
			align-items: center;
			gap: 10px;
		}
		.es-meta-section-desc {
			font-size: 13px;
			color: #64748b;
			margin: 0 0 20px 0;
			line-height: 1.6;
		}
		.es-meta-grid-2 {
			display: grid;
			grid-template-columns: repeat(2, 1fr);
			gap: 18px 24px;
		}
		@media (max-width: 782px) {
			.es-meta-grid-2 {
				grid-template-columns: 1fr;
			}
		}
		.es-field-group {
			display: flex;
			flex-direction: column;
			gap: 8px;
		}
		.es-field-label {
			font-size: 13px;
			font-weight: 600;
			color: #1e293b;
		}
		.es-field-input {
			padding: 10px 14px;
			border: 1px solid #cbd5e1;
			border-radius: 6px;
			font-size: 14px;
			line-height: 1.5;
			transition: all 0.2s ease;
			background-color: #ffffff;
		}
		.es-field-input:focus {
			border-color: #0284c7;
			box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.15);
			outline: none;
		}
		.es-field-textarea {
			padding: 12px 14px;
			border: 1px solid #cbd5e1;
			border-radius: 6px;
			font-size: 14px;
			min-height: 90px;
			resize: vertical;
			line-height: 1.5;
			transition: all 0.2s ease;
		}
		.es-field-textarea:focus {
			border-color: #0284c7;
			box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.15);
			outline: none;
		}

		/* Gallery UI */
		.es-gallery-toolbar {
			display: flex;
			align-items: center;
			justify-content: space-between;
			flex-wrap: wrap;
			gap: 12px;
			margin-bottom: 20px;
		}
		.es-btn-add-photos {
			background-color: #0284c7 !important;
			color: #ffffff !important;
			border: none !important;
			padding: 10px 20px !important;
			font-size: 13px !important;
			font-weight: 600 !important;
			border-radius: 6px !important;
			cursor: pointer !important;
			display: inline-flex !important;
			align-items: center !important;
			gap: 8px !important;
			transition: all 0.2s ease !important;
			box-shadow: 0 2px 6px rgba(2, 132, 199, 0.25) !important;
		}
		.es-btn-add-photos:hover {
			background-color: #0369a1 !important;
			box-shadow: 0 4px 10px rgba(2, 132, 199, 0.35) !important;
			transform: translateY(-1px) !important;
		}
		.es-btn-clear-photos {
			background-color: #fff1f2 !important;
			color: #e11d48 !important;
			border: 1px solid #fecdd3 !important;
			padding: 9px 16px !important;
			font-size: 13px !important;
			font-weight: 600 !important;
			border-radius: 6px !important;
			cursor: pointer !important;
			display: inline-flex !important;
			align-items: center !important;
			gap: 6px !important;
			transition: all 0.2s ease !important;
		}
		.es-btn-clear-photos:hover {
			background-color: #e11d48 !important;
			color: #ffffff !important;
			border-color: #e11d48 !important;
		}
		.es-gallery-preview-grid {
			display: grid;
			grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
			gap: 18px;
			min-height: 120px;
			padding: 20px;
			background: #f8fafc;
			border: 2px dashed #cbd5e1;
			border-radius: 10px;
		}
		.es-gallery-item {
			position: relative;
			aspect-ratio: 4/3;
			border-radius: 8px;
			overflow: hidden;
			background: #ffffff;
			border: 1px solid #e2e8f0;
			box-shadow: 0 2px 6px rgba(0,0,0,0.06);
			display: flex;
			align-items: center;
			justify-content: center;
			transition: transform 0.2s ease, box-shadow 0.2s ease;
		}
		.es-gallery-item:hover {
			transform: translateY(-3px);
			box-shadow: 0 6px 16px rgba(0,0,0,0.12);
		}
		.es-gallery-item img {
			width: 100%;
			height: 100%;
			object-fit: cover;
			display: block;
		}
		.es-gallery-item-remove {
			position: absolute;
			top: 8px;
			right: 8px;
			background: #e11d48 !important;
			color: #ffffff !important;
			border: none !important;
			width: 28px;
			height: 28px;
			border-radius: 50%;
			cursor: pointer;
			display: flex;
			align-items: center;
			justify-content: center;
			opacity: 0.92;
			box-shadow: 0 2px 6px rgba(225, 29, 72, 0.4);
			transition: all 0.2s ease;
		}
		.es-gallery-item-remove:hover {
			opacity: 1;
			transform: scale(1.1);
			background: #be123c !important;
		}
		.es-gallery-empty-msg {
			grid-column: 1 / -1;
			text-align: center;
			color: #94a3b8;
			font-size: 14px;
			padding: 36px 12px;
			margin: 0;
		}
		.es-btn-select-sec {
			background-color: #0f172a !important;
			color: #ffffff !important;
			border: none !important;
			padding: 9px 18px !important;
			font-size: 13px !important;
			font-weight: 500 !important;
			border-radius: 6px !important;
			cursor: pointer !important;
			display: inline-flex !important;
			align-items: center !important;
			gap: 6px !important;
			transition: all 0.2s ease !important;
		}
		.es-btn-select-sec:hover {
			background-color: #334155 !important;
		}
		.es-sec-img-preview {
			max-width: 260px;
			aspect-ratio: 16/9;
			object-fit: cover;
			border-radius: 8px;
			border: 1px solid #cbd5e1;
			display: block;
			margin-top: 12px;
			box-shadow: 0 2px 8px rgba(0,0,0,0.06);
		}
	</style>

	<div class="es-meta-wrapper">
		
		<!-- 1. THƯ VIỆN ẢNH THỰC TẾ DỰ ÁN -->
		<div class="es-meta-section">
			<h4 class="es-meta-section-title">
				<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#0284c7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="m21 15-5-5L5 21"/></svg>
				Thư viện ảnh thực tế công trình
			</h4>
			<p class="es-meta-section-desc">Tải lên các hình ảnh thực tế sau khi thi công hoàn thiện của dự án. Hệ thống sẽ tự động lưu vào cơ sở dữ liệu và hiển thị trên slide ảnh thực tế cũng như cửa sổ xem chi tiết của dự án.</p>

			<div class="es-gallery-toolbar">
				<button type="button" class="es-btn-add-photos" id="esAddGalleryBtn">
					<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
					Thêm ảnh thực tế hoặc chọn từ thư viện
				</button>
				<button type="button" class="es-btn-clear-photos" id="esClearGalleryBtn" <?php echo empty($gallery_items) ? 'style="display:none;"' : ''; ?>>
					<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
					Xóa toàn bộ ảnh
				</button>
			</div>

			<!-- Hidden input storing gallery JSON in DB -->
			<input type="hidden" name="_es_gallery" id="esGalleryInput" value="<?php echo esc_attr( wp_json_encode( $gallery_items ) ); ?>">

			<!-- Interactive Preview Grid -->
			<div class="es-gallery-preview-grid" id="esGalleryPreviewGrid">
				<?php if ( empty( $gallery_items ) ) : ?>
					<p class="es-gallery-empty-msg">Chưa có ảnh thực tế nào. Hãy bấm nút "Thêm ảnh thực tế" ở trên để chọn hoặc tải ảnh lên.</p>
				<?php else : ?>
					<?php foreach ( $gallery_items as $item ) :
						$img_url = '';
						if ( is_numeric( $item ) ) {
							$img_url = wp_get_attachment_image_url( (int) $item, 'medium' );
						} elseif ( is_string( $item ) ) {
							$img_url = $item;
						}
						if ( empty( $img_url ) ) continue;
					?>
						<div class="es-gallery-item" data-val="<?php echo esc_attr( $item ); ?>">
							<img src="<?php echo esc_url( $img_url ); ?>" alt="Ảnh dự án">
							<button type="button" class="es-gallery-item-remove" title="Xóa ảnh này">
								<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
							</button>
						</div>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
		</div>

		<!-- 2. THÔNG SỐ KỸ THUẬT DỰ ÁN -->
		<div class="es-meta-section">
			<h4 class="es-meta-section-title">
				<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#0284c7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
				Thông số kỹ thuật dự án
			</h4>
			<p class="es-meta-section-desc">Các thông số này sẽ hiển thị trong khung tóm tắt thông tin dự án và trên thẻ đại diện danh sách dự án.</p>

			<div class="es-meta-grid-2">
				<div class="es-field-group">
					<label class="es-field-label" for="es_area">Diện tích công trình</label>
					<input type="text" id="es_area" name="_es_area" class="es-field-input" value="<?php echo esc_attr( $area ); ?>" placeholder="Ví dụ: 1.400 m² hoặc 32.000 m²">
				</div>

				<div class="es-field-group">
					<label class="es-field-label" for="es_location">Địa điểm thực hiện</label>
					<input type="text" id="es_location" name="_es_location" class="es-field-input" value="<?php echo esc_attr( $location ); ?>" placeholder="Ví dụ: Gran Meliá Nha Trang hoặc Hoàn Kiếm, Hà Nội">
				</div>

				<div class="es-field-group">
					<label class="es-field-label" for="es_style">Phong cách thiết kế</label>
					<input type="text" id="es_style" name="_es_style" class="es-field-input" value="<?php echo esc_attr( $style ); ?>" placeholder="Ví dụ: Roberto Cavalli Home Interiors hoặc Smart Corporate Office">
				</div>

				<div class="es-field-group">
					<label class="es-field-label" for="es_year">Năm hoàn thiện</label>
					<input type="text" id="es_year" name="_es_year" class="es-field-input" value="<?php echo esc_attr( $year ); ?>" placeholder="Ví dụ: 2023 hoặc 2024">
				</div>

				<div class="es-field-group" style="grid-column: 1 / -1;">
					<label class="es-field-label" for="es_scope">Hạng mục thực hiện</label>
					<input type="text" id="es_scope" name="_es_scope" class="es-field-input" value="<?php echo esc_attr( $scope ); ?>" placeholder="Ví dụ: Tổng thầu thiết kế và thi công nội thất, hoàn thiện kiến trúc và kỹ thuật">
				</div>
			</div>
		</div>

		<!-- 3. KHÔNG GIAN NỔI BẬT -->
		<div class="es-meta-section">
			<h4 class="es-meta-section-title">
				<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#0284c7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
				Không gian điểm nhấn nổi bật
			</h4>
			<p class="es-meta-section-desc">Phần giới thiệu không gian tiêu biểu nhất của công trình đặt ở phần cuối trang chi tiết dự án.</p>

			<div class="es-field-group" style="margin-bottom: 16px;">
				<label class="es-field-label" for="es_sec_title">Tiêu đề không gian nổi bật</label>
				<input type="text" id="es_sec_title" name="_es_sec_title" class="es-field-input" value="<?php echo esc_attr( $sec_title ); ?>" placeholder="Ví dụ: Không Gian Phòng Khách Đậm Chất Thời Trang Cao Cấp">
			</div>

			<div class="es-field-group" style="margin-bottom: 16px;">
				<label class="es-field-label" for="es_sec_desc">Mô tả chi tiết không gian</label>
				<textarea id="es_sec_desc" name="_es_sec_desc" class="es-field-textarea" placeholder="Mô tả các vật liệu, thủ pháp thiết kế và công năng nổi bật..."><?php echo esc_textarea( $sec_desc ); ?></textarea>
			</div>

			<div class="es-field-group">
				<label class="es-field-label">Hình ảnh không gian điểm nhấn</label>
				<div style="display: flex; gap: 10px; align-items: center;">
					<input type="text" id="es_sec_img" name="_es_sec_img" class="es-field-input" style="flex:1;" value="<?php echo esc_attr( $sec_img ); ?>" placeholder="Đường dẫn ảnh hoặc bấm Chọn ảnh bên cạnh">
					<button type="button" class="es-btn-select-sec" id="esSelectSecImgBtn">
						<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
						Chọn ảnh
					</button>
				</div>
				<?php if ( ! empty( $sec_img ) ) : ?>
					<img src="<?php echo esc_url( $sec_img ); ?>" id="esSecImgPreview" class="es-sec-img-preview" alt="Ảnh xem trước">
				<?php else : ?>
					<img src="" id="esSecImgPreview" class="es-sec-img-preview" style="display:none;" alt="Ảnh xem trước">
				<?php endif; ?>
			</div>
		</div>

	</div>

	<script>
	jQuery(document).ready(function($) {
		var galleryItems = [];
		try {
			galleryItems = JSON.parse($('#esGalleryInput').val() || '[]');
		} catch(e) {
			galleryItems = [];
		}

		function updateGalleryUI() {
			var $grid = $('#esGalleryPreviewGrid');
			$grid.empty();

			if (!galleryItems.length) {
				$grid.append('<p class="es-gallery-empty-msg">Chưa có ảnh thực tế nào. Hãy bấm "Thêm ảnh thực tế" ở trên để chọn hoặc tải ảnh lên.</p>');
				$('#esClearGalleryBtn').hide();
			} else {
				$('#esClearGalleryBtn').show();
				galleryItems.forEach(function(item) {
					var url = typeof item === 'object' ? item.url : item;
					// If it's an ID, we might have stored it or retrieved its URL
					var $card = $('<div class="es-gallery-item"></div>').attr('data-val', typeof item === 'object' ? item.id : item);
					$card.append($('<img />').attr('src', url));
					$card.append('<button type="button" class="es-gallery-item-remove" title="Xóa ảnh này"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>');
					$grid.append($card);
				});
			}

			// Store as JSON of IDs or URLs
			var saveVals = galleryItems.map(function(item) {
				return typeof item === 'object' ? (item.id || item.url) : item;
			});
			$('#esGalleryInput').val(JSON.stringify(saveVals));
		}

		// Handle adding multiple photos via wp.media
		$('#esAddGalleryBtn').on('click', function(e) {
			e.preventDefault();

			var frame = wp.media({
				title: 'Chọn ảnh thực tế cho dự án',
				button: { text: 'Thêm vào thư viện dự án' },
				multiple: true,
				library: { type: 'image' }
			});

			frame.on('select', function() {
				var selection = frame.state().get('selection');
				selection.each(function(attachment) {
					var att = attachment.toJSON();
					var imgUrl = (att.sizes && att.sizes.medium) ? att.sizes.medium.url : att.url;
					galleryItems.push({
						id: att.id,
						url: imgUrl
					});
				});
				updateGalleryUI();
			});

			frame.open();
		});

		// Remove single item
		$('#esGalleryPreviewGrid').on('click', '.es-gallery-item-remove', function(e) {
			e.preventDefault();
			var $card = $(this).closest('.es-gallery-item');
			var val = $card.attr('data-val');
			galleryItems = galleryItems.filter(function(item) {
				var itemVal = typeof item === 'object' ? (item.id || item.url) : item;
				return String(itemVal) !== String(val);
			});
			updateGalleryUI();
		});

		// Clear all
		$('#esClearGalleryBtn').on('click', function(e) {
			e.preventDefault();
			if (confirm('Bạn có chắc chắn muốn xóa toàn bộ ảnh trong thư viện dự án này không?')) {
				galleryItems = [];
				updateGalleryUI();
			}
		});

		// Feature space image selector
		$('#esSelectSecImgBtn').on('click', function(e) {
			e.preventDefault();
			var frame = wp.media({
				title: 'Chọn ảnh không gian điểm nhấn',
				button: { text: 'Chọn ảnh này' },
				multiple: false,
				library: { type: 'image' }
			});

			frame.on('select', function() {
				var attachment = frame.state().get('selection').first().toJSON();
				$('#es_sec_img').val(attachment.url);
				$('#esSecImgPreview').attr('src', attachment.url).show();
			});

			frame.open();
		});
	});
	</script>
	<?php
}

/**
 * 5. Save Meta Box Data on Post Save
 */
function eurostyle_save_project_meta( $post_id ) {
	if ( ! isset( $_POST['eurostyle_project_meta_nonce'] ) ) {
		return;
	}
	if ( ! wp_verify_nonce( $_POST['eurostyle_project_meta_nonce'], 'eurostyle_save_project_meta' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$text_fields = [
		'_es_area',
		'_es_location',
		'_es_style',
		'_es_scope',
		'_es_year',
		'_es_sec_title',
		'_es_sec_desc',
		'_es_sec_img',
	];

	foreach ( $text_fields as $field ) {
		if ( isset( $_POST[ $field ] ) ) {
			update_post_meta( $post_id, $field, sanitize_text_field( wp_unslash( $_POST[ $field ] ) ) );
		}
	}

	// Save Gallery
	if ( isset( $_POST['_es_gallery'] ) ) {
		$raw_gallery = wp_unslash( $_POST['_es_gallery'] );
		$decoded = json_decode( $raw_gallery, true );
		if ( is_array( $decoded ) ) {
			$clean_gallery = [];
			foreach ( $decoded as $item ) {
				if ( is_numeric( $item ) ) {
					$clean_gallery[] = (int) $item;
				} elseif ( is_string( $item ) ) {
					$clean_gallery[] = esc_url_raw( $item );
				}
			}
			update_post_meta( $post_id, '_es_gallery', wp_json_encode( $clean_gallery ) );

			// If project doesn't have a Featured Image yet, and gallery has at least one attachment ID, set it!
			if ( ! has_post_thumbnail( $post_id ) && ! empty( $clean_gallery ) ) {
				$first = $clean_gallery[0];
				if ( is_numeric( $first ) ) {
					set_post_thumbnail( $post_id, (int) $first );
					update_post_meta( $post_id, '_es_hero_img', wp_get_attachment_url( (int) $first ) );
				}
			}
		}
	}
}
add_action( 'save_post_du_an', 'eurostyle_save_project_meta' );

/**
 * 6. Helper function to resolve full gallery image URLs from database
 */
function eurostyle_get_project_gallery( $post_id ) {
	$raw = get_post_meta( $post_id, '_es_gallery', true );
	$items = [];
	if ( ! empty( $raw ) ) {
		if ( is_string( $raw ) ) {
			$decoded = json_decode( $raw, true );
			$items = is_array( $decoded ) ? $decoded : array_filter( array_map( 'trim', explode( ',', $raw ) ) );
		} elseif ( is_array( $raw ) ) {
			$items = $raw;
		}
	}

	$gallery = [];
	foreach ( $items as $item ) {
		if ( empty( $item ) ) continue;
		if ( is_numeric( $item ) ) {
			$url = wp_get_attachment_image_url( (int) $item, 'full' );
			if ( $url ) $gallery[] = $url;
		} elseif ( is_string( $item ) && filter_var( $item, FILTER_VALIDATE_URL ) ) {
			$gallery[] = $item;
		} elseif ( is_array( $item ) && ! empty( $item['url'] ) ) {
			$gallery[] = $item['url'];
		}
	}

	// Fallback to attached media if gallery meta was empty
	if ( empty( $gallery ) ) {
		$attached = get_attached_media( 'image', $post_id );
		foreach ( $attached as $att ) {
			$url = wp_get_attachment_image_url( $att->ID, 'full' );
			if ( $url ) $gallery[] = $url;
		}
	}

	return $gallery;
}
