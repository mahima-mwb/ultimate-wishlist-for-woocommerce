<?php

/**
 * The core plugin templates are handled here.
 *
 *
 * @since      1.0.0
 * @package    Wishlist_For_Woo
 * @subpackage Wishlist_For_Woo/includes
 * @author     MakeWebBetter <https://makewebbetter.com>
 */
class Wishlist_For_Woo_Template_Manager {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
	}

	/**
 	 *  Add a header panel for all screens in plugin.
	 *
	 * @author MakeWebBetter <plugins@makewebbetter.com>
	 * @return html
	 */
	public function render_header_content_start() {

		ob_start(); ?>
		<!-- Header Section -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<main class="mwb-wfw-main">
			<header class="mwb-wfw-header">
				<h1 class="mwb-wfw-header__title"><?php esc_html_e( 'Wishlist for Woocommerce', WISHLIST_FOR_WOO_TEXTDOMAIN ); ?></h1>
				<span class="mwb-wfw-version"><?php echo sprintf( 'v%s', esc_html( WISHLIST_FOR_WOO_VERSION ) ); ?></span>
			</header>
			<!-- End of Header Section -->
		<?php echo ob_get_clean();
	}

	/**
 	 *  Add a header panel for all screens in plugin.
	 *
	 * @author MakeWebBetter <plugins@makewebbetter.com>
	 * @return html
	 */
	public function render_navigation_tab() {
		
		ob_start(); ?>
		<!-- Tabs Section -->
		<nav class="mwb-wfw-navbar">
			<div class="mwb-wfw-toggler__wrap">
				<button class="mwb-wfw-toggler">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>
			<div class="mwb-wfw-nav-collapse">
				<ul class="mwb-wfw-nav mwb-wfw-nav-tabs" role="tablist">
					<?php $tabs = $this->retrieve_nav_tabs(); ?>
					<?php if( ! empty( $tabs ) && is_array( $tabs ) ) : ?>
						<?php foreach ( $tabs as $href => $label ) : ?>
							<li class="mwb-wfw-nav-item">
								<a class="mwb-wfw-nav-link" href="#<?php echo esc_html( $href ); ?>"><?php echo esc_html( $label ); ?></a>
							</li>
						<?php endforeach; ?>
					<?php endif; ?>
				</ul>
			</div>
		</nav>
		<!-- End of Tabs Section -->
		<?php echo ob_get_clean();	
	}

	/**
 	 *  Selected Tab settings Screen.
	 *
	 * @author MakeWebBetter <plugins@makewebbetter.com>
	 * @return html
	 */
	public function render_settings_screen() {
		
		ob_start(); ?>
		<div class="mwb-wfw-container">
			<div class="mwb-wfw-row">
				<div class="mwb-wfw-desc">
					<form method="post" action="#" class="mwb-wfw-output-form"></form>
					<div class="mwb-wfw-desc--preloader">
						<img src="<?php echo esc_url( WISHLIST_FOR_WOO_URL . 'admin/images/preloader.gif' ) ?>" alt="loader">
						<h4><?php esc_html_e( 'Loading settings please wait...', WISHLIST_FOR_WOO_TEXTDOMAIN ); ?></h4>
					</div>
				</div>
				<?php  do_action( 'mwb_wfw_helpdesk' ); ?>
			</div>
		</div>
		<?php echo ob_get_clean();
	}

	/**
 	 *  Helpdesk section in sidebar.
	 *
	 * @author MakeWebBetter <plugins@makewebbetter.com>
	 * @return html
	 */
	public function render_helpdesk_sidebar() {
		
		ob_start(); ?>
		   <div class="mwb-wfw-sidebar">
				<div class="mwb-wfw-helpdesk__icon">
					<img src="<?php echo esc_url( WISHLIST_FOR_WOO_URL . 'admin/images/customer-service-icon.jpg' ) ?>" class="mwb-wfw-helpdesk-btn" />
				</div>
				<h2>help desk </h2>
				<ul class="mwb-wfw-sidebar__items">
					<li class="mwb-wfw-sidebar__links"><a href="javascript:void(0)"><?php esc_html_e( 'go pro', WISHLIST_FOR_WOO_TEXTDOMAIN ); ?><span> &#8594;</span></a></li>
					<li class="mwb-wfw-sidebar__links"><a href="javascript:void(0)"><?php esc_html_e( 'see docs', WISHLIST_FOR_WOO_TEXTDOMAIN ); ?><span> &#8594;</span></a></li>
					<li class="mwb-wfw-sidebar__links"><a href="javascript:void(0)"><?php esc_html_e( 'see tutorial', WISHLIST_FOR_WOO_TEXTDOMAIN ); ?> <span> &#8594;</span></a></li>
				</ul>
				<div class="mwb-wfw-sidebar__connect">
					<a href="javascript:void(0)"><?php esc_html_e( 'connect with us in one click', WISHLIST_FOR_WOO_TEXTDOMAIN ); ?></a>
					<a href="javascript:void(0)" class="mwb-wfw-skype__icon"><img src="<?php echo esc_url( WISHLIST_FOR_WOO_URL . 'admin/images/skype_logo.png' ) ?>" alt="skype-log"><span>connect</span></a>
				</div>
			</div>
		<?php echo ob_get_clean();
	}	

	/**
 	 *  Add a header panel end for all screens in plugin.
	 *
	 * @author MakeWebBetter <plugins@makewebbetter.com>
	 * @return html
	 */
	public function render_header_content_end() {
		
		ob_start(); ?>
		<!-- Header Section -->
			<div class="mwb-wfw_save-wrapper is-hidden">
				<span><a href="javascript:void(0);" class="mwb-wfw_save-link"><?php esc_html_e( 'SAVE', WISHLIST_FOR_WOO_TEXTDOMAIN ); ?></a>
				<a href="javascript:void(0);" class="mwb-wfw_cancel-link"><?php esc_html_e( 'CANCEL', WISHLIST_FOR_WOO_TEXTDOMAIN ); ?></a></span>
				<span class="mwb-wfw_save-text is-hidden"><?php esc_html_e( 'You have saved your data!', WISHLIST_FOR_WOO_TEXTDOMAIN ); ?></span>
			</div>
		</main>
		<!-- End of Header Section -->
		<?php echo ob_get_clean();
	}

	/**
 	 *  Get all nav tabs of current screen.
	 *
	 * @author MakeWebBetter <plugins@makewebbetter.com>
	 * @return html
	 */
	public function retrieve_nav_tabs() {

		$current_screen = ! empty( $_GET[ 'page' ] ) ? $_GET[ 'page' ] : false;
		switch ( $current_screen ) {
			case 'wfw-config-portal':
				$tabs = array(
					'general'			=>	esc_html__( 'General', WISHLIST_FOR_WOO_TEXTDOMAIN ),
					'social_sharing'	=>	esc_html__( 'Social Sharing', WISHLIST_FOR_WOO_TEXTDOMAIN ),
					'push_notify'		=>	esc_html__( 'Push Notification', WISHLIST_FOR_WOO_TEXTDOMAIN ),
					'advance_feature'	=>	esc_html__( 'Advance Features', WISHLIST_FOR_WOO_TEXTDOMAIN ),
					'crm'				=>	esc_html__( 'CRM Configuration', WISHLIST_FOR_WOO_TEXTDOMAIN ),
				);
				break;
			
			case 'wfw-performance-reporting':
				$tabs = array(
					'general'			=>	esc_html__( 'Testing', WISHLIST_FOR_WOO_TEXTDOMAIN ),
					'social_sharing'	=>	esc_html__( 'Social Testing', WISHLIST_FOR_WOO_TEXTDOMAIN ),
					'push_notify'		=>	esc_html__( 'Push Testing', WISHLIST_FOR_WOO_TEXTDOMAIN ),
					'advance_feature'	=>	esc_html__( 'Advance Testing', WISHLIST_FOR_WOO_TEXTDOMAIN ),
					'crm'				=>	esc_html__( 'CRM Configuration', WISHLIST_FOR_WOO_TEXTDOMAIN ),
				);
				break;
				
			case 'wfw-plugin-overview':
				$tabs = array(
					'general'			=>	esc_html__( 'Overview', WISHLIST_FOR_WOO_TEXTDOMAIN ),
					'social_sharing'	=>	esc_html__( 'Overview Testing', WISHLIST_FOR_WOO_TEXTDOMAIN ),
					'push_notify'		=>	esc_html__( 'Push overview', WISHLIST_FOR_WOO_TEXTDOMAIN ),
					'advance_feature'	=>	esc_html__( 'Advance overview', WISHLIST_FOR_WOO_TEXTDOMAIN ),
					'crm'				=>	esc_html__( 'CRM overview', WISHLIST_FOR_WOO_TEXTDOMAIN ),
				);
				break;
		}

		return apply_filters( $current_screen . '-tab', $tabs );
	}

	/**
 	 *  Get all settings of General Tab.
	 *
	 * @author MakeWebBetter <plugins@makewebbetter.com>
	 * @return array
	 */
	public static function get_general_sections_settings() {
		
		$settings = array();

		// Section start.
		$settings[] = array(
			'title' => esc_html__( 'General Settings', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			'type'  => 'title',
		);

		// Toggle :: Enable/Disable Plugin.
		$settings[] = array(
			'title' 				=> esc_html__( 'Enable /Disable Plugin', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			'class' 				=> 'mwb-wfw-toggle-checkbox',
			'type'  				=> 'checkbox',
			'desc_tip' 				=> true,
			'value'   				=> get_option( 'wfw-enable-plugin', 'yes' ),
			'id'    				=> 'wfw-enable-plugin',
			'desc'  				=> esc_html__( 'Enable/Disable the complete plugin functionality.', WISHLIST_FOR_WOO_TEXTDOMAIN ),
		);

		// Toggle :: Enable Popup for Product added in wishlist Plugin.
		$settings[] = array(
			'title' 				=> esc_html__( 'Enable Wishlist Popup', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			'class' 				=> 'mwb-wfw-toggle-checkbox',
			'type'  				=> 'checkbox',
			'desc_tip' 				=> true,
			'value'   				=> get_option( 'wfw-enable-popup', '' ),
			'id'    				=> 'wfw-enable-popup',
			'desc'  				=> esc_html__( 'Show Item added in wishlist as popup after adding in list.', WISHLIST_FOR_WOO_TEXTDOMAIN ),
		);

		// Subheading ::For Preview Settings.
		$settings[]		=	array(
			'type'	=>	'sub-heading',
			'value'	=>	esc_html__( 'Wishlist Position And Preview', WISHLIST_FOR_WOO_TEXTDOMAIN )
		);

		// Select :: How to show the wishlists on frontend.
		$settings[] = array(
			'title'             => esc_html__( 'Wishlist View Type', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			'type'              => 'select',
			'desc'              => esc_html__( 'Select how you want to show the wishlist for customers.', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			'options'           => array(
									''			=>	esc_html__( 'No options Selected', WISHLIST_FOR_WOO_TEXTDOMAIN ),
									'icon'		=>	esc_html__( 'Icon over Product Image', WISHLIST_FOR_WOO_TEXTDOMAIN ),
									'button'	=>	esc_html__( 'Add to Wishlist button', WISHLIST_FOR_WOO_TEXTDOMAIN ),
								),
			'desc_tip'          => true,
			'class'		        => 'mwb-wfw-select',
			'id'   				=> 'wfw-view-type',
			'value'   			=> get_option( 'wfw-view-type', 'icon' ),
			'custom_attributes' => array( 'dependency-type' => get_option( 'wfw-view-type', 'icon' ) ),
		);

		// Select :: Which icon to use.
		$settings[] = array(
			'title'             => esc_html__( 'Wishlist Interface Icon', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			'type'              => 'select',
			'desc'              => esc_html__( 'Select which icon you want for the wishlist interface.', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			'options'           => array(
										''			=>	esc_html__( 'No options Selected', WISHLIST_FOR_WOO_TEXTDOMAIN ),
										'heart'		=>	esc_html__( 'Heart Icon', WISHLIST_FOR_WOO_TEXTDOMAIN ),
										'shopping'		=>	esc_html__( 'Shopping Icon', WISHLIST_FOR_WOO_TEXTDOMAIN ),
										'cart'		=>	esc_html__( 'Cart Icon', WISHLIST_FOR_WOO_TEXTDOMAIN ),
										'star'		=>	esc_html__( 'Star Icon', WISHLIST_FOR_WOO_TEXTDOMAIN ),
										'tag'		=>	esc_html__( 'Tag Icon', WISHLIST_FOR_WOO_TEXTDOMAIN ),
										'thumbsup'		=>	esc_html__( 'Like Icon', WISHLIST_FOR_WOO_TEXTDOMAIN ),
										'bell'		=>	esc_html__( 'Bell Icon', WISHLIST_FOR_WOO_TEXTDOMAIN ),
										'eye'		=>	esc_html__( 'Eye Icon', WISHLIST_FOR_WOO_TEXTDOMAIN ),
								),
			'desc_tip'          => true,
			'class'		        => 'mwb-wfw-select wfw-view-type-dependent',
			'id'   				=> 'wfw-icon-view',
			'value'   			=> get_option( 'wfw-icon-view-type', 'heart' ),
			'custom_attributes' => array( 'dependent' => 'dependency-type-icon' ),
		);

		// Select :: Where to show button on loops.
		$settings[] = array(
			'title'             => esc_html__( 'Wishlist on Loops', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			'type'              => 'select',
			'desc'              => esc_html__( 'Select where wishlist button should be shown on woocommerce loops or shops.', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			'options'           => array(
									''						=>	esc_html__( 'No options Selected', WISHLIST_FOR_WOO_TEXTDOMAIN ),
									'before_product_name'	=>	esc_html__( 'Before Product Title', WISHLIST_FOR_WOO_TEXTDOMAIN ),
									'after_product_name'	=>	esc_html__( 'After Product Title', WISHLIST_FOR_WOO_TEXTDOMAIN ),
									'before_add_to_cart'	=>	esc_html__( 'Before Add To Cart Button', WISHLIST_FOR_WOO_TEXTDOMAIN ),
									'before_product_loop'	=>	esc_html__( 'Before Product Section', WISHLIST_FOR_WOO_TEXTDOMAIN ),
								),
			'desc_tip'          => true,
			'class'		        => 'mwb-wfw-select wfw-view-type-dependent',
			'id'   				=> 'wfw-loop-button-view',
			'value'   			=> get_option( 'wfw-loop-button-view', 'before_product_name' ),
			'custom_attributes' => array( 'dependent' => 'dependency-type-button' ),
		);

		// Select :: Where to show button on product pages.
		$settings[] = array(
			'title'             => esc_html__( 'Wishlist on Product Page', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			'type'              => 'select',
			'desc'              => esc_html__( 'Select where wishlist button should be shown on woocommerce products page.', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			'options'           => array(
									''						=>	esc_html__( 'No options Selected', WISHLIST_FOR_WOO_TEXTDOMAIN ),
									'before_add_to_cart'	=>	esc_html__( 'Before Add To Cart Button', WISHLIST_FOR_WOO_TEXTDOMAIN ),
									'after_add_to_cart'		=>	esc_html__( 'After Add To Cart Button', WISHLIST_FOR_WOO_TEXTDOMAIN ),
									'before_product_name'	=>	esc_html__( 'Before Product Title', WISHLIST_FOR_WOO_TEXTDOMAIN ),
									'after_product_name'	=>	esc_html__( 'After Product Title', WISHLIST_FOR_WOO_TEXTDOMAIN ),
									'after_product_price'	=>	esc_html__( 'After Product Price', WISHLIST_FOR_WOO_TEXTDOMAIN ),
								),
			'desc_tip'          => true,
			'class'             => 'mwb-wfw-select wfw-view-type-dependent',
			'id'                => 'wfw-product-button-view',
			'value'             => get_option( 'wfw-product-button-view', 'before_add_to_cart' ),
			'custom_attributes' => array( 'dependent' => 'dependency-type-button' ),
		);

		// Select :: Where to show button on product pages.
		$settings[] = array(
			'type'  => 'sub-heading',
			'value' => esc_html__( 'Wishlist Page', WISHLIST_FOR_WOO_TEXTDOMAIN )
		);

		global $wpdb;

		$sql           = "SELECT `ID` FROM `wp_posts` WHERE `post_content` LIKE '%[mwb_wfw_wishlist]%' AND `post_type` = 'page' AND `post_status` = 'publish'";
		$wishlist_page = $wpdb->get_results( $sql );
		$page_option   = array();

		if( $wishlist_page ) {

			foreach ( $wishlist_page as $key => $post ) {
				$page_option[ $post->ID ] = get_the_title( $post->ID );
			}
		}

		$settings[] = array(
			'title'    => esc_html__( 'Wishlist Page', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			'type'     => 'select',
			'desc'     => esc_html__( 'Select the page where wishlist should be shown/handled.', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			'options'  => $page_option,
			'desc_tip' => true,
			'class'	   => 'mwb-wfw-select mwb-wfw-select-page',
			'id'       => 'wfw-selected-page',
			'value'    => get_option( 'wfw-selected-page', '' ),
		);

		// End of Settings.
		$settings[] = array(
			'type' => 'sectionend',
		);

		return $settings;
	}

	/**
 	 *  Get all settings of Social Sharing Tab.
	 *
	 * @author MakeWebBetter <plugins@makewebbetter.com>
	 * @return array
	 */
	public static function get_social_sharing_sections_settings() {

		// Section start.
		$settings[] = array(
			'title' => esc_html__( 'Push Notifications', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			'type'  => 'title',
		);

		// Toggle :: Enable/Disable Facebook share.
		$settings[] = array(
			'title'    => esc_html__( 'Faceook share', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			'class'    => 'mwb-wfw-toggle-checkbox',
			'type'     => 'checkbox',
			'desc_tip' => true,
			'value'    => get_option( 'wfw-enable-fb-share', 'yes' ),
			'id'       => 'wfw-enable-fb-share',
			'desc'     => esc_html__( 'Enable/Disable the Facebook share functionality.', WISHLIST_FOR_WOO_TEXTDOMAIN ),
		);

		// Input :: Facebook icon color.
		$settings[] = array(
			'title'    => esc_html__( 'Faceook Icon color', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			'class'    => 'mwb-wfw-color',
			'type'     => 'color',
			'desc_tip' => true,
			'value'    => get_option( 'wfw-enable-fb-color', '' ),
			'id'       => 'wfw-enable-fb-color',
			'desc'     => esc_html__( 'Input Facebook icon color.', WISHLIST_FOR_WOO_TEXTDOMAIN ),
		);

		// Input :: Facebook icon size.
		$settings[] = array(
			'title'    => esc_html__( 'Faceook Icon size', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			'class'    => 'mwb-wfw-select',
			'type'     => 'select',
			'options'  => array(
				'small'  => esc_html__( 'Small', 'wishlist_for_woo' ),
				'medium' => esc_html__( 'Meduim', 'wishlist_for_woo' ),
				'Large'  => esc_html__( 'Large', 'wishlist_for_woo' ),
			),
			'desc_tip' => true,
			'value'    => get_option( 'wfw-enable-fb-size', '' ),
			'id'       => 'wfw-enable-fb-size',
			'desc'     => esc_html__( 'Input Facebook icon size.', WISHLIST_FOR_WOO_TEXTDOMAIN ),
		);

		// Toggle :: Enable/Disable Whatsapp share.
		$settings[] = array(
			'title'    => esc_html__( 'WhatsApp share', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			'class'    => 'mwb-wfw-toggle-checkbox',
			'type'     => 'checkbox',
			'desc_tip' => true,
			'value'    => get_option( 'wfw-enable-whatsapp-share', 'yes' ),
			'id'       => 'wfw-enable-whatsapp-share',
			'desc'     => esc_html__( 'Enable/Disable the WhatsApp share functionality.', WISHLIST_FOR_WOO_TEXTDOMAIN ),
		);

		// Input :: Whatsapp icon color.
		$settings[] = array(
			'title'    => esc_html__( 'WhatsApp Icon color', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			'class'    => 'mwb-wfw-color',
			'type'     => 'color',
			'desc_tip' => true,
			'value'    => get_option( 'wfw-enable-whatsapp-color', '' ),
			'id'       => 'wfw-enable-whatsapp-color',
			'desc'     => esc_html__( 'Input WhatsApp icon color.', WISHLIST_FOR_WOO_TEXTDOMAIN ),
		);

		// Input :: Whatsapp icon size.
		$settings[] = array(
			'title'    => esc_html__( 'WhatsApp Icon size', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			'class'    => 'mwb-wfw-select',
			'type'     => 'select',
			'options'  => array(
				'small'  => esc_html__( 'Small', 'wishlist_for_woo' ),
				'medium' => esc_html__( 'Meduim', 'wishlist_for_woo' ),
				'Large'  => esc_html__( 'Large', 'wishlist_for_woo' ),
			),
			'desc_tip' => true,
			'value'    => get_option( 'wfw-enable-whatsapp-size', '' ),
			'id'       => 'wfw-enable-whatsapp-size',
			'desc'     => esc_html__( 'Input WhatsApp icon size.', WISHLIST_FOR_WOO_TEXTDOMAIN ),
		);

		// Toggle :: Enable/Disable twitter share.
		$settings[] = array(
			'title'    => esc_html__( 'Twitter share', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			'class'    => 'mwb-wfw-toggle-checkbox',
			'type'     => 'checkbox',
			'desc_tip' => true,
			'value'    => get_option( 'wfw-enable-twitter-share', 'yes' ),
			'id'       => 'wfw-enable-twitter-share',
			'desc'     => esc_html__( 'Enable/Disable the Twitter share functionality.', WISHLIST_FOR_WOO_TEXTDOMAIN ),
		);

		// Input :: Twitter icon color.
		$settings[] = array(
			'title'    => esc_html__( 'Twitter Icon color', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			'class'    => 'mwb-wfw-color',
			'type'     => 'color',
			'desc_tip' => true,
			'value'    => get_option( 'wfw-enable-twitter-color', '' ),
			'id'       => 'wfw-enable-twitter-color',
			'desc'     => esc_html__( 'Input WhatsApp icon color.', WISHLIST_FOR_WOO_TEXTDOMAIN ),
		);

		// Input :: Twitter icon size.
		$settings[] = array(
			'title'    => esc_html__( 'Twitter Icon size', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			'class'    => 'mwb-wfw-select',
			'type'     => 'select',
			'options'  => array(
				'small'  => esc_html__( 'Small', 'wishlist_for_woo' ),
				'medium' => esc_html__( 'Meduim', 'wishlist_for_woo' ),
				'Large'  => esc_html__( 'Large', 'wishlist_for_woo' ),
			),
			'desc_tip' => true,
			'value'    => get_option( 'wfw-enable-twitter-size', '' ),
			'id'       => 'wfw-enable-twitter-size',
			'desc'     => esc_html__( 'Input WhatsApp icon size.', WISHLIST_FOR_WOO_TEXTDOMAIN ),
		);

		// Toggle :: Enable/Disable pinterest share.
		$settings[] = array(
			'title'    => esc_html__( 'Pinterest share', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			'class'    => 'mwb-wfw-toggle-checkbox',
			'type'     => 'checkbox',
			'desc_tip' => true,
			'value'    => get_option( 'wfw-enable-pinterest-share', 'yes' ),
			'id'       => 'wfw-enable-pinterest-share',
			'desc'     => esc_html__( 'Enable/Disable the Pinterest share functionality.', WISHLIST_FOR_WOO_TEXTDOMAIN ),
		);

		// Input :: Pinterest icon color.
		$settings[] = array(
			'title'    => esc_html__( 'Pinterest Icon color', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			'class'    => 'mwb-wfw-color',
			'type'     => 'color',
			'desc_tip' => true,
			'value'    => get_option( 'wfw-enable-pinterest-color', '' ),
			'id'       => 'wfw-enable-pinterest-color',
			'desc'     => esc_html__( 'Input Pinterest icon color.', WISHLIST_FOR_WOO_TEXTDOMAIN ),
		);

		// Input :: Pinterest icon size.
		$settings[] = array(
			'title'    => esc_html__( 'Pinterest Icon size', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			'class'    => 'mwb-wfw-select',
			'type'     => 'select',
			'options'  => array(
				'small'  => esc_html__( 'Small', 'wishlist_for_woo' ),
				'medium' => esc_html__( 'Meduim', 'wishlist_for_woo' ),
				'Large'  => esc_html__( 'Large', 'wishlist_for_woo' ),
			),
			'desc_tip' => true,
			'value'    => get_option( 'wfw-enable-pinterest-size', '' ),
			'id'       => 'wfw-enable-pinterest-color',
			'desc'     => esc_html__( 'Input Pinterest icon size.', WISHLIST_FOR_WOO_TEXTDOMAIN ),
		);



		$settings[] = array(
			'type' => 'sectionend',
		);
		return $settings;
	}

	/**
 	 *  Get all settings of Push Notification Tab.
	 *
	 * @author MakeWebBetter <plugins@makewebbetter.com>
	 * @return array
	 */
	public static function get_push_notify_sections_settings() {

		// Section start.
		$settings[] = array(
			'title' => esc_html__( 'Push Notifications', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			'type'  => 'title',
		);

		// Toggle :: Enable/Disable Plugin.
		$settings[] = array(
			'title'    => esc_html__( 'Push Notifications', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			'class'    => 'mwb-wfw-toggle-checkbox',
			'type'     => 'checkbox',
			'desc_tip' => true,
			'value'    => get_option( 'wfw-enable-push-notif', 'yes' ),
			'id'       => 'wfw-enable-push-notif',
			'desc'     => esc_html__( 'Enable/Disable the push notifications functionality.', WISHLIST_FOR_WOO_TEXTDOMAIN ),
		);

		// Input :: Push notification client id.

		$settings[] = array(
			'title'    => esc_html__( 'Secret Key', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			'class'    => 'mwb-wfw-toggle-text',
			'type'     => 'text',
			'desc_tip' => true,
			'value'    => get_option( 'wfw-push-notif-sk', '' ),
			'id'       => 'wfw-push-notif-sk',
			'desc'     => esc_html__( 'Note: A file "service-worker.js" needs to be stored on the root folder, else push notifications will not work. ', WISHLIST_FOR_WOO_TEXTDOMAIN ),
		);

		// Subheading ::For Preview Settings.
		$settings[]		=	array(
			'type'	=>	'sub-heading',
			'value'	=>	esc_html__( 'Send Custom notifications.', WISHLIST_FOR_WOO_TEXTDOMAIN )
		);

		// Input :: Custom notfications title.
		$settings[] = array(
			'title'    => esc_html__( 'Title', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			'class'    => 'mwb-wfw-toggle-text',
			'type'     => 'text',
			'desc_tip' => true,
			'value'    => get_option( 'wfw-custom-notif-title', '' ),
			'id'       => 'wfw-custom-notif-title',
			'desc'     => esc_html__( 'Enter custom noitification title. ', WISHLIST_FOR_WOO_TEXTDOMAIN ),
		);

		// Input :: Custom notfications URL.
		$settings[] = array(
			'title'    => esc_html__( 'URL', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			'class'    => 'mwb-wfw-toggle-text',
			'type'     => 'url',
			'desc_tip' => true,
			'value'    => get_option( 'wfw-custom-notif-url', '' ),
			'id'       => 'wfw-custom-notif-url',
			'desc'     => esc_html__( 'Enter custom noitification URL. ', WISHLIST_FOR_WOO_TEXTDOMAIN ),
		);

		// Input :: Custom notfications Message.
		$settings[] = array(
			'title'    => esc_html__( 'Message', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			'class'    => 'mwb-wfw-toggle-text',
			'type'     => 'text',
			'desc_tip' => true,
			'value'    => get_option( 'wfw-custom-notif-msg', '' ),
			'id'       => 'wfw-custom-notif-msg',
			'desc'     => esc_html__( 'Enter custom noitification message. ', WISHLIST_FOR_WOO_TEXTDOMAIN ),
		);

		// Input :: Custom notfications Image.
		$settings[] = array(
			'title'    => esc_html__( 'Image', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			'class'    => 'mwb-wfw-toggle-text',
			'type'     => 'file',
			'desc_tip' => true,
			'value'    => get_option( 'wfw-custom-notif-img', '' ),
			'id'       => 'wfw-custom-notif-img',
			'desc'     => esc_html__( 'Enter custom noitification image. ', WISHLIST_FOR_WOO_TEXTDOMAIN ),
		);

		$settings[] = array(
			'type' => 'sectionend',
		);

		return $settings;
	}

	/**
 	 *  Get all settings of Advance Features Tab.
	 *
	 * @author MakeWebBetter <plugins@makewebbetter.com>
	 * @return array
	 */
	public static function get_advance_feature_sections_settings() {

		$settings = array();

		// Section start.
		$settings[] = array(
			'title' => esc_html__( 'Advnace Notifications', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			'type'  => 'title',
		);

		// Toggle :: Enable/Disable multiple wishlist.
		$settings[] = array(
			'title'    => esc_html__( 'Multiple Wishlist', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			'class'    => 'mwb-wfw-toggle-checkbox',
			'type'     => 'checkbox',
			'desc_tip' => true,
			'value'    => get_option( 'wfw-enable-multi-wishlist', 'yes' ),
			'id'       => 'wfw-enable-multi-wishlist',
			'desc'     => esc_html__( 'Enable/Disable the multiple wishlist functionality.', WISHLIST_FOR_WOO_TEXTDOMAIN ),
		);

		// Toggle :: Enable/Disable create api routing.
		$settings[] = array(
			'title'    => esc_html__( 'Create API routing', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			'class'    => 'mwb-wfw-toggle-checkbox',
			'type'     => 'checkbox',
			'desc_tip' => true,
			'value'    => get_option( 'wfw-enable-api-route', 'yes' ),
			'id'       => 'wfw-enable-api-route',
			'desc'     => esc_html__( 'Enable/Disable the API routing functionality.', WISHLIST_FOR_WOO_TEXTDOMAIN ),
		);

		// Toggle :: Enable/Disable Automated emails.
		$settings[] = array(
			'title'    => esc_html__( 'Automated Emails', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			'class'    => 'mwb-wfw-toggle-checkbox',
			'type'     => 'checkbox',
			'desc_tip' => true,
			'value'    => get_option( 'wfw-enable-automated-mail', 'yes' ),
			'id'       => 'wfw-enable-automated-mail',
			'desc'     => esc_html__( 'Send automated emails to wishlist owners.', WISHLIST_FOR_WOO_TEXTDOMAIN ),
		);

			// Toggle :: Enable/Disable instock notifications.
			$settings[] = array(
				'title'    => esc_html__( 'In-stock Notification', WISHLIST_FOR_WOO_TEXTDOMAIN ),
				'class'    => 'mwb-wfw-toggle-checkbox',
				'type'     => 'checkbox',
				'desc_tip' => true,
				'value'    => get_option( 'wfw-enable-instock-notif', 'yes' ),
				'id'       => 'wfw-enable-instock-notif',
				'desc'     => esc_html__( 'Enable/Disable in-stock notifications functionality.', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			);

		$settings[] = array(
			'type' => 'sectionend',
		);
		return $settings;
	}

	/**
 	 *  Get all settings of CRM Tab.
	 *
	 * @author MakeWebBetter <plugins@makewebbetter.com>
	 * @return array
	 */
	public static function get_crm_sections_settings() {

		ob_start();
		?>
		<div id="mfw_crm_config_wrapper">
			<div id="wfw_crm_configurations">

				<h3><?php esc_html_e( 'CRM Configurations', WISHLIST_FOR_WOO_TEXTDOMAIN ); ?></h3>
				<h3><?php esc_html_e( 'Supported CRM Tools', WISHLIST_FOR_WOO_TEXTDOMAIN ); ?></h3>

				<div class="wfw_crm_config_options">
					<div class="wfw_crm_config_options_icon simple">
						<a href="<?php echo esc_url( esc_url( 'https://wordpress.org/plugins/enhanced-woocommerce-mautic-integration/' ) ); ?>">
							<img class="wfw_crm_tool_mautic" src="<?php echo esc_url( WISHLIST_FOR_WOO_URL . 'admin/images/mautic-logo.png' ); ?>">
						</a>
					</div>
					<div class="wfw_crm_config_options_icon simple">
						<a href="<?php echo esc_url( esc_url( 'https://wordpress.org/plugins/makewebbetter-hubspot-for-woocommerce/' ) ); ?>">
							<img class="wfw_crm_tool_hubspot" src="<?php echo esc_url( WISHLIST_FOR_WOO_URL . 'admin/images/hubspot-logo.svg' ); ?>">
						</a>
					</div>
				</div>
			</div>
		</div>
		<?php
		$settings = ob_get_clean();

		return $settings;
	}

# End of class.
}
