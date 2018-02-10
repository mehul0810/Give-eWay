<?php
/**
 * List of general function used to process eWay Payment Gateway
 *
 * @package   Give
 * @copyright Copyright (c) 2018, WordImpress
 * @license   https://opensource.org/licenses/gpl-license GNU Public License
 * @since     1.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get Payment Method Label.
 *
 * @since 1.0
 *
 * @return string
 */
function give_eway_get_payment_method_label() {
	return give_get_option( 'eway_checkout_label', __( 'eWay', 'give-eway' ) );
}