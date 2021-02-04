<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://makewebbetter.com
 * @since      1.0.0
 *
 * @package    Wishlist_For_Woo
 * @subpackage Wishlist_For_Woo/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wishlist_For_Woo
 * @subpackage Wishlist_For_Woo/admin
 * @author     MakeWebBetter <https://makewebbetter.com>
 */
class Wishlist_For_Woo_Admin {

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
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $admin_path    The current version of the plugin.
	 */
	protected $admin_path;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->admin_path = plugin_dir_path( __FILE__ );
	}

	/**
	 * Register the stylesheets for the admin area.
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

		/**
		 * Scripts and Stylesheets need to be accessed and enqueued on configuration panels only. 
		 */
		if( self::is_valid_screen() ) {
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wishlist-for-woo-admin.css', array(), $this->version, 'all' );
		}
	}

	/**
	 * Register the JavaScript for the admin area.
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
		if( self::is_valid_screen() ) {
			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wishlist-for-woo-admin.js', array( 'jquery' ), $this->version, false );
			wp_enqueue_script( $this->plugin_name . 'swal-alert', plugin_dir_url( __FILE__ ) . 'js/swal.js', array( 'jquery' ), $this->version, false );
			wp_localize_script(
				$this->plugin_name,
				'mwb_wfw_obj',
				array(
					'ajaxUrl'       => admin_url( 'admin-ajax.php' ),
					'mobileView'   => wp_is_mobile(),
					'authNonce'    => wp_create_nonce( 'mwb_wfw_nonce' ),
					'notfoundErrorMessage'    => esc_html__( 'Settings Panel Not Found.', WISHLIST_FOR_WOO_TEXTDOMAIN ),
					'criticalErrorMessage'    => esc_html__( 'Internal Server Error.', WISHLIST_FOR_WOO_TEXTDOMAIN ),
				)
			);	
		}
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @author 	 MakeWebBetter <plugins@makewebbetter.com>
	 * @return   bool true|fase
	 */
	private static function is_valid_screen() {

		$result = false;
		$valid_screens = array(
			'toplevel_page_wfw-config-portal',
			'wishlist-for-woocommerce_page_wfw-performance-reporting',
			'wishlist-for-woocommerce_page_wfw-plugin-overview',
		);

		$screen = get_current_screen();

		if ( ! empty( $screen->id ) ) {

			$pagescreen = $screen->id;

			if ( in_array( $pagescreen, $valid_screens ) ) {
				$result = true;
			}
		}

		return $result;
	}

	/**
 	 *  Add a admin menu for accessing plugin features.
	 * 
	 * @author MakeWebBetter <plugins@makewebbetter.com>
	 * @return null
	 */
	public function add_config_menu() {

		add_menu_page(
			esc_html__( 'Wishlist For Woocommerce', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			esc_html__( 'Wishlist For Woocommerce', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			'manage_woocommerce',
			'wfw-config-portal',
			array( $this, 'add_config_screen' ),
			'dashicons-yes-alt',
			57
		);

		/**
		 * Add sub-menu for Configuration settings.
		 */
		add_submenu_page( 'wfw-config-portal', esc_html__( 'Configuration & Settings', WISHLIST_FOR_WOO_TEXTDOMAIN ), esc_html__( 'Configuration & Settings', WISHLIST_FOR_WOO_TEXTDOMAIN ), 'manage_options', 'wfw-config-portal' );

		/**
		 * Add sub-menu for Reportings settings.
		 */
		add_submenu_page( 'wfw-config-portal', esc_html__( 'Reports & Analytics', WISHLIST_FOR_WOO_TEXTDOMAIN ), esc_html__( 'Reports & Analytics', WISHLIST_FOR_WOO_TEXTDOMAIN ), 'manage_options', 'wfw-performance-reporting', array( $this, 'add_reporting_screen' ) );
		
		/**
		 * Add sub-menu for Plugin Overview.
		 */
		add_submenu_page( 'wfw-config-portal', esc_html__( 'Overview', WISHLIST_FOR_WOO_TEXTDOMAIN ), esc_html__( 'Overview', WISHLIST_FOR_WOO_TEXTDOMAIN ), 'manage_options', 'wfw-plugin-overview', array( $this, 'add_overview_screen' ) );
	}


	/**
 	 *  Add a admin menu for accessing config portal.
	 * 
	 * @throws $error If something interesting cannot happen while registering the portal.
	 * @author MakeWebBetter <plugins@makewebbetter.com>
	 * @return null
	 */
	public function add_config_screen() {

		$config_settings = Wishlist_For_Woo_Configuration::get_config_settings();
		wc_get_template(
			'partials/wishlist-for-woo-config-portal.php',
			array(
				'config_settings' => $config_settings,
			),
			'',
			$this->admin_path
		);
	}

	/**
 	 *  Add a admin menu for accessing reporting portal.
	 * 
	 * @throws $error If something interesting cannot happen while registering the portal.
	 * @author MakeWebBetter <plugins@makewebbetter.com>
	 * @return null
	 */
	public function add_reporting_screen() {
		
		$reporting_settings = Wishlist_For_Woo_Configuration::get_reporting_settings();
		wc_get_template(
			'partials/wishlist-for-woo-reporting-portal.php',
			array(
				'reporting_settings' => $reporting_settings,
			),
			'',
			$this->admin_path
		);
	}

	/**
 	 *  Add a admin menu for accessing overview portal.
	 * 
	 * @throws $error If something interesting cannot happen while registering the portal.
	 * @author MakeWebBetter <plugins@makewebbetter.com>
	 * @return null
	 */
	public function add_overview_screen() {

		$overview_settings = Wishlist_For_Woo_Configuration::get_overview_settings();
		wc_get_template(
			'partials/wishlist-for-woo-reporting-portal.php',
			array(
				'overview_settings' => $overview_settings,
			),
			'',
			$this->admin_path
		);	
	}

	/**
 	 *  Get screen ajax callback.
	 * 
	 * @throws $error If something interesting cannot happen while registering the portal.
	 * @author MakeWebBetter <plugins@makewebbetter.com>
	 * @return html
	 */
	public function getCurrentScreen() {
		
		// Nonce verification.
		check_ajax_referer( 'mwb_wfw_nonce', 'nonce' );	

		$hashScreen = ! empty( $_POST[ 'hashScreen' ] ) ? str_replace( '#', '', $_POST[ 'hashScreen' ] ) : false;
		$hashScreen = ! empty( $_POST[ 'hashScreen' ] ) ? str_replace( '_', '-', $hashScreen ) : false;

		try {
			$config_settings = Wishlist_For_Woo_Configuration::get_config_settings();
			
			$template_path = 'partials/templates/' . $hashScreen . '-template.php';
			
			// If template not found!
			if( false == file_exists( $this->admin_path . $template_path ) ) {
				$result = array(
					'status'	=>	404,
					'content'	=>	false,
				);
			}

			else {
				
				$result = array(
					'status'	=>	200,
					'content'	=>	file_get_contents( $this->admin_path . $template_path ),
				);
			}
			
		} catch (\Throwable $error ) {

			$result = array(
				'status'	=>	500,
				'content'	=>	$error->getMessage(),
			);	
		}
		
		echo json_encode( $result );
		wp_die();
	}

# End of class.
}
