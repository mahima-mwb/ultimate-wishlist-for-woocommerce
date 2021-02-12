<?php

/**
 * The shortcode management for wishlist plugin.
 *
 * @link       https://makewebbetter.com
 * @since      1.0.0
 *
 * @package    Wishlist_For_Woo
 * @subpackage Wishlist_For_Woo/includes
 */

/**
 * Fired during Woo plugin activation.
 *
 * This class defines all code necessary to run shortcode management for wishlist plugin.
 *
 * @since      1.0.0
 * @package    Wishlist_For_Woo
 * @subpackage Wishlist_For_Woo/includes
 * @author     MakeWebBetter <https://makewebbetter.com>
 */
class Wishlist_For_Woo_Shortcode_Manager {

	/**
	 * The base path of public class.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $base_path    The ID of this plugin.
	 */
	public $base_path;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $base_path       The name of the plugin.
	 */
	public function __construct( $base_path ) {
		$this->base_path = $base_path;
	}

	/**
	 * Callback function for shortcode.
	 *
	 * @since    1.0.0
	 */
	public static function init() {

		ob_start();
		
			wc_get_template(
				'partials/wishlist-for-woo-shortcode-view.php',
				array(
				),
				'',
				$this->base_path
			);

		$output = ob_get_contents();
		ob_end_clean();	

		return $output;
	}

// End of class.
}
