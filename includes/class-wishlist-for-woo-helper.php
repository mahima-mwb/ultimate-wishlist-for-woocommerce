<?php

/**
 * Fired during plugin activation
 *
 * @link       https://makewebbetter.com
 * @since      1.0.0
 *
 * @package    Wishlist_For_Woo
 * @subpackage Wishlist_For_Woo/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Wishlist_For_Woo
 * @subpackage Wishlist_For_Woo/includes
 * @author     MakeWebBetter <https://makewebbetter.com>
 */
class Wishlist_For_Woo_Helper {

	/**
	 * Get options settings from db.
	 *
	 * @since    1.0.0
	 */
	public static function get_settings() {

        global $wpdb;
        $get_query = "SELECT `option_name`, `option_value`, `option_id`
        FROM `wp_options`
        WHERE `option_name` LIKE '%wfw-%'";

        $response = $wpdb->get_results( $get_query, ARRAY_A );

        if( ! empty( $wpdb->last_error ) || empty( $response ) ) {

            $result = array(
                'status'    => 400, 
                'message'    => ! empty( $wpdb->last_error ) ? $wpdb->last_error : esc_html( 'Settings Not Found. Please Save settings once again.', WISHLIST_FOR_WOO_TEXTDOMAIN ), 
            );
        }

        else {

            $formatted_result = self::format_sql_result( $response );

            $result = array(
                'status'    => 200, 
                'message'    => $formatted_result, 
            );
        }

        return $result;
    }

	/**
	 * Get Wishlist Strings.
	 *
	 * @since    1.0.0
	 */
	public static function get_strings() {
        return array(
            'popup_title'	=>	apply_filters( 'wfw_popup_title', esc_html__( 'New Item Added in Wishlist', 'wishlist-for-woo' ) ),
            'view_text'	=>	apply_filters( 'mwf_view_text', esc_html__( 'View Wishlist', 'wishlist-for-woo' ) ),
            'processing_text'	=>	apply_filters( 'mwf_processing_text', esc_html__( 'Processing', 'wishlist-for-woo' ) ),
            'add_to_cart'	=>	apply_filters( 'mwf_add_to_cart', esc_html__( 'Buy Now', 'wishlist-for-woo' ) ),
            'login_required'	=>	apply_filters( 'mwf_login_required', esc_html__( 'Please Login to your account first.', 'wishlist-for-woo' ) ),
            'add_to_wishlist'	=>	apply_filters( 'mwb_wfw_wishlist_accept_text', esc_html__( 'Add to Wishlist', 'wishlist-for-woo' ) ),
            'remove_from_wishlist'	=>	apply_filters( 'mwb_wfw_wishlist_remove_text', esc_html__( 'Remove from Wishlist', 'wishlist-for-woo' ) ),
        );
    }

	/**
	 * Get options settings from db.
	 *
	 * @since    1.0.0
	 */
    public static function format_sql_result( $result=array() ) {

        if( ! empty( $result ) && is_array( $result ) ) {

            $formatted_result = array();
            foreach ( $result as $key => $option ) {
                $formatted_result[ str_replace( '-', '_', $option[ 'option_name' ] ) ] = $option[ 'option_value' ];
            }

            return $formatted_result;
        }
    }

// End of class.
}