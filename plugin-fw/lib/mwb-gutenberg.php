<?php
/**
 * This file belongs to the mwb Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */

/**
 * Text Domain: mwb-plugin-fw
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if( ! class_exists( 'mwb_Gutenberg' ) ){

	class mwb_Gutenberg{
		/**
		 * @var array Registered blocks
		 */
		private $_registered_blocks = array();

		/**
		 * @var array Blocks to register
		 */
		private $_to_register_blocks = array();

		/**
		 * @var array Blocks args
		 */
		private $_blocks_args = array();

		/**
		 * @var string Block category slug
		 */
		private $_category_slug = 'mwb-blocks';

		/**
		 * @var mwb_Upgrade The main instance
		 */
		protected static $_instance;

		/**
		 * Main plugin Instance
		 *
		 * @static
		 * @return object Main instance
		 *
		 * @since  1.0
		 * @author Andrea Grillo <andrea.grillo@mwbemes.com>
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		/**
		 * mwb_Gutenberg constructor.
		 */
		private function __construct() {
			add_action( 'init', array( $this, 'register_blocks' ), 30 );
			add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_block_editor_assets' ) );
			add_action( 'wp_ajax_mwb_plugin_fw_gutenberg_do_shortcode', array( $this, 'do_shortcode' ) );
			add_action( 'wc_ajax_mwb_plugin_fw_gutenberg_do_shortcode', array( $this, 'do_shortcode' ) );
		}

		/**
		 * Enqueue scripts for gutenberg
		 */
		public function enqueue_block_editor_assets() {
			$ajax_url = function_exists( 'WC' ) ? add_query_arg( 'wc-ajax', 'mwb_plugin_fw_gutenberg_do_shortcode', trailingslashit( site_url() ) ) : admin_url( 'admin-ajax.php' );
			$suffix   = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
			$deps     = apply_filters( 'mwb_plugin_fw_gutenberg_script_deps', array(
				'wp-blocks',
				'wp-element',
				'mwb-js-md5'
			) );
			wp_register_script( 'mwb-js-md5', mwb_CORE_PLUGIN_URL . '/assets/js/javascript-md5/md5.min.js', array(), '2.10.0', true );
			wp_enqueue_script( 'mwb-gutenberg', mwb_CORE_PLUGIN_URL . '/assets/js/mwb-gutenberg' . $suffix . '.js', $deps, mwb_plugin_fw_get_version(), true );
			wp_localize_script( 'mwb-gutenberg', 'mwb_gutenberg', $this->_blocks_args );
			wp_localize_script( 'mwb-gutenberg', 'mwb_gutenberg_ajax', array( 'ajaxurl' => $ajax_url ) );
		}

		/**
		 * Add blocks to gutenberg editor
		 *
		 * @return void
		 * @author Andrea Grillo <andrea.grillo@mwbemes.com>
		 */
		public function register_blocks(){
		    $block_args = array();
			foreach (  $this->_to_register_blocks as $block => $args ){
				if( isset( $args['style'] ) ){
					$block_args['style'] = $args['style'];
				}

				if( isset( $args['script'] ) ){
					$block_args['script'] = $args['script'];
				}

				if( register_block_type( "mwb/{$block}", $block_args ) ){
					$this->_registered_blocks[] = $block;
				}
			}

			if( ! empty( $this->_registered_blocks ) ){
				add_filter( 'block_categories', array( $this, 'block_category' ), 10, 2 );
			}
		}

		/**
		 * Add block category
		 *
		 * @param $categories array block categories array
		 * @param $post WP_Post current post
		 *
		 * @return array block categories
		 *
		 * @author Andrea Grillo <andrea.grillo@mwbemes.com>
		 */
		public function block_category( $categories, $post ){
			return array_merge(
				$categories,
				array(
					array(
						'slug' => 'mwb-blocks',
						'title' => _x( 'mwb', '[gutenberg]: Category Name', 'mwb-plugin-fw' ),
					),
				)
			);
		}

		/**
		 * Add new blocks to Gutenberg
		 *
		 * @param $blocks string|array new blocks
		 * @return bool true if add a new blocks, false otherwise
		 *
		 * @author Andrea Grillo <andrea.grillo@mwbemes.com>
		 */
		public function add_blocks( $blocks ){
			$added = false;
			if( ! empty( $blocks ) ){
				$added = true;
				if( is_array( $blocks ) ){
					$this->_to_register_blocks = array_merge( $this->_to_register_blocks, $blocks );
				}

				else {
					$this->_to_register_blocks[] = $blocks;
				}
			}

			return $added;
		}

		/**
		 * Return an array with the registered blocks
		 *
		 * @return array
		 */
		public function get_registered_blocks(){
			return $this->_registered_blocks;
		}

		/**
		 * Return an array with the blocks to register
		 *
		 * @return array
		 */
		public function get_to_register_blocks(){
			return $this->_to_register_blocks;
		}

		/**
		 * Return an array with the block(s) arguments
		 *
		 * @return array
		 */
		public function get_block_args( $block = 'all' ){
			if( 'all' == $block ){
				return $this->_blocks_args;
			}

			elseif( isset( $this->_blocks_args[ $block ] ) ){
				return $this->_blocks_args[ $block ];
			}

			return false;
		}

		/**
		 * @return string Default block cateogyr slug
		 */
		public function get_default_blocks_category_slug(){
			return $this->_category_slug;
		}

		/**
		 * Set the block arguments
		 *
		 * @param $args array The block argument
		 */
		public function set_block_args( $args ){
			foreach( $args as $block => $block_args ){

				/* === Add Default Keywords === */
				$default_keywords = array( 'mwb' );
				if( ! empty( $block_args['shortcode_name']  ) ){
					$default_keywords[] = $block_args['shortcode_name'];
				}

				$args[ $block ]['keywords'] = ! empty( $args[ $block ]['keywords'] ) ? array_merge( $args[ $block ]['keywords'], $default_keywords ) : $default_keywords;

				if( count( $args[ $block ]['keywords'] ) > 3 ){
					$args[ $block ]['keywords'] = array_slice($args[ $block ]['keywords'], 0, 3);
				}
				
				if( empty( $block_args['category'] ) ){
					//Add mwb block category
					$args[ $block ]['category'] = $this->get_default_blocks_category_slug();
				}

				if( isset( $block_args['attributes'] )  ){
					foreach( $block_args['attributes'] as $attr_name => $attributes ){
						// Set the do_shortcode args
						if( ! empty( $attributes['do_shortcode'] ) ){
							$args[ $block ]['attributes'][ $attr_name ] = true;
						}

						if( ! empty( $attributes['options'] ) && is_array( $attributes['options'] ) ){
							$options = array();
							foreach( $attributes['options'] AS $v => $l  ){
								//Prepare options array for react component
								$options[] = array(
									'label' => $l,
									'value' => $v,
								);
							}
							$args[ $block ]['attributes'][ $attr_name ]['options'] = $options;
						}

						if( empty( $attributes['remove_quotes'] ) ){
							$args[ $block ]['attributes'][ $attr_name ]['remove_quotes'] = false;
						}

						/* === Special Requirements for Block Type === */
						if( ! empty( $attributes['type'] ) ) {
							$args[ $block ]['attributes'][ $attr_name ]['blocktype'] = $attributes['type'];
							$args[ $block ]['attributes'][ $attr_name ]['type']      = 'string';

							switch( $attributes['type'] ){
								case 'select':
									//Add default value for multiple
									if( ! isset( $attributes['multiple'] ) ) {
										$args[ $block ]['attributes'][ $attr_name ]['multiple'] = false;
									}

									if( ! empty( $attributes['multiple'] ) ){
										$args[ $block ]['attributes'][ $attr_name ]['type'] = 'array';
									}
									break;

								case 'color':
								case 'colorpicker':
									if( ! isset( $attributes['disableAlpha'] ) ){
										//Disable alpha gradient for color picker
										$args[ $block ]['attributes'][ $attr_name ]['disableAlpha'] = true;
									}
									break;

								case 'number':
									$args[ $block ]['attributes'][ $attr_name ]['type'] = 'integer';
									break;

								case 'toggle':
								case 'checkbox':
									$args[ $block ]['attributes'][ $attr_name ]['type'] = 'boolean';
									break;
							}
						}
					}
				}
			}

			$this->_blocks_args = array_merge( $this->_blocks_args, $args );
		}

		/**
		 * Get a do_shortcode in ajax call to show block preview
		 *
		 * @param $args array The block argument
		 */
		public function do_shortcode(){
			$current_action = current_action();
			$sc             = ! empty( $_POST['shortcode'] ) ? $_POST['shortcode'] : '';

			if( ! apply_filters( 'mwb_plugin_fw_gutenberg_skip_shortcode_sanitize', false ) ){
				$sc = sanitize_text_field( stripslashes( $sc ) );
			}

			do_action( 'mwb_plugin_fw_gutenberg_before_do_shortcode', $sc, $current_action );
			echo do_shortcode( apply_filters( 'mwb_plugin_fw_gutenberg_shortcode', $sc, $current_action ) );
			do_action( 'mwb_plugin_fw_gutenberg_after_do_shortcode', $sc, $current_action );

			if( is_ajax() ){
				die();
			}
		}
	}
}

if ( ! function_exists( 'mwb_Gutenberg' ) ) {
	/**
	 * Main instance of plugin
	 *
	 * @return mwb_Gutenberg
	 * @since  1.0
	 * @author Andrea Grillo <andrea.grillo@mwbemes.com>
	 */
	function mwb_Gutenberg() {
		return mwb_Gutenberg::instance();
	}
}

mwb_Gutenberg();