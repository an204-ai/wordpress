<?php
/**
 * Brand Showcase Marquee Shortcode for Fountainhead Homepage (Client & Partner Brands)
 * Usage: [fountainhead_home_brand_marquee]
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function fountainhead_home_brand_marquee_shortcode() {
	ob_start();
	?>
	<div class="es-brand-showcase">
		<!-- ROW 1: TẬP ĐOÀN & BẤT ĐỘNG SẢN (CORPORATES & REAL ESTATE) -->
		<div class="es-brand-row">
			<div class="es-brand-category">
				<span class="es-brand-cat-name">TẬP ĐOÀN &amp; ĐẦU TƯ</span>
			</div>
			<div class="es-brand-marquee-container">
				<div class="es-brand-track es-track-speed-1">
					<!-- Set A -->
					<div class="es-brand-item" title="Keppel Land">
						<div style="display:flex; align-items:center; gap:6px; background:#f8fafc; padding:5px 12px; border-radius:4px; border:1px solid #e2e8f0;">
							<svg width="18" height="18" viewBox="0 0 24 24" fill="#dc2626"><polygon points="12,2 22,8.5 22,15.5 12,22 2,15.5 2,8.5"/></svg>
							<span style="font-family:'Montserrat', sans-serif; font-weight:800; font-size:16px; color:#1e293b; letter-spacing:0.5px;">Keppel</span>
						</div>
					</div>

					<div class="es-brand-item" title="CapitaLand">
						<div style="display:flex; flex-direction:column; align-items:center;">
							<svg width="85" height="10" viewBox="0 0 100 12" fill="none"><path d="M0,10 Q50,0 100,10" stroke="#007a3d" stroke-width="2.5" fill="none"/></svg>
							<span style="font-family:'Montserrat', sans-serif; font-weight:700; font-size:17px; color:#005a9c; letter-spacing:-0.2px;"><span style="color:#007a3d;">Capita</span>Land</span>
						</div>
					</div>

					<div class="es-brand-item" title="Vingroup">
						<div style="display:flex; align-items:center; gap:7px;">
							<svg width="22" height="22" viewBox="0 0 32 32"><circle cx="16" cy="16" r="15" fill="#dc2626"/><path d="M8 12 Q16 6 24 12 Q16 26 8 12 Z" fill="#fbbf24"/><circle cx="16" cy="14" r="3" fill="#dc2626"/></svg>
							<span style="font-family:'Montserrat', sans-serif; font-weight:800; font-size:15.5px; color:#b91c1c; letter-spacing:1px;">VINGROUP</span>
						</div>
					</div>

					<div class="es-brand-item" title="Dragon Capital">
						<div style="display:flex; align-items:center; gap:8px;">
							<svg width="24" height="18" viewBox="0 0 32 24" fill="#047857"><path d="M4 18 C6 10 12 6 18 8 C22 10 26 6 28 4 C26 12 20 18 14 18 C10 18 6 22 4 18 Z"/></svg>
							<div style="display:flex; flex-direction:column; line-height:1;"><span style="font-family:'Montserrat', sans-serif; font-weight:800; font-size:11px; letter-spacing:1.5px; color:#065f46;">DRAGON</span><span style="font-family:'Montserrat', sans-serif; font-weight:700; font-size:11px; letter-spacing:1px; color:#065f46;">CAPITAL</span></div>
						</div>
					</div>

					<div class="es-brand-item" title="VinaCapital">
						<div style="display:flex; align-items:center; gap:6px;">
							<svg width="18" height="18" viewBox="0 0 24 24" fill="#b91c1c"><polygon points="4,4 12,20 20,4 15,4 12,12 9,4"/></svg>
							<span style="font-family:'Georgia', serif; font-weight:700; font-size:16.5px; color:#1e293b; letter-spacing:0.3px;">VinaCapital</span>
						</div>
					</div>

					<div class="es-brand-item" title="Sacombank">
						<div style="display:flex; align-items:center; gap:7px;">
							<svg width="20" height="20" viewBox="0 0 24 24"><polygon points="12,2 22,12 12,22 2,12" fill="#0284c7"/><polygon points="12,6 18,12 12,18 6,12" fill="#f59e0b"/></svg>
							<div style="display:flex; flex-direction:column; line-height:1;"><span style="font-family:'Montserrat', sans-serif; font-weight:800; font-size:15px; color:#0369a1; letter-spacing:-0.3px;">Sacombank</span><span style="font-size:6px; color:#64748b; font-weight:600; letter-spacing:0.5px;">NGÂN HÀNG SÀI GÒN THƯƠNG TÍN</span></div>
						</div>
					</div>

					<div class="es-brand-item" title="CityLand">
						<div style="display:flex; align-items:center; gap:2px;">
							<svg width="22" height="22" viewBox="0 0 28 28"><circle cx="14" cy="14" r="13" fill="#dc2626"/><text x="14" y="20" fill="#fff" font-family="'Montserrat', sans-serif" font-weight="900" font-size="16" text-anchor="middle">C</text></svg>
							<span style="font-family:'Montserrat', sans-serif; font-weight:700; font-size:17px; color:#0f172a; margin-left:-3px;">ityLand<span style="color:#dc2626;">.</span></span>
						</div>
					</div>

					<div class="es-brand-item" title="POSCO E&C">
						<div style="display:flex; align-items:center; gap:5px;">
							<span style="font-family:'Montserrat', sans-serif; font-weight:800; font-size:18px; color:#0e7490; letter-spacing:-0.5px;">posco</span>
							<span style="font-family:'Montserrat', sans-serif; font-weight:700; font-size:11px; color:#0891b2; border-left:1.5px solid #0891b2; padding-left:4px; line-height:1;">E&amp;C</span>
						</div>
					</div>

					<div class="es-brand-item" title="TTC Group">
						<div style="display:flex; align-items:center; gap:5px;">
							<span style="font-family:'Montserrat', sans-serif; font-weight:900; font-size:22px; color:#1e3a8a; letter-spacing:1px;">TTC</span>
							<svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M4 18 Q14 4 20 6 Q16 16 8 20 Z" fill="#f97316"/></svg>
						</div>
					</div>

					<div class="es-brand-item" title="Saigontel">
						<div style="display:flex; align-items:center; gap:3px; border:1.5px solid #0284c7; padding:2px 8px; border-radius:3px;">
							<span style="font-family:'Montserrat', sans-serif; font-weight:700; font-size:10px; color:#0284c7; letter-spacing:0.5px;">SAIGON</span>
							<span style="font-family:'Montserrat', sans-serif; font-weight:900; font-size:15px; color:#0369a1;">TEL</span>
						</div>
					</div>

					<!-- Set B (duplicate for seamless loop) -->
					<div class="es-brand-item" title="Keppel Land">
						<div style="display:flex; align-items:center; gap:6px; background:#f8fafc; padding:5px 12px; border-radius:4px; border:1px solid #e2e8f0;">
							<svg width="18" height="18" viewBox="0 0 24 24" fill="#dc2626"><polygon points="12,2 22,8.5 22,15.5 12,22 2,15.5 2,8.5"/></svg>
							<span style="font-family:'Montserrat', sans-serif; font-weight:800; font-size:16px; color:#1e293b; letter-spacing:0.5px;">Keppel</span>
						</div>
					</div>

					<div class="es-brand-item" title="CapitaLand">
						<div style="display:flex; flex-direction:column; align-items:center;">
							<svg width="85" height="10" viewBox="0 0 100 12" fill="none"><path d="M0,10 Q50,0 100,10" stroke="#007a3d" stroke-width="2.5" fill="none"/></svg>
							<span style="font-family:'Montserrat', sans-serif; font-weight:700; font-size:17px; color:#005a9c; letter-spacing:-0.2px;"><span style="color:#007a3d;">Capita</span>Land</span>
						</div>
					</div>

					<div class="es-brand-item" title="Vingroup">
						<div style="display:flex; align-items:center; gap:7px;">
							<svg width="22" height="22" viewBox="0 0 32 32"><circle cx="16" cy="16" r="15" fill="#dc2626"/><path d="M8 12 Q16 6 24 12 Q16 26 8 12 Z" fill="#fbbf24"/><circle cx="16" cy="14" r="3" fill="#dc2626"/></svg>
							<span style="font-family:'Montserrat', sans-serif; font-weight:800; font-size:15.5px; color:#b91c1c; letter-spacing:1px;">VINGROUP</span>
						</div>
					</div>

					<div class="es-brand-item" title="Dragon Capital">
						<div style="display:flex; align-items:center; gap:8px;">
							<svg width="24" height="18" viewBox="0 0 32 24" fill="#047857"><path d="M4 18 C6 10 12 6 18 8 C22 10 26 6 28 4 C26 12 20 18 14 18 C10 18 6 22 4 18 Z"/></svg>
							<div style="display:flex; flex-direction:column; line-height:1;"><span style="font-family:'Montserrat', sans-serif; font-weight:800; font-size:11px; letter-spacing:1.5px; color:#065f46;">DRAGON</span><span style="font-family:'Montserrat', sans-serif; font-weight:700; font-size:11px; letter-spacing:1px; color:#065f46;">CAPITAL</span></div>
						</div>
					</div>

					<div class="es-brand-item" title="VinaCapital">
						<div style="display:flex; align-items:center; gap:6px;">
							<svg width="18" height="18" viewBox="0 0 24 24" fill="#b91c1c"><polygon points="4,4 12,20 20,4 15,4 12,12 9,4"/></svg>
							<span style="font-family:'Georgia', serif; font-weight:700; font-size:16.5px; color:#1e293b; letter-spacing:0.3px;">VinaCapital</span>
						</div>
					</div>

					<div class="es-brand-item" title="Sacombank">
						<div style="display:flex; align-items:center; gap:7px;">
							<svg width="20" height="20" viewBox="0 0 24 24"><polygon points="12,2 22,12 12,22 2,12" fill="#0284c7"/><polygon points="12,6 18,12 12,18 6,12" fill="#f59e0b"/></svg>
							<div style="display:flex; flex-direction:column; line-height:1;"><span style="font-family:'Montserrat', sans-serif; font-weight:800; font-size:15px; color:#0369a1; letter-spacing:-0.3px;">Sacombank</span><span style="font-size:6px; color:#64748b; font-weight:600; letter-spacing:0.5px;">NGÂN HÀNG SÀI GÒN THƯƠNG TÍN</span></div>
						</div>
					</div>

					<div class="es-brand-item" title="CityLand">
						<div style="display:flex; align-items:center; gap:2px;">
							<svg width="22" height="22" viewBox="0 0 28 28"><circle cx="14" cy="14" r="13" fill="#dc2626"/><text x="14" y="20" fill="#fff" font-family="'Montserrat', sans-serif" font-weight="900" font-size="16" text-anchor="middle">C</text></svg>
							<span style="font-family:'Montserrat', sans-serif; font-weight:700; font-size:17px; color:#0f172a; margin-left:-3px;">ityLand<span style="color:#dc2626;">.</span></span>
						</div>
					</div>

					<div class="es-brand-item" title="POSCO E&C">
						<div style="display:flex; align-items:center; gap:5px;">
							<span style="font-family:'Montserrat', sans-serif; font-weight:800; font-size:18px; color:#0e7490; letter-spacing:-0.5px;">posco</span>
							<span style="font-family:'Montserrat', sans-serif; font-weight:700; font-size:11px; color:#0891b2; border-left:1.5px solid #0891b2; padding-left:4px; line-height:1;">E&amp;C</span>
						</div>
					</div>

					<div class="es-brand-item" title="TTC Group">
						<div style="display:flex; align-items:center; gap:5px;">
							<span style="font-family:'Montserrat', sans-serif; font-weight:900; font-size:22px; color:#1e3a8a; letter-spacing:1px;">TTC</span>
							<svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M4 18 Q14 4 20 6 Q16 16 8 20 Z" fill="#f97316"/></svg>
						</div>
					</div>

					<div class="es-brand-item" title="Saigontel">
						<div style="display:flex; align-items:center; gap:3px; border:1.5px solid #0284c7; padding:2px 8px; border-radius:3px;">
							<span style="font-family:'Montserrat', sans-serif; font-weight:700; font-size:10px; color:#0284c7; letter-spacing:0.5px;">SAIGON</span>
							<span style="font-family:'Montserrat', sans-serif; font-weight:900; font-size:15px; color:#0369a1;">TEL</span>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- ROW 2: THỜI TRANG & BÁN LẺ (FASHION & RETAIL) -->
		<div class="es-brand-row">
			<div class="es-brand-category">
				<span class="es-brand-cat-name">THỜI TRANG &amp; BÁN LẺ</span>
			</div>
			<div class="es-brand-marquee-container">
				<div class="es-brand-track es-track-speed-2">
					<!-- Set A -->
					<div class="es-brand-item" title="Swarovski">
						<div style="display:flex; flex-direction:column; align-items:center; gap:2px;">
							<svg width="22" height="14" viewBox="0 0 24 16" fill="#111"><path d="M12 2 C8 2 6 5 6 8 C6 12 10 14 16 14 C20 14 22 11 22 8 C22 4 18 2 14 2 C10 2 8 5 9 8 C10 10 13 10 14 9 C15 8 14 6 12 6 C10 6 9 8 10 9"/></svg>
							<span style="font-family:'Lora', 'Bodoni MT', serif; font-weight:700; font-size:13px; letter-spacing:3px; color:#111;">SWAROVSKI</span>
						</div>
					</div>

					<div class="es-brand-item" title="Charles &amp; Keith">
						<span style="font-family:'Montserrat', sans-serif; font-weight:600; font-size:13.5px; letter-spacing:3.5px; color:#1e293b; text-transform:uppercase;">CHARLES &amp; KEITH</span>
					</div>

					<div class="es-brand-item" title="Pedro">
						<div style="display:flex; flex-direction:column; align-items:center; line-height:1.1;">
							<span style="font-family:'Georgia', serif; font-size:20px; font-weight:600; letter-spacing:4px; color:#111;">P e d r o</span>
							<span style="font-family:'Montserrat', sans-serif; font-size:6px; letter-spacing:1.5px; color:#64748b; font-weight:600;">FOOTWEAR AND ACCESSORIES</span>
						</div>
					</div>

					<div class="es-brand-item" title="Maison Joint Stock Company">
						<div style="display:flex; align-items:center; gap:6px; background:#111; color:#fff; padding:5px 12px; border-radius:3px;">
							<svg width="15" height="15" viewBox="0 0 24 24" fill="#fff"><path d="M12 2 C10 6 6 6 6 10 C6 13 9 14 12 12 C15 14 18 13 18 10 C18 6 14 6 12 2 Z M12 22 C10 18 6 18 6 14 C6 11 9 10 12 12 C15 10 18 11 18 14 C18 18 14 18 12 22 Z"/></svg>
							<div style="display:flex; flex-direction:column; line-height:1;"><span style="font-family:'Montserrat', sans-serif; font-weight:800; font-size:12px; letter-spacing:2px; color:#fff;">MAISON</span><span style="font-size:5.5px; letter-spacing:1px; color:#94a3b8;">JOINT STOCK COMPANY</span></div>
						</div>
					</div>

					<div class="es-brand-item" title="Dsquared2">
						<div style="display:flex; flex-direction:column; align-items:center; gap:2px;">
							<svg width="16" height="16" viewBox="0 0 24 24" fill="#111"><path d="M12 2 L13 6 L17 4 L16 8 L20 8 L18 12 L22 14 L18 16 L19 20 L15 18 L14 22 L12 19 L10 22 L9 18 L5 20 L6 16 L2 14 L6 12 L4 8 L8 8 L7 4 L11 6 Z"/></svg>
							<span style="font-family:'Montserrat', sans-serif; font-weight:800; font-size:11.5px; letter-spacing:1.5px; color:#111;">DSQUARED2</span>
						</div>
					</div>

					<div class="es-brand-item" title="H:CONNECT">
						<div style="background:#111; color:#fff; padding:4px 14px; border-radius:2px; font-family:'Montserrat', sans-serif; font-weight:700; font-size:13px; letter-spacing:2px;">H:CONNECT</div>
					</div>

					<div class="es-brand-item" title="Trendiano">
						<span style="font-family:'Montserrat', sans-serif; font-weight:700; font-size:16px; letter-spacing:4px; color:#111; text-transform:uppercase;">TRENDIANO</span>
					</div>

					<div class="es-brand-item" title="Mujosh">
						<div style="display:flex; flex-direction:column; align-items:center; gap:2px;">
							<svg width="18" height="18" viewBox="0 0 24 24"><circle cx="12" cy="12" r="11" fill="none" stroke="#111" stroke-width="1.8"/><path d="M12 5 v14 M7 9 h10 M7 14 h10" stroke="#111" stroke-width="1.5"/></svg>
							<span style="font-family:'Montserrat', sans-serif; font-weight:700; font-size:10px; letter-spacing:2px; color:#111;">MUJOSH</span>
						</div>
					</div>

					<div class="es-brand-item" title="Lovisa">
						<span style="font-family:'Brush Script MT', 'Bickham Script Pro', cursive; font-size:26px; font-weight:500; color:#111; letter-spacing:1px;">Lovisa</span>
					</div>

					<div class="es-brand-item" title="Cao Minh Tailor">
						<span style="font-family:'Playfair Display', 'Didot', serif; font-size:19px; font-weight:700; letter-spacing:1px; color:#111;">caoMInh<sup style="font-size:9px;">&reg;</sup></span>
					</div>

					<!-- Set B (duplicate) -->
					<div class="es-brand-item" title="Swarovski">
						<div style="display:flex; flex-direction:column; align-items:center; gap:2px;">
							<svg width="22" height="14" viewBox="0 0 24 16" fill="#111"><path d="M12 2 C8 2 6 5 6 8 C6 12 10 14 16 14 C20 14 22 11 22 8 C22 4 18 2 14 2 C10 2 8 5 9 8 C10 10 13 10 14 9 C15 8 14 6 12 6 C10 6 9 8 10 9"/></svg>
							<span style="font-family:'Lora', 'Bodoni MT', serif; font-weight:700; font-size:13px; letter-spacing:3px; color:#111;">SWAROVSKI</span>
						</div>
					</div>

					<div class="es-brand-item" title="Charles &amp; Keith">
						<span style="font-family:'Montserrat', sans-serif; font-weight:600; font-size:13.5px; letter-spacing:3.5px; color:#1e293b; text-transform:uppercase;">CHARLES &amp; KEITH</span>
					</div>

					<div class="es-brand-item" title="Pedro">
						<div style="display:flex; flex-direction:column; align-items:center; line-height:1.1;">
							<span style="font-family:'Georgia', serif; font-size:20px; font-weight:600; letter-spacing:4px; color:#111;">P e d r o</span>
							<span style="font-family:'Montserrat', sans-serif; font-size:6px; letter-spacing:1.5px; color:#64748b; font-weight:600;">FOOTWEAR AND ACCESSORIES</span>
						</div>
					</div>

					<div class="es-brand-item" title="Maison Joint Stock Company">
						<div style="display:flex; align-items:center; gap:6px; background:#111; color:#fff; padding:5px 12px; border-radius:3px;">
							<svg width="15" height="15" viewBox="0 0 24 24" fill="#fff"><path d="M12 2 C10 6 6 6 6 10 C6 13 9 14 12 12 C15 14 18 13 18 10 C18 6 14 6 12 2 Z M12 22 C10 18 6 18 6 14 C6 11 9 10 12 12 C15 10 18 11 18 14 C18 18 14 18 12 22 Z"/></svg>
							<div style="display:flex; flex-direction:column; line-height:1;"><span style="font-family:'Montserrat', sans-serif; font-weight:800; font-size:12px; letter-spacing:2px; color:#fff;">MAISON</span><span style="font-size:5.5px; letter-spacing:1px; color:#94a3b8;">JOINT STOCK COMPANY</span></div>
						</div>
					</div>

					<div class="es-brand-item" title="Dsquared2">
						<div style="display:flex; flex-direction:column; align-items:center; gap:2px;">
							<svg width="16" height="16" viewBox="0 0 24 24" fill="#111"><path d="M12 2 L13 6 L17 4 L16 8 L20 8 L18 12 L22 14 L18 16 L19 20 L15 18 L14 22 L12 19 L10 22 L9 18 L5 20 L6 16 L2 14 L6 12 L4 8 L8 8 L7 4 L11 6 Z"/></svg>
							<span style="font-family:'Montserrat', sans-serif; font-weight:800; font-size:11.5px; letter-spacing:1.5px; color:#111;">DSQUARED2</span>
						</div>
					</div>

					<div class="es-brand-item" title="H:CONNECT">
						<div style="background:#111; color:#fff; padding:4px 14px; border-radius:2px; font-family:'Montserrat', sans-serif; font-weight:700; font-size:13px; letter-spacing:2px;">H:CONNECT</div>
					</div>

					<div class="es-brand-item" title="Trendiano">
						<span style="font-family:'Montserrat', sans-serif; font-weight:700; font-size:16px; letter-spacing:4px; color:#111; text-transform:uppercase;">TRENDIANO</span>
					</div>

					<div class="es-brand-item" title="Mujosh">
						<div style="display:flex; flex-direction:column; align-items:center; gap:2px;">
							<svg width="18" height="18" viewBox="0 0 24 24"><circle cx="12" cy="12" r="11" fill="none" stroke="#111" stroke-width="1.8"/><path d="M12 5 v14 M7 9 h10 M7 14 h10" stroke="#111" stroke-width="1.5"/></svg>
							<span style="font-family:'Montserrat', sans-serif; font-weight:700; font-size:10px; letter-spacing:2px; color:#111;">MUJOSH</span>
						</div>
					</div>

					<div class="es-brand-item" title="Lovisa">
						<span style="font-family:'Brush Script MT', 'Bickham Script Pro', cursive; font-size:26px; font-weight:500; color:#111; letter-spacing:1px;">Lovisa</span>
					</div>

					<div class="es-brand-item" title="Cao Minh Tailor">
						<span style="font-family:'Playfair Display', 'Didot', serif; font-size:19px; font-weight:700; letter-spacing:1px; color:#111;">caoMInh<sup style="font-size:9px;">&reg;</sup></span>
					</div>
				</div>
			</div>
		</div>

		<!-- ROW 3: KHÁCH SẠN, GIẢI TRÍ & TRUYỀN THÔNG (HOSPITALITY & MEDIA) -->
		<div class="es-brand-row">
			<div class="es-brand-category">
				<span class="es-brand-cat-name">KHÁCH SẠN &amp; GIẢI TRÍ</span>
			</div>
			<div class="es-brand-marquee-container">
				<div class="es-brand-track es-track-speed-3">
					<!-- Set A -->
					<div class="es-brand-item" title="MGM Grand">
						<div style="display:flex; flex-direction:column; align-items:center; gap:2px;">
							<svg width="26" height="14" viewBox="0 0 36 20" fill="#b45309"><path d="M6 18 C8 12 12 10 18 10 C24 10 28 6 32 4 C30 10 26 14 20 16 C16 17 10 18 6 18 Z"/></svg>
							<span style="font-family:'Lora', serif; font-weight:700; font-size:11px; letter-spacing:2.5px; color:#b45309;">MGM GRAND.</span>
						</div>
					</div>

					<div class="es-brand-item" title="Somerset Grand Hanoi">
						<div style="display:flex; flex-direction:column; align-items:center; gap:2px;">
							<svg width="22" height="10" viewBox="0 0 30 14" fill="#b45309"><path d="M15 2 L18 8 L24 4 L22 12 L8 12 L6 4 L12 8 Z"/></svg>
							<span style="font-family:'Cinzel', 'Lora', serif; font-weight:700; font-size:11px; letter-spacing:1.5px; color:#78350f;">SOMERSET</span>
							<span style="font-size:5.5px; letter-spacing:1px; color:#92400e;">GRAND HANOI</span>
						</div>
					</div>

					<div class="es-brand-item" title="SC VivoCity">
						<div style="display:flex; flex-direction:column; align-items:center; line-height:1;">
							<div style="display:flex; align-items:baseline; gap:3px;"><span style="font-family:'Montserrat', sans-serif; font-weight:900; font-size:17px; color:#c026d3;">VIVO</span><span style="font-family:'Montserrat', sans-serif; font-size:10px; font-weight:700; color:#db2777;">city</span></div>
							<span style="font-size:6px; color:#64748b; letter-spacing:0.5px;">mapletree</span>
						</div>
					</div>

					<div class="es-brand-item" title="Đông Tây Promotion">
						<div style="border:1.5px solid #b45309; padding:2px 6px; background:#fffbeb; display:flex; flex-direction:column; align-items:center; line-height:1;">
							<span style="font-family:'Montserrat', sans-serif; font-weight:800; font-size:9px; color:#b45309; letter-spacing:1px;">ĐÔNG TÂY</span>
							<span style="font-family:'Montserrat', sans-serif; font-size:6px; font-weight:700; color:#fff; background:#b45309; padding:1px 3px; letter-spacing:1px; margin-top:2px;">PROMOTION</span>
						</div>
					</div>

					<div class="es-brand-item" title="DatVietVAC Group Holdings">
						<div style="display:flex; align-items:center; gap:6px;">
							<svg width="18" height="18" viewBox="0 0 24 24"><polygon points="4,20 12,4 20,4 12,20" fill="#65a30d"/></svg>
							<span style="font-family:'Montserrat', sans-serif; font-weight:800; font-size:16px; color:#1e293b; letter-spacing:-0.3px;">Dat<span style="color:#65a30d;">Viet</span>VAC</span>
						</div>
					</div>

					<div class="es-brand-item" title="Hum Vietnam">
						<div style="display:flex; align-items:center; gap:4px;">
							<span style="font-family:'Brush Script MT', 'Segoe Script', cursive; font-size:22px; color:#be123c;">...hum,</span>
							<span style="font-family:'Montserrat', sans-serif; font-size:7px; color:#15803d; font-weight:600; letter-spacing:0.5px;">Vietnam</span>
						</div>
					</div>

					<div class="es-brand-item" title="Orient Global">
						<div style="display:flex; flex-direction:column; align-items:center; gap:2px;">
							<svg width="20" height="14" viewBox="0 0 28 20" fill="#b45309"><circle cx="14" cy="6" r="3"/><path d="M8 18 C8 12 12 10 16 10 C20 10 24 14 24 18"/></svg>
							<span style="font-family:'Montserrat', sans-serif; font-weight:700; font-size:9px; letter-spacing:1.5px; color:#78350f;">ORIENT GLOBAL</span>
						</div>
					</div>

					<div class="es-brand-item" title="IMO">
						<div style="display:flex; align-items:center; gap:4px;">
							<svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M4 18 Q12 2 20 18" stroke="#0284c7" stroke-width="2.5"/></svg>
							<span style="font-family:'Montserrat', sans-serif; font-weight:900; font-size:18px; color:#ea580c; letter-spacing:1px;">IMO</span>
						</div>
					</div>

					<div class="es-brand-item" title="PTG">
						<div style="font-family:'Montserrat', sans-serif; font-weight:900; font-size:20px; letter-spacing:2px; color:#0369a1; border-bottom:2.5px solid #dc2626; padding-bottom:1px;">PTG</div>
					</div>

					<!-- Set B (duplicate) -->
					<div class="es-brand-item" title="MGM Grand">
						<div style="display:flex; flex-direction:column; align-items:center; gap:2px;">
							<svg width="26" height="14" viewBox="0 0 36 20" fill="#b45309"><path d="M6 18 C8 12 12 10 18 10 C24 10 28 6 32 4 C30 10 26 14 20 16 C16 17 10 18 6 18 Z"/></svg>
							<span style="font-family:'Lora', serif; font-weight:700; font-size:11px; letter-spacing:2.5px; color:#b45309;">MGM GRAND.</span>
						</div>
					</div>

					<div class="es-brand-item" title="Somerset Grand Hanoi">
						<div style="display:flex; flex-direction:column; align-items:center; gap:2px;">
							<svg width="22" height="10" viewBox="0 0 30 14" fill="#b45309"><path d="M15 2 L18 8 L24 4 L22 12 L8 12 L6 4 L12 8 Z"/></svg>
							<span style="font-family:'Cinzel', 'Lora', serif; font-weight:700; font-size:11px; letter-spacing:1.5px; color:#78350f;">SOMERSET</span>
							<span style="font-size:5.5px; letter-spacing:1px; color:#92400e;">GRAND HANOI</span>
						</div>
					</div>

					<div class="es-brand-item" title="SC VivoCity">
						<div style="display:flex; flex-direction:column; align-items:center; line-height:1;">
							<div style="display:flex; align-items:baseline; gap:3px;"><span style="font-family:'Montserrat', sans-serif; font-weight:900; font-size:17px; color:#c026d3;">VIVO</span><span style="font-family:'Montserrat', sans-serif; font-size:10px; font-weight:700; color:#db2777;">city</span></div>
							<span style="font-size:6px; color:#64748b; letter-spacing:0.5px;">mapletree</span>
						</div>
					</div>

					<div class="es-brand-item" title="Đông Tây Promotion">
						<div style="border:1.5px solid #b45309; padding:2px 6px; background:#fffbeb; display:flex; flex-direction:column; align-items:center; line-height:1;">
							<span style="font-family:'Montserrat', sans-serif; font-weight:800; font-size:9px; color:#b45309; letter-spacing:1px;">ĐÔNG TÂY</span>
							<span style="font-family:'Montserrat', sans-serif; font-size:6px; font-weight:700; color:#fff; background:#b45309; padding:1px 3px; letter-spacing:1px; margin-top:2px;">PROMOTION</span>
						</div>
					</div>

					<div class="es-brand-item" title="DatVietVAC Group Holdings">
						<div style="display:flex; align-items:center; gap:6px;">
							<svg width="18" height="18" viewBox="0 0 24 24"><polygon points="4,20 12,4 20,4 12,20" fill="#65a30d"/></svg>
							<span style="font-family:'Montserrat', sans-serif; font-weight:800; font-size:16px; color:#1e293b; letter-spacing:-0.3px;">Dat<span style="color:#65a30d;">Viet</span>VAC</span>
						</div>
					</div>

					<div class="es-brand-item" title="Hum Vietnam">
						<div style="display:flex; align-items:center; gap:4px;">
							<span style="font-family:'Brush Script MT', 'Segoe Script', cursive; font-size:22px; color:#be123c;">...hum,</span>
							<span style="font-family:'Montserrat', sans-serif; font-size:7px; color:#15803d; font-weight:600; letter-spacing:0.5px;">Vietnam</span>
						</div>
					</div>

					<div class="es-brand-item" title="Orient Global">
						<div style="display:flex; flex-direction:column; align-items:center; gap:2px;">
							<svg width="20" height="14" viewBox="0 0 28 20" fill="#b45309"><circle cx="14" cy="6" r="3"/><path d="M8 18 C8 12 12 10 16 10 C20 10 24 14 24 18"/></svg>
							<span style="font-family:'Montserrat', sans-serif; font-weight:700; font-size:9px; letter-spacing:1.5px; color:#78350f;">ORIENT GLOBAL</span>
						</div>
					</div>

					<div class="es-brand-item" title="IMO">
						<div style="display:flex; align-items:center; gap:4px;">
							<svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M4 18 Q12 2 20 18" stroke="#0284c7" stroke-width="2.5"/></svg>
							<span style="font-family:'Montserrat', sans-serif; font-weight:900; font-size:18px; color:#ea580c; letter-spacing:1px;">IMO</span>
						</div>
					</div>

					<div class="es-brand-item" title="PTG">
						<div style="font-family:'Montserrat', sans-serif; font-weight:900; font-size:20px; letter-spacing:2px; color:#0369a1; border-bottom:2.5px solid #dc2626; padding-bottom:1px;">PTG</div>
					</div>
				</div>
			</div>
		</div>

		<!-- ROW 4: CÔNG NGHỆ, KIẾN TRÚC & GIÁO DỤC (TECH, DESIGN & EDUCATION) -->
		<div class="es-brand-row">
			<div class="es-brand-category">
				<span class="es-brand-cat-name">KIẾN TRÚC &amp; ĐỐI TÁC</span>
			</div>
			<div class="es-brand-marquee-container">
				<div class="es-brand-track es-track-speed-4">
					<!-- Set A -->
					<div class="es-brand-item" title="AECOM">
						<div style="display:flex; align-items:center; gap:2px; font-family:'Montserrat', sans-serif; font-weight:900; font-size:20px; color:#111; letter-spacing:1px;">
							<span>A</span>
							<svg width="14" height="16" viewBox="0 0 16 16"><rect x="1" y="4" width="14" height="3" fill="#111"/><rect x="1" y="9" width="14" height="3" fill="#111"/></svg>
							<span>COM</span>
						</div>
					</div>

					<div class="es-brand-item" title="Oxford University Press">
						<div style="display:flex; align-items:center; gap:7px;">
							<svg width="22" height="22" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" fill="none" stroke="#0369a1" stroke-width="1.8"/><path d="M8 8 h8 v8 h-8 z M8 12 h8" fill="none" stroke="#0369a1" stroke-width="1.2"/></svg>
							<div style="display:flex; flex-direction:column; line-height:1;"><span style="font-family:'Cinzel', 'Lora', serif; font-weight:700; font-size:11px; letter-spacing:1px; color:#0c4a6e;">OXFORD</span><span style="font-size:6px; letter-spacing:0.5px; color:#0284c7; font-weight:600;">UNIVERSITY PRESS</span></div>
						</div>
					</div>

					<div class="es-brand-item" title="KMS Technology">
						<div style="display:flex; align-items:center; gap:7px;">
							<svg width="20" height="20" viewBox="0 0 24 24" fill="#06b6d4"><circle cx="12" cy="12" r="4"/><circle cx="12" cy="4" r="2"/><circle cx="12" cy="20" r="2"/><circle cx="4" cy="12" r="2"/><circle cx="20" cy="12" r="2"/></svg>
							<div style="display:flex; flex-direction:column; line-height:1;"><span style="font-family:'Montserrat', sans-serif; font-weight:800; font-size:14px; color:#0e7490; letter-spacing:1px;">KMS</span><span style="font-size:6px; color:#0891b2; font-weight:600; letter-spacing:0.5px;">TECHNOLOGY</span></div>
						</div>
					</div>

					<div class="es-brand-item" title="DKSH">
						<div style="display:flex; align-items:center; gap:7px;">
							<svg width="22" height="22" viewBox="0 0 24 24" fill="#dc2626"><circle cx="12" cy="12" r="10" fill="#fee2e2"/><path d="M12 4 C8 8 8 16 12 20 C16 16 16 8 12 4 Z" fill="#dc2626"/></svg>
							<span style="font-family:'Montserrat', sans-serif; font-weight:900; font-size:20px; color:#dc2626; letter-spacing:1px;">DKSH</span>
						</div>
					</div>

					<div class="es-brand-item" title="VUS">
						<div style="display:flex; align-items:center; gap:4px;">
							<span style="font-family:'Montserrat', sans-serif; font-weight:900; font-size:22px; font-style:italic; color:#dc2626; letter-spacing:0.5px;">VUS</span>
							<svg width="18" height="14" viewBox="0 0 24 16" fill="#dc2626"><path d="M2 14 Q12 8 22 14 Q12 2 2 14 Z"/></svg>
						</div>
					</div>

					<div class="es-brand-item" title="Mathnasium">
						<div style="display:flex; flex-direction:column; align-items:center; line-height:1;">
							<div style="display:flex; align-items:center; font-family:'Montserrat', sans-serif; font-weight:800; font-size:14px; color:#dc2626;"><span style="font-size:17px;">M</span><span style="font-size:18px; color:#b91c1c; margin:0 1px;">+</span><span>THNASIUM</span></div>
							<span style="font-size:6px; color:#64748b; font-weight:600; letter-spacing:0.5px;">The Math Learning Center</span>
						</div>
					</div>

					<div class="es-brand-item" title="Mỹ Đức Ceramics">
						<div style="display:flex; align-items:center; gap:6px;">
							<svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M6 20 C6 10 12 4 12 4 C12 4 18 10 18 20" stroke="#047857" stroke-width="2.5" stroke-linecap="round"/><circle cx="12" cy="12" r="2" fill="#047857"/></svg>
							<div style="display:flex; flex-direction:column; line-height:1;"><span style="font-family:'Montserrat', sans-serif; font-weight:800; font-size:10px; color:#065f46; letter-spacing:0.5px;">MỸ ĐỨC</span><span style="font-size:6px; color:#047857; font-weight:600; letter-spacing:0.5px;">CERAMICS</span></div>
						</div>
					</div>

					<!-- Set B (duplicate) -->
					<div class="es-brand-item" title="AECOM">
						<div style="display:flex; align-items:center; gap:2px; font-family:'Montserrat', sans-serif; font-weight:900; font-size:20px; color:#111; letter-spacing:1px;">
							<span>A</span>
							<svg width="14" height="16" viewBox="0 0 16 16"><rect x="1" y="4" width="14" height="3" fill="#111"/><rect x="1" y="9" width="14" height="3" fill="#111"/></svg>
							<span>COM</span>
						</div>
					</div>

					<div class="es-brand-item" title="Oxford University Press">
						<div style="display:flex; align-items:center; gap:7px;">
							<svg width="22" height="22" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" fill="none" stroke="#0369a1" stroke-width="1.8"/><path d="M8 8 h8 v8 h-8 z M8 12 h8" fill="none" stroke="#0369a1" stroke-width="1.2"/></svg>
							<div style="display:flex; flex-direction:column; line-height:1;"><span style="font-family:'Cinzel', 'Lora', serif; font-weight:700; font-size:11px; letter-spacing:1px; color:#0c4a6e;">OXFORD</span><span style="font-size:6px; letter-spacing:0.5px; color:#0284c7; font-weight:600;">UNIVERSITY PRESS</span></div>
						</div>
					</div>

					<div class="es-brand-item" title="KMS Technology">
						<div style="display:flex; align-items:center; gap:7px;">
							<svg width="20" height="20" viewBox="0 0 24 24" fill="#06b6d4"><circle cx="12" cy="12" r="4"/><circle cx="12" cy="4" r="2"/><circle cx="12" cy="20" r="2"/><circle cx="4" cy="12" r="2"/><circle cx="20" cy="12" r="2"/></svg>
							<div style="display:flex; flex-direction:column; line-height:1;"><span style="font-family:'Montserrat', sans-serif; font-weight:800; font-size:14px; color:#0e7490; letter-spacing:1px;">KMS</span><span style="font-size:6px; color:#0891b2; font-weight:600; letter-spacing:0.5px;">TECHNOLOGY</span></div>
						</div>
					</div>

					<div class="es-brand-item" title="DKSH">
						<div style="display:flex; align-items:center; gap:7px;">
							<svg width="22" height="22" viewBox="0 0 24 24" fill="#dc2626"><circle cx="12" cy="12" r="10" fill="#fee2e2"/><path d="M12 4 C8 8 8 16 12 20 C16 16 16 8 12 4 Z" fill="#dc2626"/></svg>
							<span style="font-family:'Montserrat', sans-serif; font-weight:900; font-size:20px; color:#dc2626; letter-spacing:1px;">DKSH</span>
						</div>
					</div>

					<div class="es-brand-item" title="VUS">
						<div style="display:flex; align-items:center; gap:4px;">
							<span style="font-family:'Montserrat', sans-serif; font-weight:900; font-size:22px; font-style:italic; color:#dc2626; letter-spacing:0.5px;">VUS</span>
							<svg width="18" height="14" viewBox="0 0 24 16" fill="#dc2626"><path d="M2 14 Q12 8 22 14 Q12 2 2 14 Z"/></svg>
						</div>
					</div>

					<div class="es-brand-item" title="Mathnasium">
						<div style="display:flex; flex-direction:column; align-items:center; line-height:1;">
							<div style="display:flex; align-items:center; font-family:'Montserrat', sans-serif; font-weight:800; font-size:14px; color:#dc2626;"><span style="font-size:17px;">M</span><span style="font-size:18px; color:#b91c1c; margin:0 1px;">+</span><span>THNASIUM</span></div>
							<span style="font-size:6px; color:#64748b; font-weight:600; letter-spacing:0.5px;">The Math Learning Center</span>
						</div>
					</div>

					<div class="es-brand-item" title="Mỹ Đức Ceramics">
						<div style="display:flex; align-items:center; gap:6px;">
							<svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M6 20 C6 10 12 4 12 4 C12 4 18 10 18 20" stroke="#047857" stroke-width="2.5" stroke-linecap="round"/><circle cx="12" cy="12" r="2" fill="#047857"/></svg>
							<div style="display:flex; flex-direction:column; line-height:1;"><span style="font-family:'Montserrat', sans-serif; font-weight:800; font-size:10px; color:#065f46; letter-spacing:0.5px;">MỸ ĐỨC</span><span style="font-size:6px; color:#047857; font-weight:600; letter-spacing:0.5px;">CERAMICS</span></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
	return ob_get_clean();
}
add_shortcode( 'fountainhead_home_brand_marquee', 'fountainhead_home_brand_marquee_shortcode' );
