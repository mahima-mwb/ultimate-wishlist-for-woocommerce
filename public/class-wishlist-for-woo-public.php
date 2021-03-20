<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://makewebbetter.com
 * @since      1.0.0
 *
 * @package    Wishlist_For_Woo
 * @subpackage Wishlist_For_Woo/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Wishlist_For_Woo
 * @subpackage Wishlist_For_Woo/public
 * @author     MakeWebBetter <https://makewebbetter.com>
 */
class Wishlist_For_Woo_Public {

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
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      string    $public_path    The public class location.
	 */
	public $public_path;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
		$this->public_path = plugin_dir_path( __FILE__ );
		$this->render      = Wishlist_For_Woo_Renderer::get_instance();
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wishlist-for-woo-public.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'wp-jquery-ui-dialog' );
		

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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
		$settings = Wishlist_For_Woo_Helper::get_settings();
		$settings = 200 == $settings[ 'status' ] ? $settings[ 'message' ] : $settings;

		$strings = Wishlist_For_Woo_Helper::get_strings();
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wishlist-for-woo-public.js', array( 'jquery' ), $this->version, false );
		wp_localize_script(
			$this->plugin_name,
			'mwb_wfw_obj',
			array(
				'ajaxurl'       => admin_url( 'admin-ajax.php' ),
				'mobile_view'   => wp_is_mobile(),
				'auth_nonce'    => wp_create_nonce( 'mwb_wfw_nonce' ),
				'strings'   	=> $strings ? $strings : array(),
				'settings'    	=> $settings ? $settings : array(),
				'user'    		=> get_current_user_id(),
				'permalink'     => ! empty( get_option( 'wfw-selected-page', '' ) ) ? get_page_link( get_option( 'wfw-selected-page', '' ) ) : false,
			)
		);

		wp_enqueue_script( $this->plugin_name . '-swal-alert', WISHLIST_FOR_WOO_URL . 'admin/js/swal.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'jquery-ui-dialog' );
		add_thickbox();

		wp_enqueue_script( 'wfw-pushy-sdk', plugin_dir_url( __FILE__ ) . 'js/wishlist-pushy-sdk.js', array( 'jquery' ), $this->version, false );
	}

	/**
 	 *  Initiate all functionalities after woocommerce is initiated.
	 * 
	 * @throws Some_Exception_Class If something interesting cannot happen
	 * @author MakeWebBetter <plugins@makewebbetter.com>
	 * @return null
	 */
	public function wishlist_init() {
		
		// Check if plugin enabled.
		$is_plugin_enabled = get_option( 'wfw-enable-plugin', 'yes' );
		if( is_admin() || 'yes' !== $is_plugin_enabled ) {
			return;
		}

		// Enable wishlist popup.
		$this->enable_wishlist_popup();

		// Enable wishlist at Public View.
		$this->enable_wishlist_on_site();

		// Initiate a wishlist shortcode.
		$this->init_shortcodes();

	}

	/**
 	 *  Enable a wishlist dynamic popup to manage newly added items.
	 * 
	 * @throws Exception If something interesting cannot happen
	 * @author MakeWebBetter <plugins@makewebbetter.com>
	 * @return null
	 */
	public function enable_wishlist_popup() {
	
		if( 'yes' == get_option( 'wfw-enable-popup', 'no' ) ) {
			
			// Wishlist popup view html.
			add_action( 'wp_footer', array( $this, 'render_wishlist_html' ) );
		}
	}

	/**
	 * Enable push notifications& enqueue its JS.
	 */
	public function enable_push_notifications() {

		$secret_key = get_option( 'wfw-push-notif-sk', '' );

		$file = ABSPATH . 'service-worker.js';

		if ( ! empty( $secret_key ) ) {

			if ( file_exists( $file ) ) {

				?>
				<script type='module'>
					// Register visitor's browser for push notifications
					Pushy.register({ appId: '<?php echo esc_html( $secret_key ); ?>' }).then(function (deviceToken) {
					}).catch(function (err) {
						// Handle registration errors
						console.error(err);
					});
				</script>
				<?php
			}
		}
	}


	/**
 	 *  Adds a wishlist dynamic popup to manage newly added items.
	 * 
	 * @throws Exception If something interesting cannot happen
	 * @author MakeWebBetter <plugins@makewebbetter.com>
	 * @return null
	 */
	public function render_wishlist_html() {
		
		wc_get_template(
			'partials/wishlist-for-woo-wishlist-processor.php',
			array(),
			'',
			$this->public_path
		);
	}

	/**
 	 *  Enable wishlist at Public View.
	 * 
	 * @throws Exception If something interesting cannot happen
	 * @author MakeWebBetter <plugins@makewebbetter.com>
	 * @return null
	 */
	public function enable_wishlist_on_site() {
		
		// Check if wishlist needs to be added on current view.
		$is_wishlist_enabled = get_option( 'wfw-view-type', 'icon' );

		if( empty( $is_wishlist_enabled ) ) {
			return;
		}

		$shop_hook = array();
		$single_hook = array();

		switch ( $is_wishlist_enabled ) {
			case 'icon' :
				$shop_hook = Wishlist_For_Woo_Renderer::get_icons_hooks( 'loop' );
				$shop_func = 'return_wishlist_icon';

				$single_hook = Wishlist_For_Woo_Renderer::get_icons_hooks( 'single' );
				$single_func = 'return_wishlist_icon';
				break;

			case 'button' :
				$position = get_option( 'wfw-loop-button-view', 'before_product_name' );
				$shop_hook = Wishlist_For_Woo_Renderer::get_button_hooks( 'loop', $position );
				$shop_func = 'return_wishlist_button';

				$position = get_option( 'wfw-product-button-view', 'before_add_to_cart' );
				$single_hook = Wishlist_For_Woo_Renderer::get_button_hooks( 'single', $position );
				$single_func = 'return_wishlist_button';
				break;
		}

		if( ! empty( $shop_hook ) && is_array( $shop_hook ) ) {
			add_action( $shop_hook[ 'hook' ] , array( $this->render, $shop_func ),  $shop_hook[ 'priority' ] );
		}

		if( ! empty( $single_hook ) && is_array( $single_hook ) ) {
			add_action( $single_hook[ 'hook' ] , array( $this->render, $single_func ),  $single_hook[ 'priority' ] );
		}
	}

	/**
 	 *  Enable wishlist shortcodes.
	 * 
	 * @throws Exception If something interesting cannot happen
	 * @author MakeWebBetter <plugins@makewebbetter.com>
	 * @return null
	 */
	public function init_shortcodes() {
		
		// Init shortcode class.
		$shortcode = new Wishlist_For_Woo_Shortcode_Manager( $this->public_path );

		// wishlist page view.
		add_shortcode( 'mwb_wfw_wishlist', array( $shortcode, 'init' ) );
	}

	/**
 	 *  Ajax Callback :: Adds a product to wishlist.
	 * 
	 * @throws Exception If something interesting cannot happen
	 * @author MakeWebBetter <plugins@makewebbetter.com>
	 * @return null
	 */
	public function UpdateWishlist() {
		
		// Nonce verification.
		check_ajax_referer( 'mwb_wfw_nonce', 'nonce' );	
		$formdata = ! empty( $_POST ) ?  map_deep( wp_unslash( $_POST ), 'sanitize_text_field' ) : array();

		unset( $formdata['nonce'] );

		$wishlist_manager = Wishlist_For_Woo_Crud_Manager::get_instance();
		
		if( 'add' == $formdata[ 'task' ] ) {

			$pid = ! empty( $formdata[ 'productId' ] ) ? $formdata[ 'productId' ] : '';
			if( empty( $pid ) ) {
				$result = array(
					'status'	=>	404,
					'message'	=>	esc_html__( 'Invalid Request', 'wishlist_for_woo' )
				);
				return json_encode( $result );	
			}

			$user = wp_get_current_user();
			$wishlist_query = $wishlist_manager->retrieve( 'owner', $user->user_email, array( 'properties' => array( 'default' => true ) ) );

			// Wishlist Exists, Add product.
			if( 200 == $wishlist_query[ 'status' ] && count( $wishlist_query[ 'message' ] ) ) {

				$wishlist = reset( $wishlist_query[ 'message' ] );
				$wid = ! empty( $wishlist['id'] ) ? $wishlist['id'] : '';

				if( empty( $wid ) ) {
					$result = array(
						'status'	=>	404,
						'message'	=>	esc_html__( 'Invalid Request', 'wishlist_for_woo' )
					);
					return json_encode( $result );
				}
				else {
					
					$wishlist_manager->id = $wid;
					$products = $wishlist_manager->get_prop( 'products' );
					$products = $products ? $products : array();
					$products = ! is_array( $products ) ? json_decode( json_encode( $products ), true ) : $products;
			
					array_push( $products, $pid );

					// Update Products again.
					$args[ 'products' ] = $products;

					$result = $wishlist_manager->update( $args );
				}
			}
	
			// Wishlist does not Exists, Create new and add product.
			else {
	
				$args = array(
					'title'			=> 'Wishlist #1',
					'products'		=> array( $formdata[ 'productId' ] ),
					'createdate'	=> date( "Y-m-d h:i:s" ),
					'modifieddate' 	=> date( "Y-m-d h:i:s" ),
					'owner' 		=> $user->user_email,
					'status' 		=> 'private',
					'collaborators' => array(),
					'properties' 	=> array( 'default' => true ),
				);
	
				$result = $wishlist_manager->create( $args );
			}

		}
		elseif ( 'remove'  == $formdata[ 'task' ] ) {

			$wid = ! empty( $formdata[ 'wishlistId' ] ) ? $formdata[ 'wishlistId' ] : '';
			$pid = ! empty( $formdata[ 'productId' ] ) ? $formdata[ 'productId' ] : '';

			if( empty( $wid ) || ! is_numeric( $wid ) ) {

				return array(
					'status'	=>	404,
					'message'	=>	esc_html__( 'Invalid Request', 'wishlist_for_woo' )
				);
			}

			// Assign Id to object.
			$wishlist_manager->id = $wid;

			$products = $wishlist_manager->get_prop( 'products' );
			$products = ! empty( $products ) ? $products : array();
			$products = ! is_array( $products ) ? json_decode( json_encode( $products ), true ) : $products;
	
			if( ! empty( $products ) ) {

				$found = array_search( $pid, $products );

				if( false !== $found ) {
					unset( $products[ $found ] );
				}
				
				// Update Products again.
				$args[ 'products' ] = $products;
				$result = $wishlist_manager->update( $args );
			}
			else {
				$result = array(
					'status'	=>	403,
					'message'	=>	esc_html__( 'Unable to access data.', 'wishlist_for_woo' ),
				);
			}
		}

		// Add a flag that this Wishlist Id was updated.
		$result[ 'id' ] = $wishlist_manager->id;
		echo json_encode( $result );
		wp_die();
	}


	/**
	 * Ajax callback for Meta Updates.
	 */
	public function UpdateWishlistMeta() {

		// Nonce verification.
		check_ajax_referer( 'mwb_wfw_nonce', 'nonce' );

		$result = array();

		$formdata = ! empty( $_POST['formData'] ) ?  map_deep( wp_unslash( $_POST['formData'] ), 'sanitize_text_field' ) : false;

		$formdata = $this->parse_serialised_data( $formdata );

		$wishlist_manager = Wishlist_For_Woo_Crud_Manager::get_instance();
		$wishlist_manager->id = $formdata[ 'wid' ] ? $formdata[ 'wid' ] : false;
		$properties = $wishlist_manager->get_prop( 'properties' );
		$properties = ! is_array( $properties ) ? json_decode( json_encode( $properties ), true ) : $properties;
		$properties[  'comments' ] = $properties[  'comments' ] ? $properties[  'comments' ] : array();

		$properties[  'comments' ][ $formdata[ 'product' ] ] = $formdata;

		unset( $properties[  'comments' ][ $formdata[ 'wid' ] ][ 'wid' ] );
		unset( $properties[  'comments' ][ $formdata[ 'wid' ] ][ 'product' ] );

		$args['properties'] = $properties;

		$response = $wishlist_manager->update( $args );

		if ( 200 == $response['status'] ) {

			// $properties
			$result = array(
				'status'  => true,
				'message' => esc_html__( 'Comment added successfully', 'wishlist_for_woo' ),
			);
		} else {
			$result = array(
				'status'  => false,
				'message' => esc_html__( 'There\'s some problem adding comment, try again', 'wishlist_for_woo' ),
			);
		}

		wp_send_json( $result );
	}

	/**
	 * Ajax callback for Email Invitation.
	 */
	public function InvitationEmail() {

		// Nonce verification.
		check_ajax_referer( 'mwb_wfw_nonce', 'nonce' );

		$result = array();

		$email = ! empty( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : false;
		$id    = ! empty( $_POST['id'] ) ? sanitize_text_field( wp_unslash( $_POST['id'] ) ) : '';

		if ( empty( $email ) || empty( $id ) ) {

			$result = array(
				'status'  => false,
				'message' => esc_html__( 'Email field cannot be empty', 'wishlist_for_woo' ),
			);

		}

		if ( false != $email && ! empty( $id ) ) {

			$wishlist_manager = Wishlist_For_Woo_Crud_Manager::get_instance( $id );

			$wishlist_title = $wishlist_manager->get_prop( 'title' );
			$collaborators  = $wishlist_manager->get_prop( 'collaborators' );

			$link = get_permalink( get_option( 'wfw-selected-page', '' ) );

			if ( ! empty( $link ) ) {
				$link = add_query_arg(
					array(
						'wl-ref' => Wishlist_For_Woo_Helper::encrypter( $id ),
					),
					$link
				);

			}

			$subject = apply_filters( 'wfw_invite_email_subject', 'Join as a collaborator' );
			$message = apply_filters( 'wfw_invite_email_messgae', 'You are now added as a collaborator to this wishlist ' . $wishlist_title . '. Visit the page here ' . $link );

			if ( ! function_exists( 'wp_mail' ) ) {

				$result = array(
					'status'  => false,
					'message' => esc_html__( 'At the moment, you are not allowed to send this mail', 'wishlist_for_you' ),
				);
			}

			wp_mail(
				$email,
				$subject,
				$message,
				array(
					'From: ' . get_bloginfo( 'name' ) . ' <' . get_bloginfo( 'admin_email' ) . '>'
				)
			);

			array_push( $collaborators, $email );

			$args['collaborators'] = $collaborators;

			$update = $wishlist_manager->update( $args );

			if ( 200 == $update['status'] ) {

				$result = array(
					'status'  => true,
					'message' => esc_html__( 'Invite sent successfully', 'wishlist_for_woo' ),
				);
			} else {
				$result = array(
					'status'  => false,
					'message' => esc_html__( 'Invitation failed', 'wishlist_for_woo' ),
				);
			}

			wp_send_json( $result );
		}
	}

	/**
	 * Details popup modal content.
	 */
	public function wfw_get_item_details() {

		// Nonce verification.
		check_ajax_referer( 'mwb_wfw_nonce', 'nonce' );

		$wid     = ! empty( $_POST['wId'] ) ? sanitize_text_field( wp_unslash( $_POST['wId'] ) ) : '';
		$prod_id = ! empty( $_POST['pro_id'] ) ? sanitize_text_field( wp_unslash( $_POST['pro_id'] ) ) : '';

		$result = array();

		if ( empty( $wid ) || empty( $prod_id ) ) {

			$result = array(
				'status'  => false,
				'message' => esc_html__( 'No data found', 'whishlist_for_woo' ),
			);

		}

		if ( ! empty( $wid ) && ! empty( $prod_id ) ) {

			$wishlist_manager = Wishlist_For_Woo_Crud_Manager::get_instance( $wid );

			$properties = $wishlist_manager->get_prop( 'properties' );

			if ( ! empty( $properties ) ) {
				if ( isset( $properties->comments ) ) {

					if ( ! empty( $properties->comments->$prod_id ) ) {

						if ( ! empty( $properties->comments->$prod_id->comment ) ) {

							$result = array(
								'status'  => true,
								'message' => $properties->comments->$prod_id->comment,
							);
						} else {
							$result = array(
								'status'  => false,
								'message' => esc_html__( 'No comments found for this product. ', 'wishlist_for_woo' ),
							);
						}
					} else {
						$result = array(
							'status'  => false,
							'message' => esc_html__( 'No comments found for this product. ', 'wishlist_for_woo' ),
						);
					}
				} else {
					$result = array(
						'status'  => false,
						'message' => esc_html__( 'No comments found.', 'wishlist_for_woo' ),
					);
				}
			} else {
				$result = array(
					'status'  => false,
					'message' => esc_html__( 'No properties found.', 'wishlist_for_woo' ),
				);
			}
		}

		wp_send_json( $result );

	}

	/**
	 * Add to cart wish list product.
	 */
	public function add_to_cart_wish_prod() {

		// Nonce verification.
		check_ajax_referer( 'mwb_wfw_nonce', 'nonce' );

		$wid     = ! empty( $_POST['wId'] ) ? sanitize_text_field( wp_unslash( $_POST['wId'] ) ) : '';
		$prod_id = ! empty( $_POST['pro_id'] ) ? sanitize_text_field( wp_unslash( $_POST['pro_id'] ) ) : '';

		$result = array();

		if ( empty( $wid ) || empty( $prod_id ) ) {

			$result = array(
				'status'  => false,
				'message' => esc_html__( 'Something went wrong, try again', 'whishlist_for_woo' ),
			);

		}

		if ( ! empty( $wid ) && ! empty( $prod_id ) ) {

			$wishlist_manager = Wishlist_For_Woo_Crud_Manager::get_instance( $wid );

			$products = $wishlist_manager->get_prop( 'products' );
			$products = ! empty( $products ) ? $products : array();
			$products = ! is_array( $products ) ? json_decode( json_encode( $products ), true ) : $products;

			if ( ! empty( $products ) && is_array( $products ) ) {

				foreach ( $products as $product_id ) {

					if ( $prod_id == $product_id ) {

						$product = wc_get_product( $prod_id );

						if ( $product ) {

							if ( 'instock' == $product->get_stock_status() || $product->backorders_allowed() ) {

								if ( $product->is_type( 'variable' ) ) {

									$result = array(
										'status'   => true,
										'variable' => true,
										'message'  => get_permalink( $prod_id ),
									);

								} elseif ( function_exists( 'WC' ) ) {

									WC()->cart->add_to_cart( $prod_id );

									$result = array(
										'status'   => true,
										'variable' => false,
										'message'  => wc_get_checkout_url(),
									);
								}
							}
						} else {
							$result = array(
								'status'  => false,
								'message' => esc_html__( 'Product does not exists', 'wishlist_for_woo' ),
							);
						}
					}
				}
			}
		}

		wp_send_json( $result );

	}

	/**
	 * Remove product and go to checkout.
	 */
	public function go_to_checkout_wish_prod() {

		// Nonce verification.
		check_ajax_referer( 'mwb_wfw_nonce', 'nonce' );

		$wid     = ! empty( $_POST['wId'] ) ? sanitize_text_field( wp_unslash( $_POST['wId'] ) ) : '';
		$prod_id = ! empty( $_POST['pro_id'] ) ? sanitize_text_field( wp_unslash( $_POST['pro_id'] ) ) : '';

		$result = array();

		if ( empty( $wid ) || empty( $prod_id ) ) {

			$result = array(
				'status'  => false,
				'message' => esc_html__( 'Something went wrong, try again', 'whishlist_for_woo' ),
			);

		}

		if ( ! empty( $wid ) && ! empty( $prod_id ) ) {

			$wishlist_manager = Wishlist_For_Woo_Crud_Manager::get_instance( $wid );

			$products = $wishlist_manager->get_prop( 'products' );
			$products = ! empty( $products ) ? $products : array();
			$products = ! is_array( $products ) ? json_decode( json_encode( $products ), true ) : $products;

			if ( ! empty( $products ) && is_array( $products ) ) {

				foreach ( $products as $key => $product_id ) {

					if ( $prod_id == $product_id ) {
						unset( $products[ $key ] );

						$args['products'] = array_values( $products );

						$response = $wishlist_manager->update( $args );

						if ( 200 == $response['status'] ) {

							$result = array(
								'status'  => true,
								'message' => wc_get_checkout_url(),
							);
						} else {
							$result = array(
								'status'  => false,
								'message' => esc_html__( 'Something went wrong', 'wishlist_for_woo' ),
							);
						}
					}
				}
			}
		}

		wp_send_json( $result );

	}

	/**
	 * Delete product from wishlist.
	 */
	public function delete_wish_prod() {

		// Nonce verification.
		check_ajax_referer( 'mwb_wfw_nonce', 'nonce' );

		$wid     = ! empty( $_POST['wId'] ) ? sanitize_text_field( wp_unslash( $_POST['wId'] ) ) : '';
		$prod_id = ! empty( $_POST['pro_id'] ) ? sanitize_text_field( wp_unslash( $_POST['pro_id'] ) ) : '';

		$result = array();

		if ( empty( $wid ) || empty( $prod_id ) ) {

			$result = array(
				'status'  => false,
				'message' => esc_html__( 'Something went wrong, try again', 'whishlist_for_woo' ),
			);

		}

		if ( ! empty( $wid ) && ! empty( $prod_id ) ) {

			$wishlist_manager = Wishlist_For_Woo_Crud_Manager::get_instance( $wid );

			$products = $wishlist_manager->get_prop( 'products' );
			$products = ! empty( $products ) ? $products : array();
			$products = ! is_array( $products ) ? json_decode( json_encode( $products ), true ) : $products;

			if ( ! empty( $products ) && is_array( $products ) ) {

				foreach ( $products as $key => $product_id ) {

					if ( $prod_id == $product_id ) {
						unset( $products[ $key ] );

						$args['products'] = array_values( $products );

						$response = $wishlist_manager->update( $args );

						if ( 200 == $response['status'] ) {

							$result = array(
								'status'  => true,
								'message' => esc_html__( 'Product deleted successfully', 'wishlist_for_woo' ),
							);
						} else {
							$result = array(
								'status'  => false,
								'message' => esc_html__( 'Something went wrong', 'wishlist_for_woo' ),
							);
						}
					}
				}
			}
		}

		wp_send_json( $result );
	}

	/**
	 * Delete current wish list.
	 */
	public function delete_current_wishlist() {

		// Nonce verification.
		check_ajax_referer( 'mwb_wfw_nonce', 'nonce' );

		$wid = ! empty( $_POST['wId'] ) ? sanitize_text_field( wp_unslash( $_POST['wId'] ) ) : '';

		$result = array();

		if ( empty( $wid ) ) {

			$result = array(
				'status'  => false,
				'message' => esc_html__( 'Something went wrong, try again', 'whishlist_for_woo' ),
			);

		}

		if ( ! empty( $wid ) ) {

			$wishlist_manager = Wishlist_For_Woo_Crud_Manager::get_instance( $wid );

			$response = $wishlist_manager->delete();

			if ( 200 == $response['status'] ) {

				$result = array(
					'status'  => true,
					'reload'  => get_permalink( get_option( 'wfw-selected-page', '' ) ),
					'message' => esc_html__( 'Wishlist deleted successfully', 'wishlist_for_woo' ),
				);
			} else if ( 400 == $response['status'] ) {

				$result = array(
					'status'  => false,
					'message' => esc_html__( 'Something went wrong, try again', 'wishlist_for_woo' ),
				);
			} else {
				$result = array(
					'status'  => false,
					'message' => esc_html__( 'Technical error, try reloading the page.', 'wishlist_for_woo' ),
				);
			}
		}

		wp_send_json( $result );
	}

	/**
	 * Set wishlist as default.
	 */
	public function wishlist_set_default() {

		// Nonce verification.
		check_ajax_referer( 'mwb_wfw_nonce', 'nonce' );

		$wid = ! empty( $_POST['wId'] ) ? sanitize_text_field( wp_unslash( $_POST['wId'] ) ) : '';

		$result = array();

		if ( empty( $wid ) ) {

			$result = array(
				'status'  => false,
				'message' => esc_html__( 'Something went wrong, try again', 'whishlist_for_woo' ),
			);

		}

		if ( ! empty( $wid ) ) {

			$wishlist_manager = Wishlist_For_Woo_Crud_Manager::get_instance( $wid );

			$result = array(
				'status'  => true,
				'message' => esc_html__( 'Already the default list', 'wishlist_for_woo' ),
			);
		}

		wp_send_json( $result );

	}

	/**
	 * Parse Serialised data.
	 */
	public function parse_serialised_data( $array=array() ) {
		$result = array();
		if( ! empty( $array ) && is_array( $array ) ) {
			foreach ( $array as $key => $value ) {
				
				$result[ $value[ 'name' ] ] = $value[ 'value' ];
			}
		}

		return $result;
	}
// End of class.
}
