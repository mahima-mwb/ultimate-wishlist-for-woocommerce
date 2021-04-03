<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://makewebbetter.com
 * @since             1.0.0
 * @package           Ultimate_Wishlist_For_Woocommerce
 *
 * @wordpress-plugin
 * Plugin Name:       		Ultimate Wishlist for WooCommerce
 * Plugin URI:        		https://wordpress.org/plugins/ultimate-wishlist-for-woocommerce
 * Description:             Wishes and purchases are like ZERO and ONE of the shopping journeys respectively. This plugin helps you to turn this ZERO into ONE.
 * Version:                 1.0.0
 * Requires at least:       4.4
 * Tested up to:            5.7
 * WC requires at least:    3.0
 * WC tested up to:         5.1.0
 * Author:                  MakeWebBetter
 * Author URI:              https://makewebbetter.com
 * License:                 GPL-3.0
 * License URI:             http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       		ultimate-wishlist-for-woocommerce
 * Domain Path:       		/languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Plugin Active Detection.
 *
 * @since    1.0.0
 * @param    string $plugin_slug index file of plugin.
 */
function mwb_wfw_is_plugin_active( $plugin_slug = '' ) {

	if ( empty( $plugin_slug ) ) {

		return false;
	}

	$active_plugins = (array) get_option( 'active_plugins', array() );

	if ( is_multisite() ) {

		$active_plugins = array_merge( $active_plugins, get_site_option( 'active_sitewide_plugins', array() ) );

	}

	return in_array( $plugin_slug, $active_plugins ) || array_key_exists( $plugin_slug, $active_plugins );

}

/**
 * The code that runs during plugin validation.
 * This action is checks for WooCommerce Dependency.
 *
 * @since    1.0.0
 */
function mwb_wfw_plugin_activation() {

	$activation['status'] = true;
	$activation['message'] = '';

	// Dependant plugin.
	if ( ! mwb_wfw_is_plugin_active( 'woocommerce/woocommerce.php' ) ) {

		$activation['status'] = false;
		$activation['message'] = 'woo_inactive';

	}

	return $activation;
}

$mwb_wfw_plugin_activation = mwb_wfw_plugin_activation();

