<?php
/**
 * Template Name: Trang Năng Lực & Dịch Vụ
 * Architectural Shapes & Minimalist Luxury Editorial Layout (Inspired by EuroStyle)
 * Clean typographic aesthetic, authentic geometric shapes, and zero clutter.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="primary" class="site-main es-about-editorial-page">

	<!-- 1. HERO BANNER -->
	<section class="es-about-hero">
		<div class="es-about-hero-bg"></div>
		<div class="es-about-hero-overlay"></div>
		<div class="es-about-hero-content">
			<h1 class="es-about-hero-title">Năng Lực &amp; Dịch Vụ</h1>
			<p class="es-about-hero-desc">
				Fountainhead tự hào là đơn vị tổng thầu Design &amp; Build tiên phong, kiến tạo những không gian kiến trúc, nội thất và công nghiệp chuẩn mực quốc tế.
			</p>
		</div>
	</section>

	<!-- 2. SHAPES SECTION WITH WARM GREIGE BACKGROUND -->
	<section class="es-about-shapes-section">
		<div class="es-about-shapes-container">

			<!-- ROW 1: Narrative & Roman Arch Shape -->
			<div class="es-about-row es-about-row-1">
				<div class="es-about-col-text">
					<p class="es-about-narrative">
						Fountainhead sở hữu hệ sinh thái toàn diện chuẩn quốc tế từ tư vấn – thiết kế – thi công – sản xuất và hoàn thiện phân khúc cao cấp với những dự án tầm vóc, từ tư gia đến trụ sở văn phòng, nhà máy công nghiệp và khu nghỉ dưỡng mang tính biểu tượng như Keppel Land, CapitaLand, DKSH, P&amp;G, Đất Việt VAC, Sacombank.
					</p>
				</div>
				<div class="es-about-col-shape">
					<div class="es-shape-arch-frame">
						<img src="<?php echo esc_url( home_url( '/wp-content/uploads/2026/09/techcombank-tower-featured.jpg' ) ); ?>" alt="Kiến trúc biểu tượng Fountainhead" loading="lazy">
					</div>
				</div>
			</div>

			<!-- ROW 2: Circle Oculus Shape & Workshop Narrative -->
			<div class="es-about-row es-about-row-2">
				<div class="es-about-col-shape">
					<div class="es-shape-circle-frame">
						<img src="<?php echo esc_url( home_url( '/wp-content/uploads/2026/04/fountainhead-xuong-moc-san-xuat-thanh-xuan-31-quan-12.jpg' ) ); ?>" alt="Kỹ nghệ chế tác mộc tại xưởng Quận 12" loading="lazy">
					</div>
				</div>
				<div class="es-about-col-text">
					<p class="es-about-narrative es-narrative-secondary">
						Sở hữu tổ hợp xưởng mộc 2.000m² tại Thạnh Xuân 31 (Quận 12) cùng hệ thống máy móc CNC số hóa hiện đại, Fountainhead làm chủ 100% chất lượng từ bản vẽ đến từng thớ gỗ hoàn thiện, xóa bỏ nguy cơ phát sinh chi phí và bảo đảm tiến độ thực thi chuẩn xác.
					</p>
				</div>
			</div>

			<!-- ROW 3: Tầm Nhìn & Rectangle Shape -->
			<div class="es-about-row es-about-row-3">
				<div class="es-about-col-text">
					<div class="es-vision-sub-block">
						<h2 class="es-editorial-subheading">Tầm nhìn</h2>
						<p class="es-vision-narrative">
							Fountainhead nỗ lực không ngừng để kiến tạo nên chuẩn mực mới cho các công trình văn phòng và công nghiệp cao cấp, dẫn đầu về chất lượng kỹ nghệ mộc và giải pháp thi công bền vững tại Việt Nam.
						</p>
					</div>
				</div>
				<div class="es-about-col-shape">
					<div class="es-shape-rect-frame">
						<img src="<?php echo esc_url( home_url( '/wp-content/uploads/2026/09/the-coral-villa-featured.jpg' ) ); ?>" alt="Không gian hoàn thiện The Coral Villa" loading="lazy">
					</div>
				</div>
			</div>

		</div>
	</section>

	<!-- 3. SỨ MỆNH BLOCK (BLACK BACKGROUND TRANSITION) -->
	<section class="es-mission-dark-section">
		<div class="es-about-shapes-container">
			<div class="es-mission-content">
				<h2 class="es-editorial-subheading es-text-white">Sứ mệnh</h2>
				<p class="es-mission-narrative">
					Phát triển hệ sinh thái toàn diện từ tư vấn, thiết kế, sản xuất trực tiếp và thi công hoàn thiện với quy chuẩn khắt khe nhất, mang lại giá trị gia tăng tối ưu và đồng hành bền vững cùng mỗi Chủ đầu tư.
				</p>
			</div>
		</div>
	</section>

	<!-- 4. SERVICES ACCORDION (DỊCH VỤ - SOLID BLACK BACKGROUND) -->
	<section class="es-editorial-services-section">
		<div class="es-editorial-inner-container">
			<h2 class="es-editorial-sec-title">Dịch Vụ</h2>

			<div class="es-services-euro-accordion" id="esServicesEuroAccordion">

				<!-- 1. Văn phòng -->
				<div class="es-euro-acc-item active">
					<button type="button" class="es-euro-acc-header" aria-expanded="true">
						<span class="es-euro-acc-title">1. THƯƠNG HIỆU &amp; VĂN PHÒNG DOANH NGHIỆP</span>
						<span class="es-euro-acc-sign" aria-hidden="true"></span>
					</button>
					<div class="es-euro-acc-content">
						<p>Thiết kế và thi công hoàn thiện hơn 200 văn phòng làm việc cho các tập đoàn đa quốc gia và thương hiệu lớn: Keppel Land, DKSH, Dragon Capital, Đất Việt VAC, Sacombank... Tối ưu công năng và nhận diện thương hiệu.</p>
					</div>
				</div>

				<!-- 2. Nhà máy -->
				<div class="es-euro-acc-item">
					<button type="button" class="es-euro-acc-header" aria-expanded="false">
						<span class="es-euro-acc-title">2. NHÀ MÁY &amp; CÔNG TRÌNH CÔNG NGHIỆP</span>
						<span class="es-euro-acc-sign" aria-hidden="true"></span>
					</button>
					<div class="es-euro-acc-content">
						<p>Hơn 100 dự án nhà máy và nhà xưởng công nghiệp quy mô lớn: Nhà máy P&amp;G, DKSH, Nhà máy Giấy An Bình, Casta AFL, Best Pacific, UPL... Đáp ứng chuẩn kỹ thuật quốc tế và an toàn công trường.</p>
					</div>
				</div>

				<!-- 3. Nghỉ dưỡng -->
				<div class="es-euro-acc-item">
					<button type="button" class="es-euro-acc-header" aria-expanded="false">
						<span class="es-euro-acc-title">3. BẤT ĐỘNG SẢN NGHỈ DƯỠNG &amp; NHÀ HÀNG</span>
						<span class="es-euro-acc-sign" aria-hidden="true"></span>
					</button>
					<div class="es-euro-acc-content">
						<p>Thiết kế kiến trúc và thi công hoàn thiện khu nghỉ dưỡng, biệt thự biển và chuỗi nhà hàng cao cấp độc bản: Dốc Lết Beach Resort &amp; Spa, Nhà hàng Sinh thái Hum Thảo Điền Quận 2...</p>
					</div>
				</div>

				<!-- 4. Xưởng mộc -->
				<div class="es-euro-acc-item">
					<button type="button" class="es-euro-acc-header" aria-expanded="false">
						<span class="es-euro-acc-title">4. SẢN XUẤT NỘI THẤT &amp; XƯỞNG MỘC TRỰC TIẾP</span>
						<span class="es-euro-acc-sign" aria-hidden="true"></span>
					</button>
					<div class="es-euro-acc-content">
						<p>Xưởng mộc gia công đồ gỗ nội thất tại Thạnh Xuân 31 (Quận 12), làm chủ 100% nguyên vật liệu, cấu kiện module dry-fit và kiểm soát chất lượng QA/QC nghiêm ngặt qua từng công đoạn.</p>
					</div>
				</div>

				<!-- 5. Fit-out Design & Build -->
				<div class="es-euro-acc-item">
					<button type="button" class="es-euro-acc-header" aria-expanded="false">
						<span class="es-euro-acc-title">5. TỔNG THẦU THI CÔNG FIT-OUT CHÌA KHÓA TRAO TAY</span>
						<span class="es-euro-acc-sign" aria-hidden="true"></span>
					</button>
					<div class="es-euro-acc-content">
						<p>Giải pháp Design &amp; Build trọn gói từ bóc tách khối lượng (BoQ), dự toán minh bạch đến quản lý công trường chuẩn xác từng milimet, cam kết bàn giao đúng tiến độ và không phát sinh ngân sách.</p>
					</div>
				</div>

			</div>
		</div>
	</section>

	<!-- 5. CHẶNG ĐƯỜNG PHÁT TRIỂN (TIMELINE SECTION) -->
	<section class="es-editorial-timeline-section">
		<div class="es-editorial-inner-container">
			<h2 class="es-timeline-sec-title">CHẶNG ĐƯỜNG PHÁT TRIỂN</h2>

			<div class="es-timeline-axis-wrap">
				<div class="es-timeline-axis-line"></div>
				<div class="es-timeline-grid">
					
					<div class="es-timeline-node">
						<div class="es-timeline-year">2024</div>
						<div class="es-timeline-dot"></div>
						<p class="es-timeline-desc">Bàn giao văn phòng Đất Việt VAC &amp; mở rộng tổ hợp xưởng Quận 12</p>
					</div>

					<div class="es-timeline-node">
						<div class="es-timeline-year">2022</div>
						<div class="es-timeline-dot"></div>
						<p class="es-timeline-desc">Hoàn thiện tổ hợp nhà máy DKSH &amp; dự án Keppel Land</p>
					</div>

					<div class="es-timeline-node">
						<div class="es-timeline-year">2018</div>
						<div class="es-timeline-dot"></div>
						<p class="es-timeline-desc">Mở rộng phân khúc nghỉ dưỡng &amp; biệt thự cao cấp</p>
					</div>

					<div class="es-timeline-node">
						<div class="es-timeline-year">2012</div>
						<div class="es-timeline-dot"></div>
						<p class="es-timeline-desc">Cán mốc 100 công trình văn phòng &amp; nhà xưởng quy mô lớn</p>
					</div>

					<div class="es-timeline-node">
						<div class="es-timeline-year">2007</div>
						<div class="es-timeline-dot"></div>
						<p class="es-timeline-desc">Thành lập Fountainhead Design &amp; Build tại TP. Hồ Chí Minh</p>
					</div>

				</div>
			</div>
		</div>
	</section>

</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
	var accordion = document.getElementById('esServicesEuroAccordion');
	if (accordion) {
		var items = accordion.querySelectorAll('.es-euro-acc-item');
		items.forEach(function(item) {
			var header = item.querySelector('.es-euro-acc-header');
			if (!header) return;
			header.addEventListener('click', function() {
				var isOpen = item.classList.contains('active');
				items.forEach(function(other) {
					if (other !== item) {
						other.classList.remove('active');
						var otherBtn = other.querySelector('.es-euro-acc-header');
						if (otherBtn) otherBtn.setAttribute('aria-expanded', 'false');
					}
				});
				if (isOpen) {
					item.classList.remove('active');
					header.setAttribute('aria-expanded', 'false');
				} else {
					item.classList.add('active');
					header.setAttribute('aria-expanded', 'true');
				}
			});
		});
	}
});
</script>

<?php
get_footer();
