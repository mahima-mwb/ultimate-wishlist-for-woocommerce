<?php
/*
 * This file belongs to the mwb Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'mwb_Upgrade' ) ) {
	/**
	 * mwb Upgrade
	 *
	 * Notify and Update plugin
	 *
	 * @class       mwb_Upgrade
	 * @package     mwb
	 * @since       1.0
	 * @author      Your Inspiration Themes
	 * @see         WP_Updater Class
	 */
	class mwb_Upgrade {
		/**
		 * @var mwb_Upgrade The main instance
		 */
		protected static $_instance;

		/**
		 * Construct
		 *
		 * @author Andrea Grillo <andrea.grillo@mwbemes.com>
		 * @since  1.0
		 */
		public function __construct() {
			//Silence is golden...
		}

		/**
		 * Main plugin Instance
		 *
		 * @param $plugin_slug | string The plugin slug
		 * @param $plugin_init | string The plugin init file
		 *
		 * @return void
		 *
		 * @since  1.0
		 * @author Andrea Grillo <andrea.grillo@mwbemes.com>
		 */
		public function register( $plugin_slug, $plugin_init ) {
			if( ! function_exists( 'mwb_Plugin_Upgrade' ) ){
				//Try to load mwb_Plugin_Upgrade class
				mwb_plugin_fw_load_update_and_licence_files();
			}

            try {
                mwb_Plugin_Upgrade()->register( $plugin_slug, $plugin_init );
            } catch( Error $e ){
            }
		}

		/**
		 * Main plugin Instance
		 *
		 * @static
		 * @return object Main instance
		 *
		 * @since  1.0
		 * @author Andrea Grillo <andrea.grillo@mwbemes.com>
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}
	}
}

if ( ! function_exists( 'mwb_Upgrade' ) ) {
	/**
	 * Main instance of plugin
	 *
	 * @return mwb_Upgrade
	 * @since  1.0
	 * @author Andrea Grillo <andrea.grillo@mwbemes.com>
	 */
	function mwb_Upgrade() {
		return mwb_Upgrade::instance();
	}
}

/**
 * Instance a mwb_Upgrade object
 */
mwb_Upgrade();
