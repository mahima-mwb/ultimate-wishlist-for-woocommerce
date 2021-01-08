/**
 * This file belongs to the mwb Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */
(function ( $ ) {
    $(document).on( 'click', 'a.mwb-update-link', function(event){
        var t = $(this),
            p_wrapper = t.parent('p');

        event.preventDefault();
        $.ajax({
            type: 'POST',
            url: mwb_plugin_fw.ajaxurl,
            data: {
                'action': "update-plugin",
                'plugin': t.data('plugin'),
                'slug': t.data('slug'),
                'name': t.data('name'),
                '_ajax_nonce': mwb_plugin_fw.ajax_nonce
            },
            beforeSend: function(){
                p_wrapper.text( mwb_plugin_fw.l10n.updating.replace( '%s', t.data('name') ) );
                p_wrapper.addClass( 'mwb-updating' );
            },
            success: function (response) {
                p_wrapper.removeClass( 'mwb-updating' ).addClass( 'mwb-updated' );
                var notice_wrapper = p_wrapper.parent('div');
                notice_wrapper.removeClass( 'notice-warning' ),
                result_text = '';

                if( response.success === true ){
                    notice_wrapper.addClass('notice-success updated-message').removeClass( 'update-message' );
                    result_text = mwb_plugin_fw.l10n.updated;
                }

                else {
                    notice_wrapper.addClass('notice-error');
                    result_text = mwb_plugin_fw.l10n.failed;
                }

                p_wrapper.text( result_text.replace( '%s', t.data('name') ) );
            }
        });
    });
})( jQuery );
