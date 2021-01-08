<?php
/**
 * Lists options page
 *
 * @author  Your Inspiration Themes
 * @package mwb WooCommerce Wishlist
 * @version 3.0.0
 */

if ( ! defined( 'mwb_WCWL' ) ) {
	exit;
} // Exit if accessed directly

return apply_filters( 'mwb_wcwl_list_options', array(
	'lists' => array(
		'lists_section_start' => array(
			'type' => 'title',
			'desc' => '',
			'id' => 'mwb_wcwl_lists_settings'
		),

		'wishlists' => array(
			'name' => __( 'Wishlists', 'mwb-woocommerce-wishlist' ),
			'type' => 'mwb-field',
			'mwb-type' => 'list-table',

			'class' => '',
			'list_table_class' => 'mwb_WCWL_Admin_Table',
			'list_table_class_dir' => mwb_WCWL_INC . 'tables/class.mwb-wcwl-admin-table.php',
			'title' => __( 'Wishlists', 'mwb-woocommerce-wishlist' ),
			'search_form' => array(
				'text' => __( 'Search list', 'mwb-woocommerce-wishlist' ),
				'input_id' => 'search_list'
			),
			'id' => 'wishlist-filter'
		),

		'lists_section_end' => array(
			'type' => 'sectionend',
			'id' => 'mwb_wcwl_lists_settings'
		),

	)
) );
