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
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
        
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
			array(
				'hook'			=>	'woocommerce_before_add_to_cart_form',
				'priority'			=>	'10',
			),
			array(
				'hook'			=>	'woocommerce_after_add_to_cart_button',
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

# End of class.
}
