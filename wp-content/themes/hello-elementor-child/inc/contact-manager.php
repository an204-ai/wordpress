<?php
/**
 * Fountainhead Contact Leads & Appointment Manager
 * Database storage, Custom SMTP & Email Notifications, and Modern Admin Dashboard
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Fountainhead_Contact_Manager {

	private static $instance = null;
	private $table_name;

	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function __construct() {
		global $wpdb;
		$this->table_name = $wpdb->prefix . 'es_contact_leads';

		// Auto create/upgrade table
		add_action( 'after_setup_theme', [ $this, 'create_table' ] );

		// Configure PHPMailer & SMTP
		add_action( 'phpmailer_init', [ $this, 'configure_phpmailer' ] );
		add_filter( 'wp_mail_from', [ $this, 'filter_mail_from' ] );
		add_filter( 'wp_mail_from_name', [ $this, 'filter_mail_from_name' ] );

		// AJAX Hooks for frontend submission
		add_action( 'wp_ajax_es_submit_contact', [ $this, 'handle_frontend_submit' ] );
		add_action( 'wp_ajax_nopriv_es_submit_contact', [ $this, 'handle_frontend_submit' ] );

		// AJAX Hooks for admin actions
		add_action( 'wp_ajax_es_update_lead_status', [ $this, 'handle_update_status' ] );
		add_action( 'wp_ajax_es_delete_lead', [ $this, 'handle_delete_lead' ] );
		add_action( 'wp_ajax_es_save_contact_settings', [ $this, 'handle_save_settings' ] );
		add_action( 'admin_init', [ $this, 'handle_csv_export' ] );

		// Admin Menu
		add_action( 'admin_menu', [ $this, 'register_admin_menu' ] );
	}

	/**
	 * Create Custom DB Table if not exists
	 */
	public function create_table() {
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE IF NOT EXISTS {$this->table_name} (
			id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
			form_type VARCHAR(50) NOT NULL DEFAULT 'consult',
			full_name VARCHAR(255) NOT NULL,
			phone VARCHAR(50) NOT NULL,
			email VARCHAR(191) NOT NULL,
			service VARCHAR(255) NOT NULL,
			location VARCHAR(255) NULL,
			preferred_date DATE NULL,
			message LONGTEXT NULL,
			status VARCHAR(50) NOT NULL DEFAULT 'new',
			ip_address VARCHAR(100) NULL,
			created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY (id),
			KEY status (status),
			KEY created_at (created_at)
		) $charset_collate;";

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $sql );
	}

	/**
	 * Configure PHPMailer with custom SMTP and embedded brand assets
	 */
	public function configure_phpmailer( $phpmailer ) {
		// Embed brand logo as inline CID attachment (ensures logo renders across all email clients)
		$upload_dir = wp_upload_dir();
		$logo_path  = $upload_dir['basedir'] . '/2026/09/logo_suoinguon.png';
		if ( file_exists( $logo_path ) ) {
			try {
				$phpmailer->addEmbeddedImage( $logo_path, 'fountainhead_logo', 'logo_suoinguon.png' );
			} catch ( Exception $e ) {
				// Silently continue
			}
		}

		$smtp_enabled = get_option( 'es_contact_smtp_enable', '0' );
		if ( '1' !== $smtp_enabled ) {
			return;
		}

		$host       = get_option( 'es_contact_smtp_host', '' );
		$port       = (int) get_option( 'es_contact_smtp_port', 587 );
		$encryption = get_option( 'es_contact_smtp_encryption', 'tls' );
		$auth       = get_option( 'es_contact_smtp_auth', '1' );
		$user       = get_option( 'es_contact_smtp_user', '' );
		$pass       = get_option( 'es_contact_smtp_pass', '' );

		if ( empty( $host ) ) {
			return;
		}

		$phpmailer->isSMTP();
		$phpmailer->Host = $host;
		$phpmailer->Port = $port;

		if ( '1' === $auth && ! empty( $user ) ) {
			$phpmailer->SMTPAuth = true;
			$phpmailer->Username = $user;
			$phpmailer->Password = $pass;
		} else {
			$phpmailer->SMTPAuth = false;
		}

		if ( 'tls' === $encryption ) {
			$phpmailer->SMTPSecure = 'tls';
			$phpmailer->SMTPAutoTLS = true;
		} elseif ( 'ssl' === $encryption ) {
			$phpmailer->SMTPSecure = 'ssl';
		} else {
			$phpmailer->SMTPSecure = '';
			$phpmailer->SMTPAutoTLS = false;
		}
	}

	/**
	 * Automatically use SMTP account email as From Email (or admin_email fallback)
	 */
	public function filter_mail_from( $from_email ) {
		$smtp_enable = get_option( 'es_contact_smtp_enable', '0' );
		$smtp_user   = get_option( 'es_contact_smtp_user', '' );

		if ( '1' === $smtp_enable && ! empty( $smtp_user ) && is_email( $smtp_user ) ) {
			return $smtp_user;
		}

		$admin_email = get_option( 'admin_email' );
		if ( ! empty( $admin_email ) && is_email( $admin_email ) && false !== strpos( $admin_email, '.' ) ) {
			return $admin_email;
		}

		return 'info@suoinguon.vn';
	}

	/**
	 * Ensure From Name is set properly
	 */
	public function filter_mail_from_name( $from_name ) {
		$custom_name = get_option( 'es_contact_from_name', '' );
		if ( ! empty( $custom_name ) ) {
			return $custom_name;
		}
		return get_bloginfo( 'name' );
	}

	/**
	 * Handle Frontend AJAX Submission
	 */
	public function handle_frontend_submit() {
		check_ajax_referer( 'es_contact_nonce_action', 'es_contact_nonce' );

		// Honeypot anti-spam check
		if ( ! empty( $_POST['website_hp'] ) ) {
			wp_send_json_error( [ 'message' => 'Spam detected.' ] );
		}

		$form_type      = sanitize_text_field( $_POST['form_type'] ?? 'consult' );
		$full_name      = sanitize_text_field( $_POST['full_name'] ?? '' );
		$phone          = sanitize_text_field( $_POST['phone'] ?? '' );
		$email          = sanitize_email( $_POST['email'] ?? '' );
		$service        = sanitize_text_field( $_POST['service'] ?? '' );
		$location       = sanitize_text_field( $_POST['location'] ?? '' );
		$preferred_date = ! empty( $_POST['preferred_date'] ) ? sanitize_text_field( $_POST['preferred_date'] ) : null;
		$message        = sanitize_textarea_field( $_POST['message'] ?? '' );
		$ip_address     = sanitize_text_field( $_SERVER['REMOTE_ADDR'] ?? '' );

		if ( empty( $full_name ) || empty( $phone ) || empty( $email ) ) {
			wp_send_json_error( [ 'message' => 'Vui lòng điền đầy đủ các thông tin bắt buộc (Họ tên, Số điện thoại, Email).' ] );
		}

		// Service mapping
		$service_labels = [
			'chia-khoa-trao-tay'     => 'Dự án Chìa khoá trao tay Design & Build',
			'thiet-ke-kien-truc'     => 'Thiết kế kiến trúc & Tư vấn nội thất',
			'thi-cong-noi-that'      => 'Thi công nội thất & Xây dựng',
			'san-xuat-do-go'         => 'Sản xuất & Cung cấp đồ gỗ nội thất từ xưởng mộc',
			'quan-ly-du-an'          => 'Quản lý dự án & Giám sát công trình',
			'khac'                   => 'Nhu cầu tư vấn khác',
			'nha-cung-cap-vat-lieu'  => 'Nhà cung cấp vật liệu xây dựng & hoàn thiện',
			'nha-thau-phu-thi-cong'  => 'Nhà thầu phụ chuyên ngành thi công lắp đặt',
			'kien-truc-su-doi-tac'   => 'Kiến trúc sư và Văn phòng thiết kế đối tác',
			'chu-dau-tu-du-an'       => 'Chủ đầu tư và Doanh nghiệp phát triển dự án',
			'hop-tac-khac'           => 'Đề xuất hợp tác chiến lược khác',
		];
		$service_readable = $service_labels[ $service ] ?? ( ! empty( $service ) ? $service : 'Chưa phân loại' );

		// Location mapping
		$location_labels = [
			'office-bach-dang'     => 'Trụ sở Fountainhead: 285-287 Bạch Đằng, P.15, Bình Thạnh, TP.HCM',
			'factory-thanh-xuan'   => 'Xưởng sản xuất: Số 28 Đường Thạnh Xuân 31, P. Thạnh Xuân, Q.12, TP.HCM',
			'onsite-survey'        => 'Khảo sát trực tiếp tại địa điểm dự án của Quý khách',
			'online-consultation'  => 'Tư vấn trực tuyến (Điện thoại hoặc Hội thoại trực tuyến)',
		];
		$location_readable = $location_labels[ $location ] ?? ( ! empty( $location ) ? $location : 'Chưa chỉ định' );

		// Save to Database
		global $wpdb;
		$inserted = $wpdb->insert(
			$this->table_name,
			[
				'form_type'      => $form_type,
				'full_name'      => $full_name,
				'phone'          => $phone,
				'email'          => $email,
				'service'        => $service_readable,
				'location'       => $location_readable,
				'preferred_date' => $preferred_date,
				'message'        => $message,
				'status'         => 'new',
				'ip_address'     => $ip_address,
				'created_at'     => current_time( 'mysql' ),
			],
			[ '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s' ]
		);

		if ( false === $inserted ) {
			wp_send_json_error( [ 'message' => 'Lỗi lưu thông tin vào cơ sở dữ liệu. Vui lòng thử lại sau.' ] );
		}

		$lead_id = $wpdb->insert_id;

		// Send Email Notifications
		$this->send_lead_notification_email( $lead_id, [
			'form_type'      => $form_type,
			'full_name'      => $full_name,
			'phone'          => $phone,
			'email'          => $email,
			'service'        => $service_readable,
			'location'       => $location_readable,
			'preferred_date' => $preferred_date,
			'message'        => $message,
		] );

		wp_send_json_success( [
			'message' => 'Cảm ơn Quý khách đã gửi yêu cầu. Chúng tôi đã tiếp nhận thông tin và sẽ phản hồi trong vòng 24 giờ làm việc.',
			'lead_id' => $lead_id,
		] );
	}

	/**
	 * Send Notification Email Helper (Formatted with Tenten / Luxury Layout)
	 */
	public function send_lead_notification_email( $lead_id, $data ) {
		$recipient_raw = get_option( 'es_contact_recipient_emails', '' );
		if ( empty( $recipient_raw ) ) {
			$recipient_raw = get_option( 'admin_email' );
		}

		$recipients = array_filter( array_map( 'trim', explode( ',', $recipient_raw ) ) );
		if ( empty( $recipients ) ) {
			$recipients = [ get_option( 'admin_email' ) ];
		}

		$site_title = get_bloginfo( 'name' );
		$form_title = ( 'partner' === ( $data['form_type'] ?? '' ) ) ? 'ĐĂNG KÝ HỢP TÁC & CUNG ỨNG' : 'ĐẶT LỊCH HẸN TƯ VẤN DỰ ÁN';

		$subject = sprintf( '[%s] Yêu Cầu Mới #%d: %s - %s', $site_title, $lead_id, $form_title, $data['full_name'] );

		$headers = [
			'Content-Type: text/html; charset=UTF-8',
			'Reply-To: ' . $data['full_name'] . ' <' . $data['email'] . '>',
		];

		// Logo URL
		$logo_url = home_url( '/wp-content/uploads/2026/09/logo_suoinguon.png' );

		ob_start();
		?>
		<!DOCTYPE html>
		<html lang="vi">
		<head>
			<meta charset="utf-8">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<title><?php echo esc_html( $subject ); ?></title>
		</head>
		<body style="margin: 0; padding: 24px 10px; background-color: #f4f6f8; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; color: #1e293b;">
			<table width="100%" border="0" cellpadding="0" cellspacing="0" style="background-color: #f4f6f8; margin: 0; padding: 0;">
				<tr>
					<td align="center" style="padding: 10px 0 30px 0;">
						<table class="email-container" width="600" border="0" cellpadding="0" cellspacing="0" style="width: 100%; max-width: 600px; background-color: #ffffff; border: 1px solid #e2e8f0; border-radius: 4px; box-shadow: 0 2px 10px rgba(0,0,0,0.04); overflow: hidden; text-align: left;">
							<!-- Header Logo -->
							<tr>
								<td style="padding: 26px 28px 16px 28px; text-align: center; background-color: #ffffff;">
									<a href="<?php echo esc_url( home_url() ); ?>" target="_blank" style="text-decoration: none; display: inline-block;">
										<img src="cid:fountainhead_logo" alt="<?php echo esc_attr( $site_title ); ?>" style="max-height: 52px; width: auto; max-width: 250px; display: block; margin: 0 auto; border: 0;" />
									</a>
									<div style="border-top: 1px dashed #cbd5e1; margin-top: 20px; width: 100%;"></div>
								</td>
							</tr>

							<!-- Email Body -->
							<tr>
								<td style="padding: 6px 28px 24px 28px; background-color: #ffffff;">
									<!-- Salutation -->
									<p style="font-size: 14px; font-weight: bold; color: #0f172a; margin: 0 0 12px 0;">Kính gửi Ban Quản Trị Fountainhead / Quý Khách,</p>
									<p style="font-size: 13.5px; line-height: 1.6; color: #334155; margin: 0 0 18px 0;">
										Hệ thống website vừa tiếp nhận yêu cầu liên hệ / tư vấn dự án mới từ khách hàng với thông tin chi tiết như sau:
									</p>

									<!-- Request Overview Header -->
									<p style="font-size: 13.5px; font-weight: bold; color: #0f172a; margin: 0 0 10px 0;">
										<span style="color: #0070ba;">&#9658;</span> Thông tin yêu cầu &ndash; <span style="color: #e65100;"><?php echo esc_html( $form_title ); ?></span>:
									</p>

									<!-- Data Bullet List -->
									<ul style="margin: 0 0 18px 0; padding-left: 20px; font-size: 13.5px; line-height: 1.85; color: #334155;">
										<li><strong>Mã yêu cầu:</strong> <span style="color: #0f172a; font-weight: bold;">#<?php echo esc_html( $lead_id ); ?></span></li>
										<li><strong>Họ tên / Đơn vị:</strong> <span style="color: #0f172a; font-weight: bold; font-size: 14px;"><?php echo esc_html( $data['full_name'] ); ?></span></li>
										<li><strong>Số điện thoại:</strong> <a href="tel:<?php echo esc_attr( $data['phone'] ); ?>" style="color: #0f172a; text-decoration: none; font-weight: bold;"><?php echo esc_html( $data['phone'] ); ?></a></li>
										<li><strong>Địa chỉ Email:</strong> <a href="mailto:<?php echo esc_attr( $data['email'] ); ?>" style="color: #0070ba; text-decoration: none;"><?php echo esc_html( $data['email'] ); ?></a></li>
										<li><strong>Hạng mục quan tâm:</strong> <span style="color: #0f172a;"><?php echo esc_html( $data['service'] ); ?></span></li>
										<li><strong>Địa điểm tư vấn:</strong> <span style="color: #0f172a;"><?php echo esc_html( $data['location'] ); ?></span></li>
										<?php if ( ! empty( $data['preferred_date'] ) ) : ?>
										<li><strong>Thời gian hẹn:</strong> <span style="color: #0f172a; font-weight: bold;"><?php echo esc_html( date_i18n( 'd/m/Y', strtotime( $data['preferred_date'] ) ) ); ?></span></li>
										<?php endif; ?>
										<li><strong>Thời gian tiếp nhận:</strong> <span style="color: #64748b;"><?php echo esc_html( current_time( 'd/m/Y H:i' ) ); ?></span></li>
									</ul>

									<!-- Detailed Message (if present) -->
									<?php if ( ! empty( $data['message'] ) ) : ?>
										<p style="font-size: 13.5px; font-weight: bold; color: #0f172a; margin: 16px 0 8px 0;">
											<span style="color: #0070ba;">&#9658;</span> Nội dung / Yêu cầu chi tiết:
										</p>
										<div style="background-color: #f8fafc; border-left: 3px solid #0070ba; border-radius: 4px; padding: 12px 16px; font-size: 13px; line-height: 1.65; color: #334155; margin-bottom: 22px; word-break: break-word;">
											<?php echo nl2br( esc_html( $data['message'] ) ); ?>
										</div>
									<?php endif; ?>

									<!-- Call to Action Button (Tenten style orange button) -->
									<div style="text-align: center; margin: 26px 0 26px 0;">
										<a href="<?php echo esc_url( admin_url( 'admin.php?page=es-contact-leads' ) ); ?>" target="_blank" style="display: inline-block; background-color: #e65100; color: #ffffff !important; font-size: 13px; font-weight: bold; padding: 12px 28px; text-decoration: none; border-radius: 4px; text-transform: uppercase; letter-spacing: 0.5px; box-shadow: 0 2px 4px rgba(230,81,0,0.25);">
											XEM CHI TIẾT TRÊN TRANG QUẢN TRỊ
										</a>
									</div>

									<!-- Full-Width Blue Footer Strip (Tenten style) -->
									<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #0070ba; border-radius: 4px; margin-bottom: 14px;">
										<tr>
											<td style="padding: 10px 14px; text-align: center; font-size: 12px; color: #ffffff; line-height: 1.55;">
												<strong style="color: #ffffff;">Hotline: 0902.92.05.79 (Giờ hành chính) &ndash; 0902.92.05.79 (Kỹ thuật / Tư vấn)</strong><br>
												<span style="color: #ffffff;">Email: <a href="mailto:info@suoinguon.vn" style="color: #ffffff; text-decoration: underline;">info@suoinguon.vn</a></span>
											</td>
										</tr>
									</table>

									<!-- Sub-footer Disclaimer -->
									<div style="text-align: center; font-size: 11px; color: #94a3b8; line-height: 1.5;">
										Bạn nhận được email này khi có khách hàng đăng ký nhận thông tin tại website <a href="<?php echo esc_url( home_url() ); ?>" target="_blank" style="color: #0070ba; text-decoration: underline;"><?php echo esc_html( parse_url( home_url(), PHP_URL_HOST ) ); ?></a>.<br>
										Email thông báo tự động từ hệ thống FOUNTAINHEAD DESIGN &amp; BUILD.
									</div>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</body>
		</html>
		<?php
		$email_content = ob_get_clean();

		foreach ( $recipients as $to_email ) {
			if ( is_email( $to_email ) ) {
				@wp_mail( $to_email, $subject, $email_content, $headers );
			}
		}
	}

	/**
	 * Handle AJAX status update from Admin
	 */
	public function handle_update_status() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( [ 'message' => 'Không có quyền thực hiện.' ] );
		}

		check_ajax_referer( 'es_admin_lead_nonce', 'nonce' );

		$lead_id = intval( $_POST['lead_id'] ?? 0 );
		$status  = sanitize_text_field( $_POST['status'] ?? 'new' );

		if ( ! $lead_id || ! in_array( $status, [ 'new', 'contacted', 'completed', 'cancelled' ], true ) ) {
			wp_send_json_error( [ 'message' => 'Dữ liệu trạng thái không hợp lệ.' ] );
		}

		global $wpdb;
		$updated = $wpdb->update(
			$this->table_name,
			[ 'status' => $status ],
			[ 'id' => $lead_id ],
			[ '%s' ],
			[ '%d' ]
		);

		if ( false === $updated ) {
			wp_send_json_error( [ 'message' => 'Lỗi cập nhật cơ sở dữ liệu.' ] );
		}

		$counts = $this->get_lead_counts();

		wp_send_json_success( [
			'message' => 'Cập nhật trạng thái thành công!',
			'counts'  => $counts,
		] );
	}

	/**
	 * Handle AJAX delete lead from Admin
	 */
	public function handle_delete_lead() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( [ 'message' => 'Không có quyền thực hiện.' ] );
		}

		check_ajax_referer( 'es_admin_lead_nonce', 'nonce' );

		$lead_id = intval( $_POST['lead_id'] ?? 0 );
		if ( ! $lead_id ) {
			wp_send_json_error( [ 'message' => 'Mã yêu cầu không hợp lệ.' ] );
		}

		global $wpdb;
		$deleted = $wpdb->delete(
			$this->table_name,
			[ 'id' => $lead_id ],
			[ '%d' ]
		);

		if ( false === $deleted ) {
			wp_send_json_error( [ 'message' => 'Lỗi khi xóa bản ghi.' ] );
		}

		$counts = $this->get_lead_counts();

		wp_send_json_success( [
			'message' => 'Đã xóa bản ghi thành công!',
			'counts'  => $counts,
		] );
	}

	/**
	 * Handle AJAX save email & SMTP settings
	 */
	public function handle_save_settings() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( [ 'message' => 'Không có quyền thực hiện.' ] );
		}

		check_ajax_referer( 'es_admin_lead_nonce', 'nonce' );

		$recipient_emails = sanitize_text_field( $_POST['recipient_emails'] ?? '' );
		$from_name        = sanitize_text_field( $_POST['from_name'] ?? '' );
		$smtp_enable      = ( isset( $_POST['smtp_enable'] ) && '1' === $_POST['smtp_enable'] ) ? '1' : '0';
		$smtp_host        = sanitize_text_field( $_POST['smtp_host'] ?? '' );
		$smtp_port        = intval( $_POST['smtp_port'] ?? 587 );
		$smtp_encryption  = sanitize_text_field( $_POST['smtp_encryption'] ?? 'tls' );
		$smtp_auth        = ( isset( $_POST['smtp_auth'] ) && '1' === $_POST['smtp_auth'] ) ? '1' : '0';
		$smtp_user        = sanitize_text_field( $_POST['smtp_user'] ?? '' );
		$smtp_pass        = sanitize_text_field( $_POST['smtp_pass'] ?? '' );

		update_option( 'es_contact_recipient_emails', $recipient_emails );
		update_option( 'es_contact_from_name', $from_name );
		update_option( 'es_contact_smtp_enable', $smtp_enable );
		update_option( 'es_contact_smtp_host', $smtp_host );
		update_option( 'es_contact_smtp_port', $smtp_port );
		update_option( 'es_contact_smtp_encryption', $smtp_encryption );
		update_option( 'es_contact_smtp_auth', $smtp_auth );
		update_option( 'es_contact_smtp_user', $smtp_user );
		
		// Save password (allows clearing when user deletes it)
		update_option( 'es_contact_smtp_pass', $smtp_pass );

		wp_send_json_success( [ 'message' => 'Đã lưu cấu hình Email & SMTP thành công!' ] );
	}

	/**
	 * Helper to get counts
	 */
	public function get_lead_counts() {
		global $wpdb;
		return [
			'all'       => (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$this->table_name}" ),
			'new'       => (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$this->table_name} WHERE status = 'new'" ),
			'contacted' => (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$this->table_name} WHERE status = 'contacted'" ),
			'completed' => (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$this->table_name} WHERE status = 'completed'" ),
			'cancelled' => (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$this->table_name} WHERE status = 'cancelled'" ),
		];
	}

	/**
	 * Handle Styled Excel Export (.xls)
	 */
	public function handle_csv_export() {
		if ( ! isset( $_GET['es_action'] ) || $_GET['es_action'] !== 'export_leads_csv' ) {
			return;
		}

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( 'Không có quyền thực hiện.' );
		}

		check_admin_referer( 'es_export_leads_nonce' );

		global $wpdb;
		$tab    = sanitize_text_field( $_GET['tab'] ?? 'all' );
		$where  = 'WHERE 1=1';
		if ( in_array( $tab, [ 'new', 'contacted', 'completed', 'cancelled' ], true ) ) {
			$where .= $wpdb->prepare( ' AND status = %s', $tab );
		}

		$leads = $wpdb->get_results( "SELECT * FROM {$this->table_name} {$where} ORDER BY created_at DESC", ARRAY_A );

		$filename = 'danh-sach-yeu-cau-tu-van-' . date( 'Y-m-d-His' ) . '.xls';

		header( 'Content-Type: application/vnd.ms-excel; charset=UTF-8' );
		header( 'Content-Disposition: attachment; filename="' . $filename . '"' );
		header( 'Pragma: no-cache' );
		header( 'Expires: 0' );

		$status_map = [
			'new'       => [ 'label' => 'Chưa xử lý', 'bg' => '#dbeafe', 'color' => '#1e40af' ],
			'contacted' => [ 'label' => 'Đã liên hệ', 'bg' => '#fef3c7', 'color' => '#92400e' ],
			'completed' => [ 'label' => 'Hoàn thành', 'bg' => '#dcfce7', 'color' => '#166534' ],
			'cancelled' => [ 'label' => 'Đã hủy', 'bg' => '#f1f5f9', 'color' => '#475569' ],
		];

		$total_records = count( $leads );
		$export_time   = current_time( 'd/m/Y H:i:s' );
		$site_title    = get_bloginfo( 'name' );

		echo '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">';
		echo '<head>';
		echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">';
		echo '<style>';
		echo 'body { font-family: "Segoe UI", Arial, sans-serif; }';
		echo 'table { border-collapse: collapse; width: 100%; }';
		echo '.title-row { background-color: #141312; color: #ffffff; font-size: 15pt; font-weight: bold; text-align: center; height: 42px; vertical-align: middle; }';
		echo '.meta-row { background-color: #f8fafc; color: #64748b; font-size: 10pt; font-style: italic; text-align: left; height: 26px; border-bottom: 2px solid #cbd5e1; }';
		echo '.header-th { background-color: #1e293b; color: #ffffff; font-size: 11pt; font-weight: bold; text-align: center; height: 35px; vertical-align: middle; border: 1px solid #475569; }';
		echo '.data-td { border: 1px solid #cbd5e1; padding: 7px 10px; font-size: 10.5pt; vertical-align: middle; }';
		echo '.td-center { text-align: center; }';
		echo '.td-text { mso-number-format:"\@"; text-align: center; }';
		echo '.row-even { background-color: #ffffff; }';
		echo '.row-odd { background-color: #f8fafc; }';
		echo '.footer-row { background-color: #f1f5f9; font-weight: bold; font-size: 11pt; border-top: 2px solid #94a3b8; height: 32px; }';
		echo '</style>';
		echo '</head>';
		echo '<body>';
		echo '<table>';

		// Title banner
		echo '<tr><td colspan="11" class="title-row">' . esc_html( mb_strtoupper( $site_title . ' - DANH SÁCH YÊU CẦU TƯ VẤN & HỢP TÁC', 'UTF-8' ) ) . '</td></tr>';
		echo '<tr><td colspan="11" class="meta-row">&nbsp;Ngày xuất báo cáo: ' . $export_time . ' | Bộ lọc: ' . ( 'all' === $tab ? 'Tất cả' : ( $status_map[ $tab ]['label'] ?? $tab ) ) . ' | Tổng số: ' . $total_records . ' bản ghi</td></tr>';
		echo '<tr><td colspan="11" style="height:10px;"></td></tr>';

		// Header row
		echo '<thead>';
		echo '<tr>';
		echo '<th class="header-th" style="width: 60px;">STT / Mã</th>';
		echo '<th class="header-th" style="width: 140px;">Phân Loại</th>';
		echo '<th class="header-th" style="width: 190px;">Khách Hàng / Đơn Vị</th>';
		echo '<th class="header-th" style="width: 130px;">Số Điện Thoại</th>';
		echo '<th class="header-th" style="width: 200px;">Địa Chỉ Email</th>';
		echo '<th class="header-th" style="width: 240px;">Hạng Mục Quan Tâm</th>';
		echo '<th class="header-th" style="width: 220px;">Địa Điểm Tư Vấn</th>';
		echo '<th class="header-th" style="width: 120px;">Thời Gian Hẹn</th>';
		echo '<th class="header-th" style="width: 130px;">Trạng Thái</th>';
		echo '<th class="header-th" style="width: 140px;">Ngày Gửi</th>';
		echo '<th class="header-th" style="width: 320px;">Nội Dung / Yêu Cầu</th>';
		echo '</tr>';
		echo '</thead>';

		// Body
		echo '<tbody>';
		if ( empty( $leads ) ) {
			echo '<tr><td colspan="11" class="data-td td-center" style="height: 50px; color: #94a3b8;">Không có bản ghi nào trong mục này.</td></tr>';
		} else {
			$stt = 1;
			foreach ( $leads as $lead ) {
				$row_class   = ( $stt % 2 === 0 ) ? 'row-odd' : 'row-even';
				$type_text   = ( 'partner' === $lead['form_type'] ) ? 'Đăng ký hợp tác' : 'Đặt lịch tư vấn';
				$status_info = $status_map[ $lead['status'] ] ?? [ 'label' => $lead['status'], 'bg' => '#f1f5f9', 'color' => '#475569' ];
				$date_text   = ! empty( $lead['preferred_date'] ) ? date( 'd/m/Y', strtotime( $lead['preferred_date'] ) ) : 'Chưa chỉ định';
				$created_text = date( 'd/m/Y H:i', strtotime( $lead['created_at'] ) );

				echo '<tr class="' . $row_class . '">';
				echo '<td class="data-td td-center" style="font-weight: bold; color: #475569;">#' . esc_html( $lead['id'] ) . '</td>';
				echo '<td class="data-td td-center" style="font-weight: 500;">' . esc_html( $type_text ) . '</td>';
				echo '<td class="data-td" style="font-weight: bold; color: #0f172a;">' . esc_html( $lead['full_name'] ) . '</td>';
				echo '<td class="data-td td-text" style="font-weight: bold; color: #0f172a;">' . esc_html( $lead['phone'] ) . '</td>';
				echo '<td class="data-td"><a href="mailto:' . esc_attr( $lead['email'] ) . '" style="color: #2563eb;">' . esc_html( $lead['email'] ) . '</a></td>';
				echo '<td class="data-td" style="font-weight: 500;">' . esc_html( $lead['service'] ) . '</td>';
				echo '<td class="data-td">' . esc_html( $lead['location'] ) . '</td>';
				echo '<td class="data-td td-center">' . esc_html( $date_text ) . '</td>';
				echo '<td class="data-td td-center" style="background-color: ' . $status_info['bg'] . '; color: ' . $status_info['color'] . '; font-weight: bold; border-color: #cbd5e1;">' . esc_html( $status_info['label'] ) . '</td>';
				echo '<td class="data-td td-center" style="color: #64748b;">' . esc_html( $created_text ) . '</td>';
				echo '<td class="data-td" style="color: #334155;">' . nl2br( esc_html( $lead['message'] ) ) . '</td>';
				echo '</tr>';
				$stt++;
			}
		}
		echo '</tbody>';

		// Footer
		echo '<tfoot>';
		echo '<tr class="footer-row">';
		echo '<td colspan="3" class="data-td" style="font-weight: bold;">TỔNG CỘNG: ' . $total_records . ' YÊU CẦU</td>';
		echo '<td colspan="8" class="data-td" style="text-align: right; font-weight: normal; color: #64748b;">Báo cáo xuất tự động từ hệ thống ' . esc_html( $site_title ) . '</td>';
		echo '</tr>';
		echo '</tfoot>';

		echo '</table>';
		echo '</body>';
		echo '</html>';
		exit;
	}

	/**
	 * Register Admin Menu with Badge Counter
	 */
	public function register_admin_menu() {
		global $wpdb;
		$new_count = 0;
		if ( $wpdb->get_var( "SHOW TABLES LIKE '{$this->table_name}'" ) === $this->table_name ) {
			$new_count = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$this->table_name} WHERE status = 'new'" );
		}

		$badge = $new_count > 0 ? sprintf( ' <span class="update-plugins count-%d" style="background:#2563eb; color:#fff; border-radius:10px; font-weight:700; padding:1px 7px; font-size:10px;"><span class="plugin-count">%d</span></span>', $new_count, $new_count ) : '';

		add_menu_page(
			'Yêu Cầu Tư Vấn',
			'Yêu Cầu Tư Vấn' . $badge,
			'manage_options',
			'es-contact-leads',
			[ $this, 'render_admin_page' ],
			'dashicons-email-alt',
			6
		);
	}

	/**
	 * Render Admin Management Page
	 */
	public function render_admin_page() {
		global $wpdb;

		$current_tab = sanitize_text_field( $_GET['tab'] ?? 'all' );
		$search      = sanitize_text_field( $_GET['s'] ?? '' );
		$type_filter = sanitize_text_field( $_GET['form_type'] ?? '' );

		// Query where conditions
		$where = 'WHERE 1=1';
		if ( in_array( $current_tab, [ 'new', 'contacted', 'completed', 'cancelled' ], true ) ) {
			$where .= $wpdb->prepare( ' AND status = %s', $current_tab );
		}
		if ( in_array( $type_filter, [ 'consult', 'partner' ], true ) ) {
			$where .= $wpdb->prepare( ' AND form_type = %s', $type_filter );
		}
		if ( ! empty( $search ) ) {
			$like = '%' . $wpdb->esc_like( $search ) . '%';
			$where .= $wpdb->prepare( ' AND (full_name LIKE %s OR phone LIKE %s OR email LIKE %s OR service LIKE %s OR message LIKE %s)', $like, $like, $like, $like, $like );
		}

		$counts = $this->get_lead_counts();
		$leads  = $wpdb->get_results( "SELECT * FROM {$this->table_name} {$where} ORDER BY created_at DESC LIMIT 150" );

		$nonce      = wp_create_nonce( 'es_admin_lead_nonce' );
		$export_url = wp_nonce_url( admin_url( 'admin.php?es_action=export_leads_csv&tab=' . $current_tab ), 'es_export_leads_nonce' );

		// Current Settings
		$recipient_emails = get_option( 'es_contact_recipient_emails', get_option( 'admin_email' ) );
		$from_name        = get_option( 'es_contact_from_name', get_bloginfo( 'name' ) );
		$smtp_enable      = get_option( 'es_contact_smtp_enable', '0' );
		$smtp_host        = get_option( 'es_contact_smtp_host', 'smtp.gmail.com' );
		$smtp_port        = get_option( 'es_contact_smtp_port', '587' );
		$smtp_encryption  = get_option( 'es_contact_smtp_encryption', 'tls' );
		$smtp_auth        = get_option( 'es_contact_smtp_auth', '1' );
		$smtp_user        = get_option( 'es_contact_smtp_user', '' );
		$smtp_pass        = get_option( 'es_contact_smtp_pass', '' );
		?>

		<!-- Inline Master Luxury Admin Stylesheet (100% Reliable Render) -->
		<style>
			.es-admin-container {
				font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
				color: #0f172a;
				margin: 15px 15px 30px 0;
				width: auto;
				max-width: 100%;
				box-sizing: border-box;
			}
			.es-admin-header {
				display: flex;
				justify-content: space-between;
				align-items: center;
				flex-wrap: wrap;
				gap: 16px;
				margin-bottom: 20px;
				padding-bottom: 18px;
				border-bottom: 1px solid #e2e8f0;
			}
			.es-header-left h1 {
				font-size: 24px;
				font-weight: 700;
				color: #0f172a;
				margin: 0 0 4px 0;
				display: flex;
				align-items: center;
				gap: 10px;
				letter-spacing: -0.3px;
			}
			.es-header-left p {
				margin: 0;
				font-size: 13.5px;
				color: #64748b;
			}
			.es-header-actions {
				display: flex;
				align-items: center;
				flex-wrap: wrap;
				gap: 8px;
			}
			.es-btn {
				display: inline-flex;
				align-items: center;
				justify-content: center;
				gap: 6px;
				padding: 8px 16px;
				border-radius: 8px;
				font-size: 13px;
				font-weight: 600;
				cursor: pointer;
				text-decoration: none;
				border: none;
				transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
				box-shadow: 0 1px 2px rgba(0,0,0,0.05);
				white-space: nowrap;
			}
			.es-btn-excel {
				background-color: #15803d !important;
				color: #ffffff !important;
			}
			.es-btn-excel:hover {
				background-color: #166534 !important;
				color: #ffffff !important;
				transform: translateY(-1px);
				box-shadow: 0 4px 12px rgba(21, 128, 61, 0.25);
			}
			.es-btn-settings {
				background-color: #ffffff !important;
				color: #0f172a !important;
				border: 1px solid #cbd5e1 !important;
			}
			.es-btn-settings:hover {
				background-color: #f8fafc !important;
				border-color: #94a3b8 !important;
				color: #0f172a !important;
			}
			.es-btn-save {
				background-color: #15803d !important;
				color: #ffffff !important;
				padding: 10px 22px;
				font-size: 13.5px;
			}
			.es-btn-save:hover {
				background-color: #166534 !important;
				transform: translateY(-1px);
				box-shadow: 0 4px 14px rgba(21, 128, 61, 0.25);
			}

			/* Main Navigation Tabs */
			.es-nav-tabs-wrap {
				display: flex;
				align-items: center;
				justify-content: space-between;
				flex-wrap: wrap;
				gap: 10px;
				margin-bottom: 16px;
				border-bottom: 1px solid #e2e8f0;
				padding-bottom: 12px;
			}
			.es-tabs-list {
				display: flex;
				gap: 8px;
				flex-wrap: wrap;
			}
			.es-tab-link {
				display: inline-flex;
				align-items: center;
				gap: 7px;
				padding: 7px 14px;
				border-radius: 8px;
				font-size: 13px;
				font-weight: 600;
				color: #64748b;
				background: #ffffff;
				border: 1px solid #e2e8f0;
				text-decoration: none;
				transition: all 0.2s ease;
			}
			.es-tab-link:hover {
				background: #f8fafc;
				color: #0f172a;
				border-color: #cbd5e1;
			}
			.es-tab-link.active {
				background: #0f172a;
				color: #ffffff;
				border-color: #0f172a;
				box-shadow: 0 2px 6px rgba(15, 23, 42, 0.15);
			}
			.es-tab-pill {
				display: inline-block;
				padding: 1px 7px;
				border-radius: 9999px;
				font-size: 11px;
				font-weight: 700;
				background: #f1f5f9;
				color: #475569;
			}
			.es-tab-link.active .es-tab-pill {
				background: rgba(255, 255, 255, 0.25);
				color: #ffffff;
			}

			/* Filter Bar */
			.es-filter-card {
				background: #ffffff;
				border: 1px solid #e2e8f0;
				border-radius: 10px;
				padding: 12px 16px;
				margin-bottom: 16px;
				box-shadow: 0 1px 3px rgba(0,0,0,0.02);
			}
			.es-filter-form {
				display: flex;
				align-items: center;
				flex-wrap: wrap;
				gap: 10px;
			}
			.es-search-input-wrap {
				position: relative;
				flex: 1;
				min-width: 240px;
			}
			.es-search-icon {
				position: absolute;
				left: 12px;
				top: 50%;
				transform: translateY(-50%);
				color: #94a3b8;
				pointer-events: none;
			}
			.es-form-input {
				width: 100%;
				box-sizing: border-box;
				padding: 8px 12px 8px 36px;
				border: 1px solid #cbd5e1;
				border-radius: 7px;
				font-size: 13px;
				background: #ffffff;
				color: #0f172a;
				outline: none;
				transition: all 0.2s ease;
			}
			.es-form-input:focus {
				border-color: #0f172a;
				box-shadow: 0 0 0 3px rgba(15, 23, 42, 0.08);
			}
			.es-select-control {
				padding: 8px 12px;
				border: 1px solid #cbd5e1;
				border-radius: 7px;
				font-size: 13px;
				background: #ffffff;
				color: #0f172a;
				cursor: pointer;
				outline: none;
			}
			.es-select-control:focus {
				border-color: #0f172a;
			}

			/* Data Table Card & Full-Width Responsive Wrapper */
			.es-table-card {
				background: #ffffff;
				border: 1px solid #e2e8f0;
				border-radius: 10px;
				box-shadow: 0 2px 12px rgba(0, 0, 0, 0.03);
				width: 100%;
				box-sizing: border-box;
				overflow: hidden;
			}
			.es-table-responsive {
				width: 100%;
				overflow-x: auto;
				-webkit-overflow-scrolling: touch;
			}
			.es-leads-table {
				width: 100%;
				min-width: 960px;
				border-collapse: collapse;
				text-align: left;
			}
			.es-leads-table th {
				background: #f8fafc;
				padding: 12px 14px;
				font-size: 11px;
				text-transform: uppercase;
				letter-spacing: 0.6px;
				color: #64748b;
				font-weight: 700;
				border-bottom: 1px solid #e2e8f0;
				white-space: nowrap;
			}
			.es-leads-table td {
				padding: 13px 14px;
				font-size: 13px;
				color: #1e293b;
				border-bottom: 1px solid #f1f5f9;
				vertical-align: middle;
			}
			.es-leads-table tr:hover td {
				background-color: #fafbfd;
			}
			.es-leads-table tr:last-child td {
				border-bottom: none;
			}

			/* Specific Column Sizing to avoid squishing/overflow */
			.col-id { width: 50px; text-align: center; }
			.col-type { width: 140px; white-space: nowrap; }
			.col-cust { min-width: 180px; }
			.col-phone { width: 125px; white-space: nowrap; }
			.col-service { min-width: 220px; max-width: 280px; line-height: 1.45; }
			.col-date { width: 110px; white-space: nowrap; }
			.col-created { width: 125px; white-space: nowrap; font-size: 12px; }
			.col-status { width: 135px; white-space: nowrap; }
			.col-actions { width: 130px; text-align: right; white-space: nowrap; }

			/* Customer Cell */
			.es-cust-cell {
				display: flex;
				align-items: center;
				gap: 10px;
			}
			.es-avatar-initial {
				width: 34px;
				height: 34px;
				border-radius: 50%;
				background: #e2e8f0;
				color: #0f172a;
				display: flex;
				align-items: center;
				justify-content: center;
				font-weight: 700;
				font-size: 13px;
				flex-shrink: 0;
			}
			.es-cust-name {
				font-weight: 600;
				color: #0f172a;
				font-size: 13.5px;
				line-height: 1.3;
				margin-bottom: 2px;
			}
			.es-cust-email {
				font-size: 12px;
				color: #64748b;
				display: block;
			}

			/* Badges */
			.es-badge {
				display: inline-flex;
				align-items: center;
				gap: 4px;
				padding: 3px 8px;
				border-radius: 5px;
				font-size: 11.5px;
				font-weight: 600;
				white-space: nowrap;
			}
			.es-badge-consult {
				background: #e0f2fe;
				color: #0369a1;
				border: 1px solid #bae6fd;
			}
			.es-badge-partner {
				background: #fef3c7;
				color: #b45309;
				border: 1px solid #fde68a;
			}

			/* Status Dropdowns with UX colors */
			.es-status-dropdown {
				padding: 5px 10px;
				border-radius: 6px;
				font-size: 12px;
				font-weight: 600;
				border: 1px solid transparent;
				cursor: pointer;
				outline: none;
				transition: all 0.2s ease;
			}
			.es-status-new {
				background-color: #dbeafe !important;
				color: #1d4ed8 !important;
				border-color: #93c5fd !important;
			}
			.es-status-contacted {
				background-color: #fef3c7 !important;
				color: #b45309 !important;
				border-color: #fde68a !important;
			}
			.es-status-completed {
				background-color: #dcfce7 !important;
				color: #15803d !important;
				border-color: #86efac !important;
			}
			.es-status-cancelled {
				background-color: #f1f5f9 !important;
				color: #64748b !important;
				border-color: #cbd5e1 !important;
			}

			/* Action Buttons */
			.es-action-btns {
				display: inline-flex;
				align-items: center;
				justify-content: flex-end;
				gap: 5px;
			}
			.es-btn-view {
				background: #f1f5f9;
				color: #0f172a;
				border: 1px solid #cbd5e1;
				padding: 5px 10px;
				border-radius: 5px;
				font-size: 12px;
				font-weight: 600;
				cursor: pointer;
				display: inline-flex;
				align-items: center;
				gap: 4px;
				transition: all 0.2s ease;
			}
			.es-btn-view:hover {
				background: #e2e8f0;
				color: #0f172a;
			}
			.es-btn-del {
				background: #fee2e2;
				color: #b91c1c;
				border: 1px solid #fca5a5;
				padding: 5px 10px;
				border-radius: 5px;
				font-size: 12px;
				font-weight: 600;
				cursor: pointer;
				display: inline-flex;
				align-items: center;
				gap: 4px;
				transition: all 0.2s ease;
			}
			.es-btn-del:hover {
				background: #ef4444;
				color: #ffffff;
				border-color: #ef4444;
			}

			/* Settings Panel */
			.es-settings-card {
				background: #ffffff;
				border: 1px solid #e2e8f0;
				border-radius: 12px;
				box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
				padding: 28px 32px;
				max-width: 860px;
			}
			.es-settings-section-title {
				font-size: 18px;
				font-weight: 700;
				color: #0f172a;
				margin: 0 0 4px 0;
			}
			.es-settings-section-sub {
				font-size: 13.5px;
				color: #64748b;
				margin: 0 0 20px 0;
			}
			.es-settings-row {
				margin-bottom: 18px;
			}
			.es-settings-label {
				display: block;
				font-size: 13.5px;
				font-weight: 600;
				color: #1e293b;
				margin-bottom: 6px;
			}
			.es-settings-help {
				font-size: 12.5px;
				color: #64748b;
				margin-top: 5px;
				line-height: 1.5;
			}
			.es-settings-input {
				width: 100%;
				box-sizing: border-box;
				padding: 9px 12px;
				border: 1px solid #cbd5e1;
				border-radius: 7px;
				font-size: 13.5px;
				outline: none;
				transition: all 0.2s ease;
			}
			.es-settings-input:focus {
				border-color: #0f172a;
				box-shadow: 0 0 0 3px rgba(15, 23, 42, 0.08);
			}
			.es-smtp-box {
				background: #f8fafc;
				border: 1px solid #e2e8f0;
				border-radius: 10px;
				padding: 22px;
				margin-top: 14px;
			}
			.es-smtp-grid {
				display: grid;
				grid-template-columns: repeat(2, 1fr);
				gap: 14px;
			}

			/* Modal Popup */
			.es-modal-backdrop {
				display: none;
				position: fixed;
				z-index: 999999;
				left: 0;
				top: 0;
				width: 100%;
				height: 100%;
				background: rgba(15, 23, 42, 0.6);
				backdrop-filter: blur(4px);
				align-items: center;
				justify-content: center;
				padding: 20px;
				box-sizing: border-box;
			}
			.es-modal-window {
				background: #ffffff;
				border-radius: 14px;
				width: 650px;
				max-width: 100%;
				max-height: 90vh;
				overflow-y: auto;
				box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
				position: relative;
				border: 1px solid #e2e8f0;
			}
			.es-modal-head {
				padding: 20px 24px;
				border-bottom: 1px solid #e2e8f0;
				display: flex;
				justify-content: space-between;
				align-items: center;
			}
			.es-modal-head h3 {
				font-size: 18px;
				font-weight: 700;
				color: #0f172a;
				margin: 0;
			}
			.es-modal-close-btn {
				background: #f1f5f9;
				border: none;
				border-radius: 50%;
				width: 30px;
				height: 30px;
				display: flex;
				align-items: center;
				justify-content: center;
				cursor: pointer;
				color: #64748b;
				transition: all 0.2s ease;
			}
			.es-modal-close-btn:hover {
				background: #e2e8f0;
				color: #0f172a;
			}
			.es-modal-content {
				padding: 24px;
			}
			.es-info-grid-2col {
				display: grid;
				grid-template-columns: repeat(2, 1fr);
				gap: 14px;
				margin-bottom: 18px;
			}
			.es-field-box {
				background: #f8fafc;
				border: 1px solid #e2e8f0;
				border-radius: 8px;
				padding: 10px 14px;
			}
			.es-field-label {
				font-size: 11.5px;
				color: #64748b;
				font-weight: 600;
				text-transform: uppercase;
				letter-spacing: 0.4px;
				margin-bottom: 3px;
			}
			.es-field-value {
				font-size: 14px;
				color: #0f172a;
				font-weight: 500;
				word-break: break-word;
			}
			.es-msg-detail-box {
				background: #ffffff;
				border: 1px solid #e2e8f0;
				border-left: 4px solid #0f172a;
				border-radius: 6px;
				padding: 14px 16px;
				margin-top: 10px;
				font-size: 13.5px;
				line-height: 1.6;
				color: #334155;
				white-space: pre-wrap;
			}
			.es-modal-footer {
				padding: 16px 24px;
				background: #f8fafc;
				border-top: 1px solid #e2e8f0;
				display: flex;
				justify-content: space-between;
				align-items: center;
				border-radius: 0 0 14px 14px;
			}

			/* Toast Notification */
			.es-toast {
				position: fixed;
				bottom: 24px;
				right: 24px;
				z-index: 9999999;
				background: #0f172a;
				color: #ffffff;
				padding: 12px 20px;
				border-radius: 8px;
				box-shadow: 0 10px 25px rgba(0,0,0,0.2);
				display: flex;
				align-items: center;
				gap: 8px;
				font-size: 13.5px;
				font-weight: 500;
				opacity: 0;
				transform: translateY(20px);
				transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
				pointer-events: none;
			}
			.es-toast.show {
				opacity: 1;
				transform: translateY(0);
				pointer-events: auto;
			}
			.es-toast.success { background: #15803d; }
			.es-toast.error { background: #b91c1c; }
		</style>

		<div class="es-admin-container">
			<!-- Header -->
			<div class="es-admin-header">
				<div class="es-header-left">
					<h1>
						<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#c5a059" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
						Quản Lý Yêu Cầu Tư Vấn &amp; Liên Hệ
					</h1>
					<p>Tiếp nhận, phân loại và theo dõi trạng thái yêu cầu từ khách hàng &amp; đối tác Fountainhead.</p>
				</div>
				<div class="es-header-actions">
					<a href="<?php echo admin_url( 'admin.php?page=es-contact-leads&tab=settings' ); ?>" class="es-btn es-btn-settings">
						<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
						<span>Cài Đặt Email &amp; SMTP</span>
					</a>
					<a href="<?php echo esc_url( $export_url ); ?>" class="es-btn es-btn-excel">
						<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
						<span>Xuất File Excel (CSV)</span>
					</a>
				</div>
			</div>

			<!-- Navigation Tabs -->
			<div class="es-nav-tabs-wrap">
				<div class="es-tabs-list">
					<a href="<?php echo admin_url( 'admin.php?page=es-contact-leads&tab=all' ); ?>" class="es-tab-link <?php echo ( 'all' === $current_tab ) ? 'active' : ''; ?>">
						<span>Tất cả</span>
						<span class="es-tab-pill" id="tab-pill-all"><?php echo $counts['all']; ?></span>
					</a>
					<a href="<?php echo admin_url( 'admin.php?page=es-contact-leads&tab=new' ); ?>" class="es-tab-link <?php echo ( 'new' === $current_tab ) ? 'active' : ''; ?>">
						<span>Chưa xử lý</span>
						<span class="es-tab-pill" id="tab-pill-new"><?php echo $counts['new']; ?></span>
					</a>
					<a href="<?php echo admin_url( 'admin.php?page=es-contact-leads&tab=contacted' ); ?>" class="es-tab-link <?php echo ( 'contacted' === $current_tab ) ? 'active' : ''; ?>">
						<span>Đã liên hệ</span>
						<span class="es-tab-pill" id="tab-pill-contacted"><?php echo $counts['contacted']; ?></span>
					</a>
					<a href="<?php echo admin_url( 'admin.php?page=es-contact-leads&tab=completed' ); ?>" class="es-tab-link <?php echo ( 'completed' === $current_tab ) ? 'active' : ''; ?>">
						<span>Hoàn thành</span>
						<span class="es-tab-pill" id="tab-pill-completed"><?php echo $counts['completed']; ?></span>
					</a>
					<a href="<?php echo admin_url( 'admin.php?page=es-contact-leads&tab=cancelled' ); ?>" class="es-tab-link <?php echo ( 'cancelled' === $current_tab ) ? 'active' : ''; ?>">
						<span>Đã hủy</span>
						<span class="es-tab-pill" id="tab-pill-cancelled"><?php echo $counts['cancelled']; ?></span>
					</a>
					<a href="<?php echo admin_url( 'admin.php?page=es-contact-leads&tab=settings' ); ?>" class="es-tab-link <?php echo ( 'settings' === $current_tab ) ? 'active' : ''; ?>">
						<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
						<span>Cài Đặt Email &amp; SMTP</span>
					</a>
				</div>
			</div>

			<?php if ( 'settings' === $current_tab ) : ?>
				<!-- TAB: SETTINGS -->
				<div class="es-settings-card">
					<h2 class="es-settings-section-title">Cấu Hình Email Tiếp Nhận &amp; Máy Chủ SMTP</h2>
					<p class="es-settings-section-sub">Thiết lập hòm thư nhận thông báo khi có khách hàng gửi biểu mẫu và kích hoạt SMTP gửi thư trực tiếp.</p>

					<form id="esSettingsForm">
						<div class="es-settings-row">
							<label class="es-settings-label" for="recipientEmails">Danh Sách Email Tiếp Nhận Thông Báo:</label>
							<input type="text" id="recipientEmails" name="recipient_emails" class="es-settings-input" value="<?php echo esc_attr( $recipient_emails ); ?>" placeholder="admin@example.com, info@example.com (ngăn cách bằng dấu phẩy)">
							<div class="es-settings-help">Có thể nhập nhiều địa chỉ email, ngăn cách bằng dấu phẩy (,). Mặc định là email quản trị website.</div>
						</div>

						<div class="es-settings-row">
							<label class="es-settings-label" for="fromName">Tên Người Gửi Hiển Thị (From Name):</label>
							<input type="text" id="fromName" name="from_name" class="es-settings-input" value="<?php echo esc_attr( $from_name ); ?>" placeholder="Fountainhead Design &amp; Build">
							<div class="es-settings-help">Tên thương hiệu sẽ hiển thị ở phần người gửi trong email thông báo.</div>
						</div>

						<!-- SMTP Configuration -->
						<div class="es-settings-row" style="margin-top: 24px;">
							<label style="display: flex; align-items: center; gap: 10px; cursor: pointer; font-size: 14.5px; font-weight: 700;">
								<input type="checkbox" name="smtp_enable" value="1" id="smtpEnableCheckbox" <?php checked( $smtp_enable, '1' ); ?> style="width: 18px; height: 18px;">
								<span>Bật Gửi Email Qua Máy Chủ SMTP (Khuyên dùng để gửi email thật tới Gmail)</span>
							</label>
						</div>

						<div class="es-smtp-box" id="smtpConfigBox" style="<?php echo ( '1' === $smtp_enable ) ? '' : 'display: none;'; ?>">
							<div class="es-smtp-grid">
								<div class="es-settings-row">
									<label class="es-settings-label">SMTP Host:</label>
									<input type="text" name="smtp_host" class="es-settings-input" value="<?php echo esc_attr( $smtp_host ); ?>" placeholder="smtp.gmail.com">
								</div>

								<div class="es-settings-row">
									<label class="es-settings-label">SMTP Port:</label>
									<input type="number" name="smtp_port" class="es-settings-input" value="<?php echo esc_attr( $smtp_port ); ?>" placeholder="587">
								</div>

								<div class="es-settings-row">
									<label class="es-settings-label">Phương thức mã hóa:</label>
									<select name="smtp_encryption" class="es-settings-input">
										<option value="tls" <?php selected( $smtp_encryption, 'tls' ); ?>>TLS (Cổng 587 - Khuyên dùng)</option>
										<option value="ssl" <?php selected( $smtp_encryption, 'ssl' ); ?>>SSL (Cổng 465)</option>
										<option value="none" <?php selected( $smtp_encryption, 'none' ); ?>>Không mã hóa (Cổng 25)</option>
									</select>
								</div>

								<div class="es-settings-row">
									<label class="es-settings-label">Xác thực SMTP:</label>
									<select name="smtp_auth" class="es-settings-input">
										<option value="1" <?php selected( $smtp_auth, '1' ); ?>>Có xác thực (Bắt buộc với Gmail/Mail server)</option>
										<option value="0" <?php selected( $smtp_auth, '0' ); ?>>Không xác thực</option>
									</select>
								</div>

								<div class="es-settings-row">
									<label class="es-settings-label">Tài Khoản Gmail / SMTP Username:</label>
									<input type="text" name="smtp_user" class="es-settings-input" value="<?php echo esc_attr( $smtp_user ); ?>" placeholder="Nhập tài khoản email SMTP (ví dụ: email@gmail.com)">
									<div class="es-settings-help">Email này cũng sẽ tự động được sử dụng làm Email Người Gửi.</div>
								</div>

								<div class="es-settings-row">
									<label class="es-settings-label">Mật khẩu ứng dụng Google (App Password):</label>
									<input type="password" name="smtp_pass" class="es-settings-input" value="<?php echo esc_attr( $smtp_pass ); ?>" placeholder="Mật khẩu ứng dụng Google gồm 16 ký tự" autocomplete="new-password">
									<div class="es-settings-help">Tạo Mật khẩu ứng dụng tại Google Account -> Bảo mật -> Mật khẩu ứng dụng.</div>
								</div>
							</div>
						</div>

						<div style="margin-top: 20px;">
							<button type="submit" class="es-btn es-btn-save" id="btnSaveSettings">
								<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
								<span>Lưu Cấu Hình Email</span>
							</button>
						</div>
					</form>
				</div>

			<?php else : ?>
				<!-- TAB: LEADS LIST -->

				<!-- Filter & Search Bar -->
				<div class="es-filter-card">
					<form method="get" class="es-filter-form">
						<input type="hidden" name="page" value="es-contact-leads">
						<input type="hidden" name="tab" value="<?php echo esc_attr( $current_tab ); ?>">

						<div class="es-search-input-wrap">
							<svg class="es-search-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
							<input type="search" name="s" class="es-form-input" value="<?php echo esc_attr( $search ); ?>" placeholder="Tìm theo Tên, SĐT, Email, Hạng mục hoặc Nội dung...">
						</div>

						<select name="form_type" class="es-select-control">
							<option value="">-- Tất cả phân loại --</option>
							<option value="consult" <?php selected( $type_filter, 'consult' ); ?>>Tư vấn dự án</option>
							<option value="partner" <?php selected( $type_filter, 'partner' ); ?>>Hợp tác &amp; Cung ứng</option>
						</select>

						<button type="submit" class="es-btn" style="background: #0f172a; color: #ffffff;">
							<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
							<span>Lọc Dữ Liệu</span>
						</button>

						<?php if ( ! empty( $search ) || ! empty( $type_filter ) ) : ?>
							<a href="<?php echo admin_url( 'admin.php?page=es-contact-leads&tab=' . $current_tab ); ?>" class="es-btn" style="background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1;">
								<span>Xóa bộ lọc</span>
							</a>
						<?php endif; ?>
					</form>
				</div>

				<!-- Table Card with Responsive Wrapper -->
				<div class="es-table-card">
					<div class="es-table-responsive">
						<table class="es-leads-table">
							<thead>
								<tr>
									<th class="col-id">Mã</th>
									<th class="col-type">Phân Loại</th>
									<th class="col-cust">Khách Hàng / Đơn Vị</th>
									<th class="col-phone">Số Điện Thoại</th>
									<th class="col-service">Hạng Mục Quan Tâm</th>
									<th class="col-date">Thời Gian Hẹn</th>
									<th class="col-created">Ngày Gửi</th>
									<th class="col-status">Trạng Thái</th>
									<th class="col-actions">Thao Tác</th>
								</tr>
							</thead>
							<tbody>
								<?php if ( empty( $leads ) ) : ?>
									<tr>
										<td colspan="9" style="text-align: center; padding: 45px 20px; color: #94a3b8;">
											<svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.5" style="margin-bottom: 10px;"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
											<div style="font-size: 15px; font-weight: 600; color: #64748b;">Chưa có yêu cầu tư vấn nào trong mục này.</div>
											<div style="font-size: 13px; color: #94a3b8; margin-top: 4px;">Các liên hệ từ khách hàng trên trang web sẽ tự động xuất hiện tại đây.</div>
										</td>
									</tr>
								<?php else : ?>
									<?php foreach ( $leads as $lead ) : 
										$type_badge_class = ( 'partner' === $lead->form_type ) ? 'es-badge-partner' : 'es-badge-consult';
										$type_badge_text  = ( 'partner' === $lead->form_type ) ? 'Hợp tác & Cung ứng' : 'Tư vấn dự án';
										$initial = mb_substr( trim( $lead->full_name ), 0, 1, 'UTF-8' );
									?>
										<tr id="lead-row-<?php echo esc_attr( $lead->id ); ?>">
											<td class="col-id">
												<strong style="color: #64748b; font-size: 12.5px;">#<?php echo esc_html( $lead->id ); ?></strong>
											</td>
											<td class="col-type">
												<span class="es-badge <?php echo esc_attr( $type_badge_class ); ?>">
													<?php echo esc_html( $type_badge_text ); ?>
												</span>
											</td>
											<td class="col-cust">
												<div class="es-cust-cell">
													<div class="es-avatar-initial"><?php echo esc_html( $initial ); ?></div>
													<div>
														<div class="es-cust-name"><?php echo esc_html( $lead->full_name ); ?></div>
														<span class="es-cust-email"><?php echo esc_html( $lead->email ); ?></span>
													</div>
												</div>
											</td>
											<td class="col-phone">
												<a href="tel:<?php echo esc_attr( $lead->phone ); ?>" style="color: #0f172a; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 5px;">
													<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
													<span><?php echo esc_html( $lead->phone ); ?></span>
												</a>
											</td>
											<td class="col-service">
												<span style="font-weight: 500;"><?php echo esc_html( $lead->service ); ?></span>
											</td>
											<td class="col-date">
												<?php if ( ! empty( $lead->preferred_date ) ) : ?>
													<span style="font-weight: 600; color: #0f172a; display: inline-flex; align-items: center; gap: 4px;">
														<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
														<?php echo esc_html( date_i18n( 'd/m/Y', strtotime( $lead->preferred_date ) ) ); ?>
													</span>
												<?php else : ?>
													<span style="color: #94a3b8; font-size: 12px;">Chưa hẹn</span>
												<?php endif; ?>
											</td>
											<td class="col-created">
												<span style="font-size: 12px; color: #64748b;">
													<?php echo esc_html( date_i18n( 'd/m/Y H:i', strtotime( $lead->created_at ) ) ); ?>
												</span>
											</td>
											<td class="col-status">
												<select class="es-status-dropdown es-status-<?php echo esc_attr( $lead->status ); ?>" data-id="<?php echo esc_attr( $lead->id ); ?>">
													<option value="new" <?php selected( $lead->status, 'new' ); ?>>Chưa xử lý</option>
													<option value="contacted" <?php selected( $lead->status, 'contacted' ); ?>>Đã liên hệ</option>
													<option value="completed" <?php selected( $lead->status, 'completed' ); ?>>Hoàn thành</option>
													<option value="cancelled" <?php selected( $lead->status, 'cancelled' ); ?>>Đã hủy</option>
												</select>
											</td>
											<td class="col-actions">
												<div class="es-action-btns">
													<button type="button" class="es-btn-view" data-lead='<?php echo esc_attr( wp_json_encode( $lead ) ); ?>'>
														<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
														<span>Xem</span>
													</button>
													<button type="button" class="es-btn-del" data-id="<?php echo esc_attr( $lead->id ); ?>">
														<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
														<span>Xóa</span>
													</button>
												</div>
											</td>
										</tr>
									<?php endforeach; ?>
								<?php endif; ?>
							</tbody>
						</table>
					</div>
				</div>
			<?php endif; ?>
		</div>

		<!-- Detail Modal Popup -->
		<div class="es-modal-backdrop" id="esLeadModal">
			<div class="es-modal-window">
				<div class="es-modal-head">
					<h3 id="mTitle">Chi Tiết Yêu Cầu #0</h3>
					<button type="button" class="es-modal-close-btn" id="esModalClose">
						<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
					</button>
				</div>
				<div class="es-modal-content">
					<div class="es-info-grid-2col">
						<div class="es-field-box">
							<div class="es-field-label">Phân Loại:</div>
							<div class="es-field-value" id="mType"></div>
						</div>
						<div class="es-field-box">
							<div class="es-field-label">Khách Hàng / Đơn Vị:</div>
							<div class="es-field-value" id="mName" style="font-weight: 700;"></div>
						</div>
						<div class="es-field-box">
							<div class="es-field-label">Số Điện Thoại:</div>
							<div class="es-field-value" id="mPhone"></div>
						</div>
						<div class="es-field-box">
							<div class="es-field-label">Địa Chỉ Email:</div>
							<div class="es-field-value" id="mEmail"></div>
						</div>
						<div class="es-field-box">
							<div class="es-field-label">Hạng Mục Quan Tâm:</div>
							<div class="es-field-value" id="mService"></div>
						</div>
						<div class="es-field-box">
							<div class="es-field-label">Địa Điểm Tư Vấn:</div>
							<div class="es-field-value" id="mLocation"></div>
						</div>
						<div class="es-field-box">
							<div class="es-field-label">Thời Gian Dự Kiến:</div>
							<div class="es-field-value" id="mDate"></div>
						</div>
						<div class="es-field-box">
							<div class="es-field-label">Thời Gian Gửi:</div>
							<div class="es-field-value" id="mCreated"></div>
						</div>
					</div>

					<div>
						<div class="es-field-label">Nội Dung Tin Nhắn / Yêu Cầu Cụ Thể:</div>
						<div class="es-msg-detail-box" id="mMessage"></div>
					</div>
				</div>
				<div class="es-modal-footer">
					<div id="mIpWrap" style="font-size: 12px; color: #94a3b8;">IP: <span id="mIp"></span></div>
					<div style="display: flex; gap: 8px;">
						<a href="#" id="mCallBtn" class="es-btn" style="background: #15803d; color: #ffffff;">
							<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
							<span>Gọi Điện</span>
						</a>
						<a href="#" id="mMailBtn" class="es-btn" style="background: #0284c7; color: #ffffff;">
							<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
							<span>Gửi Email</span>
						</a>
						<button type="button" class="es-btn" id="mCloseFooterBtn" style="background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1;">Đóng</button>
					</div>
				</div>
			</div>
		</div>

		<!-- Toast Notification Element -->
		<div class="es-toast" id="esToast">
			<span id="esToastMsg">Thông báo</span>
		</div>

		<script>
		document.addEventListener('DOMContentLoaded', function() {
			var nonce = '<?php echo esc_js( $nonce ); ?>';
			var ajaxurl = '<?php echo esc_js( admin_url( 'admin-ajax.php' ) ); ?>';

			function showToast(msg, type) {
				var toast = document.getElementById('esToast');
				var toastMsg = document.getElementById('esToastMsg');
				if (!toast || !toastMsg) return;

				toastMsg.textContent = msg;
				toast.className = 'es-toast show ' + (type || 'success');
				setTimeout(function() {
					toast.classList.remove('show');
				}, 3500);
			}

			// SMTP toggle box
			var smtpCheckbox = document.getElementById('smtpEnableCheckbox');
			var smtpBox = document.getElementById('smtpConfigBox');
			if (smtpCheckbox && smtpBox) {
				smtpCheckbox.addEventListener('change', function() {
					smtpBox.style.display = this.checked ? 'block' : 'none';
				});
			}

			// Save settings AJAX
			var settingsForm = document.getElementById('esSettingsForm');
			if (settingsForm) {
				settingsForm.addEventListener('submit', function(e) {
					e.preventDefault();
					var btn = document.getElementById('btnSaveSettings');
					if (btn) { btn.disabled = true; btn.style.opacity = '0.7'; }

					var data = new FormData(settingsForm);
					data.append('action', 'es_save_contact_settings');
					data.append('nonce', nonce);

					fetch(ajaxurl, {
						method: 'POST',
						body: data
					})
					.then(function(res) { return res.json(); })
					.then(function(res) {
						if (res.success) {
							showToast(res.data.message || 'Đã lưu cấu hình thành công!', 'success');
						} else {
							showToast(res.data.message || 'Lỗi khi lưu cấu hình.', 'error');
						}
					})
					.catch(function(err) {
						console.error(err);
						showToast('Lỗi kết nối máy chủ.', 'error');
					})
					.finally(function() {
						if (btn) { btn.disabled = false; btn.style.opacity = '1'; }
					});
				});
			}

			// Update Status dropdown
			document.querySelectorAll('.es-status-dropdown').forEach(function(select) {
				select.addEventListener('change', function() {
					var leadId = this.getAttribute('data-id');
					var newStatus = this.value;
					var currentSelect = this;

					currentSelect.className = 'es-status-dropdown es-status-' + newStatus;

					var data = new URLSearchParams();
					data.append('action', 'es_update_lead_status');
					data.append('nonce', nonce);
					data.append('lead_id', leadId);
					data.append('status', newStatus);

					fetch(ajaxurl, {
						method: 'POST',
						body: data
					})
					.then(function(res) { return res.json(); })
					.then(function(res) {
						if (res.success) {
							showToast('Đã cập nhật trạng thái đơn #' + leadId, 'success');
							if (res.data.counts) {
								updateCounters(res.data.counts);
							}
						} else {
							showToast(res.data.message || 'Lỗi cập nhật', 'error');
						}
					})
					.catch(function(err) {
						console.error(err);
						showToast('Lỗi kết nối máy chủ.', 'error');
					});
				});
			});

			// Delete lead
			document.querySelectorAll('.es-btn-del').forEach(function(btn) {
				btn.addEventListener('click', function() {
					if (!confirm('Quý khách có chắc chắn muốn xóa vĩnh viễn yêu cầu tư vấn này? Thao tác này không thể hoàn tác.')) return;

					var leadId = this.getAttribute('data-id');
					var row = document.getElementById('lead-row-' + leadId);

					var data = new URLSearchParams();
					data.append('action', 'es_delete_lead');
					data.append('nonce', nonce);
					data.append('lead_id', leadId);

					fetch(ajaxurl, {
						method: 'POST',
						body: data
					})
					.then(function(res) { return res.json(); })
					.then(function(res) {
						if (res.success) {
							showToast('Đã xóa bản ghi #' + leadId + ' thành công', 'success');
							if (row) {
								row.style.transition = 'all 0.3s ease';
								row.style.opacity = '0';
								row.style.transform = 'scale(0.95)';
								setTimeout(function() { row.remove(); }, 300);
							}
							if (res.data.counts) {
								updateCounters(res.data.counts);
							}
						} else {
							showToast(res.data.message || 'Lỗi khi xóa.', 'error');
						}
					})
					.catch(function(err) {
						console.error(err);
						showToast('Lỗi kết nối máy chủ.', 'error');
					});
				});
			});

			function updateCounters(counts) {
				if (document.getElementById('tab-pill-all')) document.getElementById('tab-pill-all').textContent = counts.all;
				if (document.getElementById('tab-pill-new')) document.getElementById('tab-pill-new').textContent = counts.new;
				if (document.getElementById('tab-pill-contacted')) document.getElementById('tab-pill-contacted').textContent = counts.contacted;
				if (document.getElementById('tab-pill-completed')) document.getElementById('tab-pill-completed').textContent = counts.completed;
				if (document.getElementById('tab-pill-cancelled')) document.getElementById('tab-pill-cancelled').textContent = counts.cancelled;
			}

			// View modal
			var modal = document.getElementById('esLeadModal');
			var modalClose = document.getElementById('esModalClose');
			var modalCloseFooter = document.getElementById('mCloseFooterBtn');

			document.querySelectorAll('.es-btn-view').forEach(function(btn) {
				btn.addEventListener('click', function() {
					var data = JSON.parse(this.getAttribute('data-lead') || '{}');
					document.getElementById('mTitle').textContent = 'Chi Tiết Yêu Cầu #' + data.id;
					document.getElementById('mType').textContent = (data.form_type === 'partner') ? 'Đăng ký hợp tác & Cung ứng' : 'Đặt lịch tư vấn dự án';
					document.getElementById('mName').textContent = data.full_name || '-';
					document.getElementById('mPhone').innerHTML = '<a href="tel:' + data.phone + '" style="color:#0f172a; font-weight:700; text-decoration:none;">' + data.phone + '</a>';
					document.getElementById('mEmail').innerHTML = '<a href="mailto:' + data.email + '" style="color:#2563eb; text-decoration:none;">' + data.email + '</a>';
					document.getElementById('mService').textContent = data.service || '-';
					document.getElementById('mLocation').textContent = data.location || '-';
					document.getElementById('mDate').textContent = data.preferred_date ? data.preferred_date : 'Chưa chỉ định ngày hẹn';
					document.getElementById('mCreated').textContent = data.created_at || '-';
					document.getElementById('mIp').textContent = data.ip_address || '-';
					document.getElementById('mMessage').textContent = data.message || 'Không có tin nhắn kèm theo.';

					// Action links
					var callBtn = document.getElementById('mCallBtn');
					if (callBtn) callBtn.href = 'tel:' + (data.phone || '');
					var mailBtn = document.getElementById('mMailBtn');
					if (mailBtn) mailBtn.href = 'mailto:' + (data.email || '');

					if (modal) modal.style.display = 'flex';
				});
			});

			function closeModal() {
				if (modal) modal.style.display = 'none';
			}

			if (modalClose) modalClose.addEventListener('click', closeModal);
			if (modalCloseFooter) modalCloseFooter.addEventListener('click', closeModal);

			window.addEventListener('click', function(e) {
				if (e.target === modal) {
					closeModal();
				}
			});
		});
		</script>
		<?php
	}
}

// Initialize Singleton
Fountainhead_Contact_Manager::get_instance();
