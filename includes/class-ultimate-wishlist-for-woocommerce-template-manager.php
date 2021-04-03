<?php
/**
 * The core plugin templates are handled here.
 *
 * @since      1.0.0
 * @package    wishlist-for-woo
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
	 */
	public function render_header_content_start() {

		?>
		<!-- Header Section -->
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<main class="mwb-wfw-main">
			<header class="mwb-wfw-header">
				<h1 class="mwb-wfw-header__title"><?php esc_html_e( 'Ultimate Wishlist for WooCommerce', 'ultimate-wishlist-for-woocommerce' ); ?></h1>
				<span class="mwb-wfw-version"><?php echo sprintf( 'v%s', esc_html( ULTIMATE_WISHLIST_FOR_WOOCOMMERCE_VERSION ) ); ?></span>
			</header>
			<!-- End of Header Section -->
		<?php
	}

	/**
	 *  Add a header panel for all screens in plugin.
	 *
	 * @author MakeWebBetter <plugins@makewebbetter.com>
	 * @return html.
	 */
	public function render_navigation_tab() {

		?>
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
					<?php if ( ! empty( $tabs ) && is_array( $tabs ) ) : ?>
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
		<?php
	}

	/**
	 *  Selected Tab settings Screen.
	 *
	 * @author MakeWebBetter <plugins@makewebbetter.com>
	 * @return html
	 */
	public function render_settings_screen() {

		?>

		<div class="mwb-wfw-container">
			<div class="mwb-wfw-row">
				<?php do_action( 'mwb_wfw_helpdesk' ); ?>
				<div class="mwb-wfw-desc">
					<form method="post" action="#" class="mwb-wfw-output-form"></form>
					<div class="mwb-wfw-desc--preloader">
						<img src="<?php echo esc_url( ULTIMATE_WISHLIST_FOR_WOOCOMMERCE_URL . 'admin/images/preloader.gif' ); ?>" alt="loader">
						<h4><?php esc_html_e( 'Loading settings please wait...', 'ultimate-wishlist-for-woocommerce' ); ?></h4>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 *  Helpdesk section in sidebar.
	 *
	 * @author MakeWebBetter <plugins@makewebbetter.com>
	 * @return html
	 */
	public function render_helpdesk_sidebar() {

		?>
		   <div class="mwb-wfw-sidebar">
				<div class="mwb-wfw-helpdesk__icon">
					<img src="<?php echo esc_url( ULTIMATE_WISHLIST_FOR_WOOCOMMERCE_URL . 'admin/images/customer-service-icon.jpg' ); ?>" class="mwb-wfw-helpdesk-btn" />
				</div>
				<h2>help desk </h2>
				<ul class="mwb-wfw-sidebar__items">
					<li class="mwb-wfw-sidebar__links"><a href="javascript:void(0)"><?php esc_html_e( 'go pro', 'ultimate-wishlist-for-woocommerce' ); ?><span> &#8594;</span></a></li>
					<li class="mwb-wfw-sidebar__links"><a href="https://docs.makewebbetter.com/ultimate-wishlist-for-woocommerce/"><?php esc_html_e( 'see docs', 'ultimate-wishlist-for-woocommerce' ); ?><span> &#8594;</span></a></li>
					<li class="mwb-wfw-sidebar__links"><a href="https://demo.makewebbetter.com/ultimate-wishlist-for-woocommerce/"><?php esc_html_e( 'see demo', 'ultimate-wishlist-for-woocommerce' ); ?> <span> &#8594;</span></a></li>
				</ul>
				<div class="mwb-wfw-sidebar__connect">
					<a href="javascript:void(0)"><?php esc_html_e( 'connect with us in one click', 'ultimate-wishlist-for-woocommerce' ); ?></a>
					<a href="https://makewebbetter.com/submit-query/" class="mwb-wfw-skype__icon"><img src="<?php echo esc_url( ULTIMATE_WISHLIST_FOR_WOOCOMMERCE_URL . 'admin/icons/mail.png' ); ?>" alt="mail"><span>connect</span></a>
				</div>
			</div>
		<?php
	}

	/**
	 *  Add a header panel end for all screens in plugin.
	 *
	 * @author MakeWebBetter <plugins@makewebbetter.com>
	 * @return html
	 */
	public function render_header_content_end() {

		?>
		<!-- Header Section -->
			<div class="mwb-wfw_save-wrapper is-hidden">
				<span><a href="javascript:void(0);" class="mwb-wfw_save-link"><?php esc_html_e( 'SAVE', 'ultimate-wishlist-for-woocommerce' ); ?></a>
				<a href="javascript:void(0);" class="mwb-wfw_cancel-link"><?php esc_html_e( 'CANCEL', 'ultimate-wishlist-for-woocommerce' ); ?></a></span>
				<span class="mwb-wfw_save-text is-hidden"><?php esc_html_e( 'You have saved your data!', 'ultimate-wishlist-for-woocommerce' ); ?></span>
			</div>
		</main>
		<!-- End of Header Section -->
		<?php
	}

	/**
	 *  Get all nav tabs of current screen.
	 *
	 * @author MakeWebBetter <plugins@makewebbetter.com>
	 * @return html
	 */
	public function retrieve_nav_tabs() {

		$current_screen = ! empty( $_GET['page'] ) ? sanitize_text_field( wp_unslash( $_GET['page'] ) ) : false;
		switch ( $current_screen ) {
			case 'wfw-config-portal':
				$tabs = array(
					'general'           => esc_html__( 'General', 'ultimate-wishlist-for-woocommerce' ),
					'social_sharing'    => esc_html__( 'Social Sharing', 'ultimate-wishlist-for-woocommerce' ),
					'push_notify'       => esc_html__( 'Push Notification', 'ultimate-wishlist-for-woocommerce' ),
					'advance_feature'   => esc_html__( 'Advance Features', 'ultimate-wishlist-for-woocommerce' ),
					'crm'               => esc_html__( 'CRM Configuration', 'ultimate-wishlist-for-woocommerce' ),
				);
				break;

			case 'wfw-performance-reporting':
				$tabs = array(
					'wishlist_base'         => esc_html__( 'All Wishlists', 'ultimate-wishlist-for-woocommerce' ),
					'product_base'          => esc_html__( 'Product Based Reporting', 'ultimate-wishlist-for-woocommerce' ),
				);
				break;

			case 'wfw-plugin-overview':
				$tabs = array();
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
			'title' => esc_html__( 'General Settings', 'ultimate-wishlist-for-woocommerce' ),
			'type'  => 'title',
		);

		// Toggle :: Enable/Disable Plugin.
		$settings[] = array(
			'title'                 => esc_html__( 'Enable /Disable Plugin', 'ultimate-wishlist-for-woocommerce' ),
			'class'                 => 'mwb-wfw-toggle-checkbox',
			'type'                  => 'checkbox',
			'desc_tip'              => true,
			'value'                 => get_option( 'wfw-enable-plugin', 'yes' ),
			'id'                    => 'wfw-enable-plugin',
			'desc'                  => esc_html__( 'Enable/Disable the complete plugin functionality.', 'ultimate-wishlist-for-woocommerce' ),
		);

		// Toggle :: Enable Popup for Product added in wishlist Plugin.
		$settings[] = array(
			'title'                 => esc_html__( 'Enable Wishlist Popup', 'ultimate-wishlist-for-woocommerce' ),
			'class'                 => 'mwb-wfw-toggle-checkbox',
			'type'                  => 'checkbox',
			'desc_tip'              => true,
			'value'                 => get_option( 'wfw-enable-popup', 'yes' ),
			'id'                    => 'wfw-enable-popup',
			'desc'                  => esc_html__( 'Show Item added in wishlist as popup after adding in list.', 'ultimate-wishlist-for-woocommerce' ),
		);

		// Subheading ::For Preview Settings.
		$settings[]     = array(
			'type'  => 'sub-heading',
			'value' => esc_html__( 'Wishlist Position And Preview', 'ultimate-wishlist-for-woocommerce' ),
		);

		// Select :: How to show the wishlists on frontend.
		$settings[] = array(
			'title'             => esc_html__( 'Wishlist View Type', 'ultimate-wishlist-for-woocommerce' ),
			'type'              => 'select',
			'desc'              => esc_html__( 'Select how you want to show the wishlist for customers.', 'ultimate-wishlist-for-woocommerce' ),
			'options'           => array(
				''          => esc_html__( 'No options Selected', 'ultimate-wishlist-for-woocommerce' ),
				'icon'      => esc_html__( 'Icon over Product Image', 'ultimate-wishlist-for-woocommerce' ),
				'button'    => esc_html__( 'Add to Wishlist button', 'ultimate-wishlist-for-woocommerce' ),
			),
			'desc_tip'          => true,
			'class'             => 'mwb-wfw-select',
			'id'                => 'wfw-view-type',
			'value'             => get_option( 'wfw-view-type', 'icon' ),
			'custom_attributes' => array( 'dependency-type' => get_option( 'wfw-view-type', 'icon' ) ),
		);

		// Select :: Which icon to use.
		$settings[] = array(
			'title'             => esc_html__( 'Wishlist Interface Icon', 'ultimate-wishlist-for-woocommerce' ),
			'type'              => 'select',
			'desc'              => esc_html__( 'Select which icon you want for the wishlist interface.', 'ultimate-wishlist-for-woocommerce' ),
			'options'           => array(
				''          => esc_html__( 'No options Selected', 'ultimate-wishlist-for-woocommerce' ),
				'heart'     => esc_html__( 'Heart Icon', 'ultimate-wishlist-for-woocommerce' ),
				'shopping'      => esc_html__( 'Shopping Icon', 'ultimate-wishlist-for-woocommerce' ),
				'cart'      => esc_html__( 'Cart Icon', 'ultimate-wishlist-for-woocommerce' ),
				'star'      => esc_html__( 'Star Icon', 'ultimate-wishlist-for-woocommerce' ),
				'tag'       => esc_html__( 'Tag Icon', 'ultimate-wishlist-for-woocommerce' ),
				'thumbsup'      => esc_html__( 'Like Icon', 'ultimate-wishlist-for-woocommerce' ),
				'bell'      => esc_html__( 'Bell Icon', 'ultimate-wishlist-for-woocommerce' ),
				'eye'       => esc_html__( 'Eye Icon', 'ultimate-wishlist-for-woocommerce' ),
			),
			'desc_tip'          => true,
			'class'             => 'mwb-wfw-select wfw-view-type-dependent',
			'id'                => 'wfw-icon-view',
			'value'             => get_option( 'wfw-icon-view', 'heart' ),
			'custom_attributes' => array( 'dependent' => 'dependency-type-icon' ),
		);

		// Select :: Where to show button on loops.
		$settings[] = array(
			'title'             => esc_html__( 'Wishlist on Loops', 'ultimate-wishlist-for-woocommerce' ),
			'type'              => 'select',
			'desc'              => esc_html__( 'Select where wishlist button should be shown on woocommerce loops or shops.', 'ultimate-wishlist-for-woocommerce' ),
			'options'           => array(
				''                      => esc_html__( 'No options Selected', 'ultimate-wishlist-for-woocommerce' ),
				'before_product_name'   => esc_html__( 'Before Product Title', 'ultimate-wishlist-for-woocommerce' ),
				'after_product_name'    => esc_html__( 'After Product Title', 'ultimate-wishlist-for-woocommerce' ),
				'before_add_to_cart'    => esc_html__( 'Before Add To Cart Button', 'ultimate-wishlist-for-woocommerce' ),
				'before_product_loop'   => esc_html__( 'Before Product Section', 'ultimate-wishlist-for-woocommerce' ),
			),
			'desc_tip'          => true,
			'class'             => 'mwb-wfw-select wfw-view-type-dependent',
			'id'                => 'wfw-loop-button-view',
			'value'             => get_option( 'wfw-loop-button-view', 'before_product_name' ),
			'custom_attributes' => array( 'dependent' => 'dependency-type-button' ),
		);

		// Select :: Where to show button on product pages.
		$settings[] = array(
			'title'             => esc_html__( 'Wishlist on Product Page', 'ultimate-wishlist-for-woocommerce' ),
			'type'              => 'select',
			'desc'              => esc_html__( 'Select where wishlist button should be shown on woocommerce products page.', 'ultimate-wishlist-for-woocommerce' ),
			'options'           => array(
				''                      => esc_html__( 'No options Selected', 'ultimate-wishlist-for-woocommerce' ),
				'before_add_to_cart'    => esc_html__( 'Before Add To Cart Button', 'ultimate-wishlist-for-woocommerce' ),
				'after_add_to_cart'     => esc_html__( 'After Add To Cart Button', 'ultimate-wishlist-for-woocommerce' ),
				'before_product_name'   => esc_html__( 'Before Product Title', 'ultimate-wishlist-for-woocommerce' ),
				'after_product_name'    => esc_html__( 'After Product Title', 'ultimate-wishlist-for-woocommerce' ),
				'after_product_price'   => esc_html__( 'After Product Price', 'ultimate-wishlist-for-woocommerce' ),
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
			'value' => esc_html__( 'Wishlist Page', 'ultimate-wishlist-for-woocommerce' ),
		);

		global $wpdb;

		$sql           = $wpdb->prepare( "SELECT `ID` FROM `wp_posts` WHERE `post_content` LIKE '%[mwb_wfw_wishlist]%' AND `post_type` = 'page' AND `post_status` = 'publish'" );
		$wishlist_page = $wpdb->get_results( $sql );
		$page_option   = array();

		if ( $wishlist_page ) {

			foreach ( $wishlist_page as $key => $post ) {
				$page_option[ $post->ID ] = get_the_title( $post->ID );
			}
		}

		$settings[] = array(
			'title'    => esc_html__( 'Wishlist Page', 'ultimate-wishlist-for-woocommerce' ),
			'type'     => 'select',
			'desc'     => esc_html__( 'Select the page where view wishlist button should redirect. Wishlist page requires shortcode as [mwb_wfw_wishlist]', 'ultimate-wishlist-for-woocommerce' ),
			'options'  => $page_option,
			'desc_tip' => true,
			'class'    => 'mwb-wfw-select mwb-wfw-select-page',
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
			'title' => esc_html__( 'Push Notifications', 'ultimate-wishlist-for-woocommerce' ),
			'type'  => 'title',
		);

		// Input :: icon size.
		$settings[] = array(
			'title'    => esc_html__( 'Icon size', 'ultimate-wishlist-for-woocommerce' ),
			'class'    => 'mwb-wfw-select',
			'type'     => 'select',
			'options'  => array(
				'15px' => esc_html__( 'Small', 'wishlist_for_woo' ),
				'20px' => esc_html__( 'Medium', 'wishlist_for_woo' ),
				'25px' => esc_html__( 'Large', 'wishlist_for_woo' ),
			),
			'desc_tip' => true,
			'value'    => get_option( 'wfw-enable-icon-size', '15px' ),
			'id'       => 'wfw-enable-icon-size',
			'desc'     => esc_html__( 'Input Pinterest icon size.', 'ultimate-wishlist-for-woocommerce' ),
		);

		// Toggle :: Enable/Disable Facebook share.
		$settings[] = array(
			'title'    => esc_html__( 'Facebook share', 'ultimate-wishlist-for-woocommerce' ),
			'class'    => 'mwb-wfw-toggle-checkbox',
			'type'     => 'checkbox',
			'desc_tip' => true,
			'value'    => get_option( 'wfw-enable-fb-share', 'yes' ),
			'id'       => 'wfw-enable-fb-share',
			'desc'     => esc_html__( 'Enable/Disable the Facebook share functionality.', 'ultimate-wishlist-for-woocommerce' ),
		);

		// Input :: Facebook icon color.
		$settings[] = array(
			'title'    => esc_html__( 'Facebook Icon color', 'ultimate-wishlist-for-woocommerce' ),
			'class'    => 'mwb-wfw-color',
			'type'     => 'text',
			'desc_tip' => true,
			'value'    => '#' . get_option( 'wfw-enable-fb-color', '1877f2' ),
			'id'       => 'wfw-enable-fb-color',
			'desc'     => esc_html__( 'Input Facebook icon color.', 'ultimate-wishlist-for-woocommerce' ),
		);

		// Toggle :: Enable/Disable Whatsapp share.
		$settings[] = array(
			'title'    => esc_html__( 'WhatsApp share', 'ultimate-wishlist-for-woocommerce' ),
			'class'    => 'mwb-wfw-toggle-checkbox',
			'type'     => 'checkbox',
			'desc_tip' => true,
			'value'    => get_option( 'wfw-enable-whatsapp-share', 'yes' ),
			'id'       => 'wfw-enable-whatsapp-share',
			'desc'     => esc_html__( 'Enable/Disable the WhatsApp share functionality.', 'ultimate-wishlist-for-woocommerce' ),
		);

		// Input :: Whatsapp icon color.
		$settings[] = array(
			'title'    => esc_html__( 'WhatsApp Icon color', 'ultimate-wishlist-for-woocommerce' ),
			'class'    => 'mwb-wfw-color',
			'type'     => 'text',
			'desc_tip' => true,
			'value'    => '#' . get_option( 'wfw-enable-whatsapp-color', '25D366' ),
			'id'       => 'wfw-enable-whatsapp-color',
			'desc'     => esc_html__( 'Input WhatsApp icon color.', 'ultimate-wishlist-for-woocommerce' ),
		);

		// Toggle :: Enable/Disable twitter share.
		$settings[] = array(
			'title'    => esc_html__( 'Twitter share', 'ultimate-wishlist-for-woocommerce' ),
			'class'    => 'mwb-wfw-toggle-checkbox',
			'type'     => 'checkbox',
			'desc_tip' => true,
			'value'    => get_option( 'wfw-enable-twitter-share', 'yes' ),
			'id'       => 'wfw-enable-twitter-share',
			'desc'     => esc_html__( 'Enable/Disable the Twitter share functionality.', 'ultimate-wishlist-for-woocommerce' ),
		);

		// Input :: Twitter icon color.
		$settings[] = array(
			'title'    => esc_html__( 'Twitter Icon color', 'ultimate-wishlist-for-woocommerce' ),
			'class'    => 'mwb-wfw-color',
			'type'     => 'text',
			'desc_tip' => true,
			'value'    => '#' . get_option( 'wfw-enable-twitter-color', '1DA1F2' ),
			'id'       => 'wfw-enable-twitter-color',
			'desc'     => esc_html__( 'Input Twitter icon color.', 'ultimate-wishlist-for-woocommerce' ),
		);

		// Toggle :: Enable/Disable pinterest share.
		$settings[] = array(
			'title'    => esc_html__( 'Pinterest share', 'ultimate-wishlist-for-woocommerce' ),
			'class'    => 'mwb-wfw-toggle-checkbox',
			'type'     => 'checkbox',
			'desc_tip' => true,
			'value'    => get_option( 'wfw-enable-pinterest-share', 'yes' ),
			'id'       => 'wfw-enable-pinterest-share',
			'desc'     => esc_html__( 'Enable/Disable the Pinterest share functionality.', 'ultimate-wishlist-for-woocommerce' ),
		);

		// Input :: Pinterest icon color.
		$settings[] = array(
			'title'    => esc_html__( 'Pinterest Icon color', 'ultimate-wishlist-for-woocommerce' ),
			'class'    => 'mwb-wfw-color',
			'type'     => 'text',
			'desc_tip' => true,
			'value'    => '#' . get_option( 'wfw-enable-pinterest-color', 'c8232c' ),
			'id'       => 'wfw-enable-pinterest-color',
			'desc'     => esc_html__( 'Input Pinterest icon color.', 'ultimate-wishlist-for-woocommerce' ),
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
			'title' => esc_html__( 'Push Notifications', 'ultimate-wishlist-for-woocommerce' ),
			'type'  => 'title',
		);

		// Toggle :: Enable/Disable Plugin.
		$settings[] = array(
			'title'    => esc_html__( 'Push Notifications', 'ultimate-wishlist-for-woocommerce' ),
			'class'    => 'mwb-wfw-toggle-checkbox',
			'type'     => 'checkbox',
			'desc_tip' => true,
			'value'    => get_option( 'wfw-enable-push-notif', '' ),
			'id'       => 'wfw-enable-push-notif',
			'desc'     => esc_html__( 'Enable/Disable the push notifications functionality.', 'ultimate-wishlist-for-woocommerce' ),
		);

		// Input :: Push notification client id.

		$settings[] = array(
			'title'    => esc_html__( 'Secret Key', 'ultimate-wishlist-for-woocommerce' ),
			'class'    => 'mwb-wfw-toggle-text',
			'type'     => 'text',
			'desc_tip' => true,
			'value'    => get_option( 'wfw-push-notif-sk', '' ),
			'id'       => 'wfw-push-notif-sk',
			'desc'     => esc_html__( 'Note: A file "service-worker.js" needs to be stored on the root folder, else push notifications will not work. ', 'ultimate-wishlist-for-woocommerce' ),
		);

		// Subheading ::For Preview Settings.
		$settings[] = array(
			'type'  => 'sub-heading',
			'value' => esc_html__( 'Send Custom notifications.', 'ultimate-wishlist-for-woocommerce' ),
		);

		// Input :: Custom notfications title.
		$settings[] = array(
			'title'    => esc_html__( 'Title', 'ultimate-wishlist-for-woocommerce' ),
			'class'    => 'mwb-wfw-toggle-text',
			'type'     => 'text',
			'desc_tip' => true,
			'value'    => get_option( 'wfw-custom-notif-title', '' ),
			'id'       => 'wfw-custom-notif-title',
			'desc'     => esc_html__( 'Enter custom notification title. ', 'ultimate-wishlist-for-woocommerce' ),
		);

		// Input :: Custom notfications URL.
		$settings[] = array(
			'title'    => esc_html__( 'URL', 'ultimate-wishlist-for-woocommerce' ),
			'class'    => 'mwb-wfw-toggle-text',
			'type'     => 'text',
			'desc_tip' => true,
			'value'    => get_option( 'wfw-custom-notif-url', '' ),
			'id'       => 'wfw-custom-notif-url',
			'desc'     => esc_html__( 'Enter custom notification URL. ', 'ultimate-wishlist-for-woocommerce' ),
		);

		// Input :: Custom notfications Message.
		$settings[] = array(
			'title'    => esc_html__( 'Message', 'ultimate-wishlist-for-woocommerce' ),
			'class'    => 'mwb-wfw-toggle-text',
			'type'     => 'text',
			'desc_tip' => true,
			'value'    => get_option( 'wfw-custom-notif-msg', '' ),
			'id'       => 'wfw-custom-notif-msg',
			'desc'     => esc_html__( 'Enter custom notification message. ', 'ultimate-wishlist-for-woocommerce' ),
		);

		// Input :: Custom notfications Image.
		$settings[] = array(
			'title'    => esc_html__( 'Image', 'ultimate-wishlist-for-woocommerce' ),
			'class'    => 'mwb-wfw-toggle-text',
			'type'     => 'text',
			'desc_tip' => true,
			'value'    => get_option( 'wfw-custom-notif-img', '' ),
			'id'       => 'wfw-custom-notif-img',
			'desc'     => esc_html__( 'Enter custom notification image. ', 'ultimate-wishlist-for-woocommerce' ),
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
			'title' => esc_html__( 'Advance Notifications', 'ultimate-wishlist-for-woocommerce' ),
			'type'  => 'title',
		);

		// Toggle :: Enable/Disable multiple wishlist.
		$settings[] = array(
			'title'    => esc_html__( 'Multiple Wishlist', 'ultimate-wishlist-for-woocommerce' ),
			'class'    => 'mwb-wfw-toggle-checkbox',
			'type'     => 'checkbox',
			'desc_tip' => true,
			'value'    => get_option( 'wfw-enable-multi-wishlist', '' ),
			'id'       => 'wfw-enable-multi-wishlist',
			'desc'     => esc_html__( 'Enable/Disable the multiple wishlist functionality.', 'ultimate-wishlist-for-woocommerce' ),
		);

		// Toggle :: Enable/Disable create api routing.
		$settings[] = array(
			'title'    => esc_html__( 'Create API routing', 'ultimate-wishlist-for-woocommerce' ),
			'class'    => 'mwb-wfw-toggle-checkbox',
			'type'     => 'checkbox',
			'desc_tip' => true,
			'value'    => get_option( 'wfw-enable-api-route', '' ),
			'id'       => 'wfw-enable-api-route',
			'desc'     => esc_html__( 'Enable/Disable the API routing functionality.', 'ultimate-wishlist-for-woocommerce' ),
		);

		// Toggle :: Enable/Disable Automated emails.
		$settings[] = array(
			'title'    => esc_html__( 'Automated Emails', 'ultimate-wishlist-for-woocommerce' ),
			'class'    => 'mwb-wfw-toggle-checkbox',
			'type'     => 'checkbox',
			'desc_tip' => true,
			'value'    => get_option( 'wfw-enable-automated-mail', '' ),
			'id'       => 'wfw-enable-automated-mail',
			'desc'     => esc_html__( 'Send automated emails to wishlist owners.', 'ultimate-wishlist-for-woocommerce' ),
		);

		// Toggle :: Enable/Disable instock notifications.
		$settings[] = array(
			'title'    => esc_html__( 'In-stock Notification', 'ultimate-wishlist-for-woocommerce' ),
			'class'    => 'mwb-wfw-toggle-checkbox',
			'type'     => 'checkbox',
			'desc_tip' => true,
			'value'    => get_option( 'wfw-enable-instock-notif', '' ),
			'id'       => 'wfw-enable-instock-notif',
			'desc'     => esc_html__( 'Enable/Disable in-stock notifications functionality.', 'ultimate-wishlist-for-woocommerce' ),
		);

		// Toggle :: Enable/Disable instock notifications.
		$settings[] = array(
			'title'    => esc_html__( 'Delete Data/Wishlist at uninstall', 'ultimate-wishlist-for-woocommerce' ),
			'class'    => 'mwb-wfw-toggle-checkbox',
			'type'     => 'checkbox',
			'desc_tip' => true,
			'value'    => get_option( 'wfw-enable-instock-notif', '' ),
			'id'       => 'wfw-enable-instock-notif',
			'desc'     => esc_html__( 'On uninstalling the plugin all the settings and users wishlist will be deleted.', 'ultimate-wishlist-for-woocommerce' ),
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
				<h2 class="mwb-wfw-subheading"><?php esc_html_e( 'Supported CRM Tools - Premium Feature', 'ultimate-wishlist-for-woocommerce' ); ?></h2>
				<div class="wfw_crm_config_options">
					<div class="wfw_crm_config_options_icon simple">
						<a href="<?php echo esc_url( 'https://wordpress.org/plugins/enhanced-woocommerce-mautic-integration/' ); ?>">
							<img class="wfw_crm_tool_mautic" src="<?php echo esc_url( ULTIMATE_WISHLIST_FOR_WOOCOMMERCE_URL . 'admin/images/mautic-logo.svg' ); ?>">
						</a>
						<h3><?php esc_html_e( 'Mautic for WooCommerce', 'ultimate-wishlist-for-woocommerce' ); ?></h3>
						<ul>
							<li><?php esc_html_e( 'Track and nurture your WooCommerce contacts', 'ultimate-wishlist-for-woocommerce' ); ?></li>

							<li><?php esc_html_e( 'Create over 20 predefined custom fields to segregate your contacts', 'ultimate-wishlist-for-woocommerce' ); ?></li>
							<li><?php esc_html_e( 'Sync your contacts data in real-time', 'ultimate-wishlist-for-woocommerce' ); ?></li>
							<li><?php esc_html_e( 'Assign custom tags to your contacts using Mautic', 'ultimate-wishlist-for-woocommerce' ); ?></li>
							<li><?php esc_html_e( 'Create high-converting marketing campaigns', 'ultimate-wishlist-for-woocommerce' ); ?></li>
							<li><?php esc_html_e( 'Segment your contacts on their Recency, Frequency, and Monetary ratings', 'ultimate-wishlist-for-woocommerce' ); ?></li>
						</ul>
						<a class="mwb-wfw-cta" target="_blank" href="<?php echo esc_url( 'https://wordpress.org/plugins/enhanced-woocommerce-mautic-integration/' ); ?>"><?php esc_html_e( 'View Plugin Site', 'ultimate-wishlist-for-woocommerce' ); ?></a>
					</div>
					<div class="wfw_crm_config_options_icon simple">
						<a href="<?php echo esc_url( 'https://wordpress.org/plugins/makewebbetter-hubspot-for-woocommerce/' ); ?>">
							<img class="wfw_crm_tool_hubspot" src="<?php echo esc_url( ULTIMATE_WISHLIST_FOR_WOOCOMMERCE_URL . 'admin/images/hubspot-logo.svg' ); ?>">
						</a>
						<h3><?php esc_html_e( 'HubSpot for WooCommerce', 'ultimate-wishlist-for-woocommerce' ); ?></h3>
						<ul>
							<li><?php esc_html_e( 'Sync your WooCommerce store data to HubSpot', 'ultimate-wishlist-for-woocommerce' ); ?></li>
							<li><?php esc_html_e( 'Manage your customers and their orders in an easy-to-use CRM', 'ultimate-wishlist-for-woocommerce' ); ?></li>
							<li><?php esc_html_e( 'Track and recover customers’ abandoned carts', 'ultimate-wishlist-for-woocommerce' ); ?></li>
							<li><?php esc_html_e( 'Create and send beautiful, responsive emails to your leads and customers', 'ultimate-wishlist-for-woocommerce' ); ?></li>
							<li><?php esc_html_e( 'Build advertising campaigns on Facebook, Instagram, LinkedIn, and Google', 'ultimate-wishlist-for-woocommerce' ); ?></li>
						</ul>
						<a class="mwb-wfw-cta" target="_blank" href="<?php echo esc_url( 'https://wordpress.org/plugins/makewebbetter-hubspot-for-woocommerce/' ); ?>">
							<?php esc_html_e( 'View Plugin Site', 'ultimate-wishlist-for-woocommerce' ); ?>
						</a>
					</div>
				</div>
			</div>
		</div>
		<?php
		$settings = ob_get_clean();

		return $settings;
	}

	/**
	 *  Get all templates of other Tab.
	 *
	 * @author MakeWebBetter <plugins@makewebbetter.com>
	 * @param $template_name The slug for template
	 * @param $base_path The base path to include.
	 * @return html Buffered html.
	 */
	public static function get_template_sections( $template_name = false, $base_path = false ) {

		if ( ! empty( $template_name ) ) {
			ob_start();
				wc_get_template(
					'partials/templates/ultimate-wishlist-for-woocommerce-' . $template_name . '.php',
					array( $template_name => $template_name ),
					'',
					$base_path
				);
			$output = ob_get_contents();
			ob_end_clean();

			return $output;
		}
	}

	// End of class.
}
