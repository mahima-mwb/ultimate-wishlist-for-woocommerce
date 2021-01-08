<?php
/**
 * Admin init class
 *
 * @author  Your Inspiration Themes
 * @package mwb WooCommerce Wishlist
 * @version 3.0.0
 */

if ( ! defined( 'mwb_WCWL' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'mwb_WCWL_Admin' ) ) {
	/**
	 * Initiator class. Create and populate admin views.
	 *
	 * @since 1.0.0
	 */
	class mwb_WCWL_Admin {

		/**
		 * Single instance of the class
		 *
		 * @var \mwb_WCWL_Admin
		 * @since 2.0.0
		 */
		protected static $instance;

		/**
		 * Wishlist panel
		 *
		 * @var string Panel hookname
		 * @since 2.0.0
		 */
		protected $_panel = null;

		/**
		 * Link to landing page on mwbemes.com
		 *
		 * @var string
		 * @since 2.0.0
		 */
		public $premium_landing_url = 'https://mwbemes.com/themes/plugins/mwb-woocommerce-wishlist/';

		/**
		 * Tab name
		 *
		 * @var string
		 * @since 1.0.0
		 */
		public $tab;

		/**
		 * Plugin options
		 *
		 * @var array
		 * @since 1.0.0
		 */
		public $options;

		/**
		 * List of available tab for wishlist panel
		 *
		 * @var array
		 * @access public
		 * @since 2.0.0
		 */
		public $available_tabs = array();

		/**
		 * Returns single instance of the class
		 *
		 * @return \mwb_WCWL_Admin
		 * @since 2.0.0
		 */
		public static function get_instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * Constructor of the class
		 *
		 * @return \mwb_WCWL_Admin
		 * @since 2.0.0
		 */
		public function __construct() {
			// install plugin, or update from older versions.
			add_action( 'init', array( $this, 'install' ) );

			// init admin processing.
			add_action( 'init', array( $this, 'init' ) );

			// enqueue scripts.
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ), 20 );

			// plugin panel options.
			add_filter( 'mwb_plugin_fw_panel_wc_extra_row_classes', array( $this, 'mark_options_disabled' ), 10, 23 );

			// add plugin links.
			add_filter( 'plugin_action_links_' . plugin_basename( mwb_WCWL_DIR . 'init.php' ), array( $this, 'action_links' ) );
			add_filter( 'mwb_show_plugin_row_meta', array( $this, 'add_plugin_meta' ), 10, 5 );

			// register wishlist panel.
			add_action( 'admin_menu', array( $this, 'register_panel' ), 5 );
			add_action( 'mwb_wcwl_premium_tab', array( $this, 'print_premium_tab' ) );

			// add a post display state for special WC pages.
			add_filter( 'display_post_states', array( $this, 'add_display_post_states' ), 10, 2 );
		}

		/* === ADMIN GENERAL === */

		/**
		 * Add a post display state for special WC pages in the page list table.
		 *
		 * @param array   $post_states An array of post display states.
		 * @param WP_Post $post        The current post object.
		 */
		public function add_display_post_states( $post_states, $post ) {
			if ( get_option( 'mwb_wcwl_wishlist_page_id' ) == $post->ID ) {
				$post_states['mwb_wcwl_page_for_wishlist'] = __( 'Wishlist Page', 'mwb-woocommerce-wishlist' );
			}

			return $post_states;
		}

		/* === INITIALIZATION SECTION === */

		/**
		 * Initiator method. Initiate properties.
		 *
		 * @return void
		 * @access private
		 * @since 1.0.0
		 */
		public function init() {
			$prefix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? 'unminified/' : '';
			$this->available_tabs = apply_filters(
				'mwb_wcwl_available_admin_tabs',
				array(
					'settings'        => __( 'General settings', 'mwb-woocommerce-wishlist' ),
					'add_to_wishlist' => __( 'Add to wishlist options', 'mwb-woocommerce-wishlist' ),
					'wishlist_page'   => __( 'Wishlist page options', 'mwb-woocommerce-wishlist' ),
					'premium'         => __( 'Premium Version', 'mwb-woocommerce-wishlist' ),
				)
			);

			wp_register_style( 'mwb-wcwl-font-awesome', mwb_WCWL_URL . 'assets/css/font-awesome.min.css', array(), '4.7.0' );
			wp_register_style( 'mwb-wcwl-material-icons', 'https://fonts.googleapis.com/icon?family=Material+Icons', array(), '3.0.1' );
			wp_register_style( 'mwb-wcwl-admin', mwb_WCWL_URL . 'assets/css/admin.css', array( 'mwb-wcwl-font-awesome' ), mwb_WCWL_Frontend()->version );
			wp_register_script( 'mwb-wcwl-admin', mwb_WCWL_URL . 'assets/js/' . $prefix . 'admin/mwb-wcwl.js', array( 'jquery', 'wc-backbone-modal', 'jquery-blockui' ), mwb_WCWL_Frontend()->version );
		}

		/**
		 * Run the installation
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function install() {
			if ( wp_doing_ajax() ) {
				return;
			}

			$stored_db_version = get_option( 'mwb_wcwl_db_version' );

			if ( ! $stored_db_version || ! mwb_WCWL_Install()->is_installed() ) {
				// fresh installation.
				mwb_WCWL_Install()->init();
			} elseif ( version_compare( $stored_db_version, mwb_WCWL_DB_VERSION, '<' ) ) {
				// update database.
				mwb_WCWL_Install()->update( $stored_db_version );
				do_action( 'mwb_wcwl_updated' );
			}

			// Plugin installed.
			do_action( 'mwb_wcwl_installed' );
		}

		/**
		 * Adds plugin actions link
		 *
		 * @param mixed $links Available action links.
		 * @return array
		 */
		public function action_links( $links ) {
			$links = mwb_add_action_links( $links, 'mwb_wcwl_panel', defined( 'mwb_WCWL_PREMIUM' ) );
			return $links;
		}

		/**
		 * Adds plugin row meta
		 *
		 * @param array  $new_row_meta_args Array of meta for current plugin.
		 * @param array  $plugin_meta Not in use.
		 * @param string $plugin_file Current plugin iit file path.
		 * @param array  $plugin_data Plugin info.
		 * @param string $status Plugin status.
		 * @param string $init_file Wishlist plugin init file.
		 * @return array
		 * @since 2.0.0
		 */
		public function add_plugin_meta( $new_row_meta_args, $plugin_meta, $plugin_file, $plugin_data, $status, $init_file = 'mwb_WCWL_INIT' ) {
			if ( defined( $init_file ) && constant( $init_file ) == $plugin_file ) {
				$new_row_meta_args['slug']      = 'mwb-woocommerce-wishlist';

			}

			if ( defined( 'mwb_WCWL_PREMIUM' ) ) {
				$new_row_meta_args['is_premium'] = true;

			}

			return $new_row_meta_args;
		}

		/* === WISHLIST SUBPANEL SECTION === */

		/**
		 * Register wishlist panel
		 *
		 * @return void
		 * @since 2.0.0
		 */
		public function register_panel() {

			$args = array(
				'create_menu_page' => true,
				'parent_slug'   => '',
				'page_title'    => __( 'mwb WooCommerce Wishlist', 'mwb-woocommerce-wishlist' ),
				'menu_title'    => __( 'Wishlist', 'mwb-woocommerce-wishlist' ),
				'plugin_slug'   => mwb_WCWL_SLUG,
				'plugin_description' => __( 'Allows your customers to create and share lists of products that they want to purchase on your e-commerce.', 'mwb-woocommerce-wishlist' ),
				'capability'    => apply_filters( 'mwb_wcwl_settings_panel_capability', 'manage_options' ),
				'parent'        => '',
				'class'         => function_exists( 'mwb_set_wrapper_class' ) ? mwb_set_wrapper_class() : '',
				'parent_page'   => 'mwb_plugin_panel',
				'page'          => 'mwb_wcwl_panel',
				'admin-tabs'    => $this->available_tabs,
				'options-path'  => mwb_WCWL_DIR . 'plugin-options',
			);

			/* === Fixed: not updated theme  === */
			if ( ! class_exists( 'mwb_Plugin_Panel_WooCommerce' ) ) {
				require_once( mwb_WCWL_DIR . 'plugin-fw/lib/mwb-plugin-panel-wc.php' );
			}

			$this->_panel = new mwb_Plugin_Panel_WooCommerce( $args );
		}

		/**
		 * Adds mwb-disabled class
		 * Adds class to fields when required, and when disabled state cannot be achieved any other way (eg. by dependencies)
		 *
		 * @param array $classes Array of field extra classes.
		 * @param array $field   Array of field data.
		 *
		 * @return array Filtered array of extra classes
		 */
		public function mark_options_disabled( $classes, $field ) {
			if ( isset( $field['id'] ) && 'mwb_wfbt_enable_integration' == $field['id'] && ! ( defined( 'mwb_WFBT' ) && mwb_WFBT ) ) {
				$classes[] = 'mwb-disabled';
			}

			return $classes;
		}

		/**
		 * Load admin style.
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function enqueue() {
			global $woocommerce, $pagenow;

			if ( 'admin.php' == $pagenow && isset( $_GET['page'] ) && 'mwb_wcwl_panel' == $_GET['page'] ) {
				wp_enqueue_style( 'mwb-wcwl-admin' );
				wp_enqueue_script( 'mwb-wcwl-admin' );

				if ( isset( $_GET['tab'] ) && 'popular' == $_GET['tab'] ) {
					wp_enqueue_style( 'mwb-wcwl-material-icons' );
					wp_enqueue_editor();
				}
			}
		}
		

		/**
		 * Prints tab premium of the plugin
		 *
		 * @return void
		 * @since 2.0.0
		 */
		public function print_premium_tab() {
			$premium_tab = mwb_WCWL_DIR . 'templates/admin/wishlist-panel-premium.php';

			if ( file_exists( $premium_tab ) ) {
				include( $premium_tab );
			}
		}

		/**
		 * Get the premium landing uri
		 *
		 * @since   1.0.0
		 * @author  Andrea Grillo <andrea.grillo@mwbemes.com>
		 * @return  string The premium landing link
		 */
		public function get_premium_landing_uri() {
			return $this->premium_landing_url;
		}
	}
}

/**
 * Unique access to instance of mwb_WCWL_Admin class
 *
 * @return \mwb_WCWL_Admin
 * @since 2.0.0
 */
function mwb_WCWL_Admin() {
	return defined( 'mwb_WCWL_PREMIUM' ) ? mwb_WCWL_Admin_Premium::get_instance() : mwb_WCWL_Admin::get_instance();
}
