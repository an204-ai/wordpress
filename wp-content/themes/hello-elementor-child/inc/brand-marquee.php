<?php
/**
 * Brand Showcase Marquee Shortcode for Fountainhead Homepage
 * Usage: [fountainhead_home_brand_marquee]
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function fountainhead_home_brand_marquee_shortcode() {
	ob_start();
	?>
	<div class="es-brand-showcase">
		<!-- ROW 1: LIVING -->
		<div class="es-brand-row">
			<div class="es-brand-category">
				<span class="es-brand-cat-name">LIVING</span>
			</div>
			<div class="es-brand-marquee-container">
				<div class="es-brand-track es-track-speed-1">
					<!-- Set A -->
					<div class="es-brand-item es-brand-lema" title="LEMA">
						<svg viewBox="0 0 100 24" height="20" fill="currentColor">
							<text x="0" y="19" font-family="'Montserrat', 'Arial Black', sans-serif" font-weight="900" font-size="21" letter-spacing="3">LEMA</text>
						</svg>
					</div>
					<div class="es-brand-item es-brand-point" title="POINT">
						<div class="es-logo-stacked">
							<span class="es-logo-main" style="font-family:'Montserrat', sans-serif; font-weight:800; font-size:18px; letter-spacing:3px;">POINT.</span>
							<span class="es-logo-sub" style="font-family:'Montserrat', sans-serif; font-size:7px; letter-spacing:2px; color:#666;">OUTDOOR LIVING</span>
						</div>
					</div>
					<div class="es-brand-item es-brand-vondom" title="VONDOM">
						<svg viewBox="0 0 120 24" height="20" fill="currentColor">
							<text x="0" y="19" font-family="'Montserrat', sans-serif" font-weight="900" font-size="20" letter-spacing="4">VONDOM</text>
						</svg>
					</div>
					<div class="es-brand-item es-brand-poliform" title="Poliform">
						<svg viewBox="0 0 110 24" height="21" fill="currentColor">
							<text x="0" y="19" font-family="'Montserrat', sans-serif" font-weight="700" font-size="20" letter-spacing="1">Poliform</text>
						</svg>
					</div>
					<div class="es-brand-item es-brand-minotti" title="Minotti">
						<div class="es-logo-with-arrow">
							<span style="font-family:'Lora', 'Didot', serif; font-size:22px; font-weight:600; letter-spacing:1px;">Minotti</span>
							<svg class="es-logo-arrow" width="9" height="15" viewBox="0 0 8 14" fill="none" stroke="currentColor" stroke-width="1.8">
								<path d="M1 1l6 6-6 6" />
							</svg>
						</div>
					</div>
					<div class="es-brand-item es-brand-bbitalia" title="B&B Italia">
						<span style="font-family:'Montserrat', sans-serif; font-weight:800; font-size:17px; letter-spacing:2px;">B&amp;B ITALIA</span>
					</div>

					<!-- Set B (duplicate for seamless infinite marquee) -->
					<div class="es-brand-item es-brand-lema" title="LEMA">
						<svg viewBox="0 0 100 24" height="20" fill="currentColor">
							<text x="0" y="19" font-family="'Montserrat', 'Arial Black', sans-serif" font-weight="900" font-size="21" letter-spacing="3">LEMA</text>
						</svg>
					</div>
					<div class="es-brand-item es-brand-point" title="POINT">
						<div class="es-logo-stacked">
							<span class="es-logo-main" style="font-family:'Montserrat', sans-serif; font-weight:800; font-size:18px; letter-spacing:3px;">POINT.</span>
							<span class="es-logo-sub" style="font-family:'Montserrat', sans-serif; font-size:7px; letter-spacing:2px; color:#666;">OUTDOOR LIVING</span>
						</div>
					</div>
					<div class="es-brand-item es-brand-vondom" title="VONDOM">
						<svg viewBox="0 0 120 24" height="20" fill="currentColor">
							<text x="0" y="19" font-family="'Montserrat', sans-serif" font-weight="900" font-size="20" letter-spacing="4">VONDOM</text>
						</svg>
					</div>
					<div class="es-brand-item es-brand-poliform" title="Poliform">
						<svg viewBox="0 0 110 24" height="21" fill="currentColor">
							<text x="0" y="19" font-family="'Montserrat', sans-serif" font-weight="700" font-size="20" letter-spacing="1">Poliform</text>
						</svg>
					</div>
					<div class="es-brand-item es-brand-minotti" title="Minotti">
						<div class="es-logo-with-arrow">
							<span style="font-family:'Lora', 'Didot', serif; font-size:22px; font-weight:600; letter-spacing:1px;">Minotti</span>
							<svg class="es-logo-arrow" width="9" height="15" viewBox="0 0 8 14" fill="none" stroke="currentColor" stroke-width="1.8">
								<path d="M1 1l6 6-6 6" />
							</svg>
						</div>
					</div>
					<div class="es-brand-item es-brand-bbitalia" title="B&B Italia">
						<span style="font-family:'Montserrat', sans-serif; font-weight:800; font-size:17px; letter-spacing:2px;">B&amp;B ITALIA</span>
					</div>
				</div>
			</div>
		</div>

		<!-- ROW 2: STYLING -->
		<div class="es-brand-row">
			<div class="es-brand-category">
				<span class="es-brand-cat-name">STYLING</span>
			</div>
			<div class="es-brand-marquee-container">
				<div class="es-brand-track es-track-speed-2">
					<!-- Set A -->
					<div class="es-brand-item es-brand-gio" title="GIOBAGNARA">
						<span style="font-family:'Montserrat', sans-serif; font-weight:600; font-size:15px; letter-spacing:3.5px;">GIOBAGNARA</span>
					</div>
					<div class="es-brand-item es-brand-flos" title="FLOS">
						<span style="font-family:'Lora', 'Bodoni MT', serif; font-size:24px; font-weight:700; letter-spacing:2px;">FLOS</span>
					</div>
					<div class="es-brand-item es-brand-henge" title="HENGE">
						<div style="display:flex; align-items:flex-start;">
							<span style="font-family:'Montserrat', sans-serif; font-weight:800; font-size:18px; letter-spacing:2px;">HENGE</span>
							<span style="font-size:8px; margin-left:2px; font-weight:600;">E</span>
						</div>
					</div>
					<div class="es-brand-item es-brand-sanssouci" title="SANS SOUCI">
						<span style="font-family:'Montserrat', sans-serif; font-weight:500; font-size:14px; letter-spacing:4px;">SANS SOUCI</span>
					</div>
					<div class="es-brand-item es-brand-barovier" title="Barovier & Toso">
						<div class="es-logo-with-arrow">
							<div class="es-logo-stacked" style="align-items:center;">
								<svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
									<path d="M12 2L15 8L21 9L17 14L18 20L12 17L6 20L7 14L3 9L9 8L12 2Z"/>
								</svg>
								<span style="font-family:'Lora', serif; font-size:14px; font-weight:600; letter-spacing:1px;">Barovier&amp;Toso</span>
							</div>
							<svg class="es-logo-arrow" width="9" height="15" viewBox="0 0 8 14" fill="none" stroke="currentColor" stroke-width="1.8">
								<path d="M1 1l6 6-6 6" />
							</svg>
						</div>
					</div>
					<div class="es-brand-item es-brand-lasvit" title="LASVIT">
						<span style="font-family:'Montserrat', sans-serif; font-weight:700; font-size:16px; letter-spacing:3px;">LASVIT</span>
					</div>

					<!-- Set B (duplicate) -->
					<div class="es-brand-item es-brand-gio" title="GIOBAGNARA">
						<span style="font-family:'Montserrat', sans-serif; font-weight:600; font-size:15px; letter-spacing:3.5px;">GIOBAGNARA</span>
					</div>
					<div class="es-brand-item es-brand-flos" title="FLOS">
						<span style="font-family:'Lora', 'Bodoni MT', serif; font-size:24px; font-weight:700; letter-spacing:2px;">FLOS</span>
					</div>
					<div class="es-brand-item es-brand-henge" title="HENGE">
						<div style="display:flex; align-items:flex-start;">
							<span style="font-family:'Montserrat', sans-serif; font-weight:800; font-size:18px; letter-spacing:2px;">HENGE</span>
							<span style="font-size:8px; margin-left:2px; font-weight:600;">E</span>
						</div>
					</div>
					<div class="es-brand-item es-brand-sanssouci" title="SANS SOUCI">
						<span style="font-family:'Montserrat', sans-serif; font-weight:500; font-size:14px; letter-spacing:4px;">SANS SOUCI</span>
					</div>
					<div class="es-brand-item es-brand-barovier" title="Barovier & Toso">
						<div class="es-logo-with-arrow">
							<div class="es-logo-stacked" style="align-items:center;">
								<svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
									<path d="M12 2L15 8L21 9L17 14L18 20L12 17L6 20L7 14L3 9L9 8L12 2Z"/>
								</svg>
								<span style="font-family:'Lora', serif; font-size:14px; font-weight:600; letter-spacing:1px;">Barovier&amp;Toso</span>
							</div>
							<svg class="es-logo-arrow" width="9" height="15" viewBox="0 0 8 14" fill="none" stroke="currentColor" stroke-width="1.8">
								<path d="M1 1l6 6-6 6" />
							</svg>
						</div>
					</div>
					<div class="es-brand-item es-brand-lasvit" title="LASVIT">
						<span style="font-family:'Montserrat', sans-serif; font-weight:700; font-size:16px; letter-spacing:3px;">LASVIT</span>
					</div>
				</div>
			</div>
		</div>

		<!-- ROW 3: ARCHITECTURE -->
		<div class="es-brand-row">
			<div class="es-brand-category">
				<span class="es-brand-cat-name">ARCHITECTURE</span>
			</div>
			<div class="es-brand-marquee-container">
				<div class="es-brand-track es-track-speed-3">
					<!-- Set A -->
					<div class="es-brand-item es-brand-arclinea" title="Arclinea">
						<span style="font-family:'Lora', serif; font-size:22px; font-weight:600; letter-spacing:1px;">Arclinea</span>
					</div>
					<div class="es-brand-item es-brand-leicht" title="LEICHT">
						<span style="font-family:'Montserrat', sans-serif; font-weight:900; font-size:20px; letter-spacing:2px;">LEICHT</span>
					</div>
					<div class="es-brand-item es-brand-lema2" title="LEMA">
						<svg viewBox="0 0 100 24" height="20" fill="currentColor">
							<text x="0" y="19" font-family="'Montserrat', 'Arial Black', sans-serif" font-weight="900" font-size="21" letter-spacing="3">LEMA</text>
						</svg>
					</div>
					<div class="es-brand-item es-brand-gaggenau" title="GAGGENAU">
						<span style="font-family:'Montserrat', sans-serif; font-weight:800; font-size:18px; letter-spacing:2.5px;">GAGGENAU</span>
					</div>
					<div class="es-brand-item es-brand-poliform2" title="Poliform">
						<div class="es-logo-with-arrow">
							<span style="font-family:'Montserrat', sans-serif; font-weight:700; font-size:20px; letter-spacing:1px;">Poliform</span>
							<svg class="es-logo-arrow" width="9" height="15" viewBox="0 0 8 14" fill="none" stroke="currentColor" stroke-width="1.8">
								<path d="M1 1l6 6-6 6" />
							</svg>
						</div>
					</div>
					<div class="es-brand-item es-brand-boffi" title="Boffi">
						<span style="font-family:'Montserrat', sans-serif; font-weight:700; font-size:18px; letter-spacing:2px;">Boffi</span>
					</div>

					<!-- Set B (duplicate) -->
					<div class="es-brand-item es-brand-arclinea" title="Arclinea">
						<span style="font-family:'Lora', serif; font-size:22px; font-weight:600; letter-spacing:1px;">Arclinea</span>
					</div>
					<div class="es-brand-item es-brand-leicht" title="LEICHT">
						<span style="font-family:'Montserrat', sans-serif; font-weight:900; font-size:20px; letter-spacing:2px;">LEICHT</span>
					</div>
					<div class="es-brand-item es-brand-lema2" title="LEMA">
						<svg viewBox="0 0 100 24" height="20" fill="currentColor">
							<text x="0" y="19" font-family="'Montserrat', 'Arial Black', sans-serif" font-weight="900" font-size="21" letter-spacing="3">LEMA</text>
						</svg>
					</div>
					<div class="es-brand-item es-brand-gaggenau" title="GAGGENAU">
						<span style="font-family:'Montserrat', sans-serif; font-weight:800; font-size:18px; letter-spacing:2.5px;">GAGGENAU</span>
					</div>
					<div class="es-brand-item es-brand-poliform2" title="Poliform">
						<div class="es-logo-with-arrow">
							<span style="font-family:'Montserrat', sans-serif; font-weight:700; font-size:20px; letter-spacing:1px;">Poliform</span>
							<svg class="es-logo-arrow" width="9" height="15" viewBox="0 0 8 14" fill="none" stroke="currentColor" stroke-width="1.8">
								<path d="M1 1l6 6-6 6" />
							</svg>
						</div>
					</div>
					<div class="es-brand-item es-brand-boffi" title="Boffi">
						<span style="font-family:'Montserrat', sans-serif; font-weight:700; font-size:18px; letter-spacing:2px;">Boffi</span>
					</div>
				</div>
			</div>
		</div>

		<!-- ROW 4: WELLNESS -->
		<div class="es-brand-row">
			<div class="es-brand-category">
				<span class="es-brand-cat-name">WELLNESS</span>
			</div>
			<div class="es-brand-marquee-container">
				<div class="es-brand-track es-track-speed-4">
					<!-- Set A -->
					<div class="es-brand-item es-brand-agape" title="agape">
						<div style="display:flex; align-items:center; gap:8px;">
							<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
								<path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"/>
							</svg>
							<span style="font-family:'Montserrat', sans-serif; font-weight:800; font-size:19px; letter-spacing:1px;">agape</span>
						</div>
					</div>
					<div class="es-brand-item es-brand-effe" title="effe">
						<span style="font-family:'Montserrat', sans-serif; font-weight:800; font-size:23px; letter-spacing:1px;">effe</span>
					</div>
					<div class="es-brand-item es-brand-artcolor" title="ART COLOR">
						<div class="es-logo-stacked" style="align-items:center;">
							<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
								<path d="M12 3a9 9 0 0 0-9 9c0 4.97 4.03 9 9 9s9-4.03 9-9c0-1.5-.37-2.91-1.02-4.15L12 17l-3-6 7.5-3.5"/>
							</svg>
							<span style="font-family:'Montserrat', sans-serif; font-size:8px; font-weight:700; letter-spacing:1.5px;">ART COLOR</span>
						</div>
					</div>
					<div class="es-brand-item es-brand-unidrain" title="unidrain">
						<div style="display:flex; align-items:center; gap:6px;">
							<div style="display:flex; flex-direction:column; gap:2px;">
								<span style="width:10px; height:2px; background:currentColor; display:block;"></span>
								<span style="width:10px; height:2px; background:currentColor; display:block;"></span>
								<span style="width:10px; height:2px; background:currentColor; display:block;"></span>
							</div>
							<span style="font-family:'Montserrat', sans-serif; font-weight:600; font-size:16px; letter-spacing:0.5px;">unidrain<sup>&reg;</sup></span>
						</div>
					</div>
					<div class="es-brand-item es-brand-milldue" title="milldue">
						<div class="es-logo-with-arrow">
							<span style="font-family:'Montserrat', sans-serif; font-weight:800; font-size:20px; letter-spacing:0.5px;">milldue</span>
							<svg class="es-logo-arrow" width="9" height="15" viewBox="0 0 8 14" fill="none" stroke="currentColor" stroke-width="1.8">
								<path d="M1 1l6 6-6 6" />
							</svg>
						</div>
					</div>
					<div class="es-brand-item es-brand-dornbracht" title="DORNBRACHT">
						<span style="font-family:'Montserrat', sans-serif; font-weight:700; font-size:15px; letter-spacing:2px;">DORNBRACHT</span>
					</div>

					<!-- Set B (duplicate) -->
					<div class="es-brand-item es-brand-agape" title="agape">
						<div style="display:flex; align-items:center; gap:8px;">
							<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
								<path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"/>
							</svg>
							<span style="font-family:'Montserrat', sans-serif; font-weight:800; font-size:19px; letter-spacing:1px;">agape</span>
						</div>
					</div>
					<div class="es-brand-item es-brand-effe" title="effe">
						<span style="font-family:'Montserrat', sans-serif; font-weight:800; font-size:23px; letter-spacing:1px;">effe</span>
					</div>
					<div class="es-brand-item es-brand-artcolor" title="ART COLOR">
						<div class="es-logo-stacked" style="align-items:center;">
							<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
								<path d="M12 3a9 9 0 0 0-9 9c0 4.97 4.03 9 9 9s9-4.03 9-9c0-1.5-.37-2.91-1.02-4.15L12 17l-3-6 7.5-3.5"/>
							</svg>
							<span style="font-family:'Montserrat', sans-serif; font-size:8px; font-weight:700; letter-spacing:1.5px;">ART COLOR</span>
						</div>
					</div>
					<div class="es-brand-item es-brand-unidrain" title="unidrain">
						<div style="display:flex; align-items:center; gap:6px;">
							<div style="display:flex; flex-direction:column; gap:2px;">
								<span style="width:10px; height:2px; background:currentColor; display:block;"></span>
								<span style="width:10px; height:2px; background:currentColor; display:block;"></span>
								<span style="width:10px; height:2px; background:currentColor; display:block;"></span>
							</div>
							<span style="font-family:'Montserrat', sans-serif; font-weight:600; font-size:16px; letter-spacing:0.5px;">unidrain<sup>&reg;</sup></span>
						</div>
					</div>
					<div class="es-brand-item es-brand-milldue" title="milldue">
						<div class="es-logo-with-arrow">
							<span style="font-family:'Montserrat', sans-serif; font-weight:800; font-size:20px; letter-spacing:0.5px;">milldue</span>
							<svg class="es-logo-arrow" width="9" height="15" viewBox="0 0 8 14" fill="none" stroke="currentColor" stroke-width="1.8">
								<path d="M1 1l6 6-6 6" />
							</svg>
						</div>
					</div>
					<div class="es-brand-item es-brand-dornbracht" title="DORNBRACHT">
						<span style="font-family:'Montserrat', sans-serif; font-weight:700; font-size:15px; letter-spacing:2px;">DORNBRACHT</span>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
	return ob_get_clean();
}
add_shortcode( 'fountainhead_home_brand_marquee', 'fountainhead_home_brand_marquee_shortcode' );
