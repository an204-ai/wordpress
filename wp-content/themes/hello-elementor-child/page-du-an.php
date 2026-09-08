<?php
/**
 * Template Name: Trang Danh Sách Dự Án
 * Template for displaying all projects dynamically from WordPress database
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

// Query all projects from database
$projects_query = new WP_Query([
	'post_type'      => 'du_an',
	'post_status'    => 'publish',
	'posts_per_page' => -1,
	'orderby'        => 'date',
	'order'          => 'DESC',
]);
?>

<main id="primary" class="site-main es-portfolio-archive-page">
	
	<!-- 1. HERO BANNER -->
	<section class="es-portfolio-hero">
		<div class="es-portfolio-hero-bg"></div>
		<div class="es-portfolio-hero-overlay"></div>
		<div class="es-portfolio-hero-content">
			<h1 class="es-hero-heading">Hồ Sơ Dự Án Tiêu Biểu</h1>
			<p class="es-hero-desc">Mỗi công trình là một kiệt tác độc bản, từ đề bài khắt khe của Chủ đầu tư đến giải pháp thiết kế tinh hoa, quá trình thi công chuẩn quốc tế và nghiệm thu thực tế hoàn mỹ.</p>
		</div>
	</section>

	<div class="es-portfolio-main-container">

		<!-- 2. SMART FILTER BAR -->
		<section class="es-filter-section">
			<div class="es-filter-section-header">
				<span class="es-filter-pre">DANH MỤC DỰ ÁN</span>
				<h2 class="es-filter-title">Dự Án Tiêu Biểu</h2>
			</div>
			
			<div class="es-filter-pills" id="esProjectFilters">
				<button class="es-pill-btn active" data-filter="all">Tất cả</button>
				<button class="es-pill-btn" data-filter="khach-san">Khách sạn & Nghỉ dưỡng</button>
				<button class="es-pill-btn" data-filter="van-phong">Văn phòng & Trụ sở</button>
				<button class="es-pill-btn" data-filter="thuong-mai">Không gian thương mại</button>
				<button class="es-pill-btn" data-filter="cai-tao">Cải tạo & Nâng cấp</button>
			</div>
		</section>

		<!-- 3. DYNAMIC PROJECTS GRID FROM DATABASE -->
		<section class="es-projects-grid-section">
			<div class="es-projects-grid" id="esProjectsGrid">
				<?php
				if ( $projects_query->have_posts() ) :
					while ( $projects_query->have_posts() ) : $projects_query->the_post();
						$pid          = get_the_ID();
						$slug         = get_post_field( 'post_name', $pid );
						$area         = get_post_meta( $pid, '_es_area', true );
						$location     = get_post_meta( $pid, '_es_location', true );
						$style        = get_post_meta( $pid, '_es_style', true );
						$year         = get_post_meta( $pid, '_es_year', true );

						// 1. IMAGE: Ưu tiên lấy Ảnh đại diện (Featured Image) khi tạo bài viết
						$hero_img = '';
						if ( has_post_thumbnail( $pid ) ) {
							$hero_img = get_the_post_thumbnail_url( $pid, 'large' );
						} elseif ( ! empty( get_post_meta( $pid, '_es_hero_img', true ) ) ) {
							$hero_img = get_post_meta( $pid, '_es_hero_img', true );
						} else {
							// Lấy ảnh đầu tiên từ thư viện ảnh thực tế trong database
							$gallery_list = function_exists( 'eurostyle_get_project_gallery' ) ? eurostyle_get_project_gallery( $pid ) : [];
							if ( ! empty( $gallery_list ) ) {
								$hero_img = $gallery_list[0];
							}
						}
						if ( empty( $hero_img ) ) {
							$hero_img = home_url( '/wp-content/uploads/2026/09/du-an-noi-bat-heritage.jpg' );
						}

						// 2. CATEGORY: Lấy từ danh mục phân loại dự án trong database
						$cat = 'khach-san';
						$cat_name = 'Khách sạn & Nghỉ dưỡng';
						$terms = get_the_terms( $pid, 'danh_muc_du_an' );
						if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
							$cat = $terms[0]->slug;
							$cat_name = $terms[0]->name;
						} else {
							// Fallback theo tên hoặc từ khóa
							if ( stripos( $slug, 'lotte' ) !== false || stripos( $slug, 'flagship' ) !== false || stripos( $slug, 'showroom' ) !== false ) {
								$cat = 'thuong-mai';
							} elseif ( stripos( $slug, 'techcombank' ) !== false || stripos( $slug, 'office' ) !== false || stripos( $slug, 'tru-so' ) !== false ) {
								$cat = 'van-phong';
							} elseif ( stripos( $slug, 'heritage' ) !== false || stripos( $slug, 'cai-tao' ) !== false ) {
								$cat = 'cai-tao';
							}
							$cat_labels = [
								'khach-san'  => 'Khách sạn & Nghỉ dưỡng',
								'van-phong'  => 'Văn phòng & Trụ sở',
								'thuong-mai' => 'Không gian thương mại',
								'cai-tao'    => 'Cải tạo & Nâng cấp',
							];
							$cat_name = $cat_labels[ $cat ] ?? 'Dự án cao cấp';
						}
				?>
					<article class="es-project-card-item" data-category="<?php echo esc_attr( $cat ); ?>">
						<a href="<?php the_permalink(); ?>" class="es-card-link">
							<div class="es-card-media">
								<img src="<?php echo esc_url( $hero_img ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
								<div class="es-card-overlay">
									<span class="es-btn-explore">
										<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
										Xem chi tiết
									</span>
								</div>
								<span class="es-badge-cat"><?php echo esc_html( $cat_name ); ?></span>
							</div>

							<div class="es-card-body">
								<h3 class="es-card-heading"><?php the_title(); ?></h3>
								<div class="es-card-specs">
									<?php if ( ! empty( $location ) ) : ?>
										<span class="es-spec-item">
											<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
											<?php echo esc_html( $location ); ?>
										</span>
									<?php endif; ?>
									<?php if ( ! empty( $area ) ) : ?>
										<span class="es-spec-item">
											<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18"/><path d="M9 21V9"/></svg>
											<?php echo esc_html( $area ); ?>
										</span>
									<?php endif; ?>
									<?php if ( ! empty( $year ) ) : ?>
										<span class="es-spec-item es-spec-year">
											<?php echo esc_html( $year ); ?>
										</span>
									<?php endif; ?>
								</div>
							</div>
						</a>
					</article>
				<?php
					endwhile;
					wp_reset_postdata();
				else :
				?>
					<p style="color: #fff; text-align: center; grid-column: 1 / -1; padding: 40px 0;">Hiện chưa có dự án nào.</p>
				<?php endif; ?>
			</div>
		</section>

	</div>

	<!-- 4. BESPOKE EXECUTION & QUALITY COMMITMENTS SECTION -->
	<section class="es-project-standards-section">
		<div class="es-portfolio-main-container">
			<div class="es-standards-header">
				<h2 class="es-standards-title">Tiêu Chuẩn Bàn Giao</h2>
				<p class="es-standards-desc">
					Cam kết chất lượng và chuẩn mực thi công hoàn mỹ từ bản vẽ kỹ thuật đến thực tế công trình.
				</p>
			</div>

			<div class="es-standards-grid">
				<!-- Pillar 1 -->
				<div class="es-standard-card">
					<div class="es-standard-icon">
						<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
							<path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/>
						</svg>
					</div>
					<h3 class="es-standard-card-title">Độ Chuẩn Xác Cơ Khí 100%</h3>
					<p class="es-standard-card-desc">
						Số hóa dữ liệu CAD/BIM đồng bộ với máy cắt CNC 5 trục Châu Âu, cam kết công trình thực tế giống 100% bản vẽ 3D với dung sai cơ khí dưới 0.2mm.
					</p>
				</div>

				<!-- Pillar 2 -->
				<div class="es-standard-card">
					<div class="es-standard-icon">
						<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
							<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
						</svg>
					</div>
					<h3 class="es-standard-card-title">100% Vật Liệu Có Chứng Chỉ</h3>
					<p class="es-standard-card-desc">
						Minh bạch nguồn gốc CO/CQ với các thương hiệu toàn cầu hàng đầu như An Cường (CARB P2), Häfele Đức, Blum Áo và Vicostone thạch anh.
					</p>
				</div>

				<!-- Pillar 3 -->
				<div class="es-standard-card">
					<div class="es-standard-icon">
						<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
							<rect x="2" y="3" width="20" height="14" rx="2" ry="2"/>
							<line x1="8" y1="21" x2="16" y2="21"/>
							<line x1="12" y1="17" x2="12" y2="21"/>
						</svg>
					</div>
					<h3 class="es-standard-card-title">Dựng Thử Dry-Fit Tại Xưởng</h3>
					<p class="es-standard-card-desc">
						Toàn bộ hệ tủ module và vách kiến trúc phức tạp được lắp dựng thử nghiệm tại xưởng Quận 12 trước khi vận chuyển, loại bỏ 100% xung đột tại công trường.
					</p>
				</div>

				<!-- Pillar 4 -->
				<div class="es-standard-card">
					<div class="es-standard-icon">
						<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
							<circle cx="12" cy="12" r="10"/>
							<polyline points="12 6 12 12 16 14"/>
						</svg>
					</div>
					<h3 class="es-standard-card-title">Bảo Hành 02 Năm &amp; Bảo Trì</h3>
					<p class="es-standard-card-desc">
						Chính sách bảo hành kỹ thuật 24 tháng và bảo trì định kỳ 6 tháng một lần, đồng hành bền vững cùng vẻ đẹp và sự tiện nghi của mỗi công trình.
					</p>
				</div>
			</div>
		</div>
	</section>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
	var filterBtns = document.querySelectorAll('#esProjectFilters .es-pill-btn');
	var cards = document.querySelectorAll('#esProjectsGrid .es-project-card-item');

	filterBtns.forEach(function(btn) {
		btn.addEventListener('click', function() {
			filterBtns.forEach(function(b) { b.classList.remove('active'); });
			this.classList.add('active');

			var filter = this.getAttribute('data-filter');

			cards.forEach(function(card) {
				if (filter === 'all' || card.getAttribute('data-category') === filter) {
					card.style.display = 'block';
					setTimeout(function() {
						card.style.opacity = '1';
						card.style.transform = 'translateY(0)';
					}, 10);
				} else {
					card.style.opacity = '0';
					card.style.transform = 'translateY(15px)';
					setTimeout(function() {
						card.style.display = 'none';
					}, 250);
				}
			});
		});
	});
});
</script>

<?php
get_footer();
