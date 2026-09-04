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
			<span class="es-hero-tag">PORTFOLIO</span>
			<h1 class="es-hero-heading">HỒ SƠ DỰ ÁN TIÊU BIỂU</h1>
			<p class="es-hero-desc">Mỗi công trình là một kiệt tác độc bản, từ đề bài khắt khe của Chủ đầu tư đến giải pháp thiết kế tinh hoa, quá trình thi công chuẩn quốc tế và nghiệm thu thực tế hoàn mỹ.</p>
		</div>
	</section>

	<div class="es-portfolio-main-container">

		<!-- 2. SMART FILTER BAR -->
		<section class="es-filter-section">
			<div class="es-filter-section-header">
				<span class="es-filter-pre">DANH MỤC DỰ ÁN</span>
				<h2 class="es-filter-title">KHÁM PHÁ CÁC CÔNG TRÌNH BIỂU TƯỢNG</h2>
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
						$hero_img     = get_post_meta( $pid, '_es_hero_img', true );
						$area         = get_post_meta( $pid, '_es_area', true );
						$location     = get_post_meta( $pid, '_es_location', true );
						$style        = get_post_meta( $pid, '_es_style', true );
						$year         = get_post_meta( $pid, '_es_year', true );

						// Determine category for filter
						$cat = 'khach-san';
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

						if ( empty( $hero_img ) && has_post_thumbnail() ) {
							$hero_img = get_the_post_thumbnail_url( $pid, 'large' );
						}
						if ( empty( $hero_img ) ) {
							$hero_img = 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?q=80&w=1200&auto=format&fit=crop';
						}
				?>
					<article class="es-project-card-item" data-category="<?php echo esc_attr( $cat ); ?>">
						<a href="<?php the_permalink(); ?>" class="es-card-link">
							<div class="es-card-media">
								<img src="<?php echo esc_url( $hero_img ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
								<div class="es-card-overlay">
									<span class="es-btn-explore">Xem chi tiết</span>
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
