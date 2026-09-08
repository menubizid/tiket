<?php
/**
 * Administrator Panel Management
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class AN_Admin {

	public static function init() {
		// Register Meta Boxes
		add_action( 'add_meta_boxes', array( __CLASS__, 'register_meta_boxes' ) );
		// Save Post Data for Meta Boxes
		add_action( 'save_post', array( __CLASS__, 'save_meta_boxes' ) );

		// Admin Menu Pages
		add_action( 'admin_menu', array( __CLASS__, 'register_admin_pages' ) );
	}

	/**
	 * Register Custom Admin Pages
	 */
	public static function register_admin_pages() {
		add_submenu_page(
			'edit.php?post_type=an_order',
			__( 'Order Validation', 'active-nation' ),
			__( 'Order Validation', 'active-nation' ),
			'manage_active_nation',
			'an-order-validation',
			array( __CLASS__, 'render_order_validation_page' )
		);

		add_submenu_page(
			'edit.php?post_type=an_order',
			__( 'QR Scanner', 'active-nation' ),
			__( 'QR Scanner', 'active-nation' ),
			'manage_active_nation',
			'an-qr-scanner',
			array( __CLASS__, 'render_qr_scanner_page' )
		);

		add_menu_page(
			__( 'WA Automations', 'active-nation' ),
			__( 'WA Automations', 'active-nation' ),
			'manage_active_nation',
			'an-wa-automations',
			array( __CLASS__, 'render_wa_automations_page' ),
			'dashicons-smartphone',
			30
		);
	}

	/**
	 * Render WhatsApp Automations Settings Page
	 */
	public static function render_wa_automations_page() {
		if ( ! current_user_can( 'manage_active_nation' ) ) {
			return;
		}

		echo '<div class="wrap">';
		echo '<h1>' . esc_html__( 'WhatsApp Automations', 'active-nation' ) . '</h1>';

		echo '<p>' . esc_html__( 'Configure dynamic messages using variables like {name}, {event}, {ticket_id}, {link}, {form_link}.', 'active-nation' ) . '</p>';
		echo '<form method="post" action="options.php">';
		// Add basic settings fields placeholder here
		echo '<textarea rows="5" cols="50" placeholder="Template for Reminder Check-in..."></textarea><br/><br/>';
		echo '<textarea rows="5" cols="50" placeholder="Template for Thank You & Review..."></textarea><br/>';
		echo '<p class="submit"><input type="submit" class="button-primary" value="Save Changes" /></p>';
		echo '</form>';
		echo '</div>';
	}

	/**
	 * Render QR Scanner Page
	 */
	public static function render_qr_scanner_page() {
		if ( ! current_user_can( 'manage_active_nation' ) ) {
			return;
		}

		echo '<div class="wrap">';
		echo '<h1>' . esc_html__( 'QR Scanner / Check-in', 'active-nation' ) . '</h1>';

		echo '<p>' . esc_html__( 'Use a camera or manual input to scan tickets and mark attendance.', 'active-nation' ) . '</p>';
		echo '<div id="an-qr-reader" style="width: 500px;"></div>'; // Placeholder for JS scanner
		echo '<input type="text" id="an-manual-ticket-id" placeholder="Enter Ticket ID manually" />';
		echo '<button type="button" class="button button-primary" id="an-manual-checkin">' . esc_html__( 'Check In', 'active-nation' ) . '</button>';

		echo '</div>';
	}

	/**
	 * Render Order Validation Page
	 */
	public static function render_order_validation_page() {
		if ( ! current_user_can( 'manage_active_nation' ) ) {
			return;
		}

		echo '<div class="wrap">';
		echo '<h1>' . esc_html__( 'Order Validation', 'active-nation' ) . '</h1>';

		// Basic placeholder for the order validation list table
		echo '<p>' . esc_html__( 'Here you can view pending orders, check payment proofs, and approve or reject them.', 'active-nation' ) . '</p>';
		echo '</div>';
	}

	/**
	 * Register Custom Meta Boxes
	 */
	public static function register_meta_boxes() {
		// Event Meta Box
		add_meta_box(
			'an_event_details_mb',
			__( 'Event Details', 'active-nation' ),
			array( __CLASS__, 'render_event_meta_box' ),
			'an_event',
			'normal',
			'high'
		);

		// Order Meta Box
		add_meta_box(
			'an_order_details_mb',
			__( 'Order Details', 'active-nation' ),
			array( __CLASS__, 'render_order_meta_box' ),
			'an_order',
			'normal',
			'high'
		);
	}

	/**
	 * Render Event Meta Box
	 */
	public static function render_event_meta_box( $post ) {
		wp_nonce_field( 'an_save_event_meta', 'an_event_meta_nonce' );

		$price      = get_post_meta( $post->ID, '_an_event_price', true );
		$capacity   = get_post_meta( $post->ID, '_an_event_capacity', true );
		$instructor = get_post_meta( $post->ID, '_an_event_instructor', true );

		// Fetch users with instructor role
		$instructors = get_users( array( 'role' => 'an_instructor' ) );
		?>
		<table class="form-table">
			<tr>
				<th><label for="an_event_price"><?php _e( 'Price', 'active-nation' ); ?></label></th>
				<td><input type="number" name="an_event_price" id="an_event_price" value="<?php echo esc_attr( $price ); ?>" class="regular-text" /></td>
			</tr>
			<tr>
				<th><label for="an_event_capacity"><?php _e( 'Capacity', 'active-nation' ); ?></label></th>
				<td><input type="number" name="an_event_capacity" id="an_event_capacity" value="<?php echo esc_attr( $capacity ); ?>" class="regular-text" /></td>
			</tr>
			<tr>
				<th><label for="an_event_instructor"><?php _e( 'Instructor', 'active-nation' ); ?></label></th>
				<td>
					<select name="an_event_instructor" id="an_event_instructor">
						<option value=""><?php _e( 'Select Instructor', 'active-nation' ); ?></option>
						<?php foreach ( $instructors as $inst ) : ?>
							<option value="<?php echo esc_attr( $inst->ID ); ?>" <?php selected( $instructor, $inst->ID ); ?>><?php echo esc_html( $inst->display_name ); ?></option>
						<?php endforeach; ?>
					</select>
				</td>
			</tr>
		</table>
		<?php
	}

	/**
	 * Render Order Meta Box
	 */
	public static function render_order_meta_box( $post ) {
		wp_nonce_field( 'an_save_order_meta', 'an_order_meta_nonce' );

		$status        = get_post_meta( $post->ID, '_an_order_status', true );
		$payment_proof = get_post_meta( $post->ID, '_an_payment_proof', true );
		?>
		<table class="form-table">
			<tr>
				<th><label for="an_order_status"><?php _e( 'Status', 'active-nation' ); ?></label></th>
				<td>
					<select name="an_order_status" id="an_order_status">
						<option value="pending" <?php selected( $status, 'pending' ); ?>><?php _e( 'Pending', 'active-nation' ); ?></option>
						<option value="approved" <?php selected( $status, 'approved' ); ?>><?php _e( 'Approved', 'active-nation' ); ?></option>
						<option value="rejected" <?php selected( $status, 'rejected' ); ?>><?php _e( 'Rejected', 'active-nation' ); ?></option>
					</select>
				</td>
			</tr>
			<tr>
				<th><?php _e( 'Payment Proof URL', 'active-nation' ); ?></th>
				<td>
					<?php if ( $payment_proof ) : ?>
						<a href="<?php echo esc_url( $payment_proof ); ?>" target="_blank"><?php _e( 'View Proof', 'active-nation' ); ?></a>
					<?php else : ?>
						<?php _e( 'No payment proof uploaded.', 'active-nation' ); ?>
					<?php endif; ?>
				</td>
			</tr>
		</table>
		<?php
	}

	/**
	 * Save Meta Boxes Data
	 */
	public static function save_meta_boxes( $post_id ) {
		// Save Event Meta
		if ( isset( $_POST['an_event_meta_nonce'] ) && wp_verify_nonce( $_POST['an_event_meta_nonce'], 'an_save_event_meta' ) ) {
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
			if ( isset( $_POST['post_type'] ) && 'an_event' == $_POST['post_type'] && ! current_user_can( 'edit_post', $post_id ) ) return;

			if ( isset( $_POST['an_event_price'] ) ) {
				update_post_meta( $post_id, '_an_event_price', sanitize_text_field( $_POST['an_event_price'] ) );
			}
			if ( isset( $_POST['an_event_capacity'] ) ) {
				update_post_meta( $post_id, '_an_event_capacity', sanitize_text_field( $_POST['an_event_capacity'] ) );
			}
			if ( isset( $_POST['an_event_instructor'] ) ) {
				update_post_meta( $post_id, '_an_event_instructor', sanitize_text_field( $_POST['an_event_instructor'] ) );
			}
		}

		// Save Order Meta
		if ( isset( $_POST['an_order_meta_nonce'] ) && wp_verify_nonce( $_POST['an_order_meta_nonce'], 'an_save_order_meta' ) ) {
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
			if ( isset( $_POST['post_type'] ) && 'an_order' == $_POST['post_type'] && ! current_user_can( 'edit_post', $post_id ) ) return;

			if ( isset( $_POST['an_order_status'] ) ) {
				update_post_meta( $post_id, '_an_order_status', sanitize_text_field( $_POST['an_order_status'] ) );
			}
		}
	}
}

AN_Admin::init();
