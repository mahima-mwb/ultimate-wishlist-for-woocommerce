<?php
/**
 * This file belongs to the mwb Plugin Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */

if ( !defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

if ( ! class_exists( 'mwb_Plugin_Licence' ) ) {
    /**
     * mwb Licence Panel
     *
     * Setting Page to Manage Products
     *
     * @class      mwb_Licence
     * @package    mwb
     * @since      1.0
     * @author     Andrea Grillo      <andrea.grillo@mwbemes.com>
     */
    class mwb_Plugin_Licence {
	    /**
	     * @var object The single instance of the class
	     * @since 1.0
	     */
	    protected static $_instance = null;

        /**
         * Constructor
         *
         * @since    1.0
         * @author   Andrea Grillo <andrea.grillo@mwbemes.com>
         */
        public function __construct() {
            //Silence is golden
        }

        /**
         * Premium products registration
         *
         * @param $init         string | The products identifier
         * @param $secret_key   string | The secret key
         * @param $product_id   string | The product id
         *
         * @return void
         *
         * @since    1.0
         * @author   Andrea Grillo <andrea.grillo@mwbemes.com>
         */
        public function register( $init, $secret_key, $product_id ){
	        if( ! function_exists( 'mwb_Plugin_Licence' ) ){
		        //Try to load mwb_Plugin_Licence class
		        mwb_plugin_fw_load_update_and_licence_files();
	        }

            try {
                mwb_Plugin_Licence()->register( $init, $secret_key, $product_id  );
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

	    /**
	     * Get license activation URL
	     *
	     * @author Andrea Grillo <andrea.grillo@mwbemes.com>
	     * @since 3.0.17
	     */
	    public static function get_license_activation_url(){
		    return function_exists( 'mwb_Plugin_Licence' ) ? mwb_Plugin_Licence()->get_license_activation_url() : false;
	    }

	    /**
	     * Get protected array products
	     *
	     * @return mixed array
	     *
	     * @since  1.0
	     * @author Andrea Grillo <andrea.grillo@mwbemes.com>
	     */
	    public function get_products() {
		    return function_exists( 'mwb_Plugin_Licence' ) ? mwb_Plugin_Licence()->get_products() : array();
	    }
    }
}

/**
 * Main instance
 *
 * @return object
 * @since  1.0
 * @author Andrea Grillo <andrea.grillo@mwbemes.com>
 */
if ( !function_exists( 'mwb_Plugin_Licence' ) ) {
	function mwb_Plugin_Licence() {
		return mwb_Plugin_Licence::instance();
	}
}
