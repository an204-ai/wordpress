<?php
/**
 * Template Name: Trang Danh Sách Tin Tức
 * Full-width luxury layout matching https://eurostyle.com.vn/tin-tuc/
 * Categorized sections (Bản tin, Sự kiện, Báo chí) with featured + stacked cards
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

// Get the 3 main news categories from database
$cat_slugs = [ 'ban-tin', 'su-kien', 'bao-chi' ];
$categories = [];

foreach ( $cat_slugs as $slug ) {
	$c = get_category_by_slug( $slug );
	if ( $c ) {
		$categories[] = $c;
	}
}

// Fallback: if categories not found by slug, get non-empty categories
if ( empty( $categories ) ) {
	$categories = get_categories([
		'exclude'    => [ 1 ], // exclude Uncategorized
		'hide_empty' => false,
		'number'     => 4,
	]);
}
?>

<main id="primary" class="site-main es-news-fw-page">

	<!-- 1. HERO BANNER -->
	<section class="es-news-hero">
		<div class="es-news-hero-bg"></div>
		<div class="es-news-hero-overlay"></div>
		<div class="es-news-hero-content">
			<h1 class="es-news-hero-title">TIN TỨC &amp; SỰ KIỆN</h1>
			<p class="es-news-hero-desc">Cập nhật những hoạt động mới nhất, góc nhìn chuyên gia kiến trúc và xu hướng vật liệu cao cấp từ Fountainhead.</p>
		</div>
	</section>

	<!-- FULL-WIDTH CONTENT WRAPPER -->
	<div class="es-news-fw-wrapper">

		<?php
		foreach ( $categories as $cat ) :
			// Query posts for this specific category
			$cat_query = new WP_Query([
				'post_type'      => 'post',
				'post_status'    => 'publish',
				'cat'            => $cat->term_id,
				'posts_per_page' => 3,
				'orderby'        => 'date',
				'order'          => 'DESC',
			]);

			if ( ! $cat_query->have_posts() ) {
				continue;
			}

			$posts_list = $cat_query->posts;
			$featured_post = $posts_list[0];
			$stacked_posts = array_slice( $posts_list, 1 );
		?>

			<!-- CATEGORY SECTION -->
			<section class="es-news-fw-section" id="section-<?php echo esc_attr( $cat->slug ); ?>">

				<!-- Section Header with Line and "Xem tất cả" -->
				<div class="es-news-fw-sec-head">
					<h2 class="es-news-fw-sec-title"><?php echo esc_html( mb_strtoupper( $cat->name, 'UTF-8' ) ); ?></h2>
					<div class="es-news-fw-sec-line"></div>
					<a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>" class="es-news-fw-see-all" aria-label="Xem tất cả bài viết trong mục <?php echo esc_attr( $cat->name ); ?>">
						<span>Xem tất cả</span>
						<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
					</a>
				</div>

				<!-- 2-Column Grid (Left: Featured, Right: Stacked) -->
				<div class="es-news-fw-grid <?php echo ( empty( $stacked_posts ) ) ? 'single-col' : ''; ?>">

					<!-- LEFT: FEATURED POST -->
					<?php
					$feat_id    = $featured_post->ID;
					$feat_date  = get_the_date( 'd/m/Y', $feat_id );
					$feat_thumb = has_post_thumbnail( $feat_id )
						? get_the_post_thumbnail_url( $feat_id, 'large' )
						: home_url( '/wp-content/uploads/2026/09/tin-tuc-tong-thau.jpg' );
					?>
					<article class="es-news-fw-card featured">
						<a href="<?php echo esc_url( get_permalink( $feat_id ) ); ?>" class="es-news-fw-card-link">
							<div class="es-news-fw-media">
								<img src="<?php echo esc_url( $feat_thumb ); ?>" alt="<?php echo esc_attr( get_the_title( $feat_id ) ); ?>" loading="lazy">
								<div class="es-news-fw-overlay"></div>
							</div>
							<div class="es-news-fw-content">
								<div class="es-news-fw-meta">
									<span class="es-news-fw-date">
										<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
										<?php echo esc_html( $feat_date ); ?>
									</span>
								</div>
								<h3 class="es-news-fw-heading"><?php echo esc_html( get_the_title( $feat_id ) ); ?></h3>
								<div class="es-news-fw-action">
									<span class="es-news-fw-action-link">
										<span class="es-news-dash"></span>
										<span>Xem thêm</span>
										<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
									</span>
								</div>
							</div>
						</a>
					</article>

					<!-- RIGHT: STACKED POSTS (UP TO 2) -->
					<?php if ( ! empty( $stacked_posts ) ) : ?>
						<div class="es-news-fw-stacked-wrap">
							<?php
							foreach ( $stacked_posts as $sub_post ) :
								$sub_id    = $sub_post->ID;
								$sub_date  = get_the_date( 'd/m/Y', $sub_id );
								$sub_thumb = has_post_thumbnail( $sub_id )
									? get_the_post_thumbnail_url( $sub_id, 'medium_large' )
									: home_url( '/wp-content/uploads/2026/09/tin-tuc-xuong-moc.jpg' );
							?>
								<article class="es-news-fw-card stacked">
									<a href="<?php echo esc_url( get_permalink( $sub_id ) ); ?>" class="es-news-fw-card-link">
										<div class="es-news-fw-media">
											<img src="<?php echo esc_url( $sub_thumb ); ?>" alt="<?php echo esc_attr( get_the_title( $sub_id ) ); ?>" loading="lazy">
											<div class="es-news-fw-overlay"></div>
										</div>
										<div class="es-news-fw-content">
											<div class="es-news-fw-meta">
												<span class="es-news-fw-date">
													<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
													<?php echo esc_html( $sub_date ); ?>
												</span>
											</div>
											<h3 class="es-news-fw-heading"><?php echo esc_html( get_the_title( $sub_id ) ); ?></h3>
											<div class="es-news-fw-action">
												<span class="es-news-fw-action-link">
													<span class="es-news-dash"></span>
													<span>Xem thêm</span>
													<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
												</span>
											</div>
										</div>
									</a>
								</article>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>

				</div>
			</section>

		<?php
			wp_reset_postdata();
		endforeach;
		?>

	</div>

	<!-- FAQ SECTION: CÂU HỎI THƯỜNG GẶP -->
	<section class="es-news-faq-section" id="faq-section">
		<div class="es-news-faq-container">
			<div class="es-news-faq-header">
				<h2 class="es-news-faq-title">Câu Hỏi Thường Gặp</h2>
				<p class="es-news-faq-desc">
					Giải đáp các thắc mắc phổ biến về quy trình thực thi, xưởng chế tác và cam kết chất lượng.
				</p>
			</div>

			<div class="es-faq-accordion" id="esFaqAccordion">
				
				<!-- Q1 -->
				<div class="es-faq-item">
					<button class="es-faq-question" type="button" aria-expanded="false">
						<span class="es-faq-q-text">1. Quy trình thiết kế &amp; thi công trọn gói (Design &amp; Build) tại Fountainhead mất bao lâu?</span>
						<span class="es-faq-icon">
							<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
								<line x1="12" y1="5" x2="12" y2="19" class="es-icon-v" />
								<line x1="5" y1="12" x2="19" y2="12" />
							</svg>
						</span>
					</button>
					<div class="es-faq-answer">
						<div class="es-faq-answer-inner">
							<p>Thời gian phụ thuộc vào quy mô và mức độ phức tạp của công trình. Thông thường, giai đoạn nghiên cứu ý tưởng và hoàn thiện hồ sơ thiết kế kỹ thuật thi công kéo dài từ 25 – 40 ngày. Giai đoạn gia công chế tác tại xưởng Quận 12 và thi công lắp dựng thực địa dao động từ 45 – 90 ngày. Nhờ tự chủ 100% xưởng sản xuất, Fountainhead giúp rút ngắn đến 25% tổng tiến độ so với các đơn vị thuê ngoài.</p>
						</div>
					</div>
				</div>

				<!-- Q2 -->
				<div class="es-faq-item">
					<button class="es-faq-question" type="button" aria-expanded="false">
						<span class="es-faq-q-text">2. Fountainhead có cam kết công trình thực tế giống 100% bản vẽ phối cảnh 3D không?</span>
						<span class="es-faq-icon">
							<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
								<line x1="12" y1="5" x2="12" y2="19" class="es-icon-v" />
								<line x1="5" y1="12" x2="19" y2="12" />
							</svg>
						</span>
					</button>
					<div class="es-faq-answer">
						<div class="es-faq-answer-inner">
							<p>Chúng tôi cam kết độ chính xác tối đa nhờ quy trình số hóa dữ liệu CAD/BIM kết nối trực tiếp với dàn máy gia công CNC 5 trục Châu Âu, bảo đảm dung sai cơ khí dưới 0.2mm. Đặc biệt, 100% hệ tủ module và vách kiến trúc phức tạp đều được lắp dựng thử nghiệm (Dry-fit Mockup) tại xưởng trước khi đóng gói vận chuyển, loại trừ hoàn toàn nguy cơ sai lệch kích thước khi ra công trường.</p>
						</div>
					</div>
				</div>

				<!-- Q3 -->
				<div class="es-faq-item">
					<button class="es-faq-question" type="button" aria-expanded="false">
						<span class="es-faq-q-text">3. Khách hàng có thể trực tiếp đến xưởng kiểm tra phôi gỗ và quy trình chế tác không?</span>
						<span class="es-faq-icon">
							<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
								<line x1="12" y1="5" x2="12" y2="19" class="es-icon-v" />
								<line x1="5" y1="12" x2="19" y2="12" />
							</svg>
						</span>
					</button>
					<div class="es-faq-answer">
						<div class="es-faq-answer-inner">
							<p>Rất hoan nghênh! Fountainhead luôn khuyến khích Quý khách hàng và Chủ đầu tư đến trực tiếp tổ hợp xưởng chế tác tại 28 Thạnh Xuân 31, Quận 12 để trực tiếp chạm vào thớ gỗ, xem đường keo dán cạnh PUR không line, kiểm tra mẫu màu sơn trong buồng áp lực dương và làm việc cùng các nghệ nhân trưởng của chúng tôi.</p>
						</div>
					</div>
				</div>

				<!-- Q4 -->
				<div class="es-faq-item">
					<button class="es-faq-question" type="button" aria-expanded="false">
						<span class="es-faq-q-text">4. Nguồn gốc xuất xứ của các loại gỗ và phụ kiện ngũ kim được bảo đảm ra sao?</span>
						<span class="es-faq-icon">
							<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
								<line x1="12" y1="5" x2="12" y2="19" class="es-icon-v" />
								<line x1="5" y1="12" x2="19" y2="12" />
							</svg>
						</span>
					</button>
					<div class="es-faq-answer">
						<div class="es-faq-answer-inner">
							<p>100% nguyên vật liệu và phụ kiện sử dụng tại Fountainhead đều có chứng nhận xuất xứ (CO) và chứng nhận chất lượng (CQ) rõ ràng. Gỗ tự nhiên (Óc chó Walnut, Sồi Mỹ) được tẩm sấy đạt độ ẩm chuẩn 8-12%; gỗ công nghiệp đạt chuẩn phát thải CARB P2 và E1 an toàn sức khỏe từ An Cường; ngũ kim thông minh nhập khẩu chính ngạch từ Häfele (Đức) và Blum (Áo).</p>
						</div>
					</div>
				</div>

				<!-- Q5 -->
				<div class="es-faq-item">
					<button class="es-faq-question" type="button" aria-expanded="false">
						<span class="es-faq-q-text">5. Chính sách bảo hành và bảo dưỡng công trình sau khi bàn giao như thế nào?</span>
						<span class="es-faq-icon">
							<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
								<line x1="12" y1="5" x2="12" y2="19" class="es-icon-v" />
								<line x1="5" y1="12" x2="19" y2="12" />
							</svg>
						</span>
					</button>
					<div class="es-faq-answer">
						<div class="es-faq-answer-inner">
							<p>Fountainhead áp dụng chế độ bảo hành kỹ thuật toàn diện 24 tháng cho mọi sản phẩm nội thất và bảo trì trọn đời công trình. Trong suốt thời gian sử dụng, đội ngũ kỹ thuật cơ động sẽ thực hiện kiểm tra, cân chỉnh phụ kiện và bảo dưỡng bề mặt gỗ định kỳ 6 tháng/lần hoàn toàn miễn phí.</p>
						</div>
					</div>
				</div>

				<!-- Q6 -->
				<div class="es-faq-item">
					<button class="es-faq-question" type="button" aria-expanded="false">
						<span class="es-faq-q-text">6. Chi phí thi công được dự toán như thế nào để đảm bảo không phát sinh ngân sách?</span>
						<span class="es-faq-icon">
							<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
								<line x1="12" y1="5" x2="12" y2="19" class="es-icon-v" />
								<line x1="5" y1="12" x2="19" y2="12" />
							</svg>
						</span>
					</button>
					<div class="es-faq-answer">
						<div class="es-faq-answer-inner">
							<p>Mô hình Design &amp; Build đồng bộ từ khâu bản vẽ đến xưởng sản xuất cho phép chúng tôi lập bảng bóc tách khối lượng (BoQ) và báo giá chính xác 100% dựa trên bản vẽ kỹ thuật chi tiết. Hợp đồng ký kết là hợp đồng trọn gói với cam kết không phát sinh bất kỳ chi phí ngoài thỏa thuận ban đầu nếu không có yêu cầu thay đổi thiết kế từ phía Chủ đầu tư.</p>
						</div>
					</div>
				</div>

			</div>
		</div>
	</section>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
	var faqItems = document.querySelectorAll('#esFaqAccordion .es-faq-item');
	faqItems.forEach(function(item) {
		var btn = item.querySelector('.es-faq-question');
		if (!btn) return;
		btn.addEventListener('click', function() {
			var isOpen = item.classList.contains('active');
			faqItems.forEach(function(other) {
				if (other !== item) {
					other.classList.remove('active');
					var otherBtn = other.querySelector('.es-faq-question');
					if (otherBtn) otherBtn.setAttribute('aria-expanded', 'false');
				}
			});
			if (isOpen) {
				item.classList.remove('active');
				btn.setAttribute('aria-expanded', 'false');
			} else {
				item.classList.add('active');
				btn.setAttribute('aria-expanded', 'true');
			}
		});
	});
});
</script>

<?php get_footer(); ?>

