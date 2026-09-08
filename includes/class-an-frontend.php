<?php
/**
 * Frontend Panels and Shortcodes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class AN_Frontend {

	public static function init() {
		add_shortcode( 'an_customer_discovery', array( __CLASS__, 'render_customer_discovery' ) );
		add_shortcode( 'an_customer_checkout', array( __CLASS__, 'render_customer_checkout' ) );
		add_shortcode( 'an_customer_tickets', array( __CLASS__, 'render_customer_tickets' ) );
		add_shortcode( 'an_instructor_dashboard', array( __CLASS__, 'render_instructor_dashboard' ) );
		add_shortcode( 'an_instructor_schedule', array( __CLASS__, 'render_instructor_schedule' ) );
	}

	/**
	 * Instructor Panel - Schedule & Feedback
	 */
	public static function render_instructor_schedule( $atts ) {
		ob_start();

		echo '<div class="an-instructor-schedule">';
		echo '<h2>' . esc_html__( 'My Schedule', 'active-nation' ) . '</h2>';

		// Placeholder for Assigned Events query
		echo '<div class="an-schedule-card" style="border: 1px solid #ccc; padding: 15px; margin-bottom: 20px;">';
		echo '<h3>' . esc_html__( 'Assigned Event Placeholder', 'active-nation' ) . '</h3>';
		echo '<p>' . esc_html__( 'Date & Time: 25th Dec 2023, 10:00 AM', 'active-nation' ) . '</p>';

		// Visual capacity progress bar
		echo '<div class="an-capacity-bar" style="width: 100%; background: #eee; height: 20px; border-radius: 10px; overflow: hidden;">';
		echo '<div class="an-capacity-fill" style="width: 75%; background: #4caf50; height: 100%;"></div>';
		echo '</div>';
		echo '<p>' . esc_html__( 'Capacity: 30 / 40', 'active-nation' ) . '</p>';

		echo '<h4>' . esc_html__( 'Participant Feedback', 'active-nation' ) . '</h4>';
		echo '<div class="an-feedback-list">';
		echo '<p>⭐⭐⭐⭐⭐ - "Great class!"</p>';
		echo '</div>';

		echo '</div>'; // End schedule card

		echo '</div>';

		return ob_get_clean();
	}

	/**
	 * Instructor Panel - Dashboard
	 */
	public static function render_instructor_dashboard( $atts ) {
		ob_start();

		echo '<div class="an-instructor-dashboard">';
		echo '<h2>' . esc_html__( 'Instructor Dashboard', 'active-nation' ) . '</h2>';

		// Metrics placeholders
		echo '<div class="an-metrics-container" style="display: flex; gap: 20px;">';
		echo '<div class="an-metric-box" style="padding: 20px; background: #f0f0f0; border-radius: 8px;">';
		echo '<h3>' . esc_html__( 'Total Classes', 'active-nation' ) . '</h3>';
		echo '<p style="font-size: 24px; font-weight: bold;">12</p>'; // Replace with dynamic count
		echo '</div>';

		echo '<div class="an-metric-box" style="padding: 20px; background: #f0f0f0; border-radius: 8px;">';
		echo '<h3>' . esc_html__( 'Active Participants', 'active-nation' ) . '</h3>';
		echo '<p style="font-size: 24px; font-weight: bold;">150</p>'; // Replace with dynamic count
		echo '</div>';

		echo '<div class="an-metric-box" style="padding: 20px; background: #f0f0f0; border-radius: 8px;">';
		echo '<h3>' . esc_html__( 'Total Attended', 'active-nation' ) . '</h3>';
		echo '<p style="font-size: 24px; font-weight: bold;">135</p>'; // Replace with dynamic count
		echo '</div>';
		echo '</div>';

		echo '</div>';

		return ob_get_clean();
	}

	/**
	 * Customer Panel - Active Tickets & History
	 */
	public static function render_customer_tickets( $atts ) {
		ob_start();

		echo '<div class="an-tickets-panel">';
		echo '<h2>' . esc_html__( 'My Tickets', 'active-nation' ) . '</h2>';

		// Tab navigation for Active vs History
		echo '<ul class="an-ticket-tabs">';
		echo '<li><a href="#active-tickets">' . esc_html__( 'Active Tickets', 'active-nation' ) . '</a></li>';
		echo '<li><a href="#history-tickets">' . esc_html__( 'History (Attended)', 'active-nation' ) . '</a></li>';
		echo '</ul>';

		// Active Tickets Section
		echo '<div id="active-tickets" class="an-ticket-section">';
		echo '<h3>' . esc_html__( 'Active Tickets', 'active-nation' ) . '</h3>';
		echo '<p>' . esc_html__( 'Show QR Code for check-in here. Ensure dynamic forms are filled if required.', 'active-nation' ) . '</p>';
		// Placeholder for looping through 'approved' orders and generating QR codes
		echo '<div class="an-ticket-card">';
		echo '<h4>' . esc_html__( 'Event Name Placeholder', 'active-nation' ) . '</h4>';
		echo '<div class="an-qr-code-placeholder" style="width: 150px; height: 150px; background: #ddd; text-align: center; line-height: 150px;">[QR Code]</div>';
		echo '<a href="#" class="button">' . esc_html__( 'Fill Requirements Form', 'active-nation' ) . '</a>';
		echo '</div>';
		echo '</div>';

		// History Section
		echo '<div id="history-tickets" class="an-ticket-section" style="display:none;">';
		echo '<h3>' . esc_html__( 'History', 'active-nation' ) . '</h3>';
		echo '<p>' . esc_html__( 'Leave a star rating review or view/upload gallery photos.', 'active-nation' ) . '</p>';
		echo '<div class="an-ticket-card">';
		echo '<h4>' . esc_html__( 'Past Event Name Placeholder', 'active-nation' ) . '</h4>';
		echo '<a href="#" class="button">' . esc_html__( 'Leave Review', 'active-nation' ) . '</a>';
		echo '<a href="#" class="button">' . esc_html__( 'View Gallery', 'active-nation' ) . '</a>';
		echo '</div>';
		echo '</div>';

		echo '</div>';

		return ob_get_clean();
	}

	/**
	 * Customer Panel - Checkout
	 */
	public static function render_customer_checkout( $atts ) {
		ob_start();

		echo '<div class="an-checkout-panel">';
		echo '<h2>' . esc_html__( 'Checkout', 'active-nation' ) . '</h2>';

		// Placeholder for Checkout Engine
		echo '<form method="POST" action="" enctype="multipart/form-data" class="an-checkout-form">';

		echo '<h3>' . esc_html__( 'Ticket Details', 'active-nation' ) . '</h3>';
		echo '<label for="an_ticket_quantity">' . esc_html__( 'Quantity (Max 5)', 'active-nation' ) . '</label>';
		echo '<input type="number" name="an_ticket_quantity" id="an_ticket_quantity" min="1" max="5" value="1" required /><br/>';

		echo '<h3>' . esc_html__( 'Voucher', 'active-nation' ) . '</h3>';
		echo '<input type="text" name="an_voucher_code" placeholder="' . esc_attr__( 'Enter discount code', 'active-nation' ) . '" />';
		echo '<button type="button">' . esc_html__( 'Apply', 'active-nation' ) . '</button><br/>';

		echo '<h3>' . esc_html__( 'Payment Method', 'active-nation' ) . '</h3>';
		echo '<select name="an_payment_method" required>';
		echo '<option value="">' . esc_html__( 'Select Payment Method', 'active-nation' ) . '</option>';
		echo '<option value="bank_transfer">' . esc_html__( 'Bank Transfer', 'active-nation' ) . '</option>';
		echo '<option value="qris">' . esc_html__( 'QRIS', 'active-nation' ) . '</option>';
		echo '</select><br/>';

		echo '<label for="an_payment_proof">' . esc_html__( 'Upload Payment Proof', 'active-nation' ) . '</label>';
		echo '<input type="file" name="an_payment_proof" id="an_payment_proof" accept="image/*" required /><br/>';

		echo '<input type="submit" name="an_submit_checkout" value="' . esc_attr__( 'Complete Order', 'active-nation' ) . '" class="button button-primary" />';
		echo '</form>';

		echo '</div>';

		return ob_get_clean();
	}

	/**
	 * Customer Panel - Discovery
	 */
	public static function render_customer_discovery( $atts ) {
		// Enqueue scripts or styles if needed
		ob_start();

		$current_user = wp_get_current_user();
		$user_city    = get_user_meta( $current_user->ID, 'an_city', true );

		echo '<div class="an-discovery-panel">';
		echo '<h2>' . esc_html__( 'Upcoming Events', 'active-nation' ) . '</h2>';

		// Search and Filter Form
		echo '<form method="GET" action="" class="an-filter-form">';
		echo '<input type="text" name="an_search" placeholder="' . esc_attr__( 'Search events...', 'active-nation' ) . '" value="' . esc_attr( isset( $_GET['an_search'] ) ? $_GET['an_search'] : '' ) . '" />';
		echo '<input type="text" name="an_city_filter" placeholder="' . esc_attr__( 'City', 'active-nation' ) . '" value="' . esc_attr( isset( $_GET['an_city_filter'] ) ? $_GET['an_city_filter'] : $user_city ) . '" />';
		echo '<button type="submit">' . esc_html__( 'Filter', 'active-nation' ) . '</button>';
		echo '</form>';

		// Query Events
		$args = array(
			'post_type'      => 'an_event',
			'posts_per_page' => 10,
			'post_status'    => 'publish',
		);

		$search_query = isset( $_GET['an_search'] ) ? sanitize_text_field( $_GET['an_search'] ) : '';
		if ( ! empty( $search_query ) ) {
			$args['s'] = $search_query;
		}

		$city_filter = isset( $_GET['an_city_filter'] ) ? sanitize_text_field( $_GET['an_city_filter'] ) : $user_city;
		if ( ! empty( $city_filter ) ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'an_city',
					'field'    => 'name',
					'terms'    => $city_filter,
				),
			);
		}

		$events = new WP_Query( $args );

		if ( $events->have_posts() ) {
			echo '<div class="an-events-list">';
			while ( $events->have_posts() ) {
				$events->the_post();
				$price    = get_post_meta( get_the_ID(), '_an_event_price', true );
				$capacity = get_post_meta( get_the_ID(), '_an_event_capacity', true );

				echo '<div class="an-event-card">';
				if ( has_post_thumbnail() ) {
					echo '<div class="an-event-image">' . get_the_post_thumbnail( get_the_ID(), 'medium' ) . '</div>';
				}
				echo '<h3><a href="' . esc_url( get_permalink() ) . '">' . get_the_title() . '</a></h3>';
				echo '<p>' . wp_trim_words( get_the_excerpt(), 15 ) . '</p>';
				echo '<ul>';
				echo '<li><strong>' . esc_html__( 'Price:', 'active-nation' ) . '</strong> ' . esc_html( $price ) . '</li>';
				echo '<li><strong>' . esc_html__( 'Capacity:', 'active-nation' ) . '</strong> ' . esc_html( $capacity ) . '</li>';
				echo '</ul>';
				echo '<a href="' . esc_url( get_permalink() ) . '" class="button">' . esc_html__( 'View Details', 'active-nation' ) . '</a>';
				echo '</div>';
			}
			echo '</div>';
			wp_reset_postdata();
		} else {
			echo '<p>' . esc_html__( 'No upcoming events found.', 'active-nation' ) . '</p>';
		}

		echo '</div>';

		return ob_get_clean();
	}
}

AN_Frontend::init();
