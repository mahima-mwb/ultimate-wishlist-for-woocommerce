/**
 * All of the code for your admin-facing JavaScript source
 * should reside in this file.
 *
 * Note: It has been assumed you will write jQuery code here, so the
 * $ function reference has been prepared for usage within the scope
 * of this function.
 */
jQuery(document).ready(function() {

    const preloader = jQuery('.mwb-wfw-desc--preloader');
    const outputScreen = jQuery('.mwb-wfw-output-form');

    // Update Screen Upon hashchange.
    jQuery(window).bind('hashchange', function() {
        getCurrentScreens(window.location.hash);
    });

    // Update Screen Upon Page Reload.
    jQuery(window).bind('hashchange', getCurrentScreens(window.location.hash));

    /**==================================================
                    Literal Functionalities.
    ====================================================*/

    // Open/shut Helpdesk button.
    jQuery('.mwb-wfw-helpdesk-btn').on('click', function() {
        jQuery(this).parents('.mwb-wfw-row').toggleClass('active');
        jQuery('.mwb-wfw-row').children('.mwb-wfw-desc').toggleClass('mwb-wfw-overlay--active');
    });

    // Open/shut Nav toggle in mobile view.
    jQuery('.mwb-wfw-toggler').on('click', function() {
        jQuery('.mwb-wfw-nav-collapse').slideToggle('slow');
    });

    /**==================================================
                    Function Definations
    ====================================================*/

    /**
     * On selection of new tab get the concerned template.
     * @param {string} hashScreen  index of selected tab.
     */
    function getCurrentScreens(hashScreen = false) {

        // Default tab : General Settings.
        hashScreen = hashScreen.length ? hashScreen : '#general';

        /**
         * Step 1 : Before requesting the screen get the preloader on.
         * Step 2 : Handle Current Active Tab.
         * Step 3 : Empty current template.
         * Step 4 : Get current template.
         */
        preloader.css('display', 'flex');
        handleNavLinks(hashScreen);
        jQuery('.mwb-wfw-output-container').remove();
        outputScreen.empty();

        jQuery.ajax({
            type: 'post',
            dataType: 'json',
            url: mwb_wfw_obj.ajaxUrl,
            data: {
                nonce: mwb_wfw_obj.authNonce,
                action: 'getCurrentScreen',
                hashScreen: hashScreen,
            },
            success: function(result) {
                processResult(result);
            },
            error: function(xhr, textStatus, errorThrown) {
                if ('error' == textStatus) {
                    swal(textStatus.toUpperCase(), errorThrown, 'error');
                }
            }
        });
    }

    /**
     * Toggle active class within nav bars.
     * @param {string} hashScreen  index of selected tab.
     */
    function handleNavLinks(hashScreen) {
        jQuery('.mwb-wfw-nav-link').removeClass('mwb-wfw-nav-link--active');
        jQuery('a[href="' + hashScreen + '"]').addClass('mwb-wfw-nav-link--active');
    }

    /**
     * Result Ajax callback.
     * @param {object} result The result of template upon ajax call.
     */
    function processResult(result) {

        // Successfully add template.
        if (200 == result.status) {
            outputScreen.html(result.content);

            // Enable select2 fields.
            jQuery('.mwb-wfw-multi-select').select2();
        }

        // Template not Found.
        else if (404 == result.status) {
            swal(result.status.toString(), mwb_wfw_obj.notfoundErrorMessage, 'error');
        }

        // In case of any critical error.
        else {

            message = result.content.length ? result.content : mwb_wfw_obj.criticalErrorMessage;
            swal(result.status.toString(), message, 'error');
        }

        // Hide Preloader.
        preloader.hide();
    }

    // End of scripts.
    // Custom JS for save and cancel button
});