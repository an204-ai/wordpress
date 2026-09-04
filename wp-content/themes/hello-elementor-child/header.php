<?php
/**
 * EuroStyle Header - Transparent overlay on hero (like eurostyle.com.vn)
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$home_url    = home_url( '/' );
$is_home     = is_front_page() || is_home();
$is_services = is_page( 'nang-luc-dich-vu' );
$is_projects = is_page( 'du-an' ) || is_singular( 'du_an' );
$is_workshop = is_page( 'nha-xuong-cong-nghe' );
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header id="site-header" class="site-header">
	<!-- Top Utility Bar -->
	<div class="es-top-bar">
		<div class="es-top-bar-inner">
			<div class="es-top-links">
				<svg class="es-icon-globe" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M2 12h20"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
				<span class="es-lang-active">VIE</span>
				<a href="#en" class="es-lang-link">ENG</a>
			</div>
			<div class="es-top-links">
				<a href="#lien-he">LIÊN HỆ</a>
				<a href="#">CƠ HỘI VIỆC LÀM</a>
				<span class="es-top-separator"></span>
				<a href="#" class="es-top-search">
					<span>Tìm kiếm</span>
					<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
				</a>
				<a href="#" class="es-top-icon" aria-label="Tài khoản">
					<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
				</a>
			</div>
		</div>
	</div>

	<!-- Main Navigation Bar -->
	<div class="es-main-nav-bar">
		<div class="es-main-nav-inner">
			<a href="<?php echo esc_url( $home_url ); ?>" class="es-logo-brand" aria-label="EuroStyle Home">
				<span class="es-logo-text">EuroStyle</span>
			</a>

			<nav class="es-navigation" aria-label="Menu chính">
				<ul class="es-menu-tabs">
					<li class="<?php echo $is_services ? 'active' : ''; ?>">
						<a href="<?php echo esc_url( home_url( '/nang-luc-dich-vu/' ) ); ?>">Năng lực & Dịch vụ</a>
					</li>
					<li class="<?php echo $is_projects ? 'active' : ''; ?>">
						<a href="<?php echo esc_url( home_url( '/du-an/' ) ); ?>">Dự án</a>
					</li>
					<li class="<?php echo $is_workshop ? 'active' : ''; ?>">
						<a href="<?php echo esc_url( home_url( '/nha-xuong-cong-nghe/' ) ); ?>">Nhà xưởng & Công nghệ</a>
					</li>
				</ul>
			</nav>
		</div>
	</div>
</header>

<script>
(function(){
	var header = document.getElementById('site-header');
	if (!header) return;

	function updateHeader() {
		var scrollY = window.scrollY || window.pageYOffset || 0;
		if (scrollY > 80) {
			header.classList.add('scrolled');
		} else {
			header.classList.remove('scrolled');
		}

		if (document.body.classList.contains('admin-bar') && window.innerWidth <= 600) {
			var adminBarOffset = Math.max(0, 46 - scrollY);
			header.style.top = adminBarOffset + 'px';
		} else if (document.body.classList.contains('admin-bar')) {
			header.style.top = '';
		}
	}

	window.addEventListener('scroll', updateHeader, { passive: true });
	window.addEventListener('resize', updateHeader, { passive: true });
	updateHeader();
})();
</script>
