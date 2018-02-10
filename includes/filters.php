<?php
/**
 * Give eWay Filter Hooks
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
 * Show transaction error.
 *
 * @since 1.0
 *
 * @return bool
 */
function give_eway_show_error($content ) {
	if (
		! isset( $_GET['give-eway-payment'] )
		|| 'failed' !== $_GET['give-eway-payment']
		|| ! isset( $_GET['give-eway-error-message'] )
		|| empty( $_GET['give-eway-error-message'] )
		|| ! give_is_failed_transaction_page()
	) {
		return $content;
	}

	return give_output_error( sprintf( 'Payment Error: %s', base64_decode( $_GET['give-eway-error-message'] ) ), false, 'error' ) . $content;
}

add_filter( 'the_content', 'give_eway_show_error');
