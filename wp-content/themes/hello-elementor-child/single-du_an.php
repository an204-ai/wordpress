<?php
/**
 * Template for Single Project (du_an)
 * Exact luxury layout inspired by https://eurostyle.com.vn/du_an/the-coral-signature/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) : the_post();
	$pid          = get_the_ID();
	$area         = get_post_meta( $pid, '_es_area', true );
	$location     = get_post_meta( $pid, '_es_location', true );
	$style        = get_post_meta( $pid, '_es_style', true );
	$scope        = get_post_meta( $pid, '_es_scope', true );
	$year         = get_post_meta( $pid, '_es_year', true );

	// Lấy danh sách ảnh thực tế của dự án từ database
	$gallery      = function_exists( 'eurostyle_get_project_gallery' ) ? eurostyle_get_project_gallery( $pid ) : [];

	$sec_title    = get_post_meta( $pid, '_es_sec_title', true );
	$sec_desc     = get_post_meta( $pid, '_es_sec_desc', true );
	$sec_img      = get_post_meta( $pid, '_es_sec_img', true );

	// Ưu tiên 1: Ảnh đại diện (Featured Image) khi tạo bài viết / dự án
	$hero_img = '';
	if ( has_post_thumbnail( $pid ) ) {
		$hero_img = get_the_post_thumbnail_url( $pid, 'full' );
	} elseif ( ! empty( get_post_meta( $pid, '_es_hero_img', true ) ) ) {
		$hero_img = get_post_meta( $pid, '_es_hero_img', true );
	} elseif ( ! empty( $gallery ) ) {
		$hero_img = $gallery[0];
	}
?>

<main id="primary" class="site-main es-single-project-page">

	<!-- 1. HERO TOP BANNER (FULL WIDTH) -->
	<?php if ( ! empty( $hero_img ) ) : ?>
		<section class="es-proj-hero">
			<div class="es-proj-hero-bg" style="background-image: url('<?php echo esc_url( $hero_img ); ?>');"></div>
			<div class="es-proj-hero-overlay"></div>
		</section>
	<?php endif; ?>

	<div class="es-proj-container">

		<!-- Breadcrumbs -->
		<nav class="es-breadcrumbs" aria-label="Breadcrumb">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>">Trang Chủ</a>
			<span class="es-bc-sep">/</span>
			<a href="<?php echo esc_url( home_url( '/du-an/' ) ); ?>">Dự Án</a>
			<span class="es-bc-sep">/</span>
			<span class="es-bc-current"><?php the_title(); ?></span>
		</nav>
		
		<!-- 2. PROJECT TITLE & 2-COLUMN INFO -->
		<section class="es-proj-header-info">
			<!-- Left Column: Title & Full Description -->
			<div class="es-proj-content-left">
				<h1 class="es-proj-title"><?php the_title(); ?></h1>
				
				<h2 class="es-proj-subtitle">Thông tin chi tiết</h2>
				
				<div class="es-proj-body-text">
					<?php the_content(); ?>
				</div>
			</div>

			<!-- Right Column: Meta Specs Box -->
			<div class="es-proj-sidebar-right">
				<div class="es-proj-specs-card">
					<h3 class="es-proj-specs-title">Thông tin dự án</h3>
					<ul class="es-proj-specs-list">
						<?php if ( ! empty( $area ) || ! empty( $location ) ) : ?>
							<li>
								<strong>Diện tích:</strong> <?php echo esc_html( $area ); ?>
								<?php if ( ! empty( $location ) ) : ?>
									<span class="es-sep">|</span> <strong>Địa điểm:</strong> <?php echo esc_html( $location ); ?>
								<?php endif; ?>
							</li>
						<?php endif; ?>

						<?php if ( ! empty( $style ) ) : ?>
							<li>
								<strong>Phong cách:</strong> <?php echo esc_html( $style ); ?>
							</li>
						<?php endif; ?>

						<?php if ( ! empty( $scope ) ) : ?>
							<li>
								<strong>Hạng mục thực hiện:</strong> <?php echo esc_html( $scope ); ?>
							</li>
						<?php endif; ?>

						<?php if ( ! empty( $year ) ) : ?>
							<li>
								<strong>Năm hoàn thiện:</strong> <?php echo esc_html( $year ); ?>
							</li>
						<?php endif; ?>
					</ul>

					<div style="margin-top: 20px; padding-top: 16px; border-top: 1px solid #e2e8f0;">
						<?php echo do_shortcode( '[fountainhead_social_share]' ); ?>
					</div>
				</div>
			</div>
		</section>

		<!-- 3. INTERACTIVE CAROUSEL GALLERY (EXACTLY LIKE THE CORAL SIGNATURE) -->
		<?php if ( ! empty( $gallery ) ) : ?>
			<section class="es-proj-carousel-section">
				<div class="es-proj-carousel-wrapper" id="esGalleryCarousel">
					<div class="es-carousel-track">
						<?php foreach ( $gallery as $idx => $img_url ) : ?>
							<div class="es-carousel-slide <?php echo $idx === 0 ? 'active' : ''; ?>" data-index="<?php echo esc_attr( $idx ); ?>">
								<img src="<?php echo esc_url( $img_url ); ?>" alt="<?php the_title_attribute(); ?> - ảnh <?php echo $idx + 1; ?>">
							</div>
						<?php endforeach; ?>
					</div>

					<!-- Navigation Controls -->
					<button class="es-carousel-nav es-carousel-prev" id="esCarouselPrev" aria-label="Ảnh trước">
						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
						<span class="es-carousel-page-num" id="esPrevNum">0<?php echo count($gallery); ?></span>
					</button>
					<button class="es-carousel-nav es-carousel-next" id="esCarouselNext" aria-label="Ảnh sau">
						<span class="es-carousel-page-num" id="esNextNum">02</span>
						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
					</button>

					<!-- View All Button -->
					<div class="es-carousel-view-all-wrap">
						<button class="es-btn-view-all" id="esViewAllBtn">
							<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
							<span>Xem tất cả</span>
						</button>
					</div>
				</div>

				<!-- Fullscreen Lightbox / Grid Modal -->
				<div class="es-gallery-modal" id="esGalleryModal">
					<div class="es-modal-backdrop" id="esModalBackdrop"></div>
					<div class="es-modal-content">
						<div class="es-modal-header">
							<h3>Thư viện hình ảnh - <?php the_title(); ?></h3>
							<button class="es-modal-close" id="esModalClose" aria-label="Đóng">
								<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
							</button>
						</div>
						<div class="es-modal-grid">
							<?php foreach ( $gallery as $img_url ) : ?>
								<div class="es-modal-grid-item">
									<img src="<?php echo esc_url( $img_url ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
								</div>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
			</section>
		<?php endif; ?>

		<!-- 4. FEATURED INTERIOR SPACE SECTION -->
		<?php if ( ! empty( $sec_title ) || ! empty( $sec_img ) ) : ?>
			<section class="es-proj-feature-section">
				<?php if ( ! empty( $sec_img ) ) : ?>
					<div class="es-feature-img-wrap">
						<img src="<?php echo esc_url( $sec_img ); ?>" alt="<?php echo esc_attr( $sec_title ); ?>">
					</div>
				<?php endif; ?>

				<?php if ( ! empty( $sec_title ) || ! empty( $sec_desc ) ) : ?>
					<div class="es-feature-text-wrap">
						<?php if ( ! empty( $sec_title ) ) : ?>
							<h3 class="es-feature-title"><?php echo esc_html( $sec_title ); ?></h3>
						<?php endif; ?>
						<?php if ( ! empty( $sec_desc ) ) : ?>
							<p class="es-feature-desc"><?php echo esc_html( $sec_desc ); ?></p>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</section>
		<?php endif; ?>

		<!-- DIVIDER -->
		<hr class="es-proj-divider">

		<!-- 5. DỰ ÁN LIÊN QUAN (RELATED PROJECTS FROM DATABASE) -->
		<?php
		$related_query = new WP_Query([
			'post_type'      => 'du_an',
			'post_status'    => 'publish',
			'posts_per_page' => 3,
			'post__not_in'   => [ $pid ],
			'orderby'        => 'date',
			'order'          => 'DESC',
		]);

		if ( $related_query->have_posts() ) :
		?>
			<section class="es-related-projects-section">
				<h2 class="es-related-heading">DỰ ÁN LIÊN QUAN</h2>
				
				<div class="es-related-grid">
					<?php while ( $related_query->have_posts() ) : $related_query->the_post();
						$rel_id       = get_the_ID();
						$rel_location = get_post_meta( $rel_id, '_es_location', true );
						$rel_area     = get_post_meta( $rel_id, '_es_area', true );
						$rel_img      = '';
						if ( has_post_thumbnail( $rel_id ) ) {
							$rel_img = get_the_post_thumbnail_url( $rel_id, 'medium_large' );
						} elseif ( ! empty( get_post_meta( $rel_id, '_es_hero_img', true ) ) ) {
							$rel_img = get_post_meta( $rel_id, '_es_hero_img', true );
						}
					?>
						<article class="es-related-card">
							<a href="<?php the_permalink(); ?>" class="es-related-thumb-link">
								<div class="es-related-img-wrap">
									<?php if ( ! empty( $rel_img ) ) : ?>
										<img src="<?php echo esc_url( $rel_img ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
									<?php else : ?>
										<div class="es-img-placeholder">Fountainhead</div>
									<?php endif; ?>
								</div>
								<div class="es-related-card-content">
									<h4 class="es-related-card-title"><?php the_title(); ?></h4>
									<?php if ( ! empty( $rel_location ) || ! empty( $rel_area ) ) : ?>
										<p class="es-related-card-meta">
											<?php echo esc_html( trim( $rel_location . ( $rel_area ? ' • ' . $rel_area : '' ) ) ); ?>
										</p>
									<?php endif; ?>
								</div>
							</a>
						</article>
					<?php endwhile; wp_reset_postdata(); ?>
				</div>
			</section>
		<?php endif; ?>

	</div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
	// Carousel Logic
	var slides = document.querySelectorAll('.es-carousel-slide');
	var prevBtn = document.getElementById('esCarouselPrev');
	var nextBtn = document.getElementById('esCarouselNext');
	var prevNum = document.getElementById('esPrevNum');
	var nextNum = document.getElementById('esNextNum');
	var currentIndex = 0;
	var totalSlides = slides.length;

	if (totalSlides > 1) {
		function updateCarousel(newIndex) {
			slides.forEach(function(s) { s.classList.remove('active'); });
			slides[newIndex].classList.add('active');
			currentIndex = newIndex;

			var prevIdx = (currentIndex - 1 + totalSlides) % totalSlides;
			var nextIdx = (currentIndex + 1) % totalSlides;

			if (prevNum) prevNum.textContent = (prevIdx + 1 < 10 ? '0' : '') + (prevIdx + 1);
			if (nextNum) nextNum.textContent = (nextIdx + 1 < 10 ? '0' : '') + (nextIdx + 1);
		}

		if (prevBtn) {
			prevBtn.addEventListener('click', function() {
				var prevIdx = (currentIndex - 1 + totalSlides) % totalSlides;
				updateCarousel(prevIdx);
			});
		}

		if (nextBtn) {
			nextBtn.addEventListener('click', function() {
				var nextIdx = (currentIndex + 1) % totalSlides;
				updateCarousel(nextIdx);
			});
		}
	}

	// Modal Lightbox
	var viewAllBtn = document.getElementById('esViewAllBtn');
	var modal = document.getElementById('esGalleryModal');
	var modalClose = document.getElementById('esModalClose');
	var modalBackdrop = document.getElementById('esModalBackdrop');

	if (viewAllBtn && modal) {
		viewAllBtn.addEventListener('click', function() {
			modal.classList.add('active');
			document.body.style.overflow = 'hidden';
		});
	}

	function closeModal() {
		if (modal) {
			modal.classList.remove('active');
			document.body.style.overflow = '';
		}
	}

	if (modalClose) modalClose.addEventListener('click', closeModal);
	if (modalBackdrop) modalBackdrop.addEventListener('click', closeModal);
});
</script>

<?php
endwhile;

get_footer();
