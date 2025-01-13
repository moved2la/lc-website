/* global asp_ssws_subscribe_form_params */

jQuery( function( $ ) {
    'use strict';

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

    /**
     * Handle switch request.
     */
    function handleSwitchRequest() {
        if ( window.location.href.indexOf( 'switch-subscription' ) != - 1 && window.location.href.indexOf( 'item' ) != - 1 ) {
            $( '.product form.cart' ).prop( 'action', '' );
        }
    }

    /**
     * Returns true if the viewing device is Mobile.
     * 
     * @returns {Boolean}
     */
    function isMobile() {
        if ( window.matchMedia( "(max-width: 767px)" ).matches ) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Handle subscribe events via Modal.
     */
    if ( typeof asp_ssws_subscribe_form_params !== 'undefined' ) {
        $( '.asp-ssws-subscribe-via-modal' ).click( function( e ) {
            e.preventDefault();

            var $this = $( this ),
                    wrapperClass = '.asp-product_level-subscribe-wrapper';

            block( $this );
            $.ajax( {
                type : 'POST',
                url : asp_ssws_subscribe_form_params.ajax_url,
                data : {
                    action : 'asp_ssws_subscribe_via_modal',
                    security : asp_ssws_subscribe_form_params.subscribe_via_modal_nonce,
                    product_id : $this.data( 'product-id' )
                },
                success : function( response ) {
                    if ( response.success ) {
                        $.confirm( {
                            title : response.data.title,
                            content : response.data.html,
                            type : 'blue',
                            boxWidth : isMobile() ? false : '50%',
                            useBootstrap : false,
                            typeAnimated : true,
                            closeIcon : true,
                            onOpen : function() {
                                if ( $( wrapperClass ).length ) {
                                    $( wrapperClass ).each( function() {
                                        $( this ).asp_product_subscribe_form();
                                    } );
                                }
                            },
                            buttons : {
                                signup : {
                                    text : asp_ssws_subscribe_form_params.i18n_subscribe_button_text,
                                    btnClass : 'button',
                                    isHidden : false,
                                    isDisabled : false,
                                    action : function( button ) {
                                        var $wrapper = $( '.jconfirm-content-pane .asp-ssws-subscribe-wrapper' ).closest( '.jconfirm-box' );
                                        block( $wrapper );
                                        $.ajax( {
                                            type : 'POST',
                                            url : asp_ssws_subscribe_form_params.ajax_url,
                                            data : {
                                                action : 'asp_ssws_add_to_cart_subscription',
                                                security : asp_ssws_subscribe_form_params.add_to_cart_subscription_nonce,
                                                product_id : $this.data( 'product-id' ),
                                                data : $wrapper.find( ':input[name],select[name]' ).serialize()
                                            },
                                            success : function( response ) {
                                                if ( response.success ) {
                                                    $.confirm( {
                                                        title : asp_ssws_subscribe_form_params.i18n_success_text,
                                                        content : response.data.message,
                                                        type : 'green',
                                                        boxWidth : isMobile() ? false : '25%',
                                                        useBootstrap : false,
                                                        typeAnimated : true,
                                                        closeIcon : true,
                                                        buttons : {
                                                            proceedtocart : {
                                                                text : asp_ssws_subscribe_form_params.i18n_proceed_to_cart_button_text,
                                                                btnClass : 'button',
                                                                action : function( button ) {
                                                                    window.location.href = asp_ssws_subscribe_form_params.cart_url;
                                                                }
                                                            }
                                                        }
                                                    } );
                                                } else {
                                                    $.dialog( {
                                                        title : asp_ssws_subscribe_form_params.i18n_error_text,
                                                        content : response.data.message,
                                                        type : 'red',
                                                        boxWidth : isMobile() ? false : '25%',
                                                        useBootstrap : false,
                                                        typeAnimated : true,
                                                        closeIcon : true
                                                    } );
                                                }
                                            },
                                            complete : function() {
                                                unblock( $wrapper );
                                            }
                                        } );
                                        return false;
                                    }
                                }
                            }
                        } );
                    } else {
                        $.dialog( {
                            title : asp_ssws_subscribe_form_params.i18n_error_text,
                            content : response.data.message,
                            type : 'red',
                            boxWidth : isMobile() ? false : '25%',
                            useBootstrap : false,
                            typeAnimated : true,
                            closeIcon : true
                        } );
                    }
                },
                complete : function() {
                    unblock( $this );
                }
            } );
            return false;
        } );
    }

    /**
     * Handle variable product subscribe events.
     */
    var variations_form_handle = {
        variationForm : $( '.variations_form' ),
        cartForm : $( 'form.cart' ),
        init : function() {
            $( document ).on( 'found_variation.wc-variation-form', this.foundVariation );
            $( document ).on( 'reset_data', this.resetVariation );
        },
        foundVariation : function( e, variation ) {
            variations_form_handle.resetVariation();

            if ( variation.asp_subscribe_form ) {
                variations_form_handle.variationForm
                        .find( '.woocommerce-variation-add-to-cart' )
                        .before( variation.asp_subscribe_form );
                variations_form_handle.variationForm
                        .find( '.single_add_to_cart_button' )
                        .text( variation.asp_single_add_to_cart_text );

                if ( typeof asp_ssws_subscribe_form_params !== 'undefined' ) {
                    if ( variations_form_handle.variationForm.find( '.asp-product_level-subscribe-wrapper' ).length ) {
                        variations_form_handle.variationForm
                                .find( '.asp-product_level-subscribe-wrapper' )
                                .each( function() {
                                    $( this ).asp_product_subscribe_form();
                                } );

                        handleSwitchRequest();
                    }
                }
            }
        },
        resetVariation : function() {
            if ( variations_form_handle.variationForm.find( '.asp-product_level-subscribe-wrapper' ).length ) {
                variations_form_handle.variationForm
                        .find( '.asp-product_level-subscribe-wrapper' )
                        .remove();
            }

            if ( typeof asp_ssws_subscribe_form_params !== 'undefined' ) {
                variations_form_handle.variationForm
                        .find( '.single_add_to_cart_button' )
                        .removeClass( 'asp_single_subscribe_button' )
                        .text( asp_ssws_subscribe_form_params.i18n_single_add_to_cart_text );
            }
        }
    };

    variations_form_handle.init();

    /**
     * Handle cart subscribe events.
     */
    var cart_subscribe_form = {
        init : function() {
            $( document ).on( 'change', '.asp-cart_level-subscribe-wrapper .asp-ssws-pay-option,.asp-cart_level-subscribe-wrapper .asp-ssws-pay-option-hidden', this.inputChanged );
            $( document ).on( 'change', '.asp-cart_level-subscribe-wrapper select[name="asp_ssws_subscribe_plan"]', this.inputChanged );
            $( document ).on( 'change', '.asp-cart_level-subscribe-wrapper select[name="asp_ssws_subscribe_period_interval"]', this.inputChanged );
            $( document ).on( 'change', '.asp-cart_level-subscribe-wrapper select[name="asp_ssws_subscribe_period"]', this.inputChanged );
            $( document ).on( 'change', '.asp-cart_level-subscribe-wrapper select[name="asp_ssws_subscribe_length"]', this.inputChanged );

            if ( $( '.asp-cart_level-subscribe-wrapper .asp-ssws-pay-option-hidden' ).length ) {
                $( '.asp-cart_level-subscribe-wrapper .asp-ssws-pay-option-hidden' ).change();
            } else {
                $( '.asp-cart_level-subscribe-wrapper .asp-ssws-pay-option:checked' ).change();
            }
        },
        getProcessingNode : function() {
            if ( $( '.woocommerce-cart-form' ).length ) {
                return $( '.asp-cart_level-subscribe-wrapper, .cart_totals' );
            } else if ( $( '.woocommerce-checkout' ).length ) {
                return $( '.asp-cart_level-subscribe-wrapper, .woocommerce-checkout-payment, .woocommerce-checkout-review-order-table' ).closest( 'form' );
            } else {
                return $( '.asp-cart_level-subscribe-wrapper' );
            }
        },
        inputChanged : function( e ) {
            e.preventDefault();

            block( cart_subscribe_form.getProcessingNode() );
            $.ajax( {
                type : 'POST',
                url : asp_ssws_subscribe_form_params.ajax_url,
                data : {
                    action : 'asp_ssws_buy_now_or_subscribe',
                    security : asp_ssws_subscribe_form_params.buynow_or_subscribe_nonce,
                    level : 'cart_level',
                    data : $( '.asp-cart_level-subscribe-wrapper' ).find( ':input[name],select[name]' ).serialize()
                },
                success : function( response ) {
                    if ( response.success ) {
                        $( '.asp-cart_level-subscribe-wrapper' ).find( '.asp-ssws-subscribe-wrapper' ).remove();
                        $( '.asp-cart_level-subscribe-wrapper' ).append( response.data.html );

                        if ( $( '.woocommerce-cart-form' ).length ) {
                            $( document.body ).trigger( 'wc_update_cart' );
                        }

                        $( document.body ).trigger( 'update_checkout' );
                        $( document.body ).trigger( 'asp_cart_subscribe_form_submitted_success' );
                    }
                },
                complete : function() {
                    unblock( cart_subscribe_form.getProcessingNode() );
                }
            } );
            return false;
        }
    };

    /**
     * Handle subscribe events.
     */
    $( function() {
        if ( typeof asp_ssws_subscribe_form_params !== 'undefined' ) {
            if ( $( '.asp-product_level-subscribe-wrapper' ).length ) {
                $( '.asp-product_level-subscribe-wrapper' ).each( function() {
                    $( this ).asp_product_subscribe_form();
                } );

                handleSwitchRequest();
            } else if ( $( '.asp-cart_level-subscribe-wrapper' ).length ) {
                cart_subscribe_form.init();
            }
        }
    } );

    // Product Add-Ons compat.
    $( document ).on( 'updated_addons', function() {
        if ( $( '#product-addons-total .subscription-details' ).length && $( '.asp-product_level-subscribe-wrapper' ).length ) {
            $( '#product-addons-total' ).find( '.subscription-details' ).hide();
        }
    } );
} );
