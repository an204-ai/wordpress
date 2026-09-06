<?php
/**
 * Single template router
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( get_post_type() === 'du_an' ) {
	include get_stylesheet_directory() . '/single-du_an.php';
} else {
	include get_stylesheet_directory() . '/single-post.php';
}
