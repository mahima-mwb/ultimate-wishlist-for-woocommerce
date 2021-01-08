( function ( $ ) {

    /* global mwb_framework_fw_fields*/

    var mwb_fields_init = function () {
        var $datepicker   = $( '.mwb-plugin-fw-datepicker' ),
            $colorpicker  = $( '.mwb-plugin-fw-colorpicker' ),
            $upload       = {
                imgPreviewHandler  : '.mwb-plugin-fw-upload-img-preview',
                uploadButtonHandler: '.mwb-plugin-fw-upload-button',
                imgUrlHandler      : '.mwb-plugin-fw-upload-img-url',
                resetButtonHandler : '.mwb-plugin-fw-upload-button-reset',
                imgUrl             : $( '.mwb-plugin-fw-upload-img-url' )
            },
            $wpAddMedia   = $( '.add_media' ),
            $imageGallery = {
                sliderWrapper: $( '.mwb-plugin-fw .image-gallery ul.slides-wrapper' ),
                buttonHandler: '.mwb-plugin-fw .image-gallery-button'
            },
            $sidebars     = $( '.mwb-plugin-fw-sidebar-layout' ),
            $slider       = $( '.mwb-plugin-fw .mwb-plugin-fw-slider-container .ui-slider-horizontal' ),
            $codemirror   = $( '.codemirror' ),
            $icons        = $( '.mwb-icons-manager-wrapper' ),
            $checkgroup   = $( ".mwb-plugin-ui td.forminp-checkbox" );

        /* Datepicker */
        $datepicker.each( function () {
            var args = $( this ).data();

            // set animation to false to prevent style 'glitches' when removing class on closing
            args.showAnim   = false;
            args.beforeShow = function ( input, instance ) {
                instance.dpDiv.addClass( 'mwb-plugin-fw-datepicker-div' );
            };
            args.onClose    = function ( selectedDate, instance ) {
                instance.dpDiv.removeClass( 'mwb-plugin-fw-datepicker-div' );
            };

            $( this ).datepicker( args );
        } );

        /* Colorpicker */
        $colorpicker.wpColorPicker( {
            palettes: false,
            width   : 200,
            mode    : 'hsl',
            clear   : function () {
                var input = $( this );
                input.val( input.data( 'default-color' ) );
                input.change();
            }
        } );


        $colorpicker.each( function () {
            var select_label = $( this ).data( 'variations-label' ),
                wrap_main1   = $( this ).closest( '.mwb-plugin-fw-colorpicker-field-wrapper' ),
                wrap_main2   = $( this ).closest( '.mwb-single-colorpicker' ),
                wrap1        = wrap_main1.find( '.wp-picker-input-wrap' ),
                wrap2        = wrap_main2.find( '.wp-picker-input-wrap' );

            wrap1.length && wrap_main1.find( 'a.wp-color-result' ).attr( 'title', select_label );
            wrap_main2.length && wrap_main2.find( 'a.wp-color-result' ).attr( 'title', select_label );

            if ( !wrap1.find( '.wp-picker-clear-custom' ).length ) {
                var button = $( '<span/>' ).attr( {
                    class: "wp-picker-default-custom"
                } );
                wrap1.find( '.wp-picker-default' ).wrap( button );
            }

            if ( !wrap2.find( '.wp-picker-clear-custom' ).length ) {
                var button = $( '<span/>' ).attr( {
                    class: "wp-picker-default-custom"
                } );
                wrap2.find( '.wp-picker-default' ).wrap( button );
            }
        } );


        /* Upload */
        if ( typeof wp !== 'undefined' && typeof wp.media !== 'undefined' ) {
            var _custom_media = true;
            // preview
            $upload.imgUrl.change( function () {
                var url     = $( this ).val(),
                    re      = new RegExp( "(http|ftp|https)://[a-zA-Z0-9@?^=%&amp;:/~+#-_.]*.(gif|jpg|jpeg|png|ico|svg)" ),
                    preview = $( this ).parent().find( $upload.imgPreviewHandler ).first();

                if ( preview.length < 1 ) {
                    preview = $( this ).parent().parent().find( $upload.imgPreviewHandler ).first();
                }

                if ( re.test( url ) ) {
                    preview.html( '<img src="' + url + '" style="max-width:100px; max-height:100px;" />' );
                } else {
                    preview.html( '' );
                }
            } ).trigger( 'change' );

            $( document ).on( 'click', $upload.uploadButtonHandler, function ( e ) {
                e.preventDefault();

                var t  = $( this ),
                    custom_uploader,
                    id = t.attr( 'id' ).replace( /-button$/, '' ).replace(/(\[|\])/g, '\\$1');

                //If the uploader object has already been created, reopen the dialog
                if ( custom_uploader ) {
                    custom_uploader.open();
                    return;
                }

                var custom_uploader_states = [
                    // Main states.
                    new wp.media.controller.Library( {
                        library   : wp.media.query(),
                        multiple  : false,
                        title     : 'Choose Image',
                        priority  : 20,
                        filterable: 'uploaded'
                    } )
                ];

                // Create the media frame.
                custom_uploader = wp.media.frames.downloadable_file = wp.media( {
                    // Set the title of the modal.
                    title   : 'Choose Image',
                    library : {
                        type: ''
                    },
                    button  : {
                        text: 'Choose Image'
                    },
                    multiple: false,
                    states  : custom_uploader_states
                } );

                //When a file is selected, grab the URL and set it as the text field's value
                custom_uploader.on( 'select', function () {
                    var attachment = custom_uploader.state().get( 'selection' ).first().toJSON();

                    $( "#" + id ).val( attachment.url );
                    // Save the id of the selected element to an element which name is the same with a suffix "-mwb-attachment-id"
                    if ( $( "#" + id + "-mwb-attachment-id" ) ) {
                        $( "#" + id + "-mwb-attachment-id" ).val( attachment.id );
                    }
                    $upload.imgUrl.trigger( 'change' );
                } );

                //Open the uploader dialog
                custom_uploader.open();
            } );

            $( document ).on( 'click', $upload.resetButtonHandler, function ( e ) {
                var t             = $( this ),
                    id            = t.attr( 'id' ).replace(/(\[|\])/g, '\\$1'),
                    input_id      = t.attr( 'id' ).replace( /-button-reset$/, '' ).replace(/(\[|\])/g, '\\$1'),
                    default_value = $( '#' + id ).data( 'default' );

                $( "#" + input_id ).val( default_value );
                $upload.imgUrl.trigger( 'change' );
            } );
        }

        $wpAddMedia.on( 'click', function () {
            _custom_media = false;
        } );

        /* Image Gallery */
        if ( typeof wp !== 'undefined' && typeof wp.media !== 'undefined' ) {
            $( document ).on( 'click', $imageGallery.buttonHandler, function ( e ) {
                var $t                      = $( this ),
                    $container              = $t.closest( '.image-gallery' ),
                    $image_gallery_ids      = $container.find( '.image_gallery_ids' ),
                    attachment_ids          = $image_gallery_ids.val(),
                    $gallery_images_wrapper = $container.find( 'ul.slides-wrapper' );

                // Create the media frame.
                var image_gallery_frame = wp.media.frames.image_gallery = wp.media( {
                    // Set the title of the modal.
                    title : $t.data( 'choose' ),
                    button: {
                        text: $t.data( 'update' )
                    },
                    states: [
                        new wp.media.controller.Library( {
                            title     : $t.data( 'choose' ),
                            filterable: 'all',
                            multiple  : true
                        } )
                    ]
                } );

                // When an image is selected, run a callback.
                image_gallery_frame.on( 'select', function () {
                    var selection = image_gallery_frame.state().get( 'selection' );
                    selection.map( function ( attachment ) {
                        attachment = attachment.toJSON();

                        if ( attachment.id ) {
                            attachment_ids = attachment_ids ? attachment_ids + "," + attachment.id : attachment.id;
                            $gallery_images_wrapper.append( '<li class="image" data-attachment_id="' + attachment.id + '"><img src="' + attachment.sizes.thumbnail.url + '"/><ul class="actions"><li><a href="#" class="delete" title="' + $t.data( 'delete' ) + '">x</a></li></ul></li>' );
                        }
                    } );

                    $image_gallery_ids.val( attachment_ids );
                } );

                image_gallery_frame.open();

            } );

            // Image ordering
            $imageGallery.sliderWrapper.each( function () {
                var $t = $( this );
                $t.sortable( {
                    items               : 'li.image',
                    cursor              : 'move',
                    scrollSensitivity   : 40,
                    forcePlaceholderSize: true,
                    forceHelperSize     : false,
                    helper              : 'clone',
                    opacity             : 0.65,
                    start               : function ( event, ui ) {
                        ui.item.css( 'background-color', '#f6f6f6' );
                    },
                    stop                : function ( event, ui ) {
                        ui.item.removeAttr( 'style' );
                    },
                    update              : function ( event, ui ) {
                        var attachment_ids = '';

                        $t.find( 'li.image' ).css( 'cursor', 'default' ).each( function () {
                            var attachment_id = $( this ).attr( 'data-attachment_id' );
                            attachment_ids    = attachment_ids + attachment_id + ',';
                        } );

                        $t.closest( '.image-gallery' ).find( '.image_gallery_ids' ).val( attachment_ids );
                    }
                } );
            } );

            // Remove images
            $imageGallery.sliderWrapper.on( 'click', 'a.delete', function () {
                var $wrapper           = $( this ).closest( '.image-gallery' ),
                    $gallery           = $( this ).closest( '.image-gallery ul.slides-wrapper' ),
                    $image_gallery_ids = $wrapper.find( '.image_gallery_ids' ),
                    attachment_ids     = '';

                $( this ).closest( 'li.image' ).remove();

                $gallery.find( 'li.image' ).css( 'cursor', 'default' ).each( function () {
                    var attachment_id = $( this ).attr( 'data-attachment_id' );
                    attachment_ids    = attachment_ids + attachment_id + ',';
                } );

                $image_gallery_ids.val( attachment_ids );
            } );
        }


        /* Sidebars */
        $sidebars.each( function () {
            var $images = $( this ).find( 'img' );
            $images.on( 'click', function () {
                var $container = $( this ).closest( '.mwb-plugin-fw-sidebar-layout' ),
                    $left      = $container.find( '.mwb-plugin-fw-sidebar-layout-sidebar-left-container' ),
                    $right     = $container.find( '.mwb-plugin-fw-sidebar-layout-sidebar-right-container' ),
                    type       = $( this ).data( 'type' );

                $( this ).parent().children( ':radio' ).attr( 'checked', false );
                $( this ).prev( ':radio' ).attr( 'checked', true );

                if ( typeof type != 'undefined' ) {
                    switch ( type ) {
                        case 'left':
                            $left.show();
                            $right.hide();
                            break;
                        case 'right':
                            $right.show();
                            $left.hide();
                            break;
                        case 'double':
                            $left.show();
                            $right.show();
                            break;
                        default:
                            $left.hide();
                            $right.hide();
                            break;
                    }
                }
            } );
        } );

        /* Slider */
        $slider.each( function () {
            var val      = $( this ).data( 'val' ),
                minValue = $( this ).data( 'min' ),
                maxValue = $( this ).data( 'max' ),
                step     = $( this ).data( 'step' ),
                labels   = $( this ).data( 'labels' );

            $( this ).slider( {
                value: val,
                min  : minValue,
                max  : maxValue,
                range: 'min',
                step : step,

                create: function () {
                    $( this ).find( '.ui-slider-handle' ).text( $( this ).slider( "value" ) );
                },


                slide: function ( event, ui ) {
                    $( this ).find( 'input' ).val( ui.value );
                    $( this ).find( '.ui-slider-handle' ).text( ui.value );
                    $( this ).siblings( '.feedback' ).find( 'strong' ).text( ui.value + labels );
                }
            } );
        } );

        /* codemirror */
        $codemirror.each( function ( i, v ) {
            var editor = CodeMirror.fromTextArea( v, {
                lineNumbers            : 1,
                mode                   : 'javascript',
                showCursorWhenSelecting: true
            } );

            $( v ).data( 'codemirrorInstance', editor );
        } );

        /* Select All - Deselect All */
        $( document ).on( 'click', '.mwb-plugin-fw-select-all', function () {
            var $targetSelect = $( '#' + $( this ).data( 'select-id' ) );
            $targetSelect.find( 'option' ).prop( 'selected', true ).trigger( 'change' );
        } );

        $( document ).on( 'click', '.mwb-plugin-fw-deselect-all', function () {
            var $targetSelect = $( '#' + $( this ).data( 'select-id' ) );
            $targetSelect.find( 'option' ).prop( 'selected', false ).trigger( 'change' );
        } );


        $icons.each( function () {
            var $container = $( this ),
                $preview   = $container.find( '.mwb-icons-manager-icon-preview' ).first(),
                $text      = $container.find( '.mwb-icons-manager-icon-text' );

            $container.on( 'click', '.mwb-icons-manager-list li', function ( event ) {
                var $target = $( event.target ).closest( 'li' ),
                    font    = $target.data( 'font' ),
                    icon    = $target.data( 'icon' ),
                    key     = $target.data( 'key' ),
                    name    = $target.data( 'name' );

                $preview.attr( 'data-font', font );
                $preview.attr( 'data-icon', icon );
                $preview.attr( 'data-key', key );
                $preview.attr( 'data-name', name );

                $text.val( font + ':' + name );

                $container.find( '.mwb-icons-manager-list li' ).removeClass( 'active' );
                $target.addClass( 'active' );
            } );

            $container.on( 'click', '.mwb-icons-manager-action-set-default', function () {
                $container.find( '.mwb-icons-manager-list li.default' ).trigger( 'click' );
            } );
        } );

        /** Select Images */
        $( document ).on( 'click', '.mwb-plugin-fw-select-images__item', function () {
            var item    = $( this ),
                key     = item.data( 'key' ),
                wrapper = item.closest( '.mwb-plugin-fw-select-images__wrapper' ),
                items   = wrapper.find( '.mwb-plugin-fw-select-images__item' ),
                select  = wrapper.find( 'select' ).first();

            if ( select.length ) {
                select.val( key ).trigger('mwb_select_images_value_changed');
                items.removeClass( 'mwb-plugin-fw-select-images__item--selected' );
                item.addClass( 'mwb-plugin-fw-select-images__item--selected' );
            }
        } );

        $( document.body ).trigger( 'wc-enhanced-select-init' );

        $( document ).find( '.ui-sortable .mwb-toggle-elements' ).sortable(
            {
                cursor              : 'move',
                axis                : 'y',
                scrollSensitivity   : 40,
                forcePlaceholderSize: true,
                helper              : 'clone',

                stop: function ( event, ui ) {
                    var keys       = jQuery( '.ui-sortable-handle' ),
                        i          = 0,
                        array_keys = new Array();
                    for ( i = 0; i < keys.length; i++ ) {
                        array_keys[ i ] = $( keys[ i ] ).data( 'item_key' );
                    }
                    if ( array_keys.length > 0 ) {
                        var toggle = $( this ).closest( '.toggle-element' );
                        toggle.saveToggleElement( null, array_keys );
                    }
                }
            }
        );

        $( document.body ).trigger( 'mwb-framework-enhanced-select-init' );
    };

    $( document ).on( 'mwb_fields_init', mwb_fields_init ).trigger( 'mwb_fields_init' );

    /* on-off */
    $( document ).on( 'click', '.mwb-plugin-fw-onoff-container span', function () {
        var input   = $( this ).prev( 'input' ),
            checked = input.prop( 'checked' );

        if ( checked ) {
            input.prop( 'checked', false ).attr( 'value', 'no' ).removeClass( 'onoffchecked' );
        } else {
            input.prop( 'checked', true ).attr( 'value', 'yes' ).addClass( 'onoffchecked' );
        }

        input.change();
    } );


    /** Toggle **/



    //TOGGLE ELEMENT
    $.fn.saveToggleElement = function ( spinner, array_keys ) {
        var toggle      = $( this ),
            action      = 'mwb_plugin_fw_save_toggle_element',
            formdata    = toggle.serializeToggleElement(),
            wrapper     = toggle.find( '.mwb-toggle_wrapper' ),
            id          = wrapper.attr( 'id' ),
            current_tab = $.urlParam( 'tab' );

        formdata.append( 'security', wrapper.data( 'nonce' ) );

        if ( typeof array_keys != 'undefined' && array_keys.length > 0 ) {
            formdata.append( 'mwb_toggle_elements_order_keys', array_keys );
        }

        if ( toggle.closest( '.metaboxes-tab.mwb-plugin-ui' ).length ) {
            action              = 'mwb_plugin_fw_save_toggle_element_metabox';
            post_id             = $( this ).closest( 'form#post' ).find( '#post_ID' ).val();
            mwb_metaboxes_nonce = $( this ).closest( 'form#post' ).find( '#mwb_metaboxes_nonce' ).val();
            metabox_tab         = $( this ).closest( '.tabs-panel' ).attr( 'id' );
            url                 = mwb_framework_fw_fields.ajax_url +
                '?action=' + action +
                "&post_ID=" + post_id +
                '&mwb_metaboxes_nonce=' + mwb_metaboxes_nonce +
                "&toggle_id=" + id +
                "&metabox_tab=" + metabox_tab;
        } else {
            url = mwb_framework_fw_fields.admin_url + '?action=' + action + '&tab=' + current_tab + "&toggle_id=" + id;
        }

        $.ajax( {
            type       : "POST",
            url        : url,
            data       : formdata,
            contentType: false,
            processData: false,
            success    : function ( result ) {
                if ( spinner ) {
                    spinner.removeClass( 'show' );
                }

                $( document ).trigger( 'mwb_save_toggle_element_done', [result, toggle] );
            }
        } );
    };

    $.fn.serializeToggleElement = function () {
        var obj = $( this );
        /* ADD FILE TO PARAM AJAX */
        var formData = new FormData();
        var params   = $( obj ).find( ":input" ).serializeArray();

        $.each( params, function ( i, val ) {
            el_name = val.name;
            formData.append( val.name, val.value );
        } );

        return formData;
    };

    $.fn.formatToggleTitle = function () {
        var toggle_el = $( this ),
            fields    = toggle_el.find( ':input' ),
            title     = toggle_el.find( 'span.title' ).data( 'title_format' ),
            subtitle  = toggle_el.find( '.subtitle' ).data( 'subtitle_format' ),
            regExp    = new RegExp( "[^%%]+(?=[%%])", 'g' );

        if ( typeof title != 'undefined' ) {
            var res = title.match( regExp );
        }

        if ( typeof subtitle != 'undefined' ) {
            var ressub = subtitle.match( regExp );
        }

        $.each( fields, function ( i, field ) {
            if ( typeof $( field ).attr( 'id' ) != 'undefined' ) {
                $field_id    = $( field ).attr( 'id' );
                $field_array = $field_id.split( '_' );
                $field_array.pop();
                $field_id  = $field_array.join( '_' );
                $field_val = $( field ).val();

                if ( res != null && typeof res != 'undefined' && res.indexOf( $field_id ) !== -1 ) {
                    title = title.replace( '%%' + $field_id + '%%', $field_val );
                }
                if ( ressub != null && typeof ressub != 'undefined' && ressub.indexOf( $field_id ) !== -1 ) {
                    subtitle = subtitle.replace( '%%' + $field_id + '%%', $field_val );
                }
            }
        } );

        if ( '' !== title ) {
            toggle_el.find( 'span.title' ).html( title );
        }

        if ( '' !== subtitle ) {
            toggle_el.find( '.subtitle' ).html( subtitle );
        }

        $( document ).trigger( 'mwb-toggle-element-item-title', [toggle_el] );
    };

    $.urlParam = function ( name ) {
        var results = new RegExp( '[\?&]' + name + '=([^&#]*)' )
            .exec( window.location.search );

        return ( results !== null ) ? results[ 1 ] || 0 : false;
    };

    $( document ).on( 'click', '.mwb-toggle-title', function ( event ) {
        var _toggle  = $( event.target ),
            _section = _toggle.closest( '.mwb-toggle-row' ),
            _content = _section.find( '.mwb-toggle-content' );

        if ( _toggle.hasClass( 'mwb-plugin-fw-onoff' ) || _toggle.hasClass( 'mwb-icon-drag' ) ) {
            return false;
        }

        if ( _section.is( '.mwb-toggle-row-opened' ) ) {
            _content.slideUp( 400 );
        } else {
            _content.slideDown( 400 );
        }
        _section.toggleClass( 'mwb-toggle-row-opened' );
    } );

    /**Add new box toggle**/
    $( document ).on( 'click', '.mwb-add-box-button', function ( event ) {
        event.preventDefault();
        var $this        = $( this ),
            target_id    = $this.data( 'box_id' ),
            closed_label = $this.data( 'closed_label' ),
            label        = $this.data( 'opened_label' ),
            id           = $this.closest( '.mwb-toggle_wrapper' ).attr( 'id' );
        template         = wp.template( 'mwb-toggle-element-add-box-content-' + id );

        if ( '' !== target_id ) {
            $( '#' + target_id ).html( template( { index: 'box_id' } ) ).slideToggle();
            if ( closed_label !== '' ) {
                if ( $this.html() === closed_label ) {
                    $this.html( label ).removeClass( 'closed' );
                } else {
                    $this.html( closed_label ).addClass( 'closed' );
                }
            }

            $( document ).trigger( 'mwb_fields_init' );
            $( document ).trigger( 'mwb-add-box-button-toggle', [$this] );
        }
    } );

    $( document ).on( 'click', '.mwb-add-box-buttons .mwb-save-button', function ( event ) {

        event.preventDefault();
        var add_box        = $( this ).parents( '.mwb-add-box' ),
            id             = $( this ).closest( '.mwb-toggle_wrapper' ).attr( 'id' ),
            spinner        = add_box.find( '.spinner' ),
            toggle_element = $( this ).parents( '.toggle-element' ),
            fields         = add_box.find( ':input' ),
            counter        = toggle_element.find( '.mwb-toggle-row' ).length,
            hidden_obj     = $( '<input type="hidden">' );

        hidden_obj.val( counter );

        $( document ).trigger( 'mwb-toggle-change-counter', [hidden_obj, add_box] );

        counter       = hidden_obj.val();
        var template  = wp.template( 'mwb-toggle-element-item-' + id ),
            toggle_el = $( template( { index: counter } ) );

        spinner.addClass( 'show' );

        $.each( fields, function ( i, field ) {
            if ( typeof $( field ).attr( 'id' ) != 'undefined' ) {

                $field_id  = $( field ).attr( 'id' );
                $field_val = $( field ).val();

                if ( 'radio' == $( field ).attr( 'type' ) ) {
                    $field_id = $field_id.replace( 'new_', '' );
                    $field_id = $field_id.replace( '-' + $field_val, '' );
                    $field_id = $field_id + '_dataindex-' + $field_val;
                } else {
                    $field_id = $field_id.replace( 'new_', '' ) + '_' + counter;
                }

                if ( $( field ).is( ':checked' ) ) {
                    $( toggle_el ).find( '#' + $field_id ).prop( 'checked', true );
                }

                if ( $( field ).hasClass( 'mwb-post-search' ) || $( field ).hasClass( 'mwb-term-search' ) ) {
                    $( toggle_el ).find( '#' + $field_id ).html( $( '#' + $( field ).attr( 'id' ) ).html() );
                }

                $( toggle_el ).find( '#' + $field_id ).val( $field_val );

            }

        } );

        $( toggle_el ).formatToggleTitle();
        var form_is_valid = $( '<input type="hidden">' ).val( 'yes' );
        $( document ).trigger( 'mwb-toggle-element-item-before-add', [add_box, toggle_el, form_is_valid] );

        var delayInMilliseconds = 1000; //1 second
        setTimeout( function () {
            if ( form_is_valid.val() === 'yes' ) {
                $( toggle_element ).find( '.mwb-toggle-elements' ).append( toggle_el );
                $( add_box ).find( '.mwb-plugin-fw-datepicker' ).datepicker( 'destroy' );
                $( add_box ).html( '' );
                $( add_box ).prev( '.mwb-add-box-button' ).trigger( 'click' );
                toggle_element.saveToggleElement();

                var delayInMilliseconds = 2000; //1 second
                setTimeout( function () {
                    $( toggle_element ).find( '.highlight' ).removeClass( 'highlight' );
                }, delayInMilliseconds );


                $( document ).trigger( 'mwb_fields_init' );
            }
        }, delayInMilliseconds );


    } );

    $( document ).on( 'click', '.mwb-toggle-row .mwb-save-button', function ( event ) {
        event.preventDefault();
        var toggle     = $( this ).closest( '.toggle-element' ),
            toggle_row = $( this ).closest( '.mwb-toggle-row' ),
            spinner    = toggle_row.find( '.spinner' );
        toggle_row.formatToggleTitle();

        var form_is_valid = $( '<input type="hidden">' ).val( 'yes' );
        $( document ).trigger( 'mwb-toggle-element-item-before-update', [toggle, toggle_row, form_is_valid] );
        if ( form_is_valid.val() === 'yes' ) {
            spinner.addClass( 'show' );
            toggle.saveToggleElement( spinner );
        }
    } );

    //register remove the dome and save the toggle
    $( document ).on( 'click', '.mwb-toggle-row .mwb-delete-button', function ( event ) {
        event.preventDefault();
        var toggle     = $( this ).closest( '.toggle-element' ),
            toggle_row = $( this ).closest( '.mwb-toggle-row' );
        toggle_row.remove();
        toggle.saveToggleElement();
    } );

    //register onoff status
    $( document ).on( 'click', '.mwb-toggle-onoff', function ( event ) {
        event.preventDefault();
        var toggle = $( this ).closest( '.toggle-element' );
        toggle.saveToggleElement();
    } );

    // Radio
    $( document ).on( 'click', '.mwb-plugin-fw-radio input[type=radio]', function () {
        var _radioContainer = $( this ).closest( '.mwb-plugin-fw-radio' ),
            _value          = $( this ).val();

        _radioContainer.val( _value ).data( 'value', _value ).trigger( 'change' );
    } );

    $( document.body ).on( 'mwb-plugin-fw-init-radio', function () {
        $( '.mwb-plugin-fw-radio:not(.mwb-plugin-fw-radio--initialized)' ).each( function () {
            $( this ).val( $( this ).data( 'value' ) );
            $( this ).addClass( 'mwb-plugin-fw-radio--initialized' );
        } );
    } ).trigger( 'mwb-plugin-fw-init-radio' );

    // Password Eye field
    $( document ).on( 'click', '.mwb-password-eye', function () {
        var $this = $( this ),
            inp   = $( this ).closest( '.mwb-password-wrapper' ).find( 'input' );
        if ( inp.attr( 'type' ) === "password" ) {
            inp.attr( 'type', 'text' );
            $this.addClass( 'mwb-password-eye-closed' );
        } else {
            inp.attr( 'type', 'password' );
            $this.removeClass( 'mwb-password-eye-closed' );
        }
    } );

    /**
     * Select2 - add class to stylize it with the new plugin-fw style
     */
    $( document ).on( 'select2:open', function ( e ) {
        if ( $( e.target ).closest( '.mwb-plugin-ui' ).length ) {
            $( '.select2-results' ).closest( '.select2-container' ).addClass( 'mwb-plugin-fw-select2-container' );
        }
    } );
    /**
     * Dimensions
     */
    var fw_dimensions = {
        selectors   : {
            wrapper   : '.mwb-plugin-fw-dimensions',
            units     : {
                wrapper      : '.mwb-plugin-fw-dimensions__units',
                single       : '.mwb-plugin-fw-dimensions__unit',
                value        : '.mwb-plugin-fw-dimensions__unit__value',
                selectedClass: 'mwb-plugin-fw-dimensions__unit--selected'
            },
            linked    : {
                button            : '.mwb-plugin-fw-dimensions__linked',
                value             : '.mwb-plugin-fw-dimensions__linked__value',
                wrapperActiveClass: 'mwb-plugin-fw-dimensions--linked-active'
            },
            dimensions: {
                number: '.mwb-plugin-fw-dimensions__dimension__number'
            }
        },
        init        : function () {
            var self = fw_dimensions;
            $( document ).on( 'click', self.selectors.units.single, self.unitChange );
            $( document ).on( 'click', self.selectors.linked.button, self.linkedChange );
            $( document ).on( 'change keyup', self.selectors.dimensions.number, self.numberChange );
        },
        unitChange  : function ( e ) {
            var unit        = $( this ).closest( fw_dimensions.selectors.units.single ),
                wrapper     = unit.closest( fw_dimensions.selectors.units.wrapper ),
                units       = wrapper.find( fw_dimensions.selectors.units.single ),
                valueField  = wrapper.find( fw_dimensions.selectors.units.value ).first(),
                value       = unit.data( 'value' );

            units.removeClass( fw_dimensions.selectors.units.selectedClass );
            unit.addClass( fw_dimensions.selectors.units.selectedClass );
            valueField.val( value );
        },
        linkedChange: function () {
            var button      = $( this ).closest( fw_dimensions.selectors.linked.button ),
                mainWrapper = button.closest( fw_dimensions.selectors.wrapper ),
                valueField  = button.find( fw_dimensions.selectors.linked.value ),
                value       = valueField.val();

            if ( 'yes' === value ) {
                mainWrapper.removeClass( fw_dimensions.selectors.linked.wrapperActiveClass );
                valueField.val( 'no' );
            } else {
                mainWrapper.addClass( fw_dimensions.selectors.linked.wrapperActiveClass );
                valueField.val( 'yes' );

                mainWrapper.find( fw_dimensions.selectors.dimensions.number ).first().trigger( 'change' );
            }
        },
        numberChange: function ( e ) {
            var number      = $( this ).closest( fw_dimensions.selectors.dimensions.number ),
                mainWrapper = number.closest( fw_dimensions.selectors.wrapper );
            if ( mainWrapper.hasClass( fw_dimensions.selectors.linked.wrapperActiveClass ) ) {
                var numbers = mainWrapper.find( fw_dimensions.selectors.dimensions.number );

                numbers.val( number.val() );
            }
        }
    };
    fw_dimensions.init();

} )( jQuery );