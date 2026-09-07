<?php
/**
 * EuroStyle Footer - Dual CTA + Dark info (like eurostyle.com.vn)
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$cta_bg_1 = 'https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?q=80&w=1200&auto=format&fit=crop';
$cta_bg_2 = 'https://images.unsplash.com/photo-1600880292203-757bb62b4baf?q=80&w=1200&auto=format&fit=crop';
?>
<footer class="site-footer-es">
	<!-- Dual CTA Cards -->
	<div class="es-footer-cta-cards">
		<div class="es-cta-card" style="background-image: url('<?php echo esc_url( $cta_bg_1 ); ?>');">
			<div class="es-cta-card-content">
				<h3>Đặt lịch tư vấn</h3>
				<a href="<?php echo esc_url( home_url( '/lien-he/' ) ); ?>" class="es-cta-pill">Đặt lịch ngay</a>
			</div>
		</div>
		<div class="es-cta-card" style="background-image: url('<?php echo esc_url( $cta_bg_2 ); ?>');">
			<div class="es-cta-card-content">
				<h3>Trở thành đối tác của Fountainhead</h3>
				<a href="<?php echo esc_url( home_url( '/lien-he/' ) ); ?>" class="es-cta-pill">Hợp tác ngay</a>
			</div>
		</div>
	</div>

	<!-- Main Footer -->
	<div class="es-main-footer" id="lien-he">
		<div class="es-main-footer-inner">
			<div class="es-footer-grid">
				<div class="es-footer-left">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="es-logo-brand">
						<span class="es-logo-text">Fountainhead</span>
					</a>
					<p class="es-footer-address"><strong>Trụ sở chính:</strong> 285-287 Bạch Đằng, Phường 15, Quận Bình Thạnh, TP. Hồ Chí Minh</p>
					<p class="es-footer-address"><strong>Nhà máy sản xuất đồ gỗ:</strong> Số 28 Đường Thạnh Xuân 31, Phường Thạnh Xuân, Quận 12, TP. Hồ Chí Minh</p>
					<p class="es-footer-address"><strong>Quy mô hoạt động:</strong> Thực hiện các dự án Thiết kế, Thi công &amp; Hoàn thiện nội thất trên toàn quốc</p>
				</div>
				<div class="es-footer-right">
					<div class="es-hotline-label">Hotline tư vấn</div>
					<div class="es-hotline-number">0902.92.05.79</div>
					<a href="mailto:info@suoinguon.vn" class="es-email">info@suoinguon.vn</a>
					<div class="es-social-icons">
						<a href="https://www.facebook.com/fountainheadsuoinguon/?locale=vi_VN" target="_blank" rel="noopener noreferrer" aria-label="Facebook"><svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"/></svg></a>
						<a href="#" aria-label="Instagram"><svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg></a>
						<a href="#" aria-label="LinkedIn"><svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M4.98 3.5c0 1.381-1.11 2.5-2.48 2.5s-2.48-1.119-2.48-2.5c0-1.38 1.11-2.5 2.48-2.5s2.48 1.12 2.48 2.5zm.02 4.5h-5v16h5v-16zm7.982 0h-4.968v16h4.969v-8.399c0-4.67 6.029-5.052 6.029 0v8.399h4.988v-10.131c0-7.88-8.922-7.593-11.018-3.714v-2.155z"/></svg></a>
						<a href="#" aria-label="YouTube"><svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg></a>
					</div>
				</div>
			</div>
			<div class="es-footer-copyright">
				&copy; <?php echo date('Y'); ?> Fountainhead Design &amp; Build – All rights reserved
			</div>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>