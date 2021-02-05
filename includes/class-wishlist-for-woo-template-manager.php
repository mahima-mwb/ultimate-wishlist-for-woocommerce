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
                    <li class="mwb-wfw-sidebar__links"><a href="#"><?php esc_html_e( 'go pro', WISHLIST_FOR_WOO_TEXTDOMAIN ); ?><span> &#8594;</span></a></li>
                    <li class="mwb-wfw-sidebar__links"><a href="#"><?php esc_html_e( 'see docs', WISHLIST_FOR_WOO_TEXTDOMAIN ); ?><span> &#8594;</span></a></li>
                    <li class="mwb-wfw-sidebar__links"><a href="#"><?php esc_html_e( 'see tutorial', WISHLIST_FOR_WOO_TEXTDOMAIN ); ?> <span> &#8594;</span></a></li>
                </ul>
                <div class="mwb-wfw-sidebar__connect">
                    <a href="#"><?php esc_html_e( 'connect with us in one click', WISHLIST_FOR_WOO_TEXTDOMAIN ); ?></a>
                    <a href="#" class="mwb-wfw-skype__icon"><img src="<?php echo esc_url( WISHLIST_FOR_WOO_URL . 'admin/images/skype_logo.png' ) ?>" alt="skype-log"><span>connect</span></a>
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
		$settings[] = array(
			'title' => esc_html__( 'This will be heading for General Tab.', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			'class'    => 'mwb-wfw-sub-heading',
			'type'  => 'title',
			'id'    => 'mwb-wfw-heading',
		);

		$settings[] = array(
			'title'             => esc_html__( 'Enable Select2', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			'type'              => 'multiselect',
			'desc'              => esc_html__( 'This will be a select2 desctiption', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			'options'           => array( 
									''	=>	esc_html__( 'Options default', WISHLIST_FOR_WOO_TEXTDOMAIN ),
									'one'	=>	esc_html__( 'Options 1', WISHLIST_FOR_WOO_TEXTDOMAIN ),
									'two'	=>	esc_html__( 'Options 2', WISHLIST_FOR_WOO_TEXTDOMAIN ),
								),
			'desc_tip'          => true,
			'class'		        => 'mwb-wfw-multi-select',
			'id'   				=> 'mwb-wfw-multi-select-field-id',
			'custom_attributes' => array(
				'data-keytype' => esc_html__( 'user-role', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			),
		);

		$settings[] = array(
			'title'             => esc_html__( 'Enable Select', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			'type'              => 'select',
			'desc'              => esc_html__( 'This will be a select desctiption', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			'options'           => array( 
									''	=>	esc_html__( 'Options default', WISHLIST_FOR_WOO_TEXTDOMAIN ),
									'one'	=>	esc_html__( 'Options 1', WISHLIST_FOR_WOO_TEXTDOMAIN ),
									'two'	=>	esc_html__( 'Options 2', WISHLIST_FOR_WOO_TEXTDOMAIN ),
								),
			'desc_tip'          => true,
			'name'          	=> 'true',
			'class'		        => 'mwb-wfw-select',
			'id'   				=> 'mwb-wfw-select-field-id',
			'custom_attributes' => array(
				'data-keytype' => esc_html__( 'user-role', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			),
		);

		$settings[] = array(
			'title' => esc_html__( 'Enable /Disable Toggle', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			'class' => 'mwb-wfw-toggle-checkbox',
			'type'  => 'checkbox',
			'desc_tip'          => true,
			'id'    => 'mwb-wfw-checkbox-field-id',
			'desc'  => esc_html__( 'Enable /Disable Toggle for any settings', WISHLIST_FOR_WOO_TEXTDOMAIN ),
		);

		$settings[] = array(
			'title' => esc_html__( 'classic checkbox', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			'class' => 'mwb-wfw-classic-checkbox',
			'type'  => 'checkbox',
			'name'  => 'gender',
			'desc_tip'          => true,
			'id'    => 'mwb-wfw-checkbox-classic-id',
			'desc'  => esc_html__( 'Checkbox for any settings', WISHLIST_FOR_WOO_TEXTDOMAIN ),
		);
		

		$settings[] = array(
			'title'             => esc_html__( 'Input type Text', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			'id'                => 'mwb-wfw-input-field-id',
			'type'              => 'text',
			'placeholder'       => 'Place holder here',
			'default'           => '',
			'desc'              => esc_html__( 'input fields', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			'desc_tip'          => true,
			'class'             => 'mwb-wfw-input-field',
			'custom_attributes' => array(
				'data-keytype' => esc_html__( 'input-field', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			),
		);

		$settings[] = array(
			'title'             => esc_html__( 'password type Text', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			'id'                => 'mwb-wfw-password-field-id',
			'type'              => 'password',
			'placeholder'       => 'Place holder here',
			'default'           => '',
			'desc'              => esc_html__( 'password', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			'desc_tip'          => true,
			'class'             => 'mwb-wfw-password-field',
			'custom_attributes' => array(
				'data-keytype' => esc_html__( 'password-field', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			),
		);

		$settings[] = array(
			'title'             => esc_html__( 'Textarea', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			'id'                => 'mwb-wfw-textarea-field-id',
			'type'              => 'textarea',
			'placeholder'       => 'Place holder here',
			'default'           => '',
			'desc'              => esc_html__( 'textarea', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			'desc_tip'          => true,
			'class'             => 'mwb-wfw-textarea-field',
			'custom_attributes' => array(
				'data-keytype' => esc_html__( 'textarea-field', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			),
		);

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
		
		$settings = array();
		$settings[] = array(
			'title' => esc_html__( 'This will be heading for Social Sharing Tab.', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			'class'    => 'mwb-wfw-sub-heading',
			'type'  => 'title',
			'id'    => 'mwb-wfw-heading',
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
		
		$settings = array();
		$settings[] = array(
			'title' => esc_html__( 'This will be heading for any Push Notification section seperation', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			'class'    => 'mwb-wfw-sub-heading',
			'type'  => 'title',
			'id'    => 'mwb-wfw-heading',
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
		$settings[] = array(
			'title' => esc_html__( 'This will be heading for Advance Features section.', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			'class'    => 'mwb-wfw-sub-heading',
			'type'  => 'title',
			'id'    => 'mwb-wfw-heading',
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
		
		$settings = array();
		$settings[] = array(
			'title' => esc_html__( 'This will be heading for CRM section', WISHLIST_FOR_WOO_TEXTDOMAIN ),
			'class'    => 'mwb-wfw-sub-heading',
			'type'  => 'title',
			'id'    => 'mwb-wfw-heading',
		);

		$settings[] = array(
			'type' => 'sectionend',
		);
		return $settings;
	}

# End of class.
}
