/* global asp_ssws_subscribe_form_params */

;
( function( $, window, document, undefined ) {

    /**
     * SubscribeForm class which handles subscribe forms and attributes.
     */
    var SubscribeForm = function( $form ) {
        var self = this;

        self.$form = $form;
        self.loading = true;

        // Methods
        self.getProcessingNode = self.getProcessingNode.bind( self );

        self.$form.on( 'change', '.asp-ssws-pay-option,.asp-ssws-pay-option-hidden', { subscribeForm : self }, self.inputChanged );
        self.$form.on( 'change', 'select[name="asp_ssws_subscribe_plan"]', { subscribeForm : self }, self.inputChanged );
        self.$form.on( 'change', 'select[name="asp_ssws_subscribe_period_interval"]', { subscribeForm : self }, self.inputChanged );
        self.$form.on( 'change', 'select[name="asp_ssws_subscribe_period"]', { subscribeForm : self }, self.inputChanged );
        self.$form.on( 'change', 'select[name="asp_ssws_subscribe_length"]', { subscribeForm : self }, self.inputChanged );

        if ( self.$form.find( '.asp-ssws-pay-option-hidden' ).length ) {
            self.$form.find( '.asp-ssws-pay-option-hidden' ).change();
        } else {
            self.$form.find( '.asp-ssws-pay-option:checked' ).change();
        }
    };

    /**
     * Gets the form processing node.
     */
    SubscribeForm.prototype.getProcessingNode = function( $default ) {
        if ( $( '.jconfirm-content-pane .asp-ssws-subscribe-wrapper' ).length ) {
            return $( '.jconfirm-content-pane .asp-ssws-subscribe-wrapper' ).closest( '.jconfirm-box' );
        } else {
            return $default;
        }
    };

    /**
     * When the form input changed.
     */
    SubscribeForm.prototype.inputChanged = function( e ) {
        e.preventDefault();
        var form = e.data.subscribeForm;

        block( form.getProcessingNode( form.$form ) );
        $.ajax( {
            type : 'POST',
            url : asp_ssws_subscribe_form_params.ajax_url,
            data : {
                action : 'asp_ssws_buy_now_or_subscribe',
                security : asp_ssws_subscribe_form_params.buynow_or_subscribe_nonce,
                level : 'product_level',
                product_id : form.$form.find( '.asp-ssws-subscribe-wrapper' ).data( 'product-id' ),
                data : form.$form.find( ':input[name],select[name]' ).serialize()
            },
            success : function( response ) {
                if ( response.success ) {
                    form.$form.find( '.asp-ssws-subscribe-wrapper' ).remove();
                    form.$form.append( response.data.html );

                    if ( form.$form.closest( 'form' ).find( '.single_add_to_cart_button' ).length ) {
                        if ( '1' !== asp_ssws_subscribe_form_params.is_switch_request && 'subscribe' === form.$form.find( '.asp-ssws-pay-option:checked,.asp-ssws-pay-option-hidden' ).val() ) {
                            form.$form.closest( 'form' ).find( '.single_add_to_cart_button' ).addClass( 'asp_single_subscribe_button' ).text( asp_ssws_subscribe_form_params.i18n_subscribe_button_text );
                        } else {
                            form.$form.closest( 'form' ).find( '.single_add_to_cart_button' ).removeClass( 'asp_single_subscribe_button' ).text( asp_ssws_subscribe_form_params.i18n_single_add_to_cart_text );
                        }
                    }

                    form.$form.trigger( 'asp_product_subscribe_form_submitted_success' );
                }
            },
            complete : function() {
                unblock( form.getProcessingNode( form.$form ) );
            }
        } );
        return false;
    };

    /**
     * Function to call asp_product_subscribe_form on jquery selector.
     */
    $.fn.asp_product_subscribe_form = function() {
        new SubscribeForm( this );
        return this;
    };

    /**
     * Is visually blocked?
     *
     * @param {JQuery Object} $node
     */
    var is_blocked = function( $node ) {
        return $node.is( '.processing' ) || $node.parents( '.processing' ).length;
    };

    /**
     * Block a node visually for processing.
     *
     * @param {JQuery Object} $node
     */
    var block = function( $node ) {
        $.blockUI.defaults.overlayCSS.cursor = 'wait';

        if ( ! is_blocked( $node ) ) {
            $node.addClass( 'processing' ).block( {
                message : null,
                overlayCSS : {
                    background : '#fff',
                    opacity : 0.6
                }
            } );
        }
    };

    /**
     * Unblock a node after processing is complete.
     *
     * @param {JQuery Object} $node
     */
    var unblock = function( $node ) {
        $node.removeClass( 'processing' ).unblock();
    };

} )( jQuery, window, document );
