<?php
/**
 * Wishlist Exception class
 *
 * @author Your Inspiration Themes
 * @package mwb WooCommerce Wishlist
 * @version 3.0.0
 */

if ( ! defined( 'mwb_WCWL' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'mwb_WCWL_Exception' ) ) {
	/**
	 * WooCommerce Wishlist Exception
	 *
	 * @since 1.0.0
	 */
	class mwb_WCWL_Exception extends Exception {
		private $_errorCodes = array(
			0 => 'error',
			1 => 'exists'
		);

		public function getTextualCode() {
			$code = $this->getCode();

			if( array_key_exists( $code, $this->_errorCodes ) ){
				return $this->_errorCodes[ $code ];
			}

			return 'error';
		}
	}
}