if ( true === $mwb_wfw_plugin_activation['status'] ) {

	/**
	 * Currently plugin version.
	 * Start at version 1.0.0 and use SemVer - https://semver.org
	 * Rename this for your plugin and update it as you release new versions.
	 */
	define( 'ULTIMATE_WISHLIST_FOR_WOOCOMMERCE_VERSION', '1.0.0' );
	define( 'ULTIMATE_WISHLIST_FOR_WOOCOMMERCE_URL', plugin_dir_url( __FILE__ ) );
	define( 'WISHLIST_PLUGINS_PATH', plugin_dir_path( __FILE__ ) );

	// Add settings links.
	add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'mwb_wfw_plugin_action_links' );

	/**
	 * Add Settings link if premium version is not available.
	 *
	 * @since    1.0.0
	 * @param    string $links link to admin arena of plugin.
	 */
	function mwb_wfw_plugin_action_links( $links ) {

		$plugin_links = array(
			'<a href="' . admin_url( 'admin.php?page=wfw-config-portal' ) . '">' . esc_html__( 'Settings', 'ultimate-wishlist-for-woocommerce' ) . '</a>',
		);

		return array_merge( $plugin_links, $links );
	}

	add_filter( 'plugin_row_meta', 'mwb_wfw_add_important_links', 10, 2 );
	/**
	 * Add custom links for getting premium version.
	 *
	 * @param   string $links link to index file of plugin.
	 * @param   string $file index file of plugin.
	 *
	 * @since    1.0.0
	 */
	function mwb_wfw_add_important_links( $links, $file ) {

		if ( strpos( $file, 'ultimate-wishlist-for-woocommerce.php' ) !== false ) {

			$row_meta = array(
				'demo' => '<a href="https://demo.makewebbetter.com/ultimate-wishlist-for-woocommerce/?utm_source=MWB-wishlist-home&utm_medium=MWB-home-page&utm_campaign=MWB-wishlist-home" target="_blank">' . esc_html__( 'Demo', 'ultimate-wishlist-for-woocommerce' ) . '</a>',
				'doc' => '<a href="https://docs.makewebbetter.com/ultimate-wishlist-for-woocommerce/?utm_source=MWB-wishlist-home&utm_medium=MWB-home-page&utm_campaign=MWB-wishlist-home" target="_blank">' . esc_html__( 'Documentation', 'ultimate-wishlist-for-woocommerce' ) . '</a>',
				'support' => '<a href="https://makewebbetter.com/submit-query/" target="_blank">' . esc_html__( 'Support', 'ultimate-wishlist-for-woocommerce' ) . '</a>',
			);

			return array_merge( $links, $row_meta );
		}

		return (array) $links;
	}

	/**
	 * The code that runs during plugin activation.
	 * This action is documented in includes/class-ultimate-wishlist-for-woocommerce-activator.php
	 */
	function activate_ultimate_wishlist_for_woocommerce() {
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-ultimate-wishlist-for-woocommerce-activator.php';
		Ultimate_Wishlist_For_Woocommerce_Activator::activate();
	}

	/**
	 * The code that runs during plugin deactivation.
	 * This action is documented in includes/class-ultimate-wishlist-for-woocommerce-deactivator.php
	 */
	function deactivate_ultimate_wishlist_for_woocommerce() {
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-ultimate-wishlist-for-woocommerce-deactivator.php';
		Ultimate_Wishlist_For_Woocommerce_Deactivator::deactivate();
	}

	register_activation_hook( __FILE__, 'activate_ultimate_wishlist_for_woocommerce' );
	register_deactivation_hook( __FILE__, 'deactivate_ultimate_wishlist_for_woocommerce' );

	/**
	 * The core plugin class that is used to define internationalization,
	 * admin-specific hooks, and public-facing site hooks.
	 */
	require plugin_dir_path( __FILE__ ) . 'includes/class-ultimate-wishlist-for-woocommerce.php';

	/**
	 * Begins execution of the plugin.
	 *
	 * Since everything within the plugin is registered via hooks,
	 * then kicking off the plugin from this point in the file does
	 * not affect the page life cycle.
	 *
	 * @since    1.0.0
	 */
	function run_ultimate_wishlist_for_woocommerce() {

		$plugin = new Ultimate_Wishlist_For_Woocommerce();
		$plugin->run();

	}
	run_ultimate_wishlist_for_woocommerce();

} else {

	add_action( 'admin_init', 'mwb_wfw_plugin_activation_failure' );

	/**
	 * Deactivate this plugin.
	 *
	 * @since    1.0.0
	 */
	function mwb_wfw_plugin_activation_failure() {

		// To hide Plugin activated notice.
		if ( ! empty( $_GET['activate'] ) ) {

			unset( $_GET['activate'] );
		}

		deactivate_plugins( plugin_basename( __FILE__ ) );
	}

	// Add admin error notice.
	add_action( 'admin_notices', 'mwb_wfw_activation_admin_notice' );

	/**
	 * This function is used to display plugin activation error notice.
	 *
	 * @since    1.0.0
	 */
	function mwb_wfw_activation_admin_notice() {

		global $mwb_wfw_plugin_activation;

		?>

		<?php if ( 'woo_inactive' == $mwb_wfw_plugin_activation['message'] ) : ?>

			<div class="notice notice-error is-dismissible mwb-notice">
				<p><strong><?php esc_html_e( 'WooCommerce', 'ultimate-wishlist-for-woocommerce' ); ?></strong><?php esc_html_e( ' is not activated, Please activate WooCommerce first to activate ', 'ultimate-wishlist-for-woocommerce' ); ?><strong><?php esc_html_e( 'Ultimate Wishlist for WooCommerce', 'ultimate-wishlist-for-woocommerce' ); ?></strong><?php esc_html_e( '.', 'ultimate-wishlist-for-woocommerce' ); ?></p>
			</div>

			<?php
		endif;
	}
}