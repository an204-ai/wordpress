<?php
/**
 * Template Name: Trang Nhà Xưởng & Công Nghệ
 * 
 * Luxury atelier craftsmanship template with full Elementor support
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="primary" class="site-main es-factory-page">
	<?php
	while ( have_posts() ) :
		the_post();
		the_content();
	endwhile;
	?>
</main>

<?php
get_footer();
