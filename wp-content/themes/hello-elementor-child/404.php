<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package Fountainhead
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header();
?>

<main id="primary" class="site-main es-404-page">
	<div class="es-404-hero">
		<div class="es-404-overlay"></div>
		<div class="es-404-content">
			<h1 class="es-404-code">404</h1>
			<p class="es-404-message">PAGE NOT FOUND</p>
			<p class="es-404-subtext">Không gian hoặc công trình bạn đang tìm kiếm chưa được khởi tạo hoặc đã được quy hoạch lại.</p>
			<div class="es-404-actions">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="es-404-btn-home" id="btn-404-home">
					<span>GO TO HOMEPAGE</span>
					<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
						<path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
						<polyline points="9 22 9 12 15 12 15 22"/>
					</svg>
				</a>
			</div>
		</div>
	</div>
</main>

<?php
get_footer();
