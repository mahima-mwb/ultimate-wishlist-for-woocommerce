<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://makewebbetter.com
 * @since      1.0.0
 *
 * @package    Wishlist_For_Woo
 * @subpackage Wishlist_For_Woo/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Wishlist_For_Woo
 * @subpackage Wishlist_For_Woo/public
 * @author     MakeWebBetter <https://makewebbetter.com>
 */
class Wishlist_For_Woo_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wishlist_For_Woo_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wishlist_For_Woo_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wishlist-for-woo-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wishlist_For_Woo_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wishlist_For_Woo_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wishlist-for-woo-public.js', array( 'jquery' ), $this->version, false );

	}

	/**
 	 *  Initiate all functionalities after woocommerce is initiated.
	 * 
	 * @throws Some_Exception_Class If something interesting cannot happen
	 * @author MakeWebBetter <plugins@makewebbetter.com>
	 * @return null
	 */
	public function wishlist_init() {
		
		// Check if plugin enabled.
		$is_plugin_enabled = get_option( 'wfw-enable-plugin', 'yes' );
		if( is_admin() || 'yes' !== $is_plugin_enabled ) {
			return;
		}

		// Enable wishlist at loops.
		$this->enable_wishlist_on_loops();
	}

	/**
 	 *  Enable wishlist at loops.
	 * 
	 * @throws Exception If something interesting cannot happen
	 * @author MakeWebBetter <plugins@makewebbetter.com>
	 * @return null
	 */
	public function enable_wishlist_on_loops() {
		
		// Check if plugin enabled.
		$is_wishlist_enabled = get_option( 'wfw-loop-view-type', '' );

		if( empty( $is_wishlist_enabled ) ) {
			return;
		}

		$hook = '';

		switch ( $is_wishlist_enabled ) {
			case 'value':
				# code...
				break;
			
			default:
				$hook = 'woocommerce_shop_loop_item_title';
				break;
		}

		/**
		 * 'woocommerce_shop_loop_item_title' : after shop page product title in loop
		 * 'woocommerce_after_shop_loop_item' : after shop page product add to cart in image
		 */

		/**
		 * Product Image hooks.
		 */
		add_action( 'woocommerce_after_shop_loop_item' ,array( $this, 'add_wishlist_on_image' ), 10 );
		add_action( 'woocommerce_before_shop_loop_item_title' ,array( $this, 'add_wishlist_on_image' ), 10 );
		add_action( 'woocommerce_product_thumbnails' ,array( $this, 'add_wishlist_on_image' ), 10 );

		/**
		 * Loops hooks.
		 */
		add_action( 'woocommerce_shop_loop_item_title' ,array( $this, 'add_wishlist_on_shop_loops' ), 1 );
		add_action( 'woocommerce_shop_loop_item_title' ,array( $this, 'add_wishlist_on_shop_loops' ), 10 );

		/**
		 * Single product page hooks.
		 */
		add_action( 'woocommerce_simple_add_to_cart' ,array( $this, 'add_wishlist_on_single' ), 10 );

		// // Before add to cart.
		// add_action( 'woocommerce_before_add_to_cart_form' ,array( $this, 'add_wishlist_on_single' ), 10 );
		
		// // After add to cart.
		add_action( 'woocommerce_after_add_to_cart_button' ,array( $this, 'add_wishlist_on_single' ), 10 );
	}

	function add_wishlist_on_shop_loops(){
		?>
			<a href="javascript:void(0);" class="add-to-wishlist mwb_<?php echo current_action(); ?>"><?php echo 'Add to wislist'; ?></a> 
		<?php
	}

	function add_wishlist_on_single(){
		?>
			<a href="javascript:void(0);" class="add-to-wishlist mwb_<?php echo current_action(); ?>"><?php echo 'Add to wislist'; ?></a>
		<?php
	}

	function add_wishlist_on_image(){
		?>
		<a href="javascript:void(0);" class="add-to-wishlist mwb_<?php echo current_action(); ?>"><i style="font-size:24px;color:red;" class="fa">&#xf004;</i></a>
		<?php
	}

// End of class.
}
