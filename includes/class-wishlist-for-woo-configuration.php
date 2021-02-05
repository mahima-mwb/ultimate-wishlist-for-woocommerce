<?php

/**
 * The file that Retrieves/Updates the core plugin settings
 *
 *
 * @link       https://makewebbetter.com
 * @since      1.0.0
 *
 * @package    Wishlist_For_Woo
 * @subpackage Wishlist_For_Woo/includes
 */

/**
 * The core plugin settings configurations are handled here.
 *
 *
 * @since      1.0.0
 * @package    Wishlist_For_Woo
 * @subpackage Wishlist_For_Woo/includes
 * @author     MakeWebBetter <https://makewebbetter.com>
 */
class Wishlist_For_Woo_Configuration {

	/**
	 * The basic and initial level settings are saved in this property.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Wishlist_For_Woo_Configuration    $config    Maintains and retrieve all configuration settings for the plugin.
	 */
	private static $config = array();

	/**
	 * The basic and initial level settings are saved in this property.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Wishlist_For_Woo_Configuration    $reporting    Maintains and retrieve all configuration settings for the plugin.
	 */
	private static $reporting = array();

	/**
	 * The basic and initial level settings are saved in this property.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Wishlist_For_Woo_Configuration    $overview    Maintains and retrieve all configuration settings for the plugin.
	 */
	private static $overview = array();

	/**
 	 *  Retrieve the configuration settings.
	 *
	 * @param string $tab Which tab cofiguration settings need to fetch.
	 * @throws Some_Exception_Class If something interesting cannot happen
	 * @author MakeWebBetter <plugins@makewebbetter.com>
	 * @return array()
	 */
	public static function get_config_settings( $tab='basic' ) {
		
		return self::$config;
	}

	/**
 	 *  Retrieve the reporting settings.
	 *
	 * @param string $tab Which tab cofiguration settings need to fetch.
	 * @throws Some_Exception_Class If something interesting cannot happen
	 * @author MakeWebBetter <plugins@makewebbetter.com>
	 * @return array()
	 */
	public static function get_reporting_settings( $tab='' ) {
		
		return self::$reporting;
	}

	/**
 	 *  Retrieve the reporting settings.
	 *
	 * @param string $tab Which tab cofiguration settings need to fetch.
	 * @throws Some_Exception_Class If something interesting cannot happen
	 * @author MakeWebBetter <plugins@makewebbetter.com>
	 * @return array()
	 */
	public static function get_overview_settings() {
		
		return self::$overview;
	}

# End of class.
}
