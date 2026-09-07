<?php
/**
 * Fountainhead Comprehensive SEO, Social Sharing & Structured Data Engine
 * Dynamic Meta Titles, Meta Descriptions, OpenGraph, Twitter Cards, Schema.org JSON-LD, and Favicon
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Fountainhead_SEO_Manager {

	private static $instance = null;

	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function __construct() {
		// Document Title
		add_filter( 'pre_get_document_title', [ $this, 'filter_document_title' ], 99 );
		add_filter( 'document_title_parts', [ $this, 'filter_document_title_parts' ], 99 );

		// Head Tags (Meta description, OpenGraph, Twitter, Favicon, Canonical, Schema.org)
		add_action( 'wp_head', [ $this, 'render_seo_head_tags' ], 1 );
		add_action( 'wp_head', [ $this, 'render_favicon_tags' ], 2 );
		add_action( 'wp_head', [ $this, 'render_schema_jsonld' ], 20 );

		// Shortcode for Social Sharing Buttons
		add_shortcode( 'fountainhead_social_share', [ $this, 'render_social_share_shortcode' ] );
		add_shortcode( 'eurostyle_social_share', [ $this, 'render_social_share_shortcode' ] );
	}

	/**
	 * Get Current Context Metadata (Title, Description, Canonical, OG Image, OG Type)
	 */
	public function get_context_seo_data() {
		$site_name   = get_bloginfo( 'name' );
		if ( empty( $site_name ) || 'WordPress' === $site_name ) {
			$site_name = 'Fountainhead';
		}
		$default_img = get_stylesheet_directory_uri() . '/assets/images/favicon.svg';

		// Try to find a hero image in uploads for default OG image
		$hero_fallback = 'http://localhost/wordpress/wp-content/uploads/2026/09/hero-trang-chu.jpg';

		$data = [
			'title'       => $site_name . ' | Thiết Kế & Thi Công Nội Thất Cao Cấp',
			'description' => 'Fountainhead Design & Build – Tổng thầu thiết kế, thi công nội thất biệt thự, khách sạn, văn phòng cao cấp và nhà máy sản xuất đồ gỗ chuẩn quốc tế tại TP.HCM.',
			'url'         => home_url( '/' ),
			'type'        => 'website',
			'image'       => $hero_fallback,
		];

		if ( is_front_page() || is_home() ) {
			$data['title']       = $site_name . ' | Thiết Kế & Thi Công Nội Thất Cao Cấp & Nhà Xưởng Chuẩn Quốc Tế';
			$data['description'] = 'Fountainhead Design & Build – Tổng thầu thiết kế, thi công nội thất biệt thự, khách sạn, văn phòng cao cấp và nhà máy sản xuất đồ gỗ chuẩn quốc tế tại TP.HCM.';
			$data['url']         = home_url( '/' );
			$data['type']        = 'website';
			$data['image']       = $hero_fallback;
		} elseif ( is_page( 'nang-luc-dich-vu' ) ) {
			$data['title']       = 'Năng Lực & Dịch Vụ Thiết Kế Kiến Trúc Nội Thất | ' . $site_name;
			$data['description'] = 'Khám phá năng lực tổng thầu thiết kế, thi công nội thất trọn gói và quy trình quản trị dự án chuẩn mực quốc tế của Fountainhead.';
			$data['url']         = home_url( '/nang-luc-dich-vu/' );
			$data['type']        = 'website';
			$data['image']       = $hero_fallback;
		} elseif ( is_page( 'du-an' ) || ( is_archive() && 'du_an' === get_post_type() ) ) {
			$data['title']       = 'Hồ Sơ Dự Án Tiêu Biểu | Thiết Kế & Thi Công ' . $site_name;
			$data['description'] = 'Bộ sưu tập các công trình khách sạn, resort nghỉ dưỡng, văn phòng thương mại và biệt thự cao cấp do Fountainhead kiến tạo.';
			$data['url']         = home_url( '/du-an/' );
			$data['type']        = 'website';
			$data['image']       = $hero_fallback;
		} elseif ( is_singular( 'du_an' ) ) {
			$pid          = get_the_ID();
			$title        = get_the_title( $pid );
			$area         = get_post_meta( $pid, '_es_area', true );
			$location     = get_post_meta( $pid, '_es_location', true );
			$style        = get_post_meta( $pid, '_es_style', true );
			$thumb_url    = has_post_thumbnail( $pid ) ? get_the_post_thumbnail_url( $pid, 'full' ) : get_post_meta( $pid, '_es_hero_img', true );

			$desc_parts = [];
			if ( ! empty( $location ) ) $desc_parts[] = 'Địa điểm: ' . $location;
			if ( ! empty( $area ) ) $desc_parts[] = 'Diện tích: ' . $area;
			if ( ! empty( $style ) ) $desc_parts[] = 'Phong cách: ' . $style;
			$desc_extra = ! empty( $desc_parts ) ? ' (' . implode( ' | ', $desc_parts ) . ')' : '';

			$excerpt = get_the_excerpt( $pid );
			if ( empty( $excerpt ) ) {
				$excerpt = wp_trim_words( strip_tags( get_the_content( null, false, $pid ) ), 28, '...' );
			}

			$data['title']       = $title . ' - Dự Án Thiết Kế & Thi Công | ' . $site_name;
			$data['description'] = ! empty( $excerpt ) ? $excerpt . $desc_extra : 'Dự án ' . $title . ' thực hiện bởi Fountainhead Design & Build.' . $desc_extra;
			$data['url']         = get_permalink( $pid );
			$data['type']        = 'article';
			if ( ! empty( $thumb_url ) ) {
				$data['image'] = $thumb_url;
			}
		} elseif ( is_page( 'nha-xuong-cong-nghe' ) ) {
			$data['title']       = 'Nhà Xưởng Sản Xuất Đồ Gỗ & Công Nghệ Chế Tác Cao Cấp | ' . $site_name;
			$data['description'] = 'Nhà máy sản xuất nội thất gỗ quy mô lớn tại TP.HCM với hệ thống máy móc hiện đại và quy trình kiểm soát chất lượng QA/QC nghiêm ngặt.';
			$data['url']         = home_url( '/nha-xuong-cong-nghe/' );
			$data['type']        = 'website';
			$data['image']       = $hero_fallback;
		} elseif ( is_page( 'tin-tuc' ) ) {
			$data['title']       = 'Tin Tức, Sự Kiện & Xu Hướng Kiến Trúc Nội Thất | ' . $site_name;
			$data['description'] = 'Cập nhật những hoạt động mới nhất, góc nhìn chuyên gia kiến trúc và xu hướng vật liệu cao cấp từ Fountainhead.';
			$data['url']         = home_url( '/tin-tuc/' );
			$data['type']        = 'website';
			$data['image']       = $hero_fallback;
		} elseif ( is_singular( 'post' ) ) {
			$pid       = get_the_ID();
			$title     = get_the_title( $pid );
			$excerpt   = get_the_excerpt( $pid );
			if ( empty( $excerpt ) ) {
				$excerpt = wp_trim_words( strip_tags( get_the_content( null, false, $pid ) ), 30, '...' );
			}
			$thumb_url = has_post_thumbnail( $pid ) ? get_the_post_thumbnail_url( $pid, 'full' ) : $hero_fallback;

			$data['title']       = $title . ' | Tin Tức ' . $site_name;
			$data['description'] = $excerpt;
			$data['url']         = get_permalink( $pid );
			$data['type']        = 'article';
			$data['image']       = $thumb_url;
		} elseif ( is_category() ) {
			$cat_name = single_cat_title( '', false );
			$cat_desc = category_description();
			if ( empty( $cat_desc ) ) {
				$cat_desc = 'Tổng hợp các bài viết chuyên mục ' . $cat_name . ' từ Fountainhead Design & Build.';
			}
			$data['title']       = $cat_name . ' | Tin Tức ' . $site_name;
			$data['description'] = wp_strip_all_tags( $cat_desc );
			$data['url']         = get_category_link( get_queried_object_id() );
			$data['type']        = 'website';
		} elseif ( is_page( 'lien-he' ) ) {
			$data['title']       = 'Liên Hệ & Đặt Lịch Hẹn Tư Vấn Dự Án | ' . $site_name;
			$data['description'] = 'Liên hệ trực tiếp với Fountainhead hoặc đặt lịch hẹn tư vấn thiết kế thi công nội thất, hợp tác cung ứng vật liệu trên toàn quốc.';
			$data['url']         = home_url( '/lien-he/' );
			$data['type']        = 'website';
			$data['image']       = $hero_fallback;
		} elseif ( is_page() ) {
			$pid = get_the_ID();
			$data['title']       = get_the_title( $pid ) . ' | ' . $site_name;
			$data['description'] = get_the_excerpt( $pid ) ?: 'Fountainhead Design & Build - ' . get_the_title( $pid );
			$data['url']         = get_permalink( $pid );
			$data['type']        = 'website';
		}

		return $data;
	}

	/**
	 * Filter Document Title for SEO
	 */
	public function filter_document_title( $title ) {
		$seo_data = $this->get_context_seo_data();
		return $seo_data['title'];
	}

	public function filter_document_title_parts( $parts ) {
		$seo_data = $this->get_context_seo_data();
		return [ 'title' => $seo_data['title'] ];
	}

	/**
	 * Render Comprehensive Head Tags
	 */
	public function render_seo_head_tags() {
		$seo = $this->get_context_seo_data();
		$site_name = get_bloginfo( 'name' ) ?: 'Fountainhead';
		?>
		<!-- FOUNTAINHEAD SEO MASTER ENGINE -->
		<title><?php echo esc_html( $seo['title'] ); ?></title>
		<meta name="description" content="<?php echo esc_attr( $seo['description'] ); ?>" />
		<meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1" />
		<link rel="canonical" href="<?php echo esc_url( $seo['url'] ); ?>" />

		<!-- OpenGraph / Facebook / Zalo -->
		<meta property="og:locale" content="vi_VN" />
		<meta property="og:type" content="<?php echo esc_attr( $seo['type'] ); ?>" />
		<meta property="og:title" content="<?php echo esc_attr( $seo['title'] ); ?>" />
		<meta property="og:description" content="<?php echo esc_attr( $seo['description'] ); ?>" />
		<meta property="og:url" content="<?php echo esc_url( $seo['url'] ); ?>" />
		<meta property="og:site_name" content="<?php echo esc_attr( $site_name ); ?>" />
		<meta property="og:image" content="<?php echo esc_url( $seo['image'] ); ?>" />
		<meta property="og:image:secure_url" content="<?php echo esc_url( $seo['image'] ); ?>" />
		<meta property="og:image:width" content="1200" />
		<meta property="og:image:height" content="630" />
		<meta property="og:image:alt" content="<?php echo esc_attr( $seo['title'] ); ?>" />

		<!-- Twitter / X Cards -->
		<meta name="twitter:card" content="summary_large_image" />
		<meta name="twitter:title" content="<?php echo esc_attr( $seo['title'] ); ?>" />
		<meta name="twitter:description" content="<?php echo esc_attr( $seo['description'] ); ?>" />
		<meta name="twitter:image" content="<?php echo esc_url( $seo['image'] ); ?>" />

		<!-- Theme Color for Mobile Browsers -->
		<meta name="theme-color" content="#141312" />
		<meta name="msapplication-navbutton-color" content="#141312" />
		<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
		<?php
	}

	/**
	 * Render Favicon & App Icons from Uploaded Brand Logo
	 */
	public function render_favicon_tags() {
		$logo_png = home_url( '/wp-content/uploads/2026/09/logo.png' );
		$logo_150 = home_url( '/wp-content/uploads/2026/09/logo-150x150.png' );
		$logo_300 = home_url( '/wp-content/uploads/2026/09/logo-300x205.png' );
		?>
		<!-- FOUNTAINHEAD OFFICIAL BRAND FAVICON -->
		<link rel="icon" type="image/png" sizes="32x32" href="<?php echo esc_url( $logo_150 ); ?>" />
		<link rel="icon" type="image/png" sizes="192x192" href="<?php echo esc_url( $logo_300 ); ?>" />
		<link rel="apple-touch-icon" sizes="180x180" href="<?php echo esc_url( $logo_png ); ?>" />
		<link rel="shortcut icon" href="<?php echo esc_url( $logo_150 ); ?>" />
		<?php
	}

	/**
	 * Render Schema.org JSON-LD Structured Data
	 */
	public function render_schema_jsonld() {
		$home_url  = home_url( '/' );
		$site_name = get_bloginfo( 'name' ) ?: 'Fountainhead';
		$logo_url  = home_url( '/wp-content/uploads/2026/09/logo.png' );
		$seo_data  = $this->get_context_seo_data();

		$schemas = [];

		// 1. Organization & LocalBusiness
		$schemas[] = [
			'@context' => 'https://schema.org',
			'@type'    => [ 'Organization', 'HomeAndConstructionBusiness', 'GeneralContractor' ],
			'@id'      => $home_url . '#organization',
			'name'     => 'Fountainhead Design & Build',
			'alternateName' => 'Fountainhead',
			'url'      => $home_url,
			'logo'     => [
				'@type'      => 'ImageObject',
				'url'        => $logo_url,
				'caption'    => 'Fountainhead Logo',
			],
			'image'    => $seo_data['image'],
			'description' => 'Tổng thầu thiết kế, thi công nội thất biệt thự, khách sạn cao cấp và nhà máy sản xuất đồ gỗ chuẩn quốc tế tại Việt Nam.',
			'telephone'   => '+84902920579',
			'email'       => 'info@suoinguon.vn',
			'address'     => [
				'@type'           => 'PostalAddress',
				'streetAddress'   => '285-287 Bạch Đằng, Phường 15',
				'addressLocality' => 'Quận Bình Thạnh',
				'addressRegion'   => 'Hồ Chí Minh',
				'postalCode'      => '700000',
				'addressCountry'  => 'VN',
			],
			'geo'         => [
				'@type'     => 'GeoCoordinates',
				'latitude'  => 10.8037,
				'longitude' => 106.7028,
			],
			'openingHoursSpecification' => [
				[
					'@type'     => 'OpeningHoursSpecification',
					'dayOfWeek' => [ 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday' ],
					'opens'     => '08:00',
					'closes'    => '17:30',
				],
			],
			'sameAs' => [
				'https://www.facebook.com/fountainheadsuoinguon/?locale=vi_VN',
				'https://instagram.com',
				'https://linkedin.com',
				'https://youtube.com',
			],
		];

		// 2. WebSite with SiteNavigationElement
		$schemas[] = [
			'@context' => 'https://schema.org',
			'@type'    => 'WebSite',
			'@id'      => $home_url . '#website',
			'url'      => $home_url,
			'name'     => $site_name,
			'publisher' => [
				'@id' => $home_url . '#organization',
			],
			'inLanguage' => 'vi',
		];

		// 3. BreadcrumbList for subpages
		if ( ! is_front_page() && ! is_home() ) {
			$items = [
				[
					'@type'    => 'ListItem',
					'position' => 1,
					'name'     => 'Trang Chủ',
					'item'     => $home_url,
				],
			];

			if ( is_page() ) {
				$items[] = [
					'@type'    => 'ListItem',
					'position' => 2,
					'name'     => get_the_title(),
					'item'     => get_permalink(),
				];
			} elseif ( is_singular( 'du_an' ) ) {
				$items[] = [
					'@type'    => 'ListItem',
					'position' => 2,
					'name'     => 'Dự Án',
					'item'     => home_url( '/du-an/' ),
				];
				$items[] = [
					'@type'    => 'ListItem',
					'position' => 3,
					'name'     => get_the_title(),
					'item'     => get_permalink(),
				];
			} elseif ( is_singular( 'post' ) ) {
				$items[] = [
					'@type'    => 'ListItem',
					'position' => 2,
					'name'     => 'Tin Tức',
					'item'     => home_url( '/tin-tuc/' ),
				];
				$items[] = [
					'@type'    => 'ListItem',
					'position' => 3,
					'name'     => get_the_title(),
					'item'     => get_permalink(),
				];
			}

			$schemas[] = [
				'@context'        => 'https://schema.org',
				'@type'           => 'BreadcrumbList',
				'itemListElement' => $items,
			];
		}

		// 4. Specific Page Type Schemas
		if ( is_singular( 'post' ) ) {
			$pid = get_the_ID();
			$schemas[] = [
				'@context'         => 'https://schema.org',
				'@type'            => 'Article',
				'headline'         => get_the_title( $pid ),
				'description'      => $seo_data['description'],
				'image'            => $seo_data['image'],
				'datePublished'    => get_the_date( 'c', $pid ),
				'dateModified'     => get_the_modified_date( 'c', $pid ),
				'mainEntityOfPage' => get_permalink( $pid ),
				'author'           => [
					'@type' => 'Person',
					'name'  => get_the_author_meta( 'display_name', get_post_field( 'post_author', $pid ) ) ?: 'Fountainhead Editorial',
				],
				'publisher'        => [
					'@id' => $home_url . '#organization',
				],
			];
		} elseif ( is_page( 'lien-he' ) ) {
			$schemas[] = [
				'@context'    => 'https://schema.org',
				'@type'       => 'ContactPage',
				'name'        => 'Liên Hệ Fountainhead',
				'description' => $seo_data['description'],
				'url'         => home_url( '/lien-he/' ),
			];
		}

		foreach ( $schemas as $schema ) {
			echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ) . '</script>' . "\n";
		}
	}

	/**
	 * Render Modern Social Share Bar
	 */
	public function render_social_share_shortcode( $atts = [] ) {
		global $post;
		$url   = get_permalink();
		$title = get_the_title();

		$encoded_url   = rawurlencode( $url );
		$encoded_title = rawurlencode( $title );

		// Share links
		$fb_link       = 'https://www.facebook.com/sharer/sharer.php?u=' . $encoded_url;
		$zalo_link     = 'https://zalo.me/share?url=' . $encoded_url . '&title=' . $encoded_title;
		$tw_link       = 'https://twitter.com/intent/tweet?text=' . $encoded_title . '&url=' . $encoded_url;
		$linkedin_link = 'https://www.linkedin.com/sharing/share-offsite/?url=' . $encoded_url;
		$tg_link       = 'https://t.me/share/url?url=' . $encoded_url . '&text=' . $encoded_title;

		ob_start();
		?>
		<div class="es-social-share-wrap">
			<span class="es-share-label">Chia sẻ:</span>
			<div class="es-share-buttons">
				<!-- Facebook -->
				<a href="<?php echo esc_url( $fb_link ); ?>" target="_blank" rel="noopener noreferrer" class="es-share-btn es-share-fb" aria-label="Chia sẻ qua Facebook" title="Chia sẻ Facebook">
					<svg width="15" height="15" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
					<span>Facebook</span>
				</a>
				<!-- Zalo -->
				<a href="<?php echo esc_url( $zalo_link ); ?>" target="_blank" rel="noopener noreferrer" class="es-share-btn es-share-zalo" aria-label="Chia sẻ qua Zalo" title="Chia sẻ Zalo">
					<span style="font-weight: 800; font-size: 11px; letter-spacing: -0.5px;">Zalo</span>
				</a>
				<!-- LinkedIn -->
				<a href="<?php echo esc_url( $linkedin_link ); ?>" target="_blank" rel="noopener noreferrer" class="es-share-btn es-share-linkedin" aria-label="Chia sẻ qua LinkedIn" title="Chia sẻ LinkedIn">
					<svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
					<span>LinkedIn</span>
				</a>
				<!-- X / Twitter -->
				<a href="<?php echo esc_url( $tw_link ); ?>" target="_blank" rel="noopener noreferrer" class="es-share-btn es-share-twitter" aria-label="Chia sẻ qua X / Twitter" title="Chia sẻ X">
					<svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
					<span>X</span>
				</a>
				<!-- Copy Link -->
				<button type="button" class="es-share-btn es-share-copy" onclick="navigator.clipboard.writeText('<?php echo esc_js( $url ); ?>'); alert('Đã sao chép liên kết bài viết thành công!');" aria-label="Sao chép liên kết" title="Sao chép link">
					<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
					<span>Sao chép link</span>
				</button>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

// Initialize SEO Engine
Fountainhead_SEO_Manager::get_instance();
