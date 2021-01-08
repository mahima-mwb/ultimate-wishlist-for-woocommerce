<?php
/**
 * General settings page
 *
 * @author  Your Inspiration Themes
 * @package mwb WooCommerce Wishlist
 * @version 3.0.0
 */

if ( ! defined( 'mwb_WCWL' ) ) {
	exit;
} // Exit if accessed directly

$mwb_wfbt_installed = ( defined( 'mwb_WFBT' ) && mwb_WFBT );
$mwb_wfbt_landing = 'https://mwbemes.com/themes/plugins/mwb-woocommerce-frequently-bought-together/';
$mwb_wfbt_thickbox = mwb_WCWL_URL . 'assets/images/landing/mwb-wfbt-slider.jpg';
$mwb_wfbt_promo = sprintf( __( 'If you want to take advantage of this feature, you could consider purchasing the %s.', 'mwb-woocommerce-wishlist' ), '<a href="https://mwbemes.com/themes/plugins/mwb-woocommerce-frequently-bought-together/">mwb WooCommerce Frequently Bought Together Plugin</a>' );

return apply_filters( 'mwb_wcwl_settings_options', array(
	'settings' => array(

		'general_section_start' => array(
			'name' => __( 'General Settings', 'mwb-woocommerce-wishlist' ),
			'type' => 'title',
			'desc' => '',
			'id' => 'mwb_wcwl_general_settings'
		),

		'enable_ajax_loading' => array(
			'name'      => __( 'Enable AJAX loading', 'mwb-woocommerce-wishlist' ),
			'desc'      => __( 'Load any cacheable wishlist item via AJAX', 'mwb-woocommerce-wishlist' ),
			'id'        => 'mwb_wcwl_ajax_enable',
			'default'   => 'no',
			'type'      => 'mwb-field',
			'mwb-type' => 'onoff'
		),

		'general_section_end' => array(
			'type' => 'sectionend',
			'id' => 'mwb_wcwl_general_settings'
		),

		'mwb_wfbt_start' => array(
			'name' => __( 'mwb WooCommerce Frequently Bought Together Integration', 'mwb-woocommerce-wishlist' ),
			'type' => 'title',
			'desc' => ! $mwb_wfbt_installed ? sprintf( __( 'In order to use this integration you have to install and activate mwb WooCommerce Frequently Bought Together. <a href="%s">Learn more</a>', 'mwb-woocommerce-wishlist' ), $mwb_wfbt_landing ) : '',
			'id' => 'mwb_wcwl_mwb_wfbt'
		),

		'mwb_wfbt_enable_integration' => array(
			'name'      => __( 'Enable slider in wishlist', 'mwb-woocommerce-wishlist' ),
			'desc'      => sprintf( __( 'Enable the slider with linked products on the Wishlist page (<a href="%s" class="thickbox">Example</a>). %s', 'mwb-woocommerce-wishlist' ), $mwb_wfbt_thickbox,  ( ! ( defined( 'mwb_WFBT' ) && mwb_WFBT ) ) ? $mwb_wfbt_promo : '' ),
			'id'        => 'mwb_wfbt_enable_integration',
			'default'   => 'yes',
			'type'      => 'mwb-field',
			'mwb-type' => 'onoff'
		),

		'mwb_wfbt_end' => array(
			'type' => 'sectionend',
			'id' => 'mwb_wcwl_mwb_wfbt'
		)
	)
) );