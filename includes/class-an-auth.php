<?php
/**
 * Authentication and Routing Management
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class AN_Auth {

	public static function init() {
		// Custom Login Authentication
		add_filter( 'authenticate', array( __CLASS__, 'custom_authenticate' ), 20, 3 );

		// Custom Registration Hook
		add_action( 'user_register', array( __CLASS__, 'custom_registration_save' ), 10, 1 );

		// Smart Routing after Login
		add_filter( 'login_redirect', array( __CLASS__, 'custom_login_redirect' ), 10, 3 );
	}

	/**
	 * Save custom registration fields (e.g., City / Domisili)
	 */
	public static function custom_registration_save( $user_id ) {
		if ( isset( $_POST['an_city'] ) ) {
			update_user_meta( $user_id, 'an_city', sanitize_text_field( wp_unslash( $_POST['an_city'] ) ) );
		}
		if ( isset( $_POST['an_phone_number'] ) ) {
			update_user_meta( $user_id, 'an_phone_number', sanitize_text_field( wp_unslash( $_POST['an_phone_number'] ) ) );
		}

		// By default assign customer role
		$user = new WP_User( $user_id );
		$user->set_role( 'an_customer' );
	}

	/**
	 * Redirect users after login based on their role
	 */
	public static function custom_login_redirect( $redirect_to, $request, $user ) {
		if ( isset( $user->roles ) && is_array( $user->roles ) ) {
			if ( in_array( 'administrator', $user->roles, true ) ) {
				return admin_url();
			} elseif ( in_array( 'an_instructor', $user->roles, true ) ) {
				return home_url( '/instructor-dashboard/' ); // Or equivalent shortcode page
			} elseif ( in_array( 'an_customer', $user->roles, true ) ) {
				return home_url( '/discovery/' ); // Or equivalent shortcode page
			}
		}

		return $redirect_to;
	}

	/**
	 * Authenticate users using Phone Number or Username/Email
	 */
	public static function custom_authenticate( $user, $username, $password ) {
		if ( is_a( $user, 'WP_User' ) ) {
			return $user;
		}

		if ( empty( $username ) || empty( $password ) ) {
			return $user;
		}

		// Check if username is a phone number (numeric)
		if ( is_numeric( $username ) ) {
			$users = get_users(
				array(
					'meta_key'   => 'an_phone_number',
					'meta_value' => $username,
					'number'     => 1,
					'count_total'=> false,
				)
			);

			if ( ! empty( $users ) ) {
				$user_obj = $users[0];
				if ( wp_check_password( $password, $user_obj->user_pass, $user_obj->ID ) ) {
					return $user_obj;
				}
			}
		}

		return $user;
	}
}

AN_Auth::init();
