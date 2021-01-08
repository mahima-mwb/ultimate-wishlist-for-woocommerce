jQuery(document).ready( function($) {
    var pointers    = custom_pointer.pointers[0],
        options     = pointers.options,
        target      = $(pointers.target),
        pointer_id  = pointers.pointer_id;

    $(target).find('.wp-submenu li a').each(function () {

            var t = $(this),
                href = t.attr('href');

            href = href.replace('admin.php?page=', '');

            if( href == pointer_id ){

                var selected_plugin_row = t.add( target ),
                    top_level_menu      = target.find( pointers.target.replace( '#', '.' ) );

                target.toggleClass('wp-no-current-submenu wp-menu-open wp-has-current-submenu');

                t.pointer({
                    pointerClass: 'mwb-wp-pointer',
                    content : options.content,
                    position: options.position,
                    open    : function () {
                        selected_plugin_row.toggleClass( 'mwb-pointer-selected-row' );
                        top_level_menu.addClass( 'mwb-pointer' );
                    },


                    close   : function () {
                        target.toggleClass('wp-no-current-submenu wp-menu-open wp-has-current-submenu');
                        selected_plugin_row.toggleClass( 'mwb-pointer-selected-row' );
                        top_level_menu.removeClass( 'mwb-pointer' );

                        $.ajax({
                            type   : 'POST',
                            url    : ajaxurl,
                            data   : {
                                "action" : "dismiss-wp-pointer",
                                "pointer": pointer_id
                            },
                            success: function (response) {
                            }
                        });

                    }
                }).pointer('open');
            } else if( 'mwb_default_pointer' == pointer_id ) {

                 var selected_plugin_row = t.add( target ),
                     top_level_menu      = target.find( pointers.target.replace( '#', '.' )),
                     mwb_plugins         = $( pointers.target );

                mwb_plugins.addClass('wp-has-current-submenu');

                top_level_menu.pointer({
                    pointerClass: 'mwb-wp-pointer',
                    content : options.content,
                    position: options.position,

                    open    : function () {
                        mwb_plugins.addClass( 'mwb-pointer-selected-row' );
                    },

                    close   : function () {
                        mwb_plugins.removeClass( 'mwb-pointer-selected-row wp-has-current-submenu' );

                        $.ajax({
                            type   : 'POST',
                            url    : ajaxurl,
                            data   : {
                                "action" : "dismiss-wp-pointer",
                                "pointer": pointer_id
                            },
                            success: function (response) {
                            }
                        });
                    }
                }).pointer('open');
            }
        });
});