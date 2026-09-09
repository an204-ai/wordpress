<?php
/**
 * Fountainhead Hero Multi-Media Slider Widget for Elementor
 * Inspired by https://eurostyle.com.vn/
 * Default Video background (muted, loop, autoplay, no controls, manual slide change via right-edge square dots).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Fountainhead_Hero_Slider_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'fountainhead_hero_slider';
	}

	public function get_title() {
		return __( 'Hero Banner Slider (Video & Ảnh)', 'hello-elementor-child' );
	}

	public function get_icon() {
		return 'eicon-slides';
	}

	public function get_categories() {
		return [ 'general', 'fountainhead-elements' ];
	}

	public function get_keywords() {
		return [ 'hero', 'banner', 'slider', 'video', 'image', 'eurostyle', 'fountainhead' ];
	}

	protected function register_controls() {

		// Section: Slides Content
		$this->start_controls_section(
			'section_slides',
			[
				'label' => __( 'Danh Sách Banner Slides', 'hello-elementor-child' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'slide_title',
			[
				'label'       => __( 'Tiêu Đề Slide (Serif Giữa Màn Hình)', 'hello-elementor-child' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => 'Fountainhead Heritage Center',
				'placeholder' => 'Nhập tiêu đề hoặc để trống',
				'description' => __( 'Tiêu đề chữ lớn phong cách tạp chí kiến trúc (như EuroStyle)', 'hello-elementor-child' ),
			]
		);

		$repeater->add_control(
			'slide_type',
			[
				'label'   => __( 'Loại Nền Banner', 'hello-elementor-child' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'image',
				'options' => [
					'video'   => __( 'Video nền (MP4 / YouTube)', 'hello-elementor-child' ),
					'image'   => __( 'Hình ảnh', 'hello-elementor-child' ),
				],
			]
		);

		$repeater->add_control(
			'image',
			[
				'label'     => __( 'Chọn Hình Ảnh', 'hello-elementor-child' ),
				'type'      => \Elementor\Controls_Manager::MEDIA,
				'default'   => [
					'url' => home_url( '/wp-content/uploads/2026/09/hero-trang-chu.jpg' ),
				],
				'condition' => [
					'slide_type' => 'image',
				],
			]
		);

		$repeater->add_control(
			'video_url',
			[
				'label'       => __( 'Đường Dẫn Video (MP4 hoặc YouTube)', 'hello-elementor-child' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => 'https://assets.mixkit.co/videos/preview/mixkit-modern-building-architectural-details-42287-large.mp4',
				'placeholder' => 'https://domain.com/video.mp4 hoặc link YouTube',
				'condition'   => [
					'slide_type' => 'video',
				],
			]
		);

		$repeater->add_control(
			'video_poster',
			[
				'label'       => __( 'Ảnh Poster Video (Khi đang tải)', 'hello-elementor-child' ),
				'type'        => \Elementor\Controls_Manager::MEDIA,
				'default'     => [
					'url' => home_url( '/wp-content/uploads/2026/09/hero-trang-chu.jpg' ),
				],
				'condition'   => [
					'slide_type' => 'video',
				],
			]
		);

		$this->add_control(
			'slides',
			[
				'label'       => __( 'Danh sách Slides', 'hello-elementor-child' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'slide_title'  => 'Fountainhead Heritage Center',
						'slide_type'   => 'video',
						'video_url'    => 'https://assets.mixkit.co/videos/preview/mixkit-modern-building-architectural-details-42287-large.mp4',
						'video_poster' => [ 'url' => home_url( '/wp-content/uploads/2026/09/hero-trang-chu.jpg' ) ],
					],
					[
						'slide_title'  => 'The Coral Signature',
						'slide_type'   => 'image',
						'image'        => [ 'url' => home_url( '/wp-content/uploads/2026/09/fountainhead-featured-center-luxury.jpg' ) ],
					],
					[
						'slide_title'  => 'Bất Động Sản Nghỉ Dưỡng',
						'slide_type'   => 'image',
						'image'        => [ 'url' => home_url( '/wp-content/uploads/2026/09/fountainhead-resort-luxury.jpg' ) ],
					],
					[
						'slide_title'  => 'Tổ Hợp Kỹ Nghệ Mộc Thạnh Xuân',
						'slide_type'   => 'image',
						'image'        => [ 'url' => home_url( '/wp-content/uploads/2026/09/hero-nha-xuong-cong-nghe.jpg' ) ],
					],
				],
				'title_field' => '{{{ slide_title ? slide_title : (slide_type === "video" ? "🎬 Video Slide" : "🖼️ Image Slide") }}}',
			]
		);

		$this->end_controls_section();

		// Section: Settings
		$this->start_controls_section(
			'section_settings',
			[
				'label' => __( 'Cài Đặt Giao Diện (Settings)', 'hello-elementor-child' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'overlay_color',
			[
				'label'   => __( 'Màu Lớp Phủ Tối (Overlay)', 'hello-elementor-child' ),
				'type'    => \Elementor\Controls_Manager::COLOR,
				'default' => 'rgba(0, 0, 0, 0.35)',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$slides   = ! empty( $settings['slides'] ) ? $settings['slides'] : [];
		$overlay  = ! empty( $settings['overlay_color'] ) ? esc_attr( $settings['overlay_color'] ) : 'rgba(0, 0, 0, 0.35)';

		if ( empty( $slides ) ) {
			return;
		}

		$slider_id = 'es-hero-slider-' . $this->get_id();
		?>
		<div id="<?php echo esc_attr( $slider_id ); ?>" class="es-hero-multi-slider">
			<div class="es-hero-slider-track">
				<?php foreach ( $slides as $index => $slide ) : 
					$is_active   = ( $index === 0 ) ? 'is-active' : '';
					$type        = $slide['slide_type'] ?? 'image';
					$title       = ! empty( $slide['slide_title'] ) ? $slide['slide_title'] : '';
					$video_url   = ! empty( $slide['video_url'] ) ? $slide['video_url'] : '';
					$is_youtube  = ( strpos( $video_url, 'youtube.com' ) !== false || strpos( $video_url, 'youtu.be' ) !== false );
				?>
					<div class="es-hero-slider-item <?php echo esc_attr( $is_active ); ?> es-item-<?php echo esc_attr( $type ); ?>" data-index="<?php echo esc_attr( $index ); ?>">
						<?php if ( $type === 'video' && ! empty( $video_url ) ) : 
							$poster = ! empty( $slide['video_poster']['url'] ) ? $slide['video_poster']['url'] : '';
							
							if ( $is_youtube ) :
								// Extract YouTube ID
								preg_match( '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $video_url, $yt_match );
								$yt_id = $yt_match[1] ?? 'b200bIKY3k0';
							?>
								<div class="es-hero-video-wrapper es-hero-yt-wrapper">
									<iframe id="yt-hero-player-<?php echo esc_attr( $this->get_id() ); ?>" class="es-hero-yt-iframe" src="https://www.youtube-nocookie.com/embed/<?php echo esc_attr( $yt_id ); ?>?autoplay=1&mute=1&controls=0&loop=1&playlist=<?php echo esc_attr( $yt_id ); ?>&showinfo=0&rel=0&iv_load_policy=3&disablekb=1&modestbranding=1&playsinline=1&enablejsapi=1&fs=0&origin=<?php echo esc_attr( home_url() ); ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
								</div>
							<?php else : ?>
								<div class="es-hero-video-wrapper">
									<video class="es-hero-bg-video" autoplay muted loop playsinline preload="auto" disablepictureinpicture controlslist="nodownload nofullscreen" <?php echo ! empty( $poster ) ? 'poster="' . esc_url( $poster ) . '"' : ''; ?>>
										<source src="<?php echo esc_url( $video_url ); ?>" type="video/mp4">
									</video>
								</div>
							<?php endif; ?>
						<?php else : 
							$img_url = ! empty( $slide['image']['url'] ) ? $slide['image']['url'] : home_url( '/wp-content/uploads/2026/09/hero-trang-chu.jpg' );
						?>
							<div class="es-hero-image-bg" style="background-image: url('<?php echo esc_url( $img_url ); ?>');"></div>
						<?php endif; ?>
						
						<!-- Dark Transparent Overlay -->
						<div class="es-hero-slider-overlay" style="background-color: <?php echo esc_attr( $overlay ); ?>;"></div>

						<!-- Centered Serif Heading (Like EuroStyle Heritage Center) -->
						<?php if ( ! empty( $title ) ) : 
							$heading_tag = ( is_front_page() && $index === 0 ) ? 'h1' : 'h2';
						?>
							<div class="es-hero-slide-content">
								<<?php echo $heading_tag; ?> class="es-hero-slide-title"><?php echo esc_html( $title ); ?></<?php echo $heading_tag; ?>>
							</div>
						<?php endif; ?>
					</div>
				<?php endforeach; ?>
			</div>

			<!-- Right-Edge Vertical Square Dots (EuroStyle Pagination) -->
			<?php if ( count( $slides ) > 1 ) : ?>
				<nav class="es-hero-slider-dots" aria-label="Điều hướng slide banner">
					<?php foreach ( $slides as $index => $slide ) : 
						$dot_active = ( $index === 0 ) ? 'is-active' : '';
					?>
						<button type="button" class="es-hero-dot <?php echo esc_attr( $dot_active ); ?>" data-slide-index="<?php echo esc_attr( $index ); ?>" aria-label="Chuyển sang slide <?php echo esc_attr( $index + 1 ); ?>"></button>
					<?php endforeach; ?>
				</nav>
			<?php endif; ?>
		</div>

		<script>
		(function() {
			var slider = document.getElementById('<?php echo esc_js( $slider_id ); ?>');
			if (!slider) return;

			var items = slider.querySelectorAll('.es-hero-slider-item');
			var dots = slider.querySelectorAll('.es-hero-dot');
			var ytIframe = slider.querySelector('.es-hero-yt-iframe');
			var ytPlayer = null;

			// Initialize YouTube Iframe API for rock-solid mobile autoplay & no pause controls
			if (ytIframe) {
				if (!window.YT || !window.YT.Player) {
					var tag = document.createElement('script');
					tag.src = "https://www.youtube.com/iframe_api";
					var firstScriptTag = document.getElementsByTagName('script')[0];
					firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
				}

				function initYT() {
					if (window.YT && window.YT.Player) {
						ytPlayer = new YT.Player(ytIframe.id, {
							events: {
								onReady: function(e) {
									e.target.mute();
									e.target.playVideo();
								},
								onStateChange: function(e) {
									// If mobile browser pauses video automatically, force resume muted
									if (e.data === YT.PlayerState.PAUSED) {
										e.target.playVideo();
									}
								}
							}
						});
					} else {
						setTimeout(initYT, 100);
					}
				}
				initYT();

				// Mobile Autoplay Trigger on first user interaction (touch/scroll)
				function triggerMobilePlay() {
					if (ytPlayer && typeof ytPlayer.playVideo === 'function') {
						ytPlayer.mute();
						ytPlayer.playVideo();
					}
					var vids = slider.querySelectorAll('video');
					vids.forEach(function(v) {
						v.muted = true;
						v.play().catch(function(){});
					});
				}
				['touchstart', 'touchend', 'scroll', 'click'].forEach(function(evt) {
					document.addEventListener(evt, triggerMobilePlay, { once: true, passive: true });
				});
			}

			if (items.length <= 1) return;

			var currentIndex = 0;

			function showSlide(nextIndex) {
				items.forEach(function(item, idx) {
					if (idx === nextIndex) {
						item.classList.add('is-active');
						var vid = item.querySelector('video');
						if (vid) {
							vid.currentTime = 0;
							vid.play().catch(function(){});
						}
						if (ytPlayer && typeof ytPlayer.playVideo === 'function') {
							ytPlayer.playVideo();
						}
					} else {
						item.classList.remove('is-active');
					}
				});

				dots.forEach(function(dot, idx) {
					if (idx === nextIndex) {
						dot.classList.add('is-active');
					} else {
						dot.classList.remove('is-active');
					}
				});

				currentIndex = nextIndex;
			}

			// Add click event to dots - ONLY changes on manual click
			dots.forEach(function(dot) {
				dot.addEventListener('click', function(e) {
					e.preventDefault();
					var targetIdx = parseInt(this.getAttribute('data-slide-index'), 10);
					if (!isNaN(targetIdx) && targetIdx !== currentIndex) {
						showSlide(targetIdx);
					}
				});
			});
		})();
		</script>
		<?php
	}
}
