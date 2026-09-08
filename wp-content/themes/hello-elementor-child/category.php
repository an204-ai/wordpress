<?php
/**
 * Template for displaying Category Archive (Bản tin, Sự kiện, Báo chí)
 * Full-width luxury design matching EuroStyle branding
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$curr_cat = get_queried_object();
$cat_name = $curr_cat ? $curr_cat->name : 'Tin tức';
$cat_desc = $curr_cat ? $curr_cat->description : '';
$cat_count = $curr_cat ? $curr_cat->count : 0;
?>

<main id="primary" class="site-main es-cat-archive-page">

	<!-- CATEGORY HEADER -->
	<header class="es-cat-archive-header">
		<div class="es-cat-header-inner">
			<div class="es-cat-breadcrumb">
				<a href="<?php echo esc_url( home_url( '/tin-tuc/' ) ); ?>" class="es-cat-back-link">
					<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
					<span>Tất cả tin tức</span>
				</a>
				<span class="es-cat-sep">/</span>
				<span class="es-cat-curr"><?php echo esc_html( $cat_name ); ?></span>
			</div>

			<div class="es-cat-title-row">
				<h1 class="es-cat-main-title"><?php echo esc_html( mb_strtoupper( $cat_name, 'UTF-8' ) ); ?></h1>
				<span class="es-cat-count-badge"><?php echo esc_html( $cat_count ); ?> bài viết</span>
			</div>

			<?php if ( ! empty( $cat_desc ) ) : ?>
				<p class="es-cat-desc"><?php echo esc_html( $cat_desc ); ?></p>
			<?php endif; ?>
		</div>
	</header>

	<!-- FULL-WIDTH CATEGORY GRID -->
	<div class="es-cat-archive-wrapper">
		<?php if ( have_posts() ) : ?>
			<div class="es-cat-posts-grid">
				<?php
				while ( have_posts() ) : the_post();
					$pid       = get_the_ID();
					$post_date = get_the_date( 'd.m.Y' );
					$excerpt   = get_the_excerpt();

					$thumb_url = has_post_thumbnail( $pid )
						? get_the_post_thumbnail_url( $pid, 'large' )
						: home_url( '/wp-content/uploads/2026/09/tin-tuc-tong-thau.jpg' );
				?>
					<article class="es-cat-card-item">
						<a href="<?php the_permalink(); ?>" class="es-cat-card-link">
							<div class="es-cat-card-media">
								<img src="<?php echo esc_url( $thumb_url ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
								<div class="es-cat-card-overlay">
									<span class="es-cat-btn-read">
										<span>Đọc chi tiết</span>
										<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
									</span>
								</div>
								<span class="es-cat-badge-name"><?php echo esc_html( $cat_name ); ?></span>
							</div>

							<div class="es-cat-card-body">
								<div class="es-cat-meta-row">
									<span class="es-cat-date">
										<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
										<?php echo esc_html( $post_date ); ?>
									</span>
								</div>

								<h2 class="es-cat-card-heading"><?php the_title(); ?></h2>

								<?php if ( ! empty( $excerpt ) ) : ?>
									<p class="es-cat-card-excerpt"><?php echo esc_html( wp_trim_words( $excerpt, 20, '...' ) ); ?></p>
								<?php endif; ?>

								<div class="es-cat-card-footer">
									<span class="es-cat-read-link">
										<span>Xem thêm</span>
										<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
									</span>
								</div>
							</div>
						</a>
					</article>
				<?php endwhile; ?>
			</div>

			<!-- PAGINATION -->
			<div class="es-cat-pagination">
				<?php
				the_posts_pagination([
					'prev_text' => '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg>',
					'next_text' => '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>',
				]);
				?>
			</div>

		<?php else : ?>
			<div class="es-cat-empty-state">
				<p>Hiện chưa có bài viết nào trong danh mục này.</p>
				<a href="<?php echo esc_url( home_url( '/tin-tuc/' ) ); ?>" class="es-btn-gold">Quay lại Trang Tin tức</a>
			</div>
		<?php endif; ?>
	</div>

</main>

<?php get_footer(); ?>
