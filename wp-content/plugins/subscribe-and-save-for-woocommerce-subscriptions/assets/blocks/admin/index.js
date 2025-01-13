( () => {
    'use strict';

    const react_plugins = window["wp"]["plugins"];
    const react_element = window["wp"]["element"];
    const react_blocks = window["wp"]["blocks"];
    const react_blockEditor = window["wp"]["blockEditor"];
    const react_i18n = window["wp"]["i18n"];
    const react_data = window["wp"]["data"];
    const react_compose = window["wp"]["compose"];
    const react_components = window["wp"]["components"];
    const react_primitives = window["wp"]["primitives"];
    const react_wc_blocksCheckout = window["wc"]["blocksCheckout"];
    const react_wc_priceFormat = window["wc"]["priceFormat"];
    const react_wc_settings = window["wc"]["wcSettings"];

    var methods = {
        pluginData : null,
        isSubscribePlugin : function( e ) {
            // Bail out early.
            if ( undefined === e['subscribe-and-save-for-woocommerce-subscriptions'] ) {
                return false;
            }

            methods.pluginData = e['subscribe-and-save-for-woocommerce-subscriptions'];
            return true;
        },
        cartBlocks : {
            cartSubscribe : {
                cartSchema : JSON.parse( "{\"name\":\"woocommerce/cart-order-summary-asp-ssws-cart-subscribe-block\",\"icon\":\"backup\",\"keywords\":[\"subscription\",\"cart\"],\"version\":\"1.0.0\",\"title\":\"Cart Subscribe\",\"description\":\"Shows the cart subscribe form.\",\"category\":\"woocommerce\",\"supports\":{\"align\":false,\"html\":false,\"multiple\":false,\"reusable\":false},\"attributes\":{\"className\":{\"type\":\"string\",\"default\":\"\"},\"lock\":{\"type\":\"object\",\"default\":{\"remove\":true,\"move\":false}}},\"parent\":[\"woocommerce/cart-totals-block\"],\"textdomain\":\"subscribe-and-save-for-woocommerce-subscriptions\",\"apiVersion\":2}" ),
                checkoutSchema : JSON.parse( "{\"name\":\"woocommerce/checkout-order-summary-asp-ssws-cart-subscribe-block\",\"icon\":\"backup\",\"keywords\":[\"subscription\",\"cart\"],\"version\":\"1.0.0\",\"title\":\"Cart Subscribe\",\"description\":\"Shows the cart subscribe form.\",\"category\":\"woocommerce\",\"supports\":{\"align\":false,\"html\":false,\"multiple\":false,\"reusable\":false},\"attributes\":{\"className\":{\"type\":\"string\",\"default\":\"\"},\"lock\":{\"type\":\"object\",\"default\":{\"remove\":true,\"move\":false}}},\"parent\":[\"woocommerce/checkout-totals-block\"],\"textdomain\":\"subscribe-and-save-for-woocommerce-subscriptions\",\"apiVersion\":2}" ),
                init : function() {
                    return react_element.createElement( react_wc_blocksCheckout.TotalsWrapper, { className : "asp-ssws-cart-subscribe-form-wrapper" },
                            react_element.createElement( methods.cartBlocks.cartSubscribe.subscribeSelectionElement ) );
                },
                edit : function( e ) {
                    return react_element.createElement( "div", react_blockEditor.useBlockProps(),
                            react_element.createElement( methods.cartBlocks.cartSubscribe.init ) );
                },
                save : function( e ) {
                    return react_element.createElement( "div", react_blockEditor.useBlockProps.save() );
                },
                subscribeSelectionElement : function( e ) {
                    return react_element.createElement( react_wc_blocksCheckout.TotalsItem, {
                        className : "asp-ssws-cart-subscribe-form-wrapper__subscribe-options",
                        label : react_element.createElement( "p", { className : "asp-ssws-subscribe-options" },
                                react_element.createElement( methods.cartBlocks.cartSubscribe.oneTimePayOptionElement ),
                                react_element.createElement( "br" ),
                                react_element.createElement( methods.cartBlocks.cartSubscribe.subscribePayOptionElement ) )
                    } );
                },
                oneTimePayOptionElement : function( e ) {
                    const { one_time_purchase_option_label : one_time_purchase_option_label } = react_wc_settings.getSetting( 'subscribe-and-save-for-woocommerce-subscriptions_data' );

                    return react_element.createElement( "label", { htmlFor : "asp_ssws_pay_one_time" },
                            react_element.createElement( "input", {
                                id : "asp_ssws_pay_one_time",
                                value : "one-time",
                                type : "radio",
                                defaultChecked : true,
                                disabled : true
                            } ), "  ", one_time_purchase_option_label );
                },
                subscribePayOptionElement : function( e ) {
                    const { subscribe_option_label : subscribe_option_label } = react_wc_settings.getSetting( 'subscribe-and-save-for-woocommerce-subscriptions_data' );

                    return react_element.createElement( "label", { htmlFor : "asp_ssws_pay_subscribe" },
                            react_element.createElement( "input", {
                                id : "asp_ssws_pay_subscribe",
                                value : "subscribe",
                                type : "radio",
                                disabled : true
                            } ), "  ", subscribe_option_label );
                },
            }
        }
    };

    const { cart_subscribe_allowed_pages : cartSubscribeAllowedPages } = react_wc_settings.getSetting( 'subscribe-and-save-for-woocommerce-subscriptions_data' );

    if ( cartSubscribeAllowedPages.length ) {
        // Register Block in the Editor.

        if ( 'cart' === cartSubscribeAllowedPages[0] ) {
            react_blocks.registerBlockType( methods.cartBlocks.cartSubscribe.cartSchema.name, {
                title : methods.cartBlocks.cartSubscribe.cartSchema.title, // Localize title using wp.i18n.__()
                version : methods.cartBlocks.cartSubscribe.cartSchema.version,
                description : methods.cartBlocks.cartSubscribe.cartSchema.description,
                category : methods.cartBlocks.cartSubscribe.cartSchema.category, // Category Options: common, formatting, layout, widgets, embed
                supports : methods.cartBlocks.cartSubscribe.cartSchema.supports,
                icon : methods.cartBlocks.cartSubscribe.cartSchema.icon, // Dashicons Options – https://goo.gl/aTM1DQ
                keywords : methods.cartBlocks.cartSubscribe.cartSchema.keywords, // Limit to 3 Keywords / Phrases
                parent : methods.cartBlocks.cartSubscribe.cartSchema.parent,
                textdomain : methods.cartBlocks.cartSubscribe.cartSchema.textdomain,
                apiVersion : methods.cartBlocks.cartSubscribe.cartSchema.apiVersion,
                attributes : methods.cartBlocks.cartSubscribe.cartSchema.attributes, // Attributes set for each piece of dynamic data used in your block
                edit : methods.cartBlocks.cartSubscribe.edit, // Determines what is displayed in the editor
                save : methods.cartBlocks.cartSubscribe.save // Determines what is displayed on the frontend
            } );
        }

        if ( 'checkout' === cartSubscribeAllowedPages[0] || 'checkout' === cartSubscribeAllowedPages[1] ) {
            react_blocks.registerBlockType( methods.cartBlocks.cartSubscribe.checkoutSchema.name, {
                title : methods.cartBlocks.cartSubscribe.checkoutSchema.title, // Localize title using wp.i18n.__()
                version : methods.cartBlocks.cartSubscribe.checkoutSchema.version,
                description : methods.cartBlocks.cartSubscribe.checkoutSchema.description,
                category : methods.cartBlocks.cartSubscribe.checkoutSchema.category, // Category Options: common, formatting, layout, widgets, embed
                supports : methods.cartBlocks.cartSubscribe.checkoutSchema.supports,
                icon : methods.cartBlocks.cartSubscribe.checkoutSchema.icon, // Dashicons Options – https://goo.gl/aTM1DQ
                keywords : methods.cartBlocks.cartSubscribe.checkoutSchema.keywords, // Limit to 3 Keywords / Phrases
                parent : methods.cartBlocks.cartSubscribe.checkoutSchema.parent,
                textdomain : methods.cartBlocks.cartSubscribe.checkoutSchema.textdomain,
                apiVersion : methods.cartBlocks.cartSubscribe.checkoutSchema.apiVersion,
                attributes : methods.cartBlocks.cartSubscribe.checkoutSchema.attributes, // Attributes set for each piece of dynamic data used in your block
                edit : methods.cartBlocks.cartSubscribe.edit, // Determines what is displayed in the editor
                save : methods.cartBlocks.cartSubscribe.save // Determines what is displayed on the frontend
            } );
        }
    }
} )();