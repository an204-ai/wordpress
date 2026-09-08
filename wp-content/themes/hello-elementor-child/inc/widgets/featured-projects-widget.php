<?php
/**
 * Fountainhead Featured Project Banner Slider Widget for Elementor
 * Queries all projects dynamically from database and provides Left/Right arrow navigation.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Fountainhead_Featured_Project_Slider_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'fountainhead_featured_project_slider';
	}

	public function get_title() {
		return __( 'Dự Án Nổi Bật Slider (2 Mũi Tên)', 'hello-elementor-child' );
	}

	public function get_icon() {
		return 'eicon-slider-push';
	}

	public function get_categories() {
		return [ 'general', 'fountainhead-elements' ];
	}

	public function get_keywords() {
		return [ 'project', 'featured', 'banner', 'slider', 'arrow', 'fountainhead', 'du an' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_query',
			[
				'label' => __( 'Cấu Hình Dự Án', 'hello-elementor-child' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'posts_count',
			[
				'label'   => __( 'Số Lượng Dự Án', 'hello-elementor-child' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'min'     => 2,
				'max'     => 12,
				'step'    => 1,
				'default' => 6,
			]
		);

		$this->add_control(
			'tag_label',
			[
				'label'   => __( 'Nhãn Tiêu Đề Phụ (Tag Label)', 'hello-elementor-child' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => 'DỰ ÁN NỔI BẬT',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$count    = ! empty( $settings['posts_count'] ) ? intval( $settings['posts_count'] ) : 6;
		$tag_lbl  = ! empty( $settings['tag_label'] ) ? esc_html( $settings['tag_label'] ) : 'DỰ ÁN NỔI BẬT';

		$query = new WP_Query( [
			'post_type'      => 'du_an',
			'post_status'    => 'publish',
			'posts_per_page' => $count,
			'orderby'        => 'date',
			'order'          => 'DESC',
		] );

		if ( ! $query->have_posts() ) {
			return;
		}

		$slider_id = 'es-feat-proj-slider-' . $this->get_id();
		$total_posts = $query->post_count;
		?>
		<div id="<?php echo esc_attr( $slider_id ); ?>" class="es-featured-proj-slider" data-total="<?php echo esc_attr( $total_posts ); ?>">
			<div class="es-featured-proj-track">
				<?php
				$idx = 0;
				while ( $query->have_posts() ) :
					$query->the_post();
					$pid       = get_the_ID();
					$title     = get_the_title( $pid );
					$link      = get_permalink( $pid );
					$is_active = ( $idx === 0 ) ? 'is-active' : '';

					$terms = get_the_terms( $pid, 'danh_muc_du_an' );
					$cat_name = ( ! empty( $terms ) && ! is_wp_error( $terms ) ) ? $terms[0]->name : 'Fit-out & Architecture';

					$thumb_url = has_post_thumbnail( $pid )
						? get_the_post_thumbnail_url( $pid, 'full' )
						: home_url( '/wp-content/uploads/2026/09/fountainhead-featured-center-luxury.jpg' );
				?>
					<div class="es-featured-proj-slide <?php echo esc_attr( $is_active ); ?>" data-index="<?php echo esc_attr( $idx ); ?>">
						<div class="es-featured-proj-bg" style="background-image: url('<?php echo esc_url( $thumb_url ); ?>');"></div>
						<div class="es-featured-proj-curtain"></div>
						<div class="es-featured-proj-content">
							<span class="es-featured-proj-badge"><?php echo esc_html( $tag_lbl ); ?> • <?php echo esc_html( mb_strtoupper( $cat_name, 'UTF-8' ) ); ?></span>
							<h2 class="es-featured-proj-title"><?php echo esc_html( $title ); ?></h2>
							<div class="es-featured-proj-btn-wrap">
								<a href="<?php echo esc_url( $link ); ?>" class="es-featured-proj-cta-btn">
									<span>Xem chi tiết</span>
									<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"></path><path d="M12 5l7 7-7 7"></path></svg>
								</a>
							</div>
						</div>
					</div>
				<?php
					$idx++;
				endwhile;
				wp_reset_postdata();
				?>
			</div>

			<!-- Left & Right Glassmorphism Navigation Arrows (Identical styling to 'Xem chi tiết' button) -->
			<button type="button" class="es-proj-arrow es-proj-arrow-prev" aria-label="Dự án trước">
				<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
			</button>
			<button type="button" class="es-proj-arrow es-proj-arrow-next" aria-label="Dự án tiếp theo">
				<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
			</button>
		</div>

		<style>
		#<?php echo esc_attr( $slider_id ); ?> .es-proj-arrow {
			position: absolute !important;
			top: 50% !important;
			transform: translateY(-50%) !important;
			width: 42px !important;
			height: 42px !important;
			border-radius: 50% !important;
			background: rgba(30, 30, 30, 0.65) !important;
			backdrop-filter: blur(10px) !important;
			-webkit-backdrop-filter: blur(10px) !important;
			border: 1.5px solid rgba(255, 255, 255, 0.6) !important;
			color: #ffffff !important;
			display: flex !important;
			align-items: center !important;
			justify-content: center !important;
			cursor: pointer !important;
			z-index: 10 !important;
			transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1) !important;
			box-shadow: 0 4px 16px rgba(0, 0, 0, 0.3) !important;
			outline: none !important;
			padding: 0 !important;
			margin: 0 !important;
			-webkit-appearance: none !important;
			appearance: none !important;
		}
		#<?php echo esc_attr( $slider_id ); ?> .es-proj-arrow-prev {
			left: 30px !important;
		}
		#<?php echo esc_attr( $slider_id ); ?> .es-proj-arrow-next {
			right: 30px !important;
		}
		#<?php echo esc_attr( $slider_id ); ?> .es-proj-arrow:hover {
			background: #ffffff !important;
			color: #111111 !important;
			border-color: #ffffff !important;
			transform: translateY(-50%) scale(1.08) !important;
			box-shadow: 0 6px 20px rgba(255, 255, 255, 0.3), 0 4px 16px rgba(0, 0, 0, 0.4) !important;
		}
		#<?php echo esc_attr( $slider_id ); ?> .es-proj-arrow:focus,
		#<?php echo esc_attr( $slider_id ); ?> .es-proj-arrow:focus-visible {
			outline: none !important;
			box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.4) !important;
			background: rgba(30, 30, 30, 0.65) !important;
			color: #ffffff !important;
		}
		#<?php echo esc_attr( $slider_id ); ?> .es-proj-arrow:focus:hover {
			background: #ffffff !important;
			color: #111111 !important;
			border-color: #ffffff !important;
		}
		#<?php echo esc_attr( $slider_id ); ?> .es-proj-arrow:active {
			background: #ffffff !important;
			color: #111111 !important;
			border-color: #ffffff !important;
			transform: translateY(-50%) scale(0.94) !important;
		}
		#<?php echo esc_attr( $slider_id ); ?> .es-proj-arrow svg {
			display: block !important;
			stroke: currentColor !important;
			transition: transform 0.25s ease !important;
		}
		#<?php echo esc_attr( $slider_id ); ?> .es-proj-arrow-prev:hover svg {
			transform: translateX(-1.5px) !important;
		}
		#<?php echo esc_attr( $slider_id ); ?> .es-proj-arrow-next:hover svg {
			transform: translateX(1.5px) !important;
		}
		@media (max-width: 768px) {
			#<?php echo esc_attr( $slider_id ); ?> .es-proj-arrow {
				width: 36px !important;
				height: 36px !important;
			}
			#<?php echo esc_attr( $slider_id ); ?> .es-proj-arrow-prev {
				left: 12px !important;
			}
			#<?php echo esc_attr( $slider_id ); ?> .es-proj-arrow-next {
				right: 12px !important;
			}
		}
		</style>

		<script>
		(function() {
			function initFeatSlider() {
				var slider = document.getElementById('<?php echo esc_js( $slider_id ); ?>');
				if (!slider || slider.dataset.initialized === 'true') return;
				slider.dataset.initialized = 'true';

				var slides = slider.querySelectorAll('.es-featured-proj-slide');
				var btnPrev = slider.querySelector('.es-proj-arrow-prev');
				var btnNext = slider.querySelector('.es-proj-arrow-next');
				if (slides.length <= 1) {
					if (btnPrev) btnPrev.style.display = 'none';
					if (btnNext) btnNext.style.display = 'none';
					return;
				}

				var currentIndex = 0;

				function showSlide(nextIndex) {
					slides.forEach(function(slide, idx) {
						if (idx === nextIndex) {
							slide.classList.add('is-active');
						} else {
							slide.classList.remove('is-active');
						}
					});
					currentIndex = nextIndex;
				}

				if (btnPrev) {
					btnPrev.addEventListener('click', function(e) {
						e.preventDefault();
						e.stopPropagation();
						var prevIdx = (currentIndex - 1 + slides.length) % slides.length;
						showSlide(prevIdx);
					});
				}

				if (btnNext) {
					btnNext.addEventListener('click', function(e) {
						e.preventDefault();
						e.stopPropagation();
						var nextIdx = (currentIndex + 1) % slides.length;
						showSlide(nextIdx);
					});
				}

				// Touch swipe support
				var touchStartX = 0;
				var touchEndX = 0;
				slider.addEventListener('touchstart', function(e) {
					touchStartX = e.changedTouches[0].screenX;
				}, { passive: true });

				slider.addEventListener('touchend', function(e) {
					touchEndX = e.changedTouches[0].screenX;
					if (touchStartX - touchEndX > 50) {
						var nextIdx = (currentIndex + 1) % slides.length;
						showSlide(nextIdx);
					} else if (touchEndX - touchStartX > 50) {
						var prevIdx = (currentIndex - 1 + slides.length) % slides.length;
						showSlide(prevIdx);
					}
				}, { passive: true });
			}

			if (document.readyState === 'loading') {
				document.addEventListener('DOMContentLoaded', initFeatSlider);
			} else {
				initFeatSlider();
			}

			if (window.elementorFrontend && window.elementorFrontend.hooks) {
				window.elementorFrontend.hooks.addAction('frontend/element_ready/fountainhead_featured_project_slider.default', initFeatSlider);
			}
		})();
		</script>
		<?php
	}
}
