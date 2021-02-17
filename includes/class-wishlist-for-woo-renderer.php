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
 	 *  Get hooks for Buttons implementation on shop.
	 * 
	 * @param 	Option   $option  The icon name in admin settings for unicode needs to be returned.
	 * @throws 	Exception If something interesting cannot happen
	 * @author 	MakeWebBetter <plugins@makewebbetter.com>
	 * @return 	html unicode for the icon.
	 */
	public static function get_icon_unicode(  $option='' ) {
		
		/**
		 * All options available for Product page.
		 */
		$unicodes = array(
			'heart'		=>	esc_html( '&#xf004;' ),
			'shopping'	=>	esc_html( '&#xf290;' ),
			'cart'		=>	esc_html( '&#xf217;' ),
			'star'		=>	esc_html( '&#xf005;' ),
			'tag'		=>	esc_html( '&#xf02b;' ),
			'thumbsup'  =>  esc_html( '&#xf087;' ),
			'bell'		=>	esc_html( '&#xf0f3;' ),
			'eye'		=>	esc_html( '&#xf06e;' ),
		);

		return ! empty( $unicodes[ $option ] ) ? $unicodes[ $option ] : '';
	}

	/**
 	 *  Returns HTML for wishlist Text Button on All loops.
	 * 
	 * @throws Exception If something interesting cannot happen
	 * @author MakeWebBetter <plugins@makewebbetter.com>
	 * @return html
	 */
	function add_wishlist_on_all_loops(){

		$default_attr =  apply_filters( 'mwb_wfw_wishlist_attr', array(
				'text'	=>	apply_filters( 'mwb_wfw_wishlist_text', esc_html__( 'Add to Wishlist', WISHLIST_FOR_WOO_TEXTDOMAIN ) ),
				'extra_class'	=>	'',
				'style'	=>	'',
				'wishlist-type'	=>	'loop-text-button',
			)
		);

		?>
			<a href="javascript:void(0);" style="<?php echo esc_attr( $default_attr[ 'style' ] ); ?>" class="add-to-wishlist mwb-wfw-loop-text-button mwb-<?php echo esc_html( str_replace( '_', '-', current_action() ) ); ?>-loop <?php echo esc_attr( $default_attr[ 'extra_class' ] ); ?>"><?php echo esc_attr( $default_attr[ 'text' ] ); ?></a>
		<?php
	}	

	/**
 	 *  Returns HTML for wishlist icon on All loops.
	 * 
	 * @throws Exception If something interesting cannot happen
	 * @author MakeWebBetter <plugins@makewebbetter.com>
	 * @return html
	 */
	function add_wishlist_on_loop_image(){

		$default_attr =  apply_filters( 'mwb_wfw_wishlist_attr', array(
				'text'	=>	apply_filters( 'mwb_wfw_wishlist_icon', esc_attr( self::get_icon_unicode( get_option( 'wfw-loop-icon-view', '' ) ) ) ),
				'extra_class'	=>	'',
				'style'	=>	'',
				'wishlist-type'	=>	'loop-icon-button',
			)
		);
		global $product;
		?>
			<a href="javascript:void(0);" data-wishlist-id="" data-product-id="<?php echo esc_attr( $product->get_id() ); ?>" style="<?php echo esc_attr( $default_attr[ 'style' ] ); ?>" class="add-to-wishlist mwb-wfw-loop-icon-button mwb-<?php echo esc_html( str_replace( '_', '-', current_action() ) ); ?>-icon <?php echo esc_attr( $default_attr[ 'extra_class' ] ); ?>"><i class="fa mwb-wfw-icon"><?php echo esc_attr( $default_attr[ 'text' ] ); ?></i></a>
		<?php
	}

	/**
 	 *  Returns HTML for wishlist Text Button on All Single Product Page.
	 * 
	 * @throws Exception If something interesting cannot happen
	 * @author MakeWebBetter <plugins@makewebbetter.com>
	 * @return html
	 */
	function add_wishlist_on_all_single(){

		$default_attr =  apply_filters( 'mwb_wfw_wishlist_attr', array(
				'text'	=>	apply_filters( 'mwb_wfw_wishlist_text', esc_html__( 'Add to Wishlist', WISHLIST_FOR_WOO_TEXTDOMAIN ) ),
				'extra_class'	=>	'',
				'style'	=>	'',
				'wishlist-type'	=>	'product-page-text-button',
			)
		);

		?>
			<a href="javascript:void(0);" style="<?php echo esc_attr( $default_attr[ 'style' ] ); ?>" class="add-to-wishlist mwb-wfw-single-text-button mwb-<?php echo esc_html( str_replace( '_', '-', current_action() ) ); ?>-single <?php echo esc_attr( $default_attr[ 'extra_class' ] ); ?>"><?php echo esc_attr( $default_attr[ 'text' ] ); ?></a>
		<?php
	}	

	/**
 	 *  Returns HTML for wishlist icon on All Single Product Page.
	 * 
	 * @throws Exception If something interesting cannot happen
	 * @author MakeWebBetter <plugins@makewebbetter.com>
	 * @return html
	 */
	function add_wishlist_on_single_image(){

		$default_attr =  apply_filters( 'mwb_wfw_wishlist_attr', array(
				'text'	=>	apply_filters( 'mwb_wfw_wishlist_icon', esc_attr( self::get_icon_unicode( get_option( 'wfw-product-icon-view', '' ) ) ) ),
				'extra_class'	=>	'',
				'style'	=>	'',
				'wishlist-type'	=>	'product-page-icon-button',
			)
		);

		?>
			<a href="javascript:void(0);" style="<?php echo esc_attr( $default_attr[ 'style' ] ); ?>" class="add-to-wishlist mwb-wfw-single-icon-button mwb-<?php echo esc_html( str_replace( '_', '-', current_action() ) ); ?>-icon <?php echo esc_attr( $default_attr[ 'extra_class' ] ); ?>"><i class="fa mwb-wfw-icon"><?php echo esc_attr( $default_attr[ 'text' ] ); ?></i></a>
		<?php
	}


	/**
 	 *  Returns HTML for wishlist icon on All Single Product Page.
	 * 
	 * @throws Exception If something interesting cannot happen
	 * @author MakeWebBetter <plugins@makewebbetter.com>
	 * @return html
	 */
	static function return_wishlist_view_content( $wishlist=array() ){

	}

# End of class.
}
