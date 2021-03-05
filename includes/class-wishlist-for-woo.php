<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://makewebbetter.com
 * @since      1.0.0
 *
 * @package    Wishlist_For_Woo
 * @subpackage Wishlist_For_Woo/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Wishlist_For_Woo
 * @subpackage Wishlist_For_Woo/includes
 * @author     MakeWebBetter <https://makewebbetter.com>
 */
class Wishlist_For_Woo {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Wishlist_For_Woo_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;


	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'WISHLIST_FOR_WOO_VERSION' ) ) {
			$this->version = WISHLIST_FOR_WOO_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'wishlist-for-woo';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->define_template_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Wishlist_For_Woo_Loader. Orchestrates the hooks of the plugin.
	 * - Wishlist_For_Woo_i18n. Defines internationalization functionality.
	 * - Wishlist_For_Woo_Admin. Defines all hooks for the admin area.
	 * - Wishlist_For_Woo_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wishlist-for-woo-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wishlist-for-woo-i18n.php';

		/**
		 * The class responsible for defining all helper functions.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wishlist-for-woo-helper.php';

		/**
		 * The class responsible for defining all admin portal templates.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wishlist-for-woo-template-manager.php';

		/**
		 * The class responsible for defining all public wishlist templates.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wishlist-for-woo-renderer.php';

		/**
		 * The class responsible for defining all wishlist operation.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wishlist-for-woo-crud-manager.php';

		/**
		 * The class responsible for defining all wishlist operation.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wishlist-for-woo-shortcode-manager.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wishlist-for-woo-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-wishlist-for-woo-public.php';

		$this->loader = new Wishlist_For_Woo_Loader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Wishlist_For_Woo_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Wishlist_For_Woo_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Wishlist_For_Woo_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		// Add a admin menu for accessing plugin features.
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_config_menu' );
		
		// Ajax Callbacks.
		$this->loader->add_action( 'wp_ajax_getCurrentScreen', $plugin_admin, 'getCurrentScreen' );
		$this->loader->add_action( 'wp_ajax_saveFormOutput', $plugin_admin, 'saveFormOutput' );
		$this->loader->add_action( 'wp_ajax_MoveFiletoRoot', $plugin_admin, 'MoveFiletoRoot' );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Wishlist_For_Woo_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		// Initiate all functionalities after woocommerce is initiated.
		$this->loader->add_action( 'woocommerce_init', $plugin_public, 'wishlist_init' );

		// Ajax Callbacks.
		$this->loader->add_action( 'wp_ajax_UpdateWishlist', $plugin_public, 'UpdateWishlist' );
		$this->loader->add_action( 'wp_ajax_UpdateWishlistMeta', $plugin_public, 'UpdateWishlistMeta' );
		$this->loader->add_action( 'wp_ajax_nopriv_UpdateWishlist', $plugin_public, 'UpdateWishlist' );
		$this->loader->add_action( 'wp_ajax_nopriv_UpdateWishlistMeta', $plugin_public, 'UpdateWishlistMeta' );
		$this->loader->add_action( 'wp_ajax_InvitationEmail', $plugin_public, 'InvitationEmail' );
		$this->loader->add_action( 'wp_ajax_nopriv_InvitationEmail', $plugin_public, 'InvitationEmail' );
		$this->loader->add_action( 'wp_ajax_wfw_get_item_details', $plugin_public, 'wfw_get_item_details' );
		$this->loader->add_action( 'wp_ajax_nopriv_wfw_get_item_details', $plugin_public, 'wfw_get_item_details' );
		$this->loader->add_action( 'wp_ajax_add_to_cart_wish_prod', $plugin_public, 'add_to_cart_wish_prod' );
		$this->loader->add_action( 'wp_ajax_nopriv_add_to_cart_wish_prod', $plugin_public, 'add_to_cart_wish_prod' );
		$this->loader->add_action( 'wp_ajax_go_to_checkout_wish_prod', $plugin_public, 'go_to_checkout_wish_prod' );
		$this->loader->add_action( 'wp_ajax_nopriv_go_to_checkout_wish_prod', $plugin_public, 'go_to_checkout_wish_prod' );
		$this->loader->add_action( 'wp_ajax_delete_wish_prod', $plugin_public, 'delete_wish_prod' );
		$this->loader->add_action( 'wp_ajax_nopriv_delete_wish_prod', $plugin_public, 'delete_wish_prod' );

		// Push notitfications enable.
		$this->loader->add_action( 'wp_footer', $plugin_public, 'enable_push_notifications' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_template_hooks() {

		$plugin_template = new Wishlist_For_Woo_Template_Manager();

		$this->loader->add_action( 'mwb_wfw_header_start', $plugin_template, 'render_header_content_start' );
		$this->loader->add_action( 'mwb_wfw_nav_tab', $plugin_template, 'render_navigation_tab' );
		$this->loader->add_action( 'mwb_wfw_output_screen', $plugin_template, 'render_settings_screen' );
		$this->loader->add_action( 'mwb_wfw_helpdesk', $plugin_template, 'render_helpdesk_sidebar' );
		$this->loader->add_action( 'mwb_wfw_header_end', $plugin_template, 'render_header_content_end' );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Wishlist_For_Woo_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}
}
