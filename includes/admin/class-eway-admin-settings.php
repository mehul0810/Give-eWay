<?php
/**
 * Admin Settings for eWay Payment Gateway
 *
 * @package    Give
 * @subpackage Give/Admin/Give_Eway_Admin_Settings
 * @copyright  Copyright (c) 2019, GiveWP
 * @license    https://opensource.org/licenses/gpl-license GNU Public License
 * @since      1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( ! class_exists( 'Give_Eway_Admin_Settings' ) ) :

	/**
	 * Class Give_Eway_Admin_Settings
	 * 
	 * @since 1.0.0
	 */
	class Give_Eway_Admin_Settings {

		/**
		 * Instance.
		 *
		 * @since  1.0.0
		 * @access private
		 *
		 * @var object $instance
		 */
		private static $instance;

		/**
		 * Payment gateways ID
		 *
		 * @since 1.0.0
		 *
		 * @var string $gateways_id
		 */
		private $gateways_id = '';

		/**
		 * Payment gateways label
		 *
		 * @since 1.0.0
		 *
		 * @var string $gateways_label
		 */
		private $gateways_label = '';

		/**
		 * Singleton pattern.
		 *
		 * @since  1.0.0
		 * @access private
		 *
		 * Give_Eway_Admin_Settings constructor.
		 */
		private function __construct() {
		}

		/**
		 * Get instance.
		 *
		 * @since  1.0
		 * @access private
		 *
		 * @return static
		 */
		private static function get_instance() {
			if ( null === static::$instance ) {
				self::$instance = new static();
			}

			return self::$instance;
		}

		/**
		 * Setup hooks
		 *
		 * @since  1.0
		 * @access public
		 */
		public function setup() {

			$this->gateways_id    = 'eway';
			$this->gateways_label = __( 'eWay', 'give-eway' );

			add_filter( 'give_payment_gateways', array( $this, 'register_gateway' ) );
			add_filter( 'give_get_settings_gateways', array( $this, 'add_settings' ) );
			add_filter( 'give_get_sections_gateways', array( $this, 'add_gateways_section' ) );

		}

		/**
		 * Registers the Payment Gateway.
		 *
		 * @param array $gateways Payment Gateways List.
		 *
		 * @since  1.0
		 * @access public
		 *
		 * @return mixed
		 */
		public function register_gateway( $gateways ) {
			$gateways[ $this->gateways_id ] = array(
				'admin_label'    => $this->gateways_label,
				'checkout_label' => __( 'eWay', 'give-eway' ),
			);

			return $gateways;
		}

		/**
		 * Adds the Settings to the Payment Gateways.
		 *
		 * @param array $settings Payment Gateway Settings.
		 *
		 * @since  1.0
		 * @access public
		 *
		 * @return array
		 */
		public function add_settings( $settings ) {

			if ( $this->gateways_id !== give_get_current_setting_section() ) {
				return $settings;
			}

			$settings = array(
				array(
					'id'   => $this->gateways_id,
					'type' => 'title',
				),
				array(
					'name'    => __( 'Payment Method Label', 'give-eway' ),
					'id'      => 'give_eway_checkout_label',
					'type'    => 'text',
					'default' => __( 'eWay', 'give-eway' ),
					'desc'    => __( 'Payment method label will be appear on frontend.', 'give-eway' ),
				),
				array(
					'id'   => 'give_eway_live_api_key',
					'name' => __( 'Live API Key', 'give-eway' ),
					'desc' => __( 'Live API Key parameter provided by eWay', 'give-eway' ),
					'type' => 'api_key',
					'size' => 'regular',
				),
				array(
					'id'   => 'give_eway_live_api_password',
					'name' => __( 'Live API Password', 'give-eway' ),
					'desc' => __( 'Live API Password parameter provided by eWay', 'give-eway' ),
					'type' => 'api_key',
					'size' => 'regular',
				),
				array(
					'id'   => 'give_eway_sandbox_api_key',
					'name' => __( 'Sandbox API Key', 'give-eway' ),
					'desc' => __( 'Sandbox API Key parameter provided by eWay', 'give-eway' ),
					'type' => 'api_key',
					'size' => 'regular',
				),
				array(
					'id'   => 'give_eway_sandbox_api_password',
					'name' => __( 'Sandbox API Password', 'give-eway' ),
					'desc' => __( 'Sandbox API Password parameter provided by eWay', 'give-eway' ),
					'type' => 'api_key',
					'size' => 'regular',
				),
				array(
					'title'       => __( 'Collect Billing Details', 'give-eway' ),
					'id'          => 'give_eway_billing_details',
					'type'        => 'radio_inline',
					'options'     => array(
						'enabled'  => __( 'Enabled', 'give-eway' ),
						'disabled' => __( 'Disabled', 'give-eway' ),
					),
					'default'     => 'disabled',
					'description' => __( 'This option will enable the billing details section for eWay which requires the donor\'s address to complete the donation. These fields are not required by eWay to process the transaction, but you may have the need to collect the data.', 'give-eway' ),
				),
				array(
					'id'   => $this->gateways_id,
					'type' => 'sectionend',
				),
			);

			return $settings;
		}

		/**
		 * Add eWay to payment gateway section
		 *
		 * @param array $section Payment Gateway Sections.
		 *
		 * @since  1.0
		 * @access public
		 *
		 * @return mixed
		 */
		public function add_gateways_section( $section ) {
			$section[ $this->gateways_id ] = __( 'eWay', 'give-eway' );
			return $section;
		}
	}

endif;

// Initialize settings.
Give_Eway_Admin_Settings::get_instance()->setup();
