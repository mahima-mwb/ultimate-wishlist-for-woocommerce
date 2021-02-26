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

		// Init properties.
		$wishlist_manager = Wishlist_For_Woo_Crud_Manager::get_instance();
		$user = wp_get_current_user();

		// Check for Wishlists by url id.
		$current_ref = ! empty( $_GET[ 'wl-ref' ] ) ? sanitize_text_field( $_GET[ 'wl-ref' ] ) : false;
		$current_id = ! empty( $current_ref ) ? Wishlist_For_Woo_Helper::encrypter( $current_ref, 'd' ) : false;
		if( ! empty( $current_id ) ) {

			$wishlist_manager->id = $current_id;	
			$owner = $wishlist_manager->get_prop( 'owner' );
			if( $owner == $user->user_email || in_array( $user->user_email, $collaborators ) ) {
				$access = 'edit';
			}
			else {
				$access = 'view';
			}
		}

		if( 'view' == $access ) {
			$get_wishlists = $wishlist_manager->retrieve();
			if( 200 == $get_wishlists['status'] ) {
				$owner_lists = ! empty( $get_wishlists['message'] ) ? $get_wishlists['message'] : array();
			}
		}

		else {

			// Check for Wishlists by owner email.
			if( ! empty( $user->user_email ) && is_email( $user->user_email ) ) {
				$get_wishlists = $wishlist_manager->retrieve( 'owner', $user->user_email );
				if( 200 == $get_wishlists['status'] ) {
					$access = 'edit';
					$owner_lists = ! empty( $get_wishlists['message'] ) ? $get_wishlists['message'] : array();
				}
			}
		}

		ob_start();
		wc_get_template(
			'partials/wishlist-for-woo-shortcode-view.php',
			array(
				'owner_lists'		=>	$owner_lists,
				'access'			=>	$access,
				'wishlist_manager'	=>	$wishlist_manager,
				'wid_to_show'		=>	$wid_to_show
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
