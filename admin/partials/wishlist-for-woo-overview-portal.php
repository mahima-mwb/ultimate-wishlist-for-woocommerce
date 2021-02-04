<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://makewebbetter.com
 * @since      1.0.0
 *
 * @package    Wishlist_For_Woo
 * @subpackage Wishlist_For_Woo/admin/partials
 */
?>

<!-- Add required templates -->
<?php  do_action( 'mwb_wfw_header_start' ); ?>
<?php  do_action( 'mwb_wfw_nav_tab' ); ?>
<?php  do_action( 'mwb_wfw_output_screen' ); ?>
<?php  do_action( 'mwb_wfw_header_end' ); ?>