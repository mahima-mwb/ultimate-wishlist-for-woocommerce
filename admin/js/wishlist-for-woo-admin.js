/**
 * All of the code for your admin-facing JavaScript source
 * should reside in this file.
 *
 * Note: It has been assumed you will write jQuery code here, so the
 * $ function reference has been prepared for usage within the scope
 * of this function.
 */
// function preloader() {
//     // preloader.style.display = 'none';
//     var preloader = $('.mwb-wfw-desc--preloader');
//     jQuery('.mwb-wfw-desc--preloader').css('display', 'none');
//     console.log("running")
// }
jQuery(document).ready(function() {
    console.log('testing cases running');


    jQuery('.mwb-wfw-helpdesk-btn').on('click', function() {
        jQuery(this).parents('.mwb-wfw-row').toggleClass('active');
        jQuery('.mwb-wfw-row').children('.mwb-wfw-desc').toggleClass('mwb-wfw-overlay--active');
    });
    jQuery('.mwb-wfw-toggler').on('click', function() {
        jQuery('.mwb-wfw-nav-collapse').slideToggle('slow');
    })
    jQuery('.mwb-wfw-nav-link').on('click', function() {
        if (jQuery(this).parents('.mwb-wfw-nav-item').parents('.mwb-wfw-nav').find('.mwb-wfw-nav-link--active').removeClass('mwb-wfw-nav-link--active')) {
            jQuery(this).addClass('mwb-wfw-nav-link--active');
        }
    });

    // jQuery('div.mwb-wfw-desc--preloader').remove();
});