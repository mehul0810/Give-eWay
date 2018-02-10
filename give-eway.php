<?php
/**
 * Plugin Name: Give - eWay
 * Plugin URI:  https://givewp.com/addons/eway/
 * Description: Adds eWay Gateway support.
 * Version:     1.0
 * Author:      WordImpress
 * Author URI:  https://wordimpress.com
 * Text Domain: give-eway
 * Domain Path: /languages
 * GitHub URI: https://github.com/WordImpress/Give-eWay.git
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Give_Eway' ) ) :

	/**
	 * Class Give_Eway.
	 *
	 * @since 1.0
	 */
	class Give_Eway {

		/**
		 * Create Single Give eWay Instance.
		 *
		 * @var $instance
		 */
		private static $instance;

		/**
		 * Returns single instance of this class.
		 *
		 * @since 1.0
		 *
		 * @return Give_Eway
		 */
		public static function get_instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * Give_Eway constructor.
		 *
		 * @since 1.0
		 */
		protected function __construct() {

			$this->setup_constants();

			// Check whether parent plugin is active or not.
			add_action( 'admin_init', array( $this, 'is_parent_plugin_active' ) );
			add_action( 'give_loaded', array( $this, 'init' ) );

		}

		/**
		 * Initialize Plugin after plugins loaded.
		 *
		 * @since 1.0
		 */
		public function init() {

			$this->includes();
			$this->licensing();

			// Load Text Domain for Give - eWay Integration.
			load_plugin_textdomain( 'give-eway', false, GIVE_EWAY_BASENAME . '/languages' );

		}

		/**
		 * Setup Constants.
		 *
		 * @since 1.0
		 */
		public function setup_constants() {

			if ( ! defined( 'GIVE_EWAY_VERSION' ) ) {
				define( 'GIVE_EWAY_VERSION', '1.0' );
			}

			if ( ! defined( 'GIVE_EWAY_MIN_GIVE_VER' ) ) {
				define( 'GIVE_EWAY_MIN_GIVE_VER', '2.0' );
			}

			if ( ! defined( 'GIVE_EWAY_PLUGIN_FILE' ) ) {
				define( 'GIVE_EWAY_PLUGIN_FILE', __FILE__ );
			}

			if ( ! defined( 'GIVE_EWAY_PLUGIN_DIR' ) ) {
				define( 'GIVE_EWAY_PLUGIN_DIR', dirname( GIVE_EWAY_PLUGIN_FILE ) );
			}

			if ( ! defined( 'GIVE_EWAY_PLUGIN_URL' ) ) {
				define( 'GIVE_EWAY_PLUGIN_URL', plugin_dir_url( GIVE_EWAY_PLUGIN_FILE ) );
			}

			if ( ! defined( 'GIVE_EWAY_BASENAME' ) ) {
				define( 'GIVE_EWAY_BASENAME', plugin_basename( GIVE_EWAY_PLUGIN_FILE ) );
			}

		}

		/**
		 * Include Required Files.
		 *
		 * @since 1.0
		 */
		private function includes() {

			if ( is_admin() ) {
				require_once GIVE_EWAY_PLUGIN_DIR . '/includes/admin/plugin-activation.php';
				require_once GIVE_EWAY_PLUGIN_DIR . '/includes/admin/class-admin-settings.php';
			}

			require_once GIVE_EWAY_PLUGIN_DIR . '/includes/actions.php';
			require_once GIVE_EWAY_PLUGIN_DIR . '/includes/filters.php';
			require_once GIVE_EWAY_PLUGIN_DIR . '/includes/functions.php';

		}

		/**
		 * Check whether the parent plugin is active or not.
		 *
		 * @since 1.0
		 *
		 * @return bool
		 */
		public function is_parent_plugin_active() {

			if (
				current_user_can( 'activate_plugins' ) &&
				! is_plugin_active( GIVE_PLUGIN_BASENAME )
			) {

				add_action(
					'admin_notices',
					function() {
						echo sprintf(
							'<div class="notice notice-error"><p>%1$s</p></div>',
							sprintf(
								__( '<strong>Activation Error:</strong> You must have the <a href="%s" target="_blank">Give</a> plugin installed and activated for eWay add-on to activate.', 'give-eway' ),
								'https://givewp.com'
							)
						);
					}
				);

				// Deactivate this plugin.
				deactivate_plugins( GIVE_EWAY_BASENAME );

				if ( isset( $_GET['activate'] ) ) {
					unset( $_GET['activate'] );
				}

				return false;
			}
		}

		/**
		 * Plugin Licensing.
		 *
		 * @since 1.0
		 */
		public function licensing() {
			if ( class_exists( 'Give_License' ) ) {
				new Give_License( GIVE_EWAY_PLUGIN_FILE, 'eWay Gateway', GIVE_EWAY_VERSION, 'WordImpress', 'eway_license_key' );
			}
		}

	}

endif; // End if class_exists check.

Give_Eway::get_instance();