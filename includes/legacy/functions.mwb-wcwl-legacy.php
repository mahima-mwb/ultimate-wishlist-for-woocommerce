<?php
/**
 * Legacy Functions & hooks
 *
 * @author Your Inspiration Themes
 * @package mwb WooCommerce Wishlist
 * @version 3.0.0
 */

if ( ! defined( 'mwb_WCWL' ) ) {
	exit;
} // Exit if accessed directly

if( ! function_exists( 'mwb_WCWL_Admin_Init' ) ){
	/**
	 * Deprecated function that used to return admin class single instance
	 *
	 * @return mwb_WCWL_Admin
	 * @since 2.0.0
	 */
	function mwb_WCWL_Admin_Init(){
		_deprecated_function( __FUNCTION__, '3.0.0', 'mwb_WCWL_Admin' );
		return mwb_WCWL_Admin();
	}
}

if( ! function_exists( 'mwb_WCWL_Init' ) ){
	/**
	 * Deprecated function that used to return init class single instance
	 *
	 * @return mwb_WCWL_Frontend
	 * @since 2.0.0
	 */
	function mwb_WCWL_Init(){
		_deprecated_function( __FUNCTION__, '3.0.0', 'mwb_WCWL_Frontend' );
		return mwb_WCWL_Frontend();
	}
}