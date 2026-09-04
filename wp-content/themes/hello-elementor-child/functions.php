<?php
/**
 * Hello Elementor Child - EuroStyle Functions
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'EUROSTYLE_CHILD_VERSION', '1.0.1' );

/**
 * Enqueue scripts and styles.
 */
function eurostyle_enqueue_scripts() {
	// Enqueue Google Fonts
	wp_enqueue_style( 
		'eurostyle-google-fonts', 
		'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400&family=Montserrat:wght@300;400;500;600;700&display=swap', 
		[], 
		null 
	);

	// Enqueue Parent Style
	wp_enqueue_style( 'hello-elementor-theme-style', get_template_directory_uri() . '/style.css', [], HELLO_ELEMENTOR_VERSION );

	// Enqueue Child Style
	wp_enqueue_style( 'eurostyle-child-style', get_stylesheet_directory_uri() . '/style.css', [ 'hello-elementor-theme-style' ], EUROSTYLE_CHILD_VERSION );
}
add_action( 'wp_enqueue_scripts', 'eurostyle_enqueue_scripts', 20 );

/**
 * Register Navigation Menus
 */
function eurostyle_register_menus() {
	register_nav_menus( [
		'eurostyle-main-menu' => __( 'EuroStyle Main Menu', 'hello-elementor-child' ),
		'eurostyle-footer-menu' => __( 'EuroStyle Footer Menu', 'hello-elementor-child' ),
	] );
}
add_action( 'after_setup_theme', 'eurostyle_register_menus' );

/**
 * Register Custom Post Type Dự Án (du_an) using standard WordPress tables (wp_posts & wp_postmeta)
 */
function eurostyle_register_cpt_du_an() {
	$labels = [
		'name'               => __( 'Dự án', 'hello-elementor-child' ),
		'singular_name'      => __( 'Dự án', 'hello-elementor-child' ),
		'add_new'            => __( 'Thêm dự án', 'hello-elementor-child' ),
		'add_new_item'       => __( 'Thêm dự án mới', 'hello-elementor-child' ),
		'edit_item'          => __( 'Sửa dự án', 'hello-elementor-child' ),
		'new_item'           => __( 'Dự án mới', 'hello-elementor-child' ),
		'view_item'          => __( 'Xem dự án', 'hello-elementor-child' ),
		'search_items'       => __( 'Tìm kiếm dự án', 'hello-elementor-child' ),
		'not_found'          => __( 'Không tìm thấy dự án', 'hello-elementor-child' ),
		'menu_name'          => __( 'Dự án', 'hello-elementor-child' ),
	];

	$args = [
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => [ 'slug' => 'du_an', 'with_front' => false ],
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_position'      => 5,
		'menu_icon'          => 'dashicons-portfolio',
		'supports'           => [ 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ],
	];

	register_post_type( 'du_an', $args );
}
add_action( 'init', 'eurostyle_register_cpt_du_an' );

/**
 * Ensure both /du_an/ and /du-an/ reliably open the Projects page without permanent browser caching
 */
add_action( 'template_redirect', function() {
	$uri = trim( parse_url( $_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH ), '/' );
	// If visiting /wordpress/du_an or /du_an (without a single project slug)
	if ( $uri === 'wordpress/du_an' || $uri === 'du_an' ) {
		wp_safe_redirect( home_url( '/du-an/' ), 302 );
		exit;
	}
} );

// Prevent browser from caching redirects
add_action( 'send_headers', function() {
	header( 'Cache-Control: no-cache, must-revalidate, max-age=0' );
} );



