<?php
/**
 * Custom Post Types and Taxonomies Registration
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class AN_CPT {

	/**
	 * Register all CPTs and Taxonomies
	 */
	public static function register_all() {
		add_action( 'init', array( __CLASS__, 'register_taxonomies' ) );
		add_action( 'init', array( __CLASS__, 'register_post_types' ) );
	}

	/**
	 * Register Custom Taxonomies
	 */
	public static function register_taxonomies() {
		// Event Category Taxonomy
		register_taxonomy(
			'an_event_category',
			'an_event',
			array(
				'labels'       => array(
					'name'          => __( 'Event Categories', 'active-nation' ),
					'singular_name' => __( 'Event Category', 'active-nation' ),
				),
				'hierarchical' => true,
				'show_ui'      => true,
				'show_in_rest' => true,
			)
		);

		// City Taxonomy
		register_taxonomy(
			'an_city',
			'an_event',
			array(
				'labels'       => array(
					'name'          => __( 'Cities', 'active-nation' ),
					'singular_name' => __( 'City', 'active-nation' ),
				),
				'hierarchical' => false,
				'show_ui'      => true,
				'show_in_rest' => true,
			)
		);
	}

	/**
	 * Register Custom Post Types
	 */
	public static function register_post_types() {
		// Event CPT
		register_post_type(
			'an_event',
			array(
				'labels'      => array(
					'name'          => __( 'Events', 'active-nation' ),
					'singular_name' => __( 'Event', 'active-nation' ),
				),
				'public'      => true,
				'has_archive' => true,
				'supports'    => array( 'title', 'editor', 'thumbnail' ),
				'menu_icon'   => 'dashicons-calendar-alt',
				'show_in_rest'=> true,
			)
		);

		// Order/Ticket CPT
		register_post_type(
			'an_order',
			array(
				'labels'      => array(
					'name'          => __( 'Orders / Tickets', 'active-nation' ),
					'singular_name' => __( 'Order', 'active-nation' ),
				),
				'public'      => false,
				'show_ui'     => true,
				'supports'    => array( 'title' ),
				'menu_icon'   => 'dashicons-tickets-alt',
			)
		);

		// Form Template CPT
		register_post_type(
			'an_form',
			array(
				'labels'      => array(
					'name'          => __( 'Forms', 'active-nation' ),
					'singular_name' => __( 'Form', 'active-nation' ),
				),
				'public'      => false,
				'show_ui'     => true,
				'supports'    => array( 'title', 'editor' ),
				'menu_icon'   => 'dashicons-feedback',
			)
		);

		// Payment Method CPT
		register_post_type(
			'an_payment_method',
			array(
				'labels'      => array(
					'name'          => __( 'Payment Methods', 'active-nation' ),
					'singular_name' => __( 'Payment Method', 'active-nation' ),
				),
				'public'      => false,
				'show_ui'     => true,
				'supports'    => array( 'title', 'thumbnail' ),
				'menu_icon'   => 'dashicons-money-alt',
			)
		);

		// Voucher CPT
		register_post_type(
			'an_voucher',
			array(
				'labels'      => array(
					'name'          => __( 'Vouchers', 'active-nation' ),
					'singular_name' => __( 'Voucher', 'active-nation' ),
				),
				'public'      => false,
				'show_ui'     => true,
				'supports'    => array( 'title' ),
				'menu_icon'   => 'dashicons-tickets',
			)
		);
	}
}
