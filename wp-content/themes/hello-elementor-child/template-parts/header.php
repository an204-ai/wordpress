<?php
/**
 * EuroStyle Header Template (Exact visual replica of eurostyle.com.vn)
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$home_url    = home_url( '/' );
$current_url = home_url( add_query_arg( [], $GLOBALS['wp']->request ) );
if ( ! str_ends_with( $current_url, '/' ) ) {
	$current_url .= '/';
}

$is_home     = is_front_page() || is_home();
$is_services = is_page( 'nang-luc-dich-vu' );
$is_projects = is_page( 'du-an' );
$is_workshop = is_page( 'nha-xuong-cong-nghe' );
?>
<header id="site-header" class="site-header">
	<!-- Top Mini Utility Bar -->
	<div class="es-top-bar">
		<div class="es-top-bar-inner">
			<div class="es-lang-switch">
				<span style="color: var(--es-gold); font-weight: 500;">VIE</span> &nbsp;|&nbsp; <a href="#en">ENG</a>
			</div>
			<div class="es-top-links">
				<span>HOTLINE: <strong style="color: #ffffff; font-weight: 500;">1800 28 28 06</strong></span>
				<span>&bull;</span>
				<a href="<?php echo esc_url( home_url( '/nang-luc-dich-vu/' ) ); ?>">HỒ SƠ NĂNG LỰC</a>
				<span>&bull;</span>
				<a href="#lien-he">LIÊN HỆ</a>
			</div>
		</div>
	</div>

	<!-- Main Navigation Bar -->
	<div class="es-main-nav-bar">
		<div class="es-main-nav-inner">
			<!-- Logo EuroStyle -->
			<a href="<?php echo esc_url( $home_url ); ?>" class="es-logo-brand" aria-label="EuroStyle Home">
				<span class="es-logo-text">EUROSTYLE</span>
				<span class="es-logo-tagline">DESIGN &amp; BUILD</span>
			</a>

			<!-- 4 Main Navigation Tabs -->
			<nav class="es-navigation" aria-label="Menu chính">
				<ul class="es-menu-tabs">
					<li class="<?php echo $is_home ? 'active current-menu-item' : ''; ?>">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>">Trang chủ</a>
					</li>
					<li class="<?php echo $is_services ? 'active current-menu-item' : ''; ?>">
						<a href="<?php echo esc_url( home_url( '/nang-luc-dich-vu/' ) ); ?>">Năng lực &amp; Dịch vụ</a>
					</li>
					<li class="<?php echo $is_projects ? 'active current-menu-item' : ''; ?>">
						<a href="<?php echo esc_url( home_url( '/du-an/' ) ); ?>">Dự án</a>
					</li>
					<li class="<?php echo $is_workshop ? 'active current-menu-item' : ''; ?>">
						<a href="<?php echo esc_url( home_url( '/nha-xuong-cong-nghe/' ) ); ?>">Nhà xưởng &amp; Công nghệ</a>
					</li>
				</ul>
			</nav>

			<!-- CTA Button (Pill Style) -->
			<div class="es-header-actions">
				<a href="#dat-lich" class="btn-es-pill-solid">
					<span>Đặt lịch tư vấn</span>
				</a>
			</div>
		</div>
	</div>
</header>
