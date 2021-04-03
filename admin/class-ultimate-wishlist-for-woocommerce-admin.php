<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://makewebbetter.com
 * @since      1.0.0
 *
 * @package    Ultimate_Wishlist_For_Woocommerce
 * @subpackage Ultimate_Wishlist_For_Woocommerce/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Ultimate_Wishlist_For_Woocommerce
 * @subpackage Ultimate_Wishlist_For_Woocommerce/admin
 * @author     MakeWebBetter <plugins@makewebbetter.com>
 */
class Ultimate_Wishlist_For_Woocommerce_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->admin_path  = plugin_dir_path( __FILE__ );
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
		 * defined in Ultimate_Wishlist_For_Woocommerce_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ultimate_Wishlist_For_Woocommerce_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		if ( self::is_valid_screen() ) {
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ultimate-wishlist-for-woocommerce-admin.css', array(), $this->version, 'all' );
			wp_enqueue_style( $this->plugin_name . '-select2', plugin_dir_url( __FILE__ ) . 'css/select2.min.css', array(), $this->version, 'all' );
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
		 * defined in Ultimate_Wishlist_For_Woocommerce_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ultimate_Wishlist_For_Woocommerce_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		if ( self::is_valid_screen() ) {

			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ultimate-wishlist-for-woocommerce-admin.js', array( 'jquery', 'wp-color-picker' ), $this->version, false );
			wp_enqueue_script( $this->plugin_name . '-swal-alert', plugin_dir_url( __FILE__ ) . 'js/swal.js', array( 'jquery' ), $this->version, false );
			wp_enqueue_script( $this->plugin_name . '-select2', plugin_dir_url( __FILE__ ) . 'js/select2.min.js', array( 'jquery' ), $this->version, false );
			wp_localize_script(
				$this->plugin_name,
				'mwb_wfw_obj',
				array(
					'ajaxUrl'              => admin_url( 'admin-ajax.php' ),
					'params'               => map_deep( wp_unslash( $_GET ), 'sanitize_text_field' ),
					'mobileView'           => wp_is_mobile(),
					'authNonce'            => wp_create_nonce( 'mwb_wfw_nonce' ),
					'notfoundErrorMessage' => esc_html__( 'Settings Panel Not Found.', 'wishlist-for-woo' ),
					'criticalErrorMessage' => esc_html__( 'Internal Server Error.', 'wishlist-for-woo' ),
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
	 * @author   MakeWebBetter <plugins@makewebbetter.com>.
	 * @return   bool true|fase
	 */
	private static function is_valid_screen() {

		$result = false;

		$valid_screens = array(
			'toplevel_page_wfw-config-portal',
			'ultimate-wishlist-for-woocommerce_page_wfw-performance-reporting',
			'ultimate-wishlist-for-woocommerce_page_wfw-plugin-overview',
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
	 * Register page IDs for WooCommerce.
	 *
	 * @param array $screen Screen ID.
	 */
	public function set_wc_screen_ids( $screen ) {

		$screen_ids = array(
			'toplevel_page_wfw-config-portal',
			'ultimate-wishlist-for-woocommerce_page_wfw-performance-reporting',
			'ultimate-wishlist-for-woocommerce_page_wfw-plugin-overview',
		);

		$screen = array_merge( $screen_ids, $screen );

		return $screen;
	}

	/**
	 *  Add a admin menu for accessing plugin features.
	 *
	 * @author MakeWebBetter <plugins@makewebbetter.com>
	 */
	public function add_config_menu() {

		add_menu_page(
			esc_html__( 'Ultimate Wishlist for WooCommerce', 'wishlist-for-woo' ),
			esc_html__( 'Ultimate Wishlist for WooCommerce', 'wishlist-for-woo' ),
			'manage_woocommerce',
			'wfw-config-portal',
			array( $this, 'add_config_screen' ),
			'dashicons-superhero',
			57
		);

		/**
		 * Add sub-menu for Configuration settings.
		 */
		add_submenu_page( 'wfw-config-portal', esc_html__( 'Configuration & Settings', 'wishlist-for-woo' ), esc_html__( 'Configuration & Settings', 'wishlist-for-woo' ), 'manage_options', 'wfw-config-portal' );

		/**
		 * Add sub-menu for Reportings settings.
		 */
		add_submenu_page( 'wfw-config-portal', esc_html__( 'Performance Analytics', 'wishlist-for-woo' ), esc_html__( 'Performance Analytics', 'wishlist-for-woo' ), 'manage_options', 'wfw-performance-reporting', array( $this, 'add_reporting_screen' ) );

		/**
		 * Add sub-menu for Plugin Overview.
		 */
		add_submenu_page( 'wfw-config-portal', esc_html__( 'Overview', 'wishlist-for-woo' ), esc_html__( 'Overview', 'wishlist-for-woo' ), 'manage_options', 'wfw-plugin-overview', array( $this, 'add_overview_screen' ) );
	}


	/**
	 *  Add a admin menu for accessing config portal.
	 *
	 * @throws $error If something interesting cannot happen while registering the portal.
	 * @author MakeWebBetter <plugins@makewebbetter.com>
	 */
	public function add_config_screen() {

		wc_get_template(
			'partials/ultimate-wishlist-for-woocommerce-config-portal.php',
			array(),
			'',
			$this->admin_path
		);
	}

	/**
	 *  Add a admin menu for accessing reporting portal.
	 *
	 * @throws $error If something interesting cannot happen while registering the portal.
	 * @author MakeWebBetter <plugins@makewebbetter.com>
	 */
	public function add_reporting_screen() {

		wc_get_template(
			'partials/ultimate-wishlist-for-woocommerce-reporting-portal.php',
			array(),
			'',
			$this->admin_path
		);
	}

	/**
	 *  Add a admin menu for accessing overview portal.
	 *
	 * @throws $error If something interesting cannot happen while registering the portal.
	 * @author MakeWebBetter <plugins@makewebbetter.com>
	 */
	public function add_overview_screen() {

		wc_get_template(
			'partials/ultimate-wishlist-for-woocommerce-reporting-portal.php',
			array(),
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

		$hashScreen = ! empty( $_POST['hashScreen'] ) ? str_replace( '#', '', sanitize_text_field( wp_unslash( $_POST['hashScreen'] ) ) ) : false;

		try {

			$content = $this->get_selected_template_content( $hashScreen );
			if ( 404 == $content ) {
				$result = array(
					'status'  => 404,
					'content' => esc_html__( 'Undefined Portal Encountered', 'wishlist-for-woo' ),
				);
			} else {

				$result = array(
					'status'  => 200,
					'content' => $content,
				);
			}
		} catch ( \Throwable $error ) {

			$result = array(
				'status'  => 500,
				'content' => $error->getMessage(),
			);
		}

		echo json_encode( $result );
		wp_die();
	}

	/**
	 *  Return Html content for required tab.
	 *
	 * @param string $template_part the key for section which we need.
	 *
	 * @throws Some_Exception_Class If something interesting cannot happen.
	 * @author MakeWebBetter <plugins@makewebbetter.com>
	 * @return html
	 */
	public function get_selected_template_content( $template_part = false ) {

		if ( ! empty( $template_part ) ) {

			switch ( $template_part ) {

				case 'general':
					$settings = Wishlist_For_Woo_Template_Manager::get_general_sections_settings();
					break;

				case 'social_sharing':
					$settings = Wishlist_For_Woo_Template_Manager::get_social_sharing_sections_settings();
					break;

				case 'push_notify':
					$settings = Wishlist_For_Woo_Template_Manager::get_push_notify_sections_settings();
					break;

				case 'advance_feature':
					$settings = Wishlist_For_Woo_Template_Manager::get_advance_feature_sections_settings();
					break;

				case 'crm':
					$settings = Wishlist_For_Woo_Template_Manager::get_crm_sections_settings();
					break;

				case 'wishlist_base':
				case 'product_base':
				case 'overview':
					$base = $this->admin_path;
					$settings = Wishlist_For_Woo_Template_Manager::get_template_sections( str_replace( '_', '-', $template_part ), $base );
					break;

				default:
					// Nothing Found.
					$settings = 404;
					break;
			}
		}

		if ( ! empty( $settings ) && is_array( $settings ) ) {

			$output = '';

			foreach ( $settings as $index => $setting ) {

				if ( ! empty( $setting['type'] ) && 'sub-heading' == $setting['type'] ) {

					$output .= sprintf( '<tr valign="top"><td colspan="2" class="forminp wfw_admin_subheading"><h2 class="mwb-wfw-subheading">%s</h2></td></tr>', esc_html( $setting['value'] ) );

				} elseif ( ! empty( $setting['type'] ) && 'file' == $setting['type'] ) {

					$output .= sprintf( '<tr valign="top"><th scope="row" class="titledesc"><label for="%s">%s</label></th><td colspan="2" class="forminp"><input class="mwb-wfw-file" name="%s" value="%s" ></td></tr>', esc_html( $setting['id'] ), esc_html( $setting['title'] ), esc_html( $setting['id'] ), esc_html( $setting['value'] ) );
				} else {
					ob_start();
						woocommerce_admin_fields( array( $setting ) );
					$output .= ob_get_contents();
					ob_end_clean();
				}
			}

			return $output;

		} else {
			return $settings ? $settings : false;
		}
	}

	/**
	 *  Save form data ajax callback.
	 *
	 * @throws $error If something interesting cannot happen while registering the portal.
	 * @author MakeWebBetter <plugins@makewebbetter.com>
	 * @return json
	 */
	public function saveFormOutput() {

		// Nonce verification.
		check_ajax_referer( 'mwb_wfw_nonce', 'nonce' );

		$checkbox_settings = array(
			'general'   => array(
				'wfw-enable-plugin',
				'wfw-enable-popup',
			),
			'social_sharing'    => array(
				'wfw-enable-fb-share',
				'wfw-enable-whatsapp-share',
				'wfw-enable-twitter-share',
				'wfw-enable-pinterest-share',
			),
			'push_notify'   => array(
				'wfw-enable-push-notif',
			),
			'advance_feature'   => array(
				'wfw-enable-multi-wishlist',
				'wfw-enable-api-route',
				'wfw-enable-automated-mail',
				'wfw-enable-instock-notif',
			),
			'crm'   => array(),
		);

		$formdata = array();

		isset( $_POST['data'] ) ? parse_str( sanitize_text_field( wp_unslash( $_POST['data'] ) ), $formdata ) : '';
		$formdata = ! empty( $formdata ) ? map_deep( wp_unslash( $formdata ), 'sanitize_text_field' ) : false;
		$screen = ! empty( $_POST['screen'] ) ? str_replace( '#', '', sanitize_text_field( wp_unslash( $_POST['screen'] ) ) ) : false;

		try {

			if ( ! empty( $checkbox_settings[ $screen ] ) && is_array( $checkbox_settings[ $screen ] ) ) {
				foreach ( $checkbox_settings[ $screen ] as $key => $data_key ) {
					$formdata[ $data_key ] = ! empty( $formdata[ $data_key ] ) ? 'yes' : 'no';
				}
			}

			if ( count( $formdata ) ) {

				foreach ( $formdata as $data_key => $data_value ) {
					update_option( $data_key, $data_value );
				}

				$result = array(
					'status'    => 200,
					'content'   => 'success',
				);
			}
		} catch ( \Throwable $error ) {

			$result = array(
				'status'  => 500,
				'content' => $error->getMessage(),
			);
		}

		echo json_encode( $result );
		wp_die();
	}

	/**
	 * Move push notification main js to root folder.
	 */
	public function MoveFiletoRoot() {

		// Nonce verification.
		check_ajax_referer( 'mwb_wfw_nonce', 'nonce' );

		$result = array();

		$enable_push_notif = get_option( 'wfw-enable-push-notif', 'yes' );

		if ( 'yes' == $enable_push_notif ) {

			$source      = WISHLIST_PLUGINS_PATH . 'wishlist-for-woo/service-worker.js';
			$destination = ABSPATH . 'service-worker.js';

			$move_file = rename( $source, $destination );

			if ( false == $move_file ) {
				$result = array(
					'status'  => false,
					'message' => esc_html__( 'Write permission needed!', 'wishlist_for_woo' ),
				);
			} else {
				$result = array(
					'status'  => true,
					'message' => esc_html__( 'File moved successfully', 'wishlist_for_woo' ),
				);
			}
		}

		wp_send_json( $result );
	}

	/**
	 * Get all valid screens to add scripts and templates.
	 *
	 * @since    1.0.0
	 */
	public function add_mwb_frontend_screens( $valid_screens = array() ) {

		if ( is_array( $valid_screens ) ) {

			// Push your screen here.
			array_push( $valid_screens, 'toplevel_page_wfw-config-portal' );
			array_push( $valid_screens, 'ultimate-wishlist-for-woocommerce_page_wfw-performance-reporting' );
			array_push( $valid_screens, 'ultimate-wishlist-for-woocommerce_page_wfw-plugin-overview' );
		}
		return $valid_screens;
	}

	/**
	 * Get all valid slugs to add deactivate popup.
	 *
	 * @since    1.0.0
	 */
	public function add_mwb_deactivation_screens( $valid_screens = array() ) {

		if ( is_array( $valid_screens ) ) {

			// Push your screen here.
			array_push( $valid_screens, 'wishlist-for-woo' );
		}

		return $valid_screens;
	}

// end of class.
}
