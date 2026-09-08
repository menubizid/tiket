<?php
/**
 * Plugin Name: Active Nation CMS
 * Plugin URI:  https://example.com
 * Description: Platform ekosistem event olahraga digital yang menghubungkan Pelanggan, Instruktur, dan Administrator.
 * Version:     1.0.0
 * Author:      Development Team
 * Text Domain: active-nation
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define Plugin Constants
define( 'ACTIVE_NATION_VERSION', '1.0.0' );
define( 'ACTIVE_NATION_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'ACTIVE_NATION_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

/**
 * Main Active Nation CMS Class
 */
class Active_Nation_CMS {

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->includes();
		$this->init_hooks();
	}

	/**
	 * Include required files
	 */
	private function includes() {
		require_once ACTIVE_NATION_PLUGIN_DIR . 'includes/class-an-roles.php';
		require_once ACTIVE_NATION_PLUGIN_DIR . 'includes/class-an-cpt.php';
		require_once ACTIVE_NATION_PLUGIN_DIR . 'includes/class-an-auth.php';
		require_once ACTIVE_NATION_PLUGIN_DIR . 'includes/class-an-admin.php';
		require_once ACTIVE_NATION_PLUGIN_DIR . 'includes/class-an-frontend.php';
	}

	/**
	 * Initialize hooks
	 */
	private function init_hooks() {
		// Initialization hooks can go here if needed.
	}

	/**
	 * Plugin Activation Hook
	 */
	public static function activate() {
		// Initialize roles and CPTs immediately on activation to flush rewrite rules
		require_once ACTIVE_NATION_PLUGIN_DIR . 'includes/class-an-roles.php';
		require_once ACTIVE_NATION_PLUGIN_DIR . 'includes/class-an-cpt.php';

		AN_Roles::init();
		AN_CPT::register_all();

		flush_rewrite_rules();
	}

	/**
	 * Plugin Deactivation Hook
	 */
	public static function deactivate() {
		flush_rewrite_rules();
	}
}

// Initialize the plugin
function active_nation_init() {
	return new Active_Nation_CMS();
}

add_action( 'plugins_loaded', 'active_nation_init' );

register_activation_hook( __FILE__, array( 'Active_Nation_CMS', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'Active_Nation_CMS', 'deactivate' ) );
