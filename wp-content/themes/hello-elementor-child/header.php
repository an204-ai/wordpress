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
	<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
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
			<?php if ( $is_home ) : ?>
				<h1 class="es-logo-heading-wrap">
					<a href="<?php echo esc_url( $home_url ); ?>" class="es-logo-brand" aria-label="Fountainhead Home">
						<span class="es-logo-text">Fountainhead</span>
					</a>
				</h1>
			<?php else : ?>
				<a href="<?php echo esc_url( $home_url ); ?>" class="es-logo-brand" aria-label="Fountainhead Home">
					<span class="es-logo-text">Fountainhead</span>
				</a>
			<?php endif; ?>

			<nav class="es-navigation" aria-label="Menu chính">
				<ul class="es-menu-tabs">
					<li class="<?php echo $is_services ? 'active' : ''; ?>">
						<a href="<?php echo esc_url( home_url( '/nang-luc-dich-vu/' ) ); ?>">Năng lực &amp; Dịch vụ</a>
					</li>
					<li class="<?php echo $is_projects ? 'active' : ''; ?>">
						<a href="<?php echo esc_url( home_url( '/du-an/' ) ); ?>">Dự án</a>
					</li>
					<li class="<?php echo $is_workshop ? 'active' : ''; ?>">
						<a href="<?php echo esc_url( home_url( '/nha-xuong-cong-nghe/' ) ); ?>">Nhà xưởng &amp; Công nghệ</a>
					</li>
					<li class="<?php echo $is_news ? 'active' : ''; ?>">
						<a href="<?php echo esc_url( home_url( '/tin-tuc/' ) ); ?>">Tin tức</a>
					</li>
				</ul>
			</nav>

			<!-- Mobile Hamburger Toggle -->
			<button class="es-mobile-menu-toggle" id="esMobileMenuToggle" aria-label="Mở menu điều hướng" aria-expanded="false">
				<span class="es-hamburger-box">
					<span class="es-hamburger-inner"></span>
				</span>
			</button>
		</div>
	</div>
</header>

<!-- Mobile Navigation Drawer Overlay -->
<div class="es-mobile-drawer" id="esMobileDrawer" aria-hidden="true">
	<div class="es-mobile-drawer-backdrop" id="esMobileDrawerBackdrop"></div>
	<div class="es-mobile-drawer-panel">
		<div class="es-mobile-drawer-header">
			<a href="<?php echo esc_url( $home_url ); ?>" class="es-logo-brand" aria-label="Fountainhead Home">
				<span class="es-logo-text">Fountainhead</span>
			</a>
			<button class="es-mobile-drawer-close" id="esMobileDrawerClose" aria-label="Đóng menu">
				<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
			</button>
		</div>
		<div class="es-mobile-drawer-body">
			<nav class="es-mobile-nav" aria-label="Menu di động">
				<ul class="es-mobile-menu-list">
					<li class="<?php echo $is_services ? 'active' : ''; ?>">
						<a href="<?php echo esc_url( home_url( '/nang-luc-dich-vu/' ) ); ?>">
							<span>Năng lực &amp; Dịch vụ</span>
							<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
						</a>
					</li>
					<li class="<?php echo $is_projects ? 'active' : ''; ?>">
						<a href="<?php echo esc_url( home_url( '/du-an/' ) ); ?>">
							<span>Dự án tiêu biểu</span>
							<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
						</a>
					</li>
					<li class="<?php echo $is_workshop ? 'active' : ''; ?>">
						<a href="<?php echo esc_url( home_url( '/nha-xuong-cong-nghe/' ) ); ?>">
							<span>Nhà xưởng &amp; Công nghệ</span>
							<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
						</a>
					</li>
					<li class="<?php echo $is_news ? 'active' : ''; ?>">
						<a href="<?php echo esc_url( home_url( '/tin-tuc/' ) ); ?>">
							<span>Tin tức &amp; Xu hướng</span>
							<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
						</a>
					</li>
					<li class="<?php echo $is_contact ? 'active' : ''; ?>">
						<a href="<?php echo esc_url( home_url( '/lien-he/' ) ); ?>">
							<span>Liên hệ &amp; Hợp tác</span>
							<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
						</a>
					</li>
				</ul>
			</nav>

			<div class="es-mobile-drawer-cta">
				<a href="<?php echo esc_url( home_url( '/lien-he/' ) ); ?>" class="es-mobile-btn-consult">
					<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
					<span>Đặt Lịch Hẹn Tư Vấn</span>
				</a>
				<a href="tel:0902920579" class="es-mobile-btn-call">
					<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
					<span>Hotline: 0902.92.05.79</span>
				</a>
			</div>

			<div class="es-mobile-drawer-footer">
				<div class="es-mobile-lang">
					<span class="es-lang-active">VIE</span>
					<span class="es-lang-sep">|</span>
					<a href="#en" class="es-lang-link">ENG</a>
				</div>
				<div class="es-mobile-socials">
					<a href="https://www.facebook.com/fountainheadsuoinguon/?locale=vi_VN" target="_blank" rel="noopener noreferrer" aria-label="Facebook"><svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"/></svg></a>
					<a href="#" aria-label="Instagram"><svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg></a>
					<a href="#" aria-label="LinkedIn"><svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M4.98 3.5c0 1.381-1.11 2.5-2.48 2.5s-2.48-1.119-2.48-2.5c0-1.38 1.11-2.5 2.48-2.5s2.48 1.12 2.48 2.5zm.02 4.5h-5v16h5v-16zm7.982 0h-4.968v16h4.969v-8.399c0-4.67 6.029-5.052 6.029 0v8.399h4.988v-10.131c0-7.88-8.922-7.593-11.018-3.714v-2.155z"/></svg></a>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
