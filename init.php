<?php
/**
 * Plugin Name: mwb WooCommerce Wishlist
 * Plugin URI: https://mwbemes.com/themes/plugins/mwb-woocommerce-wishlist/
 * Description: <code><strong>mwb WooCommerce Wishlist</strong></code> gives your users the possibility to create, fill, manage and share their wishlists allowing you to analyze their interests and needs to improve your marketing strategies. <a href="https://mwbemes.com/" target="_blank">Get more plugins for your e-commerce on <strong>mwb</strong></a>
 * Version: 3.0.15
 * Author: mwb
 * Author URI: https://mwbemes.com/
 * Text Domain: mwb-woocommerce-wishlist
 * Domain Path: /languages/
 * WC requires at least: 4.2.0
 * WC tested up to: 4.6
 *
 * @author mwbEMES
 * @package mwb WooCommerce Wishlist
 * @version 3.0.0
 */

/*  Copyright 2013  Your Inspiration Themes  (email : plugins@mwbemes.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301 USA
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! function_exists( 'mwb_plugin_registration_hook' ) ) {
	require_once 'plugin-fw/mwb-plugin-registration-hook.php';
}
register_activation_hook( __FILE__, 'mwb_plugin_registration_hook' );

if ( ! defined( 'mwb_WCWL' ) ) {
	define( 'mwb_WCWL', true );
}

if ( ! defined( 'mwb_WCWL_URL' ) ) {
	define( 'mwb_WCWL_URL', plugin_dir_url( __FILE__ ) );
}

if ( ! defined( 'mwb_WCWL_DIR' ) ) {
	define( 'mwb_WCWL_DIR', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'mwb_WCWL_INC' ) ) {
	define( 'mwb_WCWL_INC', mwb_WCWL_DIR . 'includes/' );
}

if ( ! defined( 'mwb_WCWL_INIT' ) ) {
	define( 'mwb_WCWL_INIT', plugin_basename( __FILE__ ) );
}

if ( ! defined( 'mwb_WCWL_FREE_INIT' ) ) {
    define( 'mwb_WCWL_FREE_INIT', plugin_basename( __FILE__ ) );
}

if ( ! defined( 'mwb_WCWL_SLUG' ) ) {
	define( 'mwb_WCWL_SLUG', 'mwb-woocommerce-wishlist' );
}

/* Plugin Framework Version Check */
if( ! function_exists( 'mwb_maybe_plugin_fw_loader' ) && file_exists( mwb_WCWL_DIR . 'plugin-fw/init.php' ) ) {
	require_once( mwb_WCWL_DIR . 'plugin-fw/init.php' );
}
mwb_maybe_plugin_fw_loader( mwb_WCWL_DIR  );

if( ! function_exists( 'mwb_wishlist_constructor' ) ) {
	function mwb_wishlist_constructor() {

		load_plugin_textdomain( 'mwb-woocommerce-wishlist', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

        // Load required classes and functions
	    require_once( mwb_WCWL_INC . 'data-stores/class.mwb-wcwl-wishlist-data-store.php' );
	    require_once( mwb_WCWL_INC . 'data-stores/class.mwb-wcwl-wishlist-item-data-store.php' );
        require_once( mwb_WCWL_INC . 'functions.mwb-wcwl.php' );
	    require_once( mwb_WCWL_INC . 'legacy/functions.mwb-wcwl-legacy.php' );
	    require_once( mwb_WCWL_INC . 'class.mwb-wcwl-exception.php' );
	    require_once( mwb_WCWL_INC . 'class.mwb-wcwl-form-handler.php' );
	    require_once( mwb_WCWL_INC . 'class.mwb-wcwl-ajax-handler.php' );
	    require_once( mwb_WCWL_INC . 'class.mwb-wcwl-session.php' );
	    require_once( mwb_WCWL_INC . 'class.mwb-wcwl-cron.php' );
	    require_once( mwb_WCWL_INC . 'class.mwb-wcwl-wishlist.php' );
	    require_once( mwb_WCWL_INC . 'class.mwb-wcwl-wishlist-item.php' );
	    require_once( mwb_WCWL_INC . 'class.mwb-wcwl-wishlist-factory.php' );
        require_once( mwb_WCWL_INC . 'class.mwb-wcwl.php' );
	    require_once( mwb_WCWL_INC . 'class.mwb-wcwl-frontend.php' );
        require_once( mwb_WCWL_INC . 'class.mwb-wcwl-install.php' );
	    require_once( mwb_WCWL_INC . 'class.mwb-wcwl-shortcode.php' );

        if ( is_admin() ) {
	        require_once( mwb_WCWL_INC . 'class.mwb-wcwl-admin.php' );
        }

        // Let's start the game!

	    /**
	     * @deprecated
	     */
	    global $mwb_wcwl;
	    $mwb_wcwl = mwb_WCWL();
    }
}
add_action( 'mwb_wcwl_init', 'mwb_wishlist_constructor' );

if( ! function_exists( 'mwb_wishlist_install' ) ) {
    function mwb_wishlist_install() {

        if ( ! function_exists( 'is_plugin_active' ) ) {
            require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        }

        if ( ! function_exists( 'WC' ) ) {
            add_action( 'admin_notices', 'mwb_wcwl_install_woocommerce_admin_notice' );
        }
        elseif( defined( 'mwb_WCWL_PREMIUM' ) ) {
            add_action( 'admin_notices', 'mwb_wcwl_install_free_admin_notice' );
            deactivate_plugins( plugin_basename( __FILE__ ) );
        }
        else {
            do_action( 'mwb_wcwl_init' );
        }
    }
}
add_action( 'plugins_loaded', 'mwb_wishlist_install', 11 );

if( ! function_exists( 'mwb_wcwl_install_woocommerce_admin_notice' ) ) {
    function mwb_wcwl_install_woocommerce_admin_notice() {
        ?>
        <div class="error">
            <p><?php echo 'mwb WooCommerce Wishlist ' . __( 'is enabled but not effective. It requires WooCommerce in order to work.', 'mwb-woocommerce-wishlist' ); ?></p>
        </div>
    <?php
    }
}

if( ! function_exists( 'mwb_wcwl_install_free_admin_notice' ) ){
    function mwb_wcwl_install_free_admin_notice() {
        ?>
        <div class="error">
            <p><?php echo __( 'You can\'t activate the free version of', 'mwb-woocommerce-wishlist' ) . 'mwb WooCommerce Wishlist' . __( 'while you are using the premium one.', 'mwb-woocommerce-wishlist' ); ?></p>
        </div>
    <?php
    }
}
