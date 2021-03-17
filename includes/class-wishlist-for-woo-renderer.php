<?php
/**
 * The wishlist public facing templates are handled here.
 *
 *
 * @since      1.0.0
 * @package    Wishlist_For_Woo
 * @subpackage Wishlist_For_Woo/includes
 * @author     MakeWebBetter <https://makewebbetter.com>
 */
class Wishlist_For_Woo_Renderer {

	/**
	 * The single instance of the class.
	 *
	 * @since   1.0.0
	 * @var Wishlist_For_Woo_Renderer   The single instance of the Wishlist_For_Woo_Renderer
	 */
	protected static $_instance = null;

	/**
	 * Main Wishlist_For_Woo_Renderer Instance.
	 *
	 * Ensures only one instance of Wishlist_For_Woo_Renderer is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @static
	 * @return Wishlist_For_Woo_Renderer - Main instance.
	 */
	public static function get_instance() {

		if ( is_null( self::$_instance ) ) {

			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
 	 * Get hooks for Icons implementation on shop.
	 * 
	 * @param 	Place   $template  Hooks for woo template needs to be returned.
	 * @throws Exception If something interesting cannot happen
	 * @author MakeWebBetter <plugins@makewebbetter.com>
	 * @return array $hooks all hooks to be implemented.
	 */
	public static function get_icons_hooks( $template='' ){

		$loop = array(
						'hook'			=>	'woocommerce_after_shop_loop_item',
						'priority'			=>	'1',
					);

		$single = array(
						'hook'			=>	'woocommerce_product_thumbnails',
						'priority'			=>	'10',
					);

		/**
		 * Product Image hooks.
		 */
		$all_hooks = array(
			'loop'	=>	$loop,
			'single' => $single,
		);

		return ! empty( $all_hooks[ $template ] ) ? $all_hooks[ $template ] : array();
	}

	/**
 	 *  Get hooks for Buttons implementation on shop.
	 * 
	 * @param 	Place   $template  Hooks for woo template needs to be returned.
	 * @throws 	Exception If something interesting cannot happen
	 * @author 	MakeWebBetter <plugins@makewebbetter.com>
	 * @return 	array $hooks all hooks to be implemented.
	 */
	public static function get_button_hooks( $template='', $option='' ) {
		
		/**
		 * All options available for loops.
		 */
		$loop_hooks = array(

			'before_product_loop' => array(
				'hook'			=>	'woocommerce_before_shop_loop_item',
				'priority'			=>	'10',
			),
			'before_product_name' => array(
				'hook'			=>	'woocommerce_shop_loop_item_title',
				'priority'			=>	'1',
			),
			'after_product_name' => array(
				'hook'			=>	'woocommerce_shop_loop_item_title',
				'priority'			=>	'10',
			),
			'before_add_to_cart' => array(
				'hook'			=>	'woocommerce_after_shop_loop_item',
				'priority'			=>	'1',
			)
		);

		/**
		 * All options available for Product page.
		 */
		$single_hooks = array(
			'before_add_to_cart'	=>	array(
				'hook'			=>	'woocommerce_before_add_to_cart_form',
				'priority'			=>	'10',
			),
			'after_add_to_cart'	=>	array(
				'hook'			=>	'woocommerce_after_add_to_cart_button',
				'priority'			=>	'10',
			),
			'before_product_name'	=>	array(
				'hook'			=>	'woocommerce_single_product_summary',
				'priority'			=>	'1',
			),
			'after_product_name'	=>	array(
				'hook'			=>	'woocommerce_single_product_summary',
				'priority'			=>	'5',
			),
			'after_product_price'	=>	array(
				'hook'			=>	'woocommerce_single_product_summary',
				'priority'			=>	'10',
			)
		);


		//	Merged Output	
		$all_hooks = array(
			'loop'	=>	$loop_hooks,
			'single' => $single_hooks,
		);

		return ! empty( $all_hooks[ $template ][ $option ] ) ? $all_hooks[ $template ][ $option ] : array();
	}


	/**
 	 *  Returns HTML for wishlist Text Button.
	 * 
	 * @throws Exception If something interesting cannot happen
	 * @author MakeWebBetter <plugins@makewebbetter.com>
	 * @return html
	 */
	function return_wishlist_button(){

		global $product;
		$search_result = $this->does_wishlist_includes_product( $product->get_id() );
		$accept_text = apply_filters( 'mwb_wfw_wishlist_accept_text', esc_html__( 'Add to Wishlist', 'wishlist-for-woo' ) );
		$remove_text = apply_filters( 'mwb_wfw_wishlist_remove_text', esc_html__( 'Remove from Wishlist', 'wishlist-for-woo' ) );

		if( 200 == $search_result[ 'status' ] ) {
			$wishlist = reset( $search_result[ 'message' ] );
			$wid = $wishlist[ 'id' ] ? $wishlist[ 'id' ] : '';
			$is_active = $wid ? 'active-wishlist' : '';
			$text = ! empty( $wid ) ? $remove_text : $accept_text;
		}

		else {

			$is_active = '';
			$wid = '';
			$text = $accept_text;
		}

		$default_attr =  apply_filters( 'mwb_wfw_wishlist_attr', array(
				'text'	=>	$text,
				'extra_class'	=>	'',
				'style'	=>	'',
			)
		);

		?>
		<a href="javascript:void(0);" data-wishlist-id="<?php echo esc_attr( $wid ); ?>" data-product-id="<?php echo esc_attr( $product->get_id() ); ?>" style="<?php echo esc_attr( $default_attr[ 'style' ] ); ?>" class="add-to-wishlist <?php echo esc_attr( $is_active ); ?> mwb-wfw-loop-text-button mwb-<?php echo esc_html( str_replace( '_', '-', current_action() ) ); ?>-loop <?php echo esc_attr( $default_attr[ 'extra_class' ] ); ?>"><?php echo esc_attr( $default_attr[ 'text' ] ); ?></a>
		<?php
	}	

	/**
 	 *  Returns HTML for wishlist icon button.
	 * 
	 * @throws Exception If something interesting cannot happen
	 * @author MakeWebBetter <plugins@makewebbetter.com>
	 * @return html
	 */
	function return_wishlist_icon(){

		$default_attr =  apply_filters( 'mwb_wfw_wishlist_attr', array(
				'text'	=>	apply_filters( 'mwb_wfw_wishlist_icon', get_option( 'wfw-icon-view', 'heart' ) ),
				'extra_class'	=>	'',
				'style'	=>	'',
			)
		);

		global $product;
		$search_result = $this->does_wishlist_includes_product( $product->get_id() );

		// Wishlist Exists? 
		if( 200 == $search_result['status'] ) {

			$wishlist = reset( $search_result['message'] );
			$wid = $wishlist[ 'id' ] ? $wishlist[ 'id' ] : '';
			$is_active = $wid ? 'active-wishlist' : '';
		}
		else {
			$is_active = '';
			$wid = '';
		}

		?>
			<a href="javascript:void(0);" data-wishlist-id="<?php echo esc_attr( $wid ); ?>" data-product-id="<?php echo esc_attr( $product->get_id() ); ?>" style="<?php echo esc_attr( $default_attr[ 'style' ] ); ?>" class="add-to-wishlist <?php echo esc_attr( $is_active ); ?> mwb-wfw-loop-icon-button mwb-<?php echo esc_html( str_replace( '_', '-', current_action() ) ); ?>-icon <?php echo esc_attr( $default_attr[ 'extra_class' ] ); ?>"><img class="mwb-wfw-icon" src="<?php echo esc_url( WISHLIST_FOR_WOO_URL . 'public/icons/' . $default_attr[ 'text' ] . '.svg' ); ?>"></a>
		<?php
	}

	/**
 	 *  Checks if any current user wishlist have this product or not.
	 * 
	 * @param  $product_id string product id to search.
	 * @throws Exception If something interesting cannot happen
	 * @author MakeWebBetter <plugins@makewebbetter.com>
	 * @return bool true|false
	 */
	function does_wishlist_includes_product( $product_id=false ) {

		$wishlist_manager = Wishlist_For_Woo_Crud_Manager::get_instance();

		$user = wp_get_current_user();
		return $wishlist_manager->retrieve( 'owner', $user->user_email, array( 'products' => $product_id ) );
	}

# End of class.
}
