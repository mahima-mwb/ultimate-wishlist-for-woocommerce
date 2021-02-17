/**
 * All of the code for your admin-facing JavaScript source
 * should reside in this file.
 *
 * Note: It has been assumed you will write jQuery code here, so the
 * $ function reference has been prepared for usage within the scope
 * of this function.
 */
jQuery(document).ready(function() {

    /**==========================================================================================
     *                      Object/Function constants.
    =========================================================================================== */  

    // Wishlist triggers.
    const wishlistTrigger = jQuery( '.add-to-wishlist' );
    const strings = JSON.parse( mwb_wfw_obj.strings );
    const wishlistPopup = jQuery( '.mwb-wfw-wishlist-dialog' );
    const permalink = mwb_wfw_obj.permalink;
    const viewWishlistButton = '<a href="' + permalink + '" class="button mwb-wfw-action-button view">' + strings.view_text + '</a>';
    const processingIconHtml = '<span class="mwb-wfw-wishlist-processing"><i class="fa fa fa-spinner fa-spin"></i>' + strings.processing_text + '...</span>';

    // Initialise the wishlist action popup.
    const initWishlistPopup = () => {
        wishlistPopup.dialog({
            modal: true,
            title: strings.popup_title,
            width : 700,
            autoOpen : false,
            draggable: true,
            closeText: "Close",
            beforeClose: function( event, ui ) {
                wishlistPopupReset();
            },
            buttons: [{
                text: "Close",
                click: function() {
                    jQuery( this ).dialog( "close" );
                }
            }]
        });
    }

    // Reset the popup on every close.
    const wishlistPopupReset = () => {

        jQuery( '.mwb-wfw-wishlist-item-img' ).attr( 'src', '' );
        jQuery( '.mwb-wfw-wishlist-item-img' ).trigger( 'change' );
        jQuery( '.mwb-wfw-wishlist-item-details' ).empty();
        jQuery( '.mwb-wfw-wishlist-action-buttons' ).empty();
        jQuery( '.mwb-wfw-wishlist-processing' ).remove();
    }

    // Wishlist process.
    const processWishtlist = ( obj ) => {
        productId = obj.data( 'product-id' );
        wishlistId = obj.data( 'wishlist-id' );

        // If wishlist id is available remove from wishlist.
        if( null != wishlistId && '' != wishlistId ) {
            triggerSuccess( 'Product removed from wishlist' );  
        }

        // If wishlist id is not available add to wishlist.
        else if ( null !=  productId ) {
            const product = obj.closest( 'li.product' );
            if( product.length > 0 ) {
                triggerShowWishlist( productId, product );
            }

        } else {
            triggerError();
        }
    }

    // Ajax Callbacks.
    async function doAjax(args) {
        let result;
    
        try {
            return await jQuery.ajax({
                url: mwb_wfw_obj.ajaxurl,
                type: 'POST',
                data: args
            });

        } catch (error) {
            console.error(error);
        }
    }

    // Error Trigger process.
    const triggerError = ( msg='Something Went Wrong' ) => {
        swal( 'Oopss...', msg, 'error' );
    }

    // Success Trigger process.
    const triggerSuccess = ( msg='' ) => {
        swal( 'Congratulations...', msg, 'success' );
    }

    // Prompt before operation.
    const promptIn = () => {
        swal( "Are you sure?", {
            buttons: {
              cancel: "No, cancel it!",
              accept: "Yes, I am sure!",
            },
          })
          .then((value) => {
            switch ( value ) {
              case "accept":
                swal("Gotcha!", "Pikachu was caught!", "success");
                break;
           
              default:
            }
          });
    }

    //  Pick product details from selected product and append to Wishlist.
    const cloneProductDetails = ( product ) => {
        
        src = product.find( 'img' ).attr( 'src' );
        title = product.find( '.woocommerce-loop-product__title' ).clone();
        priceHtml = product.find( 'span.price' ).clone();
        addToCartButton = product.find( 'a.add_to_cart_button' ).clone();

        jQuery( '.mwb-wfw-wishlist-item-img' ).attr( 'src', src );
        jQuery( '.mwb-wfw-wishlist-item-img' ).trigger( 'change' );

        title.appendTo( ".mwb-wfw-wishlist-item-details" );
        priceHtml.appendTo( ".mwb-wfw-wishlist-item-details" );
        addToCartButton.appendTo( ".mwb-wfw-wishlist-action-buttons" );
        addToCartButton.text( strings.add_to_cart );
        jQuery( ".mwb-wfw-wishlist-action-buttons" ).append( viewWishlistButton );

        jQuery( ".ui-dialog-title" ).append( processingIconHtml );

    }

    // Async process : Add to wishlist.
    const addToWishlist = ( pId='' )  =>  {
        let data = {
            nonce: mwb_wfw_obj.auth_nonce,
            action : 'addToWishlist',
            productId : pId,
        };

        let result = doAjax( data );
        result.then( ( result ) => processResponse( result ) );
    }

    // Process to Show wishlist.
    const triggerShowWishlist = ( pId = '', product = {} ) => {

        // Prepare dialog box first.
        cloneProductDetails( product );

        // Add product to current wishlist.
        addToWishlist( pId );

        // Show Popup for wishlist selection.
        wishlistPopup.dialog( 'open' );
    }

    // Process the Async Output.
    const processResponse = ( response ) => {
        response = JSON.parse( response );
        const processingIcon = jQuery( '.mwb-wfw-wishlist-processing' );
        if( 200 == response.status ) {
            processingIcon.remove();
        } else {

            processingIcon.text( response.message );
        }
    }


    /**==========================================================================================
     *                      Native Functional Callbacks
    =========================================================================================== */    

    // Initialise dialog box for popup.
    initWishlistPopup();

    // Add/Remove to Wishlist.
    wishlistTrigger.on( 'click', function() {
        processWishtlist( jQuery( this ) );
    });
});

