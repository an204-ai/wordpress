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
$is_news     = is_page( 'tin-tuc' ) || is_singular( 'post' ) || is_category() || is_home();
$is_contact  = is_page( 'lien-he' );
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
				<a href="<?php echo esc_url( home_url( '/lien-he/' ) ); ?>">LIÊN HỆ</a>
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
			<a href="<?php echo esc_url( $home_url ); ?>" class="es-logo-brand" aria-label="Fountainhead Home">
				<span class="es-logo-text">Fountainhead</span>
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
					<li class="<?php echo $is_news ? 'active' : ''; ?>">
						<a href="<?php echo esc_url( home_url( '/tin-tuc/' ) ); ?>">Tin tức</a>
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
		if (scrollY > 20) {
			header.classList.add('scrolled');
		} else {
			header.classList.remove('scrolled');
		}

		if (document.body.classList.contains('admin-bar')) {
			if (window.innerWidth <= 600) {
				var adminBarOffset = Math.max(0, 46 - scrollY);
				header.style.top = adminBarOffset + 'px';
			} else if (window.innerWidth <= 782) {
				header.style.top = '46px';
			} else {
				header.style.top = '32px';
			}
		} else {
			header.style.top = '0px';
		}
	}

	function updateHeaderSpacer() {
		var topBar = header.querySelector('.es-top-bar');
		var navBar = header.querySelector('.es-main-nav-bar');
		var adminBarH = 0;
		if (document.body.classList.contains('admin-bar')) {
			var adminBar = document.getElementById('wpadminbar');
			adminBarH = adminBar ? adminBar.offsetHeight : (window.innerWidth <= 782 ? 46 : 32);
		}
		var navH = navBar ? navBar.offsetHeight : 61;
		var topH = (topBar && !header.classList.contains('scrolled')) ? topBar.offsetHeight : 34;
		var totalSpacer = navH + topH + adminBarH;
		document.documentElement.style.setProperty('--es-header-spacer', totalSpacer + 'px');
	}

	window.addEventListener('scroll', updateHeader, { passive: true });
	window.addEventListener('resize', function(){
		updateHeader();
		updateHeaderSpacer();
	}, { passive: true });
	updateHeader();
	updateHeaderSpacer();
	document.addEventListener('DOMContentLoaded', updateHeaderSpacer);
})();

// Scroll reveal animation for process timeline
document.addEventListener('DOMContentLoaded', function() {
	var timelines = document.querySelectorAll('.es-process-timeline');
	if (!timelines.length) return;

	if ('IntersectionObserver' in window) {
		var observer = new IntersectionObserver(function(entries) {
			entries.forEach(function(entry) {
				if (entry.isIntersecting) {
					entry.target.classList.add('is-in-view');
					observer.unobserve(entry.target);
				}
			});
		}, { threshold: 0.15 });

		timelines.forEach(function(tl) {
			observer.observe(tl);
		});
	} else {
		timelines.forEach(function(tl) {
			tl.classList.add('is-in-view');
		});
	}
});
</script>