(function(){
	var header = document.getElementById('site-header');
	if (!header) return;

	var drawer = document.getElementById('esMobileDrawer');
	var lastScrollY = window.scrollY || window.pageYOffset || 0;
	var isHidden = false;
	var isScrolled = false;
	var scrollThreshold = 8; // minimum delta in pixels to trigger hide/show
	var ticking = false;

	function updateHeaderState() {
		var currentScrollY = window.scrollY || window.pageYOffset || 0;

		// If mobile drawer is open, never hide header
		if (drawer && drawer.classList.contains('is-open')) {
			header.classList.remove('header-hidden');
			header.classList.add('header-visible');
			lastScrollY = currentScrollY;
			ticking = false;
			return;
		}

		// Near the very top of the page (<= 30px)
		if (currentScrollY <= 30) {
			header.classList.remove('header-hidden');
			header.classList.remove('header-visible');
			header.classList.remove('scrolled');
			isHidden = false;
			isScrolled = false;
			lastScrollY = currentScrollY;
			ticking = false;
			return;
		}

		// Past top threshold: mark header as scrolled (gives dark glassmorphism background)
		if (!isScrolled) {
			header.classList.add('scrolled');
			isScrolled = true;
		}

		var delta = currentScrollY - lastScrollY;

		// Scrolling DOWN past 80px -> Smoothly hide header
		if (delta > scrollThreshold && currentScrollY > 80) {
			if (!isHidden) {
				header.classList.add('header-hidden');
				header.classList.remove('header-visible');
				isHidden = true;
			}
		}
		// Scrolling UP -> Smoothly reveal header
		else if (delta < -scrollThreshold) {
			if (isHidden) {
				header.classList.remove('header-hidden');
				header.classList.add('header-visible');
				isHidden = false;
			}
		}

		lastScrollY = currentScrollY;
		ticking = false;
	}

	function onScroll() {
		if (!ticking) {
			window.requestAnimationFrame(updateHeaderState);
			ticking = true;
		}
	}

	window.addEventListener('scroll', onScroll, { passive: true });
	window.addEventListener('resize', onScroll, { passive: true });
	updateHeaderState();

	// Mobile Navigation Drawer Toggle
	var drawerToggle = document.getElementById('esMobileMenuToggle');
	var drawer = document.getElementById('esMobileDrawer');
	var drawerClose = document.getElementById('esMobileDrawerClose');
	var drawerBackdrop = document.getElementById('esMobileDrawerBackdrop');

	function openDrawer() {
		if (!drawer) return;
		drawer.classList.add('is-open');
		drawer.setAttribute('aria-hidden', 'false');
		if (drawerToggle) drawerToggle.setAttribute('aria-expanded', 'true');
		document.body.classList.add('es-drawer-open');
	}

	function closeDrawer() {
		if (!drawer) return;
		drawer.classList.remove('is-open');
		drawer.setAttribute('aria-hidden', 'true');
		if (drawerToggle) drawerToggle.setAttribute('aria-expanded', 'false');
		document.body.classList.remove('es-drawer-open');
	}

	if (drawerToggle) {
		drawerToggle.addEventListener('click', function(e) {
			e.preventDefault();
			if (drawer.classList.contains('is-open')) {
				closeDrawer();
			} else {
				openDrawer();
			}
		});
	}

	if (drawerClose) drawerClose.addEventListener('click', closeDrawer);
	if (drawerBackdrop) drawerBackdrop.addEventListener('click', closeDrawer);

	document.addEventListener('keydown', function(e) {
		if (e.key === 'Escape' && drawer && drawer.classList.contains('is-open')) {
			closeDrawer();
		}
	});
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
