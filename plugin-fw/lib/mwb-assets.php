<?php
/**
 * This file belongs to the mwb Plugin Framework.
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */

! defined( 'ABSPATH' ) && exit; // Exit if accessed directly

if ( ! class_exists( 'mwb_Assets' ) ) {
	/**
	 * mwb Assets
	 *
	 * @class      mwb_Assets
	 * @package    mwb
	 * @since      3.0.0
	 * @author     Leanza Francesco <leanzafrancesco@gmail.com>
	 */
	class mwb_Assets {
		/** @var string */
		public $version = '1.0.0';

		/** @var mwb_Assets */
		private static $_instance;

		/** @return mwb_Assets */
		public static function instance() {
			return ! is_null( self::$_instance ) ? self::$_instance : self::$_instance = new self();
		}

		/**
		 * Constructor
		 *
		 * @since      1.0
		 * @author     Leanza Francesco <leanzafrancesco@gmail.com>
		 */
		private function __construct() {
			$this->version = mwb_plugin_fw_get_version();
			add_action( 'admin_enqueue_scripts', array( $this, 'register_styles_and_scripts' ) );
		}

		/**
		 * Register styles and scripts
		 */
		public function register_styles_and_scripts() {
			global $wp_scripts, $woocommerce, $wp_version;

			$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

			//scripts
			wp_register_script( 'mwb-colorpicker', mwb_CORE_PLUGIN_URL . '/assets/js/mwb-colorpicker.min.js', array( 'jquery', 'wp-color-picker' ), $this->version, true );
			wp_register_script( 'mwb-plugin-fw-fields', mwb_CORE_PLUGIN_URL . '/assets/js/mwb-fields' . $suffix . '.js', array( 'jquery', 'jquery-ui-datepicker', 'mwb-colorpicker', 'codemirror', 'codemirror-javascript', 'jquery-ui-slider', 'jquery-ui-sortable' ), $this->version, true );

			wp_register_script( 'mwb-metabox', mwb_CORE_PLUGIN_URL . '/assets/js/metabox' . $suffix . '.js', array( 'jquery', 'wp-color-picker', 'mwb-plugin-fw-fields' ), $this->version, true );
			wp_register_script( 'mwb-plugin-panel', mwb_CORE_PLUGIN_URL . '/assets/js/mwb-plugin-panel' . $suffix . '.js', array( 'jquery', 'wp-color-picker', 'jquery-ui-sortable', 'mwb-plugin-fw-fields' ), $this->version, true );
			wp_register_script( 'codemirror', mwb_CORE_PLUGIN_URL . '/assets/js/codemirror/codemirror.js', array( 'jquery' ), '3.15', true );
			wp_register_script( 'codemirror-javascript', mwb_CORE_PLUGIN_URL . '/assets/js/codemirror/javascript.js', array( 'jquery', 'codemirror' ), '3.15', true );
			wp_register_script( 'colorbox', mwb_CORE_PLUGIN_URL . '/assets/js/jquery.colorbox' . $suffix . '.js', array( 'jquery' ), '1.6.3', true );
			wp_register_script( 'mwb_how_to', mwb_CORE_PLUGIN_URL . '/assets/js/how-to' . $suffix . '.js', array( 'jquery' ), $this->version, true );
			wp_register_script( 'mwb-plugin-fw-wp-pages', mwb_CORE_PLUGIN_URL . '/assets/js/wp-pages' . $suffix . '.js', array( 'jquery' ), $this->version, false );

			//styles
			$jquery_version = isset( $wp_scripts->registered['jquery-ui-core']->ver ) ? $wp_scripts->registered['jquery-ui-core']->ver : '1.9.2';
			wp_register_style( 'codemirror', mwb_CORE_PLUGIN_URL . '/assets/css/codemirror/codemirror.css' );
			wp_register_style( 'mwb-plugin-style', mwb_CORE_PLUGIN_URL . '/assets/css/mwb-plugin-panel.css', array(), $this->version );
			wp_register_style( 'raleway-font', '//fonts.googleapis.com/css?family=Raleway:400,500,600,700,800,100,200,300,900' );
			wp_register_style( 'mwb-jquery-ui-style', '//code.jquery.com/ui/' . $jquery_version . '/themes/smoothness/jquery-ui.css', array(), $jquery_version );
			wp_register_style( 'colorbox', mwb_CORE_PLUGIN_URL . '/assets/css/colorbox.css', array(), $this->version );
			wp_register_style( 'mwb-upgrade-to-pro', mwb_CORE_PLUGIN_URL . '/assets/css/mwb-upgrade-to-pro.css', array( 'colorbox' ), $this->version );
			wp_register_style( 'mwb-plugin-metaboxes', mwb_CORE_PLUGIN_URL . '/assets/css/metaboxes.css', array(), $this->version );
			wp_register_style( 'mwb-plugin-fw-fields', mwb_CORE_PLUGIN_URL . '/assets/css/mwb-fields.css', false, $this->version );

			$wc_version_suffix = '';
			if ( function_exists( 'WC' ) || ! empty( $woocommerce ) ) {
				$woocommerce_version = function_exists( 'WC' ) ? WC()->version : $woocommerce->version;
				$wc_version_suffix   = version_compare( $woocommerce_version, '3.0.0', '>=' ) ? '' : '-wc-2.6';

				wp_register_style( 'woocommerce_admin_styles', $woocommerce->plugin_url() . '/assets/css/admin.css', array(), $woocommerce_version );
			} else {
				wp_register_script( 'select2', '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js', array( 'jquery' ), '4.0.3', true );
				wp_register_style( 'mwb-select2-no-wc', mwb_CORE_PLUGIN_URL . '/assets/css/mwb-select2-no-wc.css', false, $this->version );
			}

			wp_register_script( 'mwb-enhanced-select', mwb_CORE_PLUGIN_URL . '/assets/js/mwb-enhanced-select' . $wc_version_suffix . $suffix . '.js', array( 'jquery', 'select2' ), $this->version, true );
			wp_localize_script( 'mwb-enhanced-select', 'mwb_framework_enhanced_select_params', array(
				'ajax_url'               => admin_url( 'admin-ajax.php' ),
				'search_posts_nonce'     => wp_create_nonce( 'search-posts' ),
				'search_terms_nonce'     => wp_create_nonce( 'search-terms' ),
				'search_customers_nonce' => wp_create_nonce( 'search-customers' ),
			) );

			wp_localize_script( 'mwb-plugin-fw-fields', 'mwb_framework_fw_fields', array(
				'admin_url' => admin_url( 'admin.php' ),
				'ajax_url'  => admin_url( 'admin-ajax.php' ),
			) );


			// Localize Colorpicker to avoid issues with WordPress 5.5
			if ( version_compare( $wp_version, '5.5-RC', '>=' ) ) {
				wp_localize_script( 'mwb-colorpicker', 'wpColorPickerL10n', array(
					'clear'            => __( 'Clear' ),
					'clearAriaLabel'   => __( 'Clear color' ),
					'defaultString'    => __( 'Default' ),
					'defaultAriaLabel' => __( 'Select default color' ),
					'pick'             => __( 'Select Color' ),
					'defaultLabel'     => __( 'Color value' ),
				) );
			}

			wp_enqueue_style( 'mwb-plugin-fw-admin', mwb_CORE_PLUGIN_URL . '/assets/css/admin.css', array(), $this->version );
		}
	}
}

mwb_Assets::instance();