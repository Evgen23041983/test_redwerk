function mtst_setMessage( msg ) {
    ( function( $ ){
        $( ".error" ).hide();
        $( ".mtst_image_update_message" ).html( msg ).show();
    } )( jQuery );
}

function mtst_setError( msg ) {
    ( function( $ ){
        $( ".mtst_image_update_message" ).hide();
        $( ".error" ).html( msg ).show();;
    } )( jQuery );
}

( function( $ ) {
    $( document ).ready( function() {
        $( '#mtst_ajax_update_images' ).click( function() {
            mtst_setMessage( "<p>" + mtst_vars.update_img_message + "</p>" );
            var curr = 0;
            $.ajax( {
                /* update_img_url */
                url: '../wp-admin/admin-ajax.php?action=mtst_update_image',
                type: "POST",
                data: "action1=get_all_attachment&mtst_ajax_nonce_field=" + mtst_vars.mtst_nonce,
                success: function( result ) {
                    var list = $.parseJSON( result );
                    if ( ! list ) {
                        mtst_setError( "<p>" + mtst_vars.not_found_img_info + "</p>" );
                        return;
                    }
                    $( '.mtst_loader' ).css( 'display', 'inline-block' );

                    var curr = 0,
                        all_count = Object.keys( list ).length;
                    $.each( list, function( index, value ) {
                        $.ajax( {
                            url: '../wp-admin/admin-ajax.php?action=mtst_update_image',
                            type: "POST",
                            data: "action1=update_image&id=" + value + '&mtst_ajax_nonce_field=' + mtst_vars.mtst_nonce,
                            success: function( result ) {
                                curr = curr + 1;
                                if ( curr >= all_count ) {
                                    $.ajax( {
                                        url: '../wp-admin/admin-ajax.php?action=mtst_update_image',
                                        type: "POST",
                                        data: "action1=update_options&mtst_ajax_nonce_field=" + mtst_vars.mtst_nonce,
                                    } );
                                    mtst_setMessage( "<p>" + mtst_vars.img_success + "</p>" );
                                    $( '.mtst_loader' ).hide();
                                }
                            }
                        } );
                    } );
                },
                error: function( request, status, error ) {
                    mtst_setError( "<p>" + mtst_vars.img_error + request.status + "</p>" );
                }
            } );
        } );

        var is_rtl = ( $( 'body' ).hasClass( 'rtl' ) );

        $( '#_mtst_date_compl' ).datepicker( {
            dateFormat : 'dd.mm.yy',
            isRTL : is_rtl
        } );

        $( '[name^="mtst_custom_image_size_"]' ).change( function() {
            $( '#mtst_ajax_update_images' ).attr( 'disabled', 'disabled' );
        } );

        /* mtst-text-domain images */
        var images_frame;

        $( '.mtst_add_mtst-text-domain_images' ).on( 'click', 'a', function( event ) {
            event.preventDefault();
            var $element = $( this );

            /* If the media frame already exists, reopen it */
            if ( images_frame ) {
                images_frame.open();
                return;
            }

            /* Create the media frame */
            images_frame = wp.media.frames.product_gallery = wp.media({
                title: $element.data( 'choose' ),
                button: {
                    text: $element.data( 'update' )
                },
                states: [
                    new wp.media.controller.Library( {
                        title: $element.data( 'choose' ),
                        filterable: 'all',
                        multiple: true
                    } )
                ]
            } );

            /* run a callback when an image is selected */
            images_frame.on( 'select', function() {
                var selection = images_frame.state().get( 'selection' );
                var attachment_ids = $( '#mtst_images' ).val();

                selection.map( function( attachment ) {
                    attachment = attachment.toJSON();

                    if ( attachment.id ) {
                        attachment_ids   = attachment_ids ? attachment_ids + ',' + attachment.id : attachment.id;
                        var attachment_image = attachment.sizes && attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url;

                        $( '#mtst_images_container ul' ).append( '<li class="mtst_single_image" data-attachment_id="' + attachment.id + '"><img src="' + attachment_image + '" /><span class="mtst_delete_image"><a href="#" title="' + $element.data( 'delete' ) + '">' + $element.data( 'text' ) + '</a></span></li>' );
                    }
                } );

                $( '#mtst_images' ).val( attachment_ids );
            } );

            /* Open the modal */
            images_frame.open();
        } );

        /* Add image ordering */
        if ( $( '#mtst_images_container ul' ).length > 0 ) {
            $( '#mtst_images_container ul' ).sortable({
                items: 'li.mtst_single_image',
                cursor: 'move',
                scrollSensitivity: 40,
                forcePlaceholderSize: true,
                forceHelperSize: false,
                helper: 'clone',
                opacity: 0.65,
                placeholder: 'mtst-sortable-placeholder',
                start: function( event, ui ) {
                    ui.item.css( 'background-color', '#f6f6f6' );
                },
                stop: function( event, ui ) {
                    ui.item.removeAttr( 'style' );
                },
                update: function() {
                    var attachment_ids = '';
                    $( '#mtst_images_container' ).find( 'ul li.mtst_single_image' ).css( 'cursor', 'default' ).each( function() {
                        var attachment_id = $( this ).attr( 'data-attachment_id' );
                        attachment_ids = attachment_ids + attachment_id + ',';
                    } );
                    $( '#mtst_images' ).val( attachment_ids );
                }
            } );
        }

        /* Remove image */
        $( '#mtst_images_container' ).on( 'click', '.mtst_delete_image a', function() {
            $( this ).closest( 'li.mtst_single_image' ).remove();
            var attachment_ids = '';

            $( '#mtst_images_container' ).find( 'ul li.mtst_single_image' ).css( 'cursor', 'default' ).each( function() {
                var attachment_id = $( this ).attr( 'data-attachment_id' );
                attachment_ids = attachment_ids + attachment_id + ',';
            } );

            $( '#mtst_images' ).val( attachment_ids );
            return false;
        } );
    } );
} )( jQuery );


