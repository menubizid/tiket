<?php
/**
 * Role & Capability Management
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class AN_Roles {

	/**
	 * Initialize roles and capabilities
	 */
	public static function init() {
		self::add_roles();
		self::add_capabilities();
	}

	/**
	 * Add custom roles
	 */
	private static function add_roles() {
		// Customer Role
		add_role(
			'an_customer',
			__( 'Customer', 'active-nation' ),
			array(
				'read' => true,
			)
		);

		// Instructor Role
		add_role(
			'an_instructor',
			__( 'Instructor', 'active-nation' ),
			array(
				'read' => true,
			)
		);
	}

	/**
	 * Add capabilities to existing roles (e.g., Administrator)
	 */
	private static function add_capabilities() {
		$admin_role = get_role( 'administrator' );

		if ( $admin_role ) {
			// Grant capabilities to manage Active Nation specific content
			$admin_role->add_cap( 'manage_active_nation' );
		}
	}
}
