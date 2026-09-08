<?php
/**
 * Template for Single Post (Tin tức, Sự kiện, Báo chí)
 * Exact luxury layout inspired by https://eurostyle.com.vn/eurostyle-x-inconcept-strategic-meet-up-ket-noi-tu-duy-thiet-ke-qua-gia-tri-vat-lieu/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) : the_post();
	$pid       = get_the_ID();
	$post_date = get_the_date( 'd.m.Y' );

	// Category
	$categories = get_the_category( $pid );
	$cat_name   = 'Tin tức';
	$cat_id     = 0;
	if ( ! empty( $categories ) ) {
		$cat_name = $categories[0]->name;
		$cat_id   = $categories[0]->term_id;
	}

	// Featured Image
	$hero_img = '';
	if ( has_post_thumbnail( $pid ) ) {
		$hero_img = get_the_post_thumbnail_url( $pid, 'full' );
	} else {
		$hero_img = home_url( '/wp-content/uploads/2026/09/tin-tuc-tong-thau.jpg' );
	}
?>

<main id="primary" class="site-main es-single-news-page">

	<!-- 1. SPLIT HERO HEADER (EXACT REPLICA OF EUROSTYLE) -->
	<section class="es-news-split-hero">
		<!-- Left Column: Back button, Category, Date, Title -->
		<div class="es-split-hero-left">
			<div class="es-split-hero-left-inner">
				<div class="es-back-btn-wrap">
					<a href="<?php echo esc_url( home_url( '/tin-tuc/' ) ); ?>" class="es-news-back-btn">
						<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
						<span>Trở về</span>
					</a>
				</div>

				<div class="es-split-hero-meta">
					<span class="es-split-cat"><?php echo esc_html( $cat_name ); ?></span>
					<span class="es-split-date"><?php echo esc_html( $post_date ); ?></span>
				</div>

				<h1 class="es-split-title"><?php the_title(); ?></h1>
			</div>
		</div>

		<!-- Right Column: Full Cover Featured Image -->
		<div class="es-split-hero-right" style="background-image: url('<?php echo esc_url( $hero_img ); ?>');">
			<img src="<?php echo esc_url( $hero_img ); ?>" alt="<?php the_title_attribute(); ?>" class="es-split-hero-img-preload">
		</div>
	</section>

	<!-- 2. ARTICLE CONTENT CONTAINER -->
	<article class="es-news-content-article">
		<div class="es-news-reading-container">
			<div class="es-news-body-text">
				<?php the_content(); ?>
			</div>

			<!-- Post Tags / Share Footer -->
			<div class="es-news-article-footer">
				<div class="es-news-footer-cat">
					<span class="es-news-footer-label">Chuyên mục:</span>
					<span class="es-news-footer-tag"><?php echo esc_html( $cat_name ); ?></span>
				</div>
				<?php echo do_shortcode( '[fountainhead_social_share]' ); ?>
			</div>
		</div>
	</article>

	<!-- 3. RELATED POSTS FROM DATABASE -->
	<?php
	$related_args = [
		'post_type'      => 'post',
		'post_status'    => 'publish',
		'posts_per_page' => 3,
		'post__not_in'   => [ $pid ],
	];
	if ( $cat_id > 0 ) {
		$related_args['cat'] = $cat_id;
	}

	$related_query = new WP_Query( $related_args );

	// Fallback if less than 3 in same category
	if ( $related_query->post_count < 3 ) {
		$related_query = new WP_Query([
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'posts_per_page' => 3,
			'post__not_in'   => [ $pid ],
		]);
	}

	if ( $related_query->have_posts() ) :
	?>
		<section class="es-news-related-section">
			<div class="es-news-related-container">
				<div class="es-news-related-header">
					<span class="es-news-related-tag">BÀI VIẾT</span>
					<h2 class="es-news-related-title">Bài Viết Liên Quan</h2>
				</div>

				<div class="es-news-related-grid">
					<?php
					while ( $related_query->have_posts() ) : $related_query->the_post();
						$rel_id       = get_the_ID();
						$rel_date     = get_the_date( 'd.m.Y' );
						$rel_cats     = get_the_category( $rel_id );
						$rel_cat_name = ! empty( $rel_cats ) ? $rel_cats[0]->name : 'Tin tức';

						$rel_img = '';
						if ( has_post_thumbnail( $rel_id ) ) {
							$rel_img = get_the_post_thumbnail_url( $rel_id, 'medium_large' );
						} else {
							$rel_img = home_url( '/wp-content/uploads/2026/09/tin-tuc-xuong-moc.jpg' );
						}
					?>
						<article class="es-rel-card-item">
							<a href="<?php the_permalink(); ?>" class="es-rel-card-link">
								<div class="es-rel-card-media">
									<img src="<?php echo esc_url( $rel_img ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
									<div class="es-rel-card-overlay">
										<span class="es-rel-btn-read">
											<span>Đọc chi tiết</span>
											<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
										</span>
									</div>
									<span class="es-rel-badge-cat"><?php echo esc_html( $rel_cat_name ); ?></span>
								</div>

								<div class="es-rel-card-body">
									<div class="es-rel-meta-row">
										<span class="es-rel-date">
											<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
											<?php echo esc_html( $rel_date ); ?>
										</span>
									</div>
									<h3 class="es-rel-card-heading"><?php the_title(); ?></h3>
									<div class="es-rel-card-footer">
										<span class="es-rel-read-link">
											<span>Xem thêm</span>
											<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
										</span>
									</div>
								</div>
							</a>
						</article>
					<?php endwhile; wp_reset_postdata(); ?>
				</div>
			</div>
		</section>
	<?php endif; ?>

</main>

<?php
endwhile;

get_footer();
