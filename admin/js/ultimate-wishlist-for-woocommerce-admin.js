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
    const saveScreen = jQuery('.mwb-wfw_save-wrapper');
    const savetext = jQuery('.mwb-wfw_save-text'); 
    const saveButton = jQuery('.mwb-wfw_save-link');
    const cancelButton = jQuery('.mwb-wfw_cancel-link');    
    const saveUpdates = ( data ) => {
        savetext.addClass( 'is-hidden' );

        let defaultHash = '';

        switch ( params.page ) {
            case 'wfw-config-portal':
                defaultHash = '#general';
                break;
            case 'wfw-performance-reporting':
                defaultHash = '#wishlist_base';
                break;
            default:
                defaultHash = '#overview';
                break;
        }

        return jQuery.ajax({
            type: 'post',
            dataType: 'json',
            url: mwb_wfw_obj.ajaxUrl,
            data: {
                nonce: mwb_wfw_obj.authNonce,
                action: 'saveFormOutput',
                data: data,
                screen : window.location.hash.length ? window.location.hash : defaultHash
            },
            success: function(result) {
                savetext.removeClass( 'is-hidden' );
                setTimeout( function () {
                   rollbackFormChanges()
                }, 2000 );

                if ( 200 == result.status ) {
                   var screen = window.location.hash.length ? window.location.hash : defaultHash;
                    if ( '#push_notify' == screen ) {
                        jQuery.ajax({
                            type: 'post',
                            url : mwb_wfw_obj.ajaxUrl,
                            data: {
                                nonce: mwb_wfw_obj.authNonce,
                                action: 'MoveFiletoRoot',
                            },
                            success : function(result) {
                                if ( false == result.status ) {
                                    swal( 'Opps!!', result.message, 'error' );
                                    jQuery( '#wfw-enable-push-notif' ).trigger('click');
                                    saveButton.trigger('click');
                                }
                            }
                        });
                    }
                }
            },
            error: function(xhr, textStatus, errorThrown) {
                if ('error' == textStatus) {
                    swal(textStatus.toUpperCase(), errorThrown, 'error');
                }
            }
        });
    };

    // Update Screen Upon hashchange.
    jQuery(window).bind( 'hashchange', function() {
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

    // Cancel button.
    cancelButton.on( 'click', function () {
        rollbackFormChanges();
    });

    // Save button.
    saveButton.on( 'click', function () {
        saveFormChanges();
    });
    
    /**==================================================
                    Function Definations
    ====================================================*/

    /**
     * On selection of new tab get the concerned template.
     * @param {string} hashScreen  index of selected tab.
     */
    function getCurrentScreens(hashScreen = false) {

        params = mwb_wfw_obj.params;
        let defaultHash = '';

        switch ( params.page ) {
            case 'wfw-config-portal':
                defaultHash = '#general';
                break;
            case 'wfw-performance-reporting':
                defaultHash = '#wishlist_base';
                break;
            default:
                defaultHash = '#overview';
                break;
        }

        // Default tab : General Settings.
        hashScreen = hashScreen.length ? hashScreen : defaultHash;

        /**
         * Step 1 : Before requesting the screen get the preloader on.
         * Step 2 : Handle Current Active Tab.
         * Step 3 : Empty current template.
         * Step 4 : Get current template.
         */
        preloader.css('display', 'flex');
        handleNavLinks( hashScreen );
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
                let option_color  = jQuery( '.mwb-wfw-color' );
                option_color.wpColorPicker({
                    change: (event, ui) => {
                        saveScreen.removeClass( 'is-hidden' )
                    }
                });
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

            // Append template html.
            outputScreen.html( result.content );

            // Alter tooltip html.
            let tooltip = jQuery( '.woocommerce-help-tip' );
            tooltip.each( function() {
                let data_tip = jQuery( this ).attr( 'data-tip' );
                let label = jQuery( this ).closest( 'label' );
                labelclass = label.text().replace(/\s+/g, '-').toLowerCase() + 'label';

                reformed_tip = jQuery( this ).append( '<span class="woocommerce-help-tip-text ' + labelclass + '">' + data_tip + '</span>' );
            });

            // Enable select2 fields.
            jQuery('.mwb-wfw-multi-select').select2();
            jQuery.each( jQuery( 'input, select ,textarea, button', '.mwb-wfw-output-form' ), function() {
                showSavePortal( jQuery(this));
            });

            // Subsettings show/hide on change and ready.
            jQuery.each( jQuery( '.mwb-wfw-select' ), function() {
                handleSubSetings( jQuery( this ) );
            });
            
            jQuery( '.mwb-wfw-select' ).on( 'change', function () {
                handleSubSetings( jQuery( this ) );
            });
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

    /**
     * Show Save/Cancel Button.
     */
    function showSavePortal( obj ) {
        obj.on( 'change', function(){
            saveScreen.removeClass( 'is-hidden' )
        });
    }

    /**
     * Cancel Button Click.
     */
    function rollbackFormChanges() {
        saveScreen.addClass( 'is-hidden' );
        savetext.addClass( 'is-hidden' );
    }

    /**
     * Save Button Click.
     */
    function saveFormChanges() {
        saveUpdates( outputScreen.serialize() );
    }

    /**
     * Show Hide Subsettings.
     */
    function handleSubSetings(obj) {
        let dependency = obj.attr( 'dependency-type' );
        let id = obj.attr( 'id' );

        if( 'undefined' == typeof dependency || 'undefined' == typeof id ) {
            return;
        }

        val = obj.val();

        // Update custom attr for dependency.
        obj.attr( 'dependency-type', val );

        // Hide all dependent fields and Show only the selected one.
        jQuery( '.' + id + '-dependent'  ).closest('tr').hide();
        jQuery( '[ dependent="dependency-type-' + val + '" ]' ).closest('tr').show();
    }

    // toggle Helpdesk
    jQuery('.mwb-wfw-helpdesk__icon img').on('click', function() {
        jQuery('.mwb-wfw-desc').toggleClass('mwb-wfw-over');
    })

// End of scripts.
});
