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

<!-- Header Section -->
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<main class="mwb-wfw-main">
    <header class="mwb-wfw-header">
        <h1 class="mwb-wfw-header__title"><?php esc_html_e( 'Wishlist for Woocommerce', WISHLIST_FOR_WOO_TEXTDOMAIN ); ?></h1>
        <span class="mwb-wfw-version"><?php echo sprintf( 'v%s', esc_html( WISHLIST_FOR_WOO_VERSION ) ); ?></span>
    </header>
    <!-- End of Header Section -->

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
            <ul class="mwb-wfw-nav mwb-wfw-nav-tabs" id="myTab" role="tablist">
                <li class="mwb-wfw-nav-item">
                    <a class="mwb-wfw-nav-link mwb-wfw-nav-link--active" href="#general"><?php esc_html_e( 'General', WISHLIST_FOR_WOO_TEXTDOMAIN ); ?></a>
                </li>
                <li class="mwb-wfw-nav-item">
                    <a class="mwb-wfw-nav-link" href="#social_sharing"><?php esc_html_e( 'Social Sharing', WISHLIST_FOR_WOO_TEXTDOMAIN ); ?></a>
                </li>
                <li class="mwb-wfw-nav-item">
                    <a class="mwb-wfw-nav-link" href="#push_notification"><?php esc_html_e( 'Push Notification', WISHLIST_FOR_WOO_TEXTDOMAIN ); ?></a>
                </li>
                <li class="mwb-wfw-nav-item">
                    <a class="mwb-wfw-nav-link" href="#advance_feature"><?php esc_html_e( 'Advance Features', WISHLIST_FOR_WOO_TEXTDOMAIN ); ?></a>
                </li>
                <li class="mwb-wfw-nav-item">
                    <a class="mwb-wfw-nav-link" href="#crm"><?php esc_html_e( 'CRM Configuration', WISHLIST_FOR_WOO_TEXTDOMAIN ); ?></a>
                </li>
            </ul>
        </div>
    </nav>
    <!-- End of Tabs Section -->

    <div class="mwb-wfw-container">
        <div class="mwb-wfw-row">
            <div class="mwb-wfw-desc">
                <div id="mwb-wfw-desc--preloader" class="mwb-wfw-desc--preloader">
                    <img src="<?php echo esc_url( WISHLIST_FOR_WOO_URL . 'admin/images/preloader.gif' ) ?>" alt="loader">
                    <h4><?php esc_html_e( 'Loading settings please wait...', WISHLIST_FOR_WOO_TEXTDOMAIN ); ?></h4>
                </div>
            </div>
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
        </div>
    </div>
</main>