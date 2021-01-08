<?php
/**
 * Wishlist Cron Handler
 *
 * @author  Your Inspiration Themes
 * @package mwb WooCommerce Wishlist
 * @version 3.0.0
 */

if ( ! defined( 'mwb_WCWL' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'mwb_WCWL_Cron' ) ) {
	/**
	 * This class handles cron for wishlist plugin
	 *
	 * @since 3.0.0
	 */
	class mwb_WCWL_Cron {
		/**
		 * Array of events to schedule
		 *
		 * @var array
		 */
		protected $_crons = array();

		/**
		 * Single instance of the class
		 *
		 * @var \mwb_WCWL_Cron
		 * @since 3.0.0
		 */
		protected static $instance;

		/**
		 * Constructor
		 *
		 * @return void
		 */
		public function __construct() {
			add_action( 'init', array( $this, 'schedule' ) );
		}

		/**
		 * Returns registered crons
		 *
		 * @return array Array of registered crons ans callbacks
		 */
		public function get_crons() {
			if( empty( $this->_crons ) ){
				$this->_crons = array(
					'mwb_wcwl_delete_expired_wishlists' => array(
						'schedule' => 'daily',
						'callback' => array( $this, 'delete_expired_wishlists' )
					)
				);
			}

			return apply_filters( 'mwb_wcwl_crons', $this->_crons );
		}

		/**
		 * Schedule events not scheduled yet; register callbacks for each event
		 *
		 * @return void
		 */
		public function schedule() {
			$crons = $this->get_crons();

			if( ! empty( $crons ) ){
				foreach( $crons as $hook => $data ){

					add_action( $hook, $data['callback'] );

					if( ! wp_next_scheduled( $hook ) ){
						wp_schedule_event( time() + MINUTE_IN_SECONDS, $data['schedule'], $hook );
					}
				}
			}
		}

		/**
		 * Delete expired session wishlist
		 *
		 * @return void
		 */
		public function delete_expired_wishlists() {
			try{
				WC_Data_Store::load( 'wishlist' )->delete_expired();
			}
			catch( Exception $e ){
				return;
			}
		}

		/**
		 * Returns single instance of the class
		 *
		 * @return \mwb_WCWL_Cron
		 * @since 3.0.0
		 */
		public static function get_instance(){
			if( is_null( self::$instance ) ){
				self::$instance = new self();
			}

			return self::$instance;
		}
	}
}

/**
 * Unique access to instance of mwb_WCWL_Cron class
 *
 * @return \mwb_WCWL_Cron
 * @since 3.0.0
 */
function mwb_WCWL_Cron(){
	return defined( 'mwb_WCWL_PREMIUM' ) ? mwb_WCWL_Cron_Premium::get_instance() : mwb_WCWL_Cron::get_instance();
}