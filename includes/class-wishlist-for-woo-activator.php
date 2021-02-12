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
class Wishlist_For_Woo_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		// Create a Wishlist table in wp-db.
		self::init();
	}

    /**
	 * Create a Wishlist table in wp-db.
	 *
	 * @since 1.0.0
	 * @static
	 * @return null.
	 */
	protected static function init() {

        global $wpdb;
        $table_name = $wpdb->prefix.  'wishlist_datastore';

        $query = $wpdb->prepare( 'SHOW TABLES LIKE %s', $wpdb->esc_like( $table_name ) );
        $result = $wpdb->get_var( $query );

        // Table not exists.
        if( empty( $result ) || $result != $table_name ) {
            try {
                global $wpdb;
                $charset_collate = $wpdb->get_charset_collate();
                $table_name = $wpdb->prefix . 'wishlist_datastore';
                
                $sql = "CREATE TABLE `" .  $table_name . "` (
                `id` int unsigned zerofill NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `title` varchar(500) NOT NULL,
                `products` varchar(500) NOT NULL,
                `createdate` timestamp NOT NULL ON UPDATE CURRENT_TIMESTAMP,
                `modifieddate` timestamp NOT NULL,
                `owner` varchar(100) NOT NULL,
                `status` varchar(10) NOT NULL,
                `collaborators` varchar(100) NOT NULL,
                `properties` varchar(1000) NOT NULL
              ) $charset_collate;";
    
                require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
                dbDelta( $sql );
            } catch (\Throwable $th) {
                throw new Exception( $th->getMessage(), 1 );
            }
        }
	}
}
