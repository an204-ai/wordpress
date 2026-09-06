<?php
/**
 * EuroStyle Footer Template (Exact replica of eurostyle.com.vn)
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$cta_bg_1 = 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?q=80&w=1200&auto=format&fit=crop';
$cta_bg_2 = 'https://images.unsplash.com/photo-1497366216548-37526070297c?q=80&w=1200&auto=format&fit=crop';
?>
<footer id="site-footer" class="site-footer-es">
	<!-- Dual Call-to-Action Cards (Signature EuroStyle Footer Feature) -->
	<div class="es-footer-cta-cards" id="dat-lich">
		<div class="es-cta-card" style="background-image: url('<?php echo esc_url( $cta_bg_1 ); ?>');">
			<div class="es-cta-card-content">
				<span style="color: var(--es-gold); font-size: 11px; letter-spacing: 3px; text-transform: uppercase; font-weight: 500;">DỊCH VỤ TỔNG THẦU</span>
				<h3 class="serif-title">ĐẶT LỊCH TƯ VẤN DỰ ÁN</h3>
				<p style="color: #cccccc; font-size: 14px; max-width: 460px; margin-bottom: 24px; font-weight: 300;">
					Cùng đội ngũ kiến trúc sư trưởng và chuyên gia của Fountainhead hiện thực hóa công trình hoàn mỹ của bạn.
				</p>
				<a href="<?php echo esc_url( home_url( '/lien-he/' ) ); ?>" class="btn-es-pill-solid">
					<span>Đặt lịch ngay</span>
				</a>
			</div>
		</div>

		<div class="es-cta-card" style="background-image: url('<?php echo esc_url( $cta_bg_2 ); ?>'); border-left: 1px solid rgba(255,255,255,0.08);">
			<div class="es-cta-card-content">
				<span style="color: var(--es-gold); font-size: 11px; letter-spacing: 3px; text-transform: uppercase; font-weight: 500;">HỒ SƠ CÔNG TY</span>
				<h3 class="serif-title">TRỞ THÀNH ĐỐI TÁC FOUNTAINHEAD</h3>
				<p style="color: #cccccc; font-size: 14px; max-width: 460px; margin-bottom: 24px; font-weight: 300;">
					Hợp tác cùng Fountainhead trong các dự án tổng thầu Design &amp; Build và cung ứng đồ gỗ nội thất chất lượng cao.
				</p>
				<a href="<?php echo esc_url( home_url( '/lien-he/' ) ); ?>" class="btn-es-pill-outline">
					<span>Hợp tác ngay</span>
				</a>
			</div>
		</div>
	</div>

	<!-- Main Footer Info -->
	<div class="es-main-footer" id="lien-he">
		<div class="es-main-footer-inner">
			<div class="es-footer-grid">
				<!-- Brand & Mission -->
				<div class="es-footer-col">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="es-logo-brand" style="margin-bottom: 20px;">
						<span class="es-logo-text" style="font-size: 22px;">FOUNTAINHEAD</span>
						<span class="es-logo-tagline">DESIGN &amp; BUILD</span>
					</a>
					<p style="color: var(--es-text-muted); font-size: 13px; line-height: 1.8; margin-bottom: 20px;">
						Công ty Cổ phần Thiết kế và Xây dựng Fountainhead (Suối Nguồn) – Thành lập từ năm 2007, chuyên thực hiện các dự án "Chìa khoá trao tay": thiết kế, thi công hoàn thiện trọn gói nội thất do xưởng mộc của công ty sản xuất với chất lượng cao và chi phí tối ưu.
					</p>
					<div style="font-size: 13px; color: #aaaaaa; display: flex; flex-direction: column; gap: 8px;">
						<div><strong style="color: var(--es-gold); font-weight: 400;">Hotline:</strong> 0902 92 05 79 / 028 3512 4220</div>
						<div><strong style="color: var(--es-gold); font-weight: 400;">Email:</strong> info@suoinguon.vn</div>
					</div>
				</div>

				<!-- Hệ thống Showroom -->
				<div class="es-footer-col">
					<h4>Hệ thống Cơ sở</h4>
					<div style="font-size: 13px; color: var(--es-text-muted); line-height: 1.8;">
						<p style="margin-bottom: 12px;"><strong style="color: #ffffff; font-weight: 400;">Trụ sở chính:</strong><br>285-287 Bạch Đằng, Phường 15, Quận Bình Thạnh, TP.HCM</p>
						<p style="margin-bottom: 0;"><strong style="color: #ffffff; font-weight: 400;">Xưởng mộc sản xuất:</strong><br>Số 28 Đường Thạnh Xuân 31, Phường Thạnh Xuân, Quận 12, TP.HCM</p>
					</div>
				</div>

				<!-- Phân hệ Trang -->
				<div class="es-footer-col">
					<h4>Danh mục</h4>
					<ul>
						<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Trang chủ</a></li>
						<li><a href="<?php echo esc_url( home_url( '/nang-luc-dich-vu/' ) ); ?>">Năng lực &amp; Dịch vụ</a></li>
						<li><a href="<?php echo esc_url( home_url( '/du-an/' ) ); ?>">Hồ sơ dự án</a></li>
						<li><a href="<?php echo esc_url( home_url( '/nha-xuong-cong-nghe/' ) ); ?>">Nhà xưởng &amp; Công nghệ</a></li>
						<li><a href="<?php echo esc_url( home_url( '/lien-he/' ) ); ?>">Liên hệ</a></li>
					</ul>
				</div>

				<!-- Chứng nhận & Tiêu chuẩn -->
				<div class="es-footer-col">
					<h4>Năng lực Chứng nhận</h4>
					<p style="font-size: 13px; color: var(--es-text-muted); line-height: 1.8; margin-bottom: 16px;">
						Chứng chỉ năng lực hoạt động xây dựng Số: HCM-00059043 do Sở Xây dựng TP. Hồ Chí Minh cấp.
					</p>
					<span style="display: inline-block; border: 1px solid var(--es-border-gold); color: var(--es-gold); padding: 8px 16px; font-size: 11px; letter-spacing: 1.5px;">GIẢI THƯỞNG KIẾN TRÚC QUỐC GIA</span>
				</div>
			</div>

			<div class="es-footer-bottom-bar">
				<div>
					&copy; <?php echo date( 'Y' ); ?> FOUNTAINHEAD DESIGN &amp; BUILD. Bản quyền thuộc về Fountainhead.
				</div>
				<div style="display: flex; gap: 20px;">
					<a href="<?php echo esc_url( home_url( '/nang-luc-dich-vu/' ) ); ?>">Chính sách chất lượng</a>
					<a href="<?php echo esc_url( home_url( '/du-an/' ) ); ?>">Hồ sơ thầu</a>
					<a href="<?php echo esc_url( home_url( '/nha-xuong-cong-nghe/' ) ); ?>">Tiêu chuẩn HSE</a>
				</div>
			</div>
		</div>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
