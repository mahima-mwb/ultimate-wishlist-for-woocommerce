<?php
/**
 * Color settings page
 *
 * @author  Your Inspiration Themes
 * @package mwb WooCommerce Wishlist
 * @version 2.0.0
 */

if ( ! defined( 'mwb_WCWL' ) ) {
	exit;
} // Exit if accessed directly

return array(
	'premium' => array(
		'landing' => array(
			'type' => 'custom_tab',
			'action' => 'mwb_wcwl_premium_tab',
			'hide_sidebar' => true
		)
	)
);