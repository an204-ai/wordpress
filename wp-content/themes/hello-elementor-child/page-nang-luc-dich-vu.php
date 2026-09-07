<?php
/**
 * Template Name: Trang Năng Lực & Dịch Vụ
 * Architectural Shapes & Minimalist Luxury Editorial Layout (Inspired by EuroStyle)
 * Clean typographic aesthetic, authentic geometric shapes, and zero clutter.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="primary" class="site-main es-about-editorial-page">
<?php
while ( have_posts() ) :
	the_post();
	the_content();
endwhile;
?>
</main>

<?php
get_footer();
