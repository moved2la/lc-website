( ( ) => {
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
            init : function( e ) {
                if ( methods.isSubscribePlugin( e.extensions ) && methods.pluginData.is_available ) {
                    return react_element.createElement( methods.cartBlocks.cartSubscribe.init, e );
                }

                return null;
            },
            cartSubscribe : {
                cartSchema : JSON.parse( "{\"name\":\"woocommerce/cart-order-summary-asp-ssws-cart-subscribe-block\",\"icon\":\"backup\",\"keywords\":[\"subscription\",\"cart\"],\"version\":\"1.0.0\",\"title\":\"Cart Subscribe\",\"description\":\"Shows the cart subscribe form.\",\"category\":\"woocommerce\",\"supports\":{\"align\":false,\"html\":false,\"multiple\":false,\"reusable\":false},\"attributes\":{\"className\":{\"type\":\"string\",\"default\":\"\"},\"lock\":{\"type\":\"object\",\"default\":{\"remove\":true,\"move\":false}}},\"parent\":[\"woocommerce/cart-totals-block\"],\"textdomain\":\"subscribe-and-save-for-woocommerce-subscriptions\",\"apiVersion\":2}" ),
                checkoutSchema : JSON.parse( "{\"name\":\"woocommerce/checkout-order-summary-asp-ssws-cart-subscribe-block\",\"icon\":\"backup\",\"keywords\":[\"subscription\",\"cart\"],\"version\":\"1.0.0\",\"title\":\"Cart Subscribe\",\"description\":\"Shows the cart subscribe form.\",\"category\":\"woocommerce\",\"supports\":{\"align\":false,\"html\":false,\"multiple\":false,\"reusable\":false},\"attributes\":{\"className\":{\"type\":\"string\",\"default\":\"\"},\"lock\":{\"type\":\"object\",\"default\":{\"remove\":true,\"move\":false}}},\"parent\":[\"woocommerce/checkout-totals-block\"],\"textdomain\":\"subscribe-and-save-for-woocommerce-subscriptions\",\"apiVersion\":2}" ),
                isLoading : false,
                isSubscribed : null,
                planSelected : "",
                intervalSelected : "",
                periodSelected : "",
                lengthSelected : "",
                setLoading : null,
                setIsSubscribed : null,
                setPlanSelected : null,
                setIntervalSelected : null,
                setPeriodSelected : null,
                setLengthSelected : null,
                init : function( e ) {
                    return react_element.createElement( react_element.Fragment, null,
                            react_element.createElement( methods.cartBlocks.cartSubscribe.form, null ) );
                },
                form : function() {
                    [ methods.cartBlocks.cartSubscribe.isLoading, methods.cartBlocks.cartSubscribe.setLoading ] = react_element.useState( false );

                    return react_element.createElement( react_wc_blocksCheckout.TotalsWrapper, { className : "asp-ssws-cart-subscribe-form-wrapper" },
                            '' !== methods.pluginData.cart_rule_description ? react_element.createElement( methods.cartBlocks.cartSubscribe.cartRuleDescription ) : null,
                            react_element.createElement( methods.cartBlocks.cartSubscribe.subscribeSelectionElement ),
                            'yes' === methods.pluginData.is_subscribed ? react_element.createElement( methods.cartBlocks.cartSubscribe.definedPlanSelectionElement ) : null,
                            'yes' === methods.pluginData.is_subscribed && 'userdefined' === methods.pluginData.subscribe_definition ? react_element.createElement( methods.cartBlocks.cartSubscribe.customPlanSelectionElement ) : null,
                            'yes' === methods.pluginData.is_subscribed ? react_element.createElement( methods.cartBlocks.cartSubscribe.subscribePriceString ) : null );
                },
                payOptionChanged : function( value ) {
                    methods.cartBlocks.cartSubscribe.setLoading( true );
                    react_wc_blocksCheckout.extensionCartUpdate( {
                        namespace : 'subscribe-and-save-for-woocommerce-subscriptions',
                        data : {
                            action : 'buy_now_or_subscribe',
                            value : {
                                pay_option : value,
                                subscribe_plan_selected : ( methods.pluginData.chosen_subscribe_plan > 0 ? methods.pluginData.chosen_subscribe_plan : methods.pluginData.default_subscribe_plan ),
                                subscribe_interval_selected : methods.pluginData.chosen_subscribe_interval,
                                subscribe_period_selected : methods.pluginData.chosen_subscribe_period,
                                subscribe_length_selected : methods.pluginData.chosen_subscribe_length
                            }
                        }
                    } ).then( function( e ) {
                        methods.isSubscribePlugin( e.extensions );
                        methods.cartBlocks.cartSubscribe.setIsSubscribed( methods.pluginData.is_subscribed );
                    } ).finally( function() {
                        methods.cartBlocks.cartSubscribe.setLoading( false );
                    } );
                },
                subscribePlanChanged : function( value ) {
                    methods.cartBlocks.cartSubscribe.setLoading( true );
                    react_wc_blocksCheckout.extensionCartUpdate( {
                        namespace : 'subscribe-and-save-for-woocommerce-subscriptions',
                        data : {
                            action : 'buy_now_or_subscribe',
                            value : {
                                pay_option : 'yes' === methods.pluginData.is_subscribed ? 'subscribe' : 'one-time',
                                subscribe_plan_selected : value,
                                subscribe_interval_selected : methods.pluginData.chosen_subscribe_interval,
                                subscribe_period_selected : methods.pluginData.chosen_subscribe_period,
                                subscribe_length_selected : methods.pluginData.chosen_subscribe_length
                            }
                        }
                    } ).then( function( e ) {
                        methods.isSubscribePlugin( e.extensions );
                        methods.cartBlocks.cartSubscribe.setPlanSelected( methods.pluginData.chosen_subscribe_plan );
                    } ).finally( function() {
                        methods.cartBlocks.cartSubscribe.setLoading( false );
                    } );
                },
                subscribeIntervalChanged : function( value ) {
                    methods.cartBlocks.cartSubscribe.setLoading( true );
                    react_wc_blocksCheckout.extensionCartUpdate( {
                        namespace : 'subscribe-and-save-for-woocommerce-subscriptions',
                        data : {
                            action : 'buy_now_or_subscribe',
                            value : {
                                pay_option : 'yes' === methods.pluginData.is_subscribed ? 'subscribe' : 'one-time',
                                subscribe_plan_selected : methods.pluginData.chosen_subscribe_plan,
                                subscribe_interval_selected : value,
                                subscribe_period_selected : methods.pluginData.chosen_subscribe_period,
                                subscribe_length_selected : methods.pluginData.chosen_subscribe_length
                            }
                        }
                    } ).then( function( e ) {
                        methods.isSubscribePlugin( e.extensions );
                        methods.cartBlocks.cartSubscribe.setIntervalSelected( methods.pluginData.chosen_subscribe_interval );
                    } ).finally( function() {
                        methods.cartBlocks.cartSubscribe.setLoading( false );
                    } );
                },
                subscribePeriodChanged : function( value ) {
                    methods.cartBlocks.cartSubscribe.setLoading( true );
                    react_wc_blocksCheckout.extensionCartUpdate( {
                        namespace : 'subscribe-and-save-for-woocommerce-subscriptions',
                        data : {
                            action : 'buy_now_or_subscribe',
                            value : {
                                pay_option : 'yes' === methods.pluginData.is_subscribed ? 'subscribe' : 'one-time',
                                subscribe_plan_selected : methods.pluginData.chosen_subscribe_plan,
                                subscribe_interval_selected : methods.pluginData.chosen_subscribe_interval,
                                subscribe_period_selected : value,
                                subscribe_length_selected : methods.pluginData.chosen_subscribe_length
                            }
                        }
                    } ).then( function( e ) {
                        methods.isSubscribePlugin( e.extensions );
                        methods.cartBlocks.cartSubscribe.setPeriodSelected( methods.pluginData.chosen_subscribe_period );
                    } ).finally( function() {
                        methods.cartBlocks.cartSubscribe.setLoading( false );
                    } );
                },
                subscribeLengthChanged : function( value ) {
                    methods.cartBlocks.cartSubscribe.setLoading( true );
                    react_wc_blocksCheckout.extensionCartUpdate( {
                        namespace : 'subscribe-and-save-for-woocommerce-subscriptions',
                        data : {
                            action : 'buy_now_or_subscribe',
                            value : {
                                pay_option : 'yes' === methods.pluginData.is_subscribed ? 'subscribe' : 'one-time',
                                subscribe_plan_selected : methods.pluginData.chosen_subscribe_plan,
                                subscribe_interval_selected : methods.pluginData.chosen_subscribe_interval,
                                subscribe_period_selected : methods.pluginData.chosen_subscribe_period,
                                subscribe_length_selected : value
                            }
                        }
                    } ).then( function( e ) {
                        methods.isSubscribePlugin( e.extensions );
                        methods.cartBlocks.cartSubscribe.setLengthSelected( methods.pluginData.chosen_subscribe_length );
                    } ).finally( function() {
                        methods.cartBlocks.cartSubscribe.setLoading( false );
                    } );
                },
                cartRuleDescription : function( e ) {
                    return react_element.createElement( react_wc_blocksCheckout.TotalsItem, {
                        className : "asp-ssws-cart-subscribe-form-wrapper__cart-rule-description",
                        value : react_element.createElement( react_element.RawHTML, null, methods.pluginData.cart_rule_description )
                    } );
                },
                subscribeSelectionElement : function( e ) {
                    if ( methods.pluginData.subscribe_forced ) {
                        [ methods.cartBlocks.cartSubscribe.isSubscribed, methods.cartBlocks.cartSubscribe.setIsSubscribed ] = react_element.useState( 'yes' );
                    } else {
                        if ( null === methods.pluginData.is_subscribed ) {
                            [ methods.cartBlocks.cartSubscribe.isSubscribed, methods.cartBlocks.cartSubscribe.setIsSubscribed ] = react_element.useState( 'subscribe' === methods.pluginData.default_subscribe_value ? 'yes' : 'no' );
                        } else {
                            [ methods.cartBlocks.cartSubscribe.isSubscribed, methods.cartBlocks.cartSubscribe.setIsSubscribed ] = react_element.useState( methods.pluginData.is_subscribed );
                        }
                    }

                    react_element.useEffect( function() {
                        methods.cartBlocks.cartSubscribe.payOptionChanged( 'yes' === methods.cartBlocks.cartSubscribe.isSubscribed ? 'subscribe' : 'one-time' );
                    }, [ methods.cartBlocks.cartSubscribe.isSubscribed ] );

                    return react_element.createElement( react_wc_blocksCheckout.TotalsItem, {
                        className : "asp-ssws-cart-subscribe-form-wrapper__subscribe-options",
                        label : react_element.createElement( "p", { className : "asp-ssws-subscribe-options" },
                                methods.pluginData.subscribe_forced ? null : react_element.createElement( methods.cartBlocks.cartSubscribe.oneTimePayOptionElement ),
                                methods.pluginData.subscribe_forced ? null : react_element.createElement( "br" ),
                                react_element.createElement( methods.cartBlocks.cartSubscribe.subscribePayOptionElement ) )
                    } );
                },
                oneTimePayOptionElement : function( e ) {
                    return react_element.createElement( "label", { htmlFor : "asp_ssws_pay_one_time" },
                            react_element.createElement( "input", {
                                id : "asp_ssws_pay_one_time",
                                name : "asp_ssws_pay_option",
                                className : "asp-ssws-pay-option-one-time " + ( methods.cartBlocks.cartSubscribe.isLoading ? "asp-ssws-subscribe-component--disabled" : "" ),
                                value : "one-time",
                                type : "radio",
                                checked : 'no' === methods.cartBlocks.cartSubscribe.isSubscribed || null === methods.cartBlocks.cartSubscribe.isSubscribed,
                                disabled : methods.cartBlocks.cartSubscribe.isLoading,
                                onChange : function( e ) {
                                    methods.cartBlocks.cartSubscribe.payOptionChanged( e.target.value );
                                }
                            } ), "  ", methods.pluginData.one_time_purchase_option_label );
                },
                subscribePayOptionElement : function( e ) {
                    return react_element.createElement( "label", { htmlFor : "asp_ssws_pay_subscribe" },
                            react_element.createElement( "input", {
                                id : "asp_ssws_pay_subscribe",
                                name : "asp_ssws_pay_option",
                                className : "asp-ssws-pay-option-subscribe " + ( methods.cartBlocks.cartSubscribe.isLoading ? "asp-ssws-subscribe-component--disabled" : "" ),
                                value : "subscribe",
                                type : "radio",
                                checked : 'yes' === methods.cartBlocks.cartSubscribe.isSubscribed,
                                disabled : methods.cartBlocks.cartSubscribe.isLoading,
                                onChange : function( e ) {
                                    methods.cartBlocks.cartSubscribe.payOptionChanged( e.target.value );
                                }
                            } ), "  ", methods.pluginData.subscribe_option_label );
                },
                definedPlanSelectionElement : function( e ) {
                    [ methods.cartBlocks.cartSubscribe.planSelected, methods.cartBlocks.cartSubscribe.setPlanSelected ] = react_element.useState( methods.pluginData.chosen_subscribe_plan > 0 ? methods.pluginData.chosen_subscribe_plan : methods.pluginData.default_subscribe_plan );

                    return react_element.createElement( react_wc_blocksCheckout.TotalsWrapper, { className : "asp-ssws-cart-subscribe-form-wrapper__subscribe-plan-options" },
                            react_element.createElement( react_wc_blocksCheckout.TotalsItem, {
                                className : "asp-ssws-cart-subscribe-form-wrapper__subscribe-plan-options__subscribe-plans",
                                label : methods.pluginData.subscribe_plan_label,
                                value : methods.pluginData.subscribe_plans.length > 0 ? react_element.createElement( "select", {
                                    id : "asp_ssws_subscribe_plans",
                                    className : "asp-ssws-subscribe-plans " + ( methods.cartBlocks.cartSubscribe.isLoading ? "asp-ssws-subscribe-component--disabled" : "" ),
                                    value : methods.cartBlocks.cartSubscribe.planSelected,
                                    disabled : methods.cartBlocks.cartSubscribe.isLoading,
                                    onChange : function( e ) {
                                        methods.cartBlocks.cartSubscribe.subscribePlanChanged( e.target.value );
                                    }
                                }, methods.pluginData.subscribe_plans.map( function( plan ) {
                                    return react_element.createElement( "option", { value : plan.id, key : plan.id }, plan.title );
                                } ) ) : react_element.createElement( "span", null, react_i18n.__( "No subscribe plans found.", "subscribe-and-save-for-woocommerce-subscriptions" ) ),
                                description : methods.pluginData.subscribe_discount_label && methods.pluginData.subscribe_discount > 0 ? react_element.createElement( react_element.RawHTML, { className : "asp-ssws-cart-subscribe-form-wrapper__subscribe-plan-options__subscribe-discount" }, methods.pluginData.subscribe_discount_label.replace( "{subscribe_discount}", methods.pluginData.subscribe_discount ) ) : null
                            } ) );
                },
                customPlanSelectionElement : function( e ) {
                    [ methods.cartBlocks.cartSubscribe.intervalSelected, methods.cartBlocks.cartSubscribe.setIntervalSelected ] = react_element.useState( methods.pluginData.chosen_subscribe_interval );
                    [ methods.cartBlocks.cartSubscribe.periodSelected, methods.cartBlocks.cartSubscribe.setPeriodSelected ] = react_element.useState( methods.pluginData.chosen_subscribe_period );
                    [ methods.cartBlocks.cartSubscribe.lengthSelected, methods.cartBlocks.cartSubscribe.setLengthSelected ] = react_element.useState( methods.pluginData.chosen_subscribe_length );

                    react_element.useEffect( function() {
                        methods.cartBlocks.cartSubscribe.subscribeIntervalChanged( methods.cartBlocks.cartSubscribe.intervalSelected );
                        methods.cartBlocks.cartSubscribe.subscribeLengthChanged( methods.cartBlocks.cartSubscribe.lengthSelected );
                    }, [ methods.cartBlocks.cartSubscribe.intervalSelected ] );

                    react_element.useEffect( function() {
                        methods.cartBlocks.cartSubscribe.subscribePeriodChanged( methods.cartBlocks.cartSubscribe.periodSelected );
                        methods.cartBlocks.cartSubscribe.subscribeLengthChanged( methods.cartBlocks.cartSubscribe.lengthSelected );
                    }, [ methods.cartBlocks.cartSubscribe.periodSelected ] );

                    react_element.useEffect( function() {
                        methods.cartBlocks.cartSubscribe.subscribeLengthChanged( methods.cartBlocks.cartSubscribe.lengthSelected );
                    }, [ methods.cartBlocks.cartSubscribe.lengthSelected ] );

                    return react_element.createElement( react_wc_blocksCheckout.TotalsWrapper, { className : "asp-ssws-cart-subscribe-form-wrapper__subscribe-custom-plan-options" },
                            methods.pluginData.subscribe_intervals.length > 0 ? react_element.createElement( react_wc_blocksCheckout.TotalsItem, {
                                className : "asp-ssws-cart-subscribe-form-wrapper__subscribe-custom-plan-options__subscribe-period-interval",
                                label : methods.pluginData.billing_interval_label,
                                value : react_element.createElement( "select", {
                                    id : "asp_ssws_subscribe_period_interval",
                                    className : "asp-ssws-subscribe-period-interval " + ( methods.cartBlocks.cartSubscribe.isLoading ? "asp-ssws-subscribe-component--disabled" : "" ),
                                    value : methods.cartBlocks.cartSubscribe.intervalSelected,
                                    disabled : methods.cartBlocks.cartSubscribe.isLoading,
                                    onChange : function( e ) {
                                        methods.cartBlocks.cartSubscribe.subscribeIntervalChanged( e.target.value );
                                    }
                                }, methods.pluginData.subscribe_intervals.map( function( interval ) {
                                    return react_element.createElement( "option", { value : interval.key, key : interval.key }, interval.title );
                                } ) )
                            } ) : null,
                            methods.pluginData.subscribe_periods.length > 0 ? react_element.createElement( react_wc_blocksCheckout.TotalsItem, {
                                className : "asp-ssws-cart-subscribe-form-wrapper__subscribe-custom-plan-options__subscribe-period",
                                label : methods.pluginData.billing_period_label,
                                value : react_element.createElement( "select", {
                                    id : "asp_ssws_subscribe_period",
                                    className : "asp-ssws-subscribe-period " + ( methods.cartBlocks.cartSubscribe.isLoading ? "asp-ssws-subscribe-component--disabled" : "" ),
                                    value : methods.cartBlocks.cartSubscribe.periodSelected,
                                    disabled : methods.cartBlocks.cartSubscribe.isLoading,
                                    onChange : function( e ) {
                                        methods.cartBlocks.cartSubscribe.subscribePeriodChanged( e.target.value );
                                    }
                                }, methods.pluginData.subscribe_periods.map( function( period ) {
                                    return react_element.createElement( "option", { value : period.key, key : period.key }, period.title );
                                } ) )
                            } ) : null,
                            methods.pluginData.subscribe_lengths.length > 0 ? react_element.createElement( react_wc_blocksCheckout.TotalsItem, {
                                className : "asp-ssws-cart-subscribe-form-wrapper__subscribe-custom-plan-options__subscribe-length",
                                label : methods.pluginData.billing_expiration_label,
                                value : react_element.createElement( "select", {
                                    id : "asp_ssws_subscribe_length",
                                    className : "asp-ssws-subscribe-length " + ( methods.cartBlocks.cartSubscribe.isLoading ? "asp-ssws-subscribe-component--disabled" : "" ),
                                    value : methods.cartBlocks.cartSubscribe.lengthSelected,
                                    disabled : methods.cartBlocks.cartSubscribe.isLoading,
                                    onChange : function( e ) {
                                        methods.cartBlocks.cartSubscribe.subscribeLengthChanged( e.target.value );
                                    }
                                }, methods.pluginData.subscribe_lengths.map( function( length ) {
                                    return react_element.createElement( "option", { value : length.key, key : length.key }, length.title );
                                } ) )
                            } ) : null );
                },
                subscribePriceString : function( e ) {
                    return react_element.createElement( react_wc_blocksCheckout.TotalsItem, {
                        className : "asp-ssws-cart-subscribe-form-wrapper__subscribe-price-string",
                        value : react_element.createElement( react_element.RawHTML, null, methods.pluginData.subscribe_price_string )
                    } );
                },
            }
        }
    };

    const { cart_subscribe_allowed_pages : cartSubscribeAllowedPages } = react_wc_settings.getSetting( 'subscribe-and-save-for-woocommerce-subscriptions_data' );

    if ( cartSubscribeAllowedPages.length ) {
        if ( 'cart' === cartSubscribeAllowedPages[0] ) {
            react_wc_blocksCheckout.registerCheckoutBlock( {
                metadata : methods.cartBlocks.cartSubscribe.cartSchema,
                component : methods.cartBlocks.init
            } );
        }

        if ( 'checkout' === cartSubscribeAllowedPages[0] || 'checkout' === cartSubscribeAllowedPages[1] ) {
            react_wc_blocksCheckout.registerCheckoutBlock( {
                metadata : methods.cartBlocks.cartSubscribe.checkoutSchema,
                component : methods.cartBlocks.init
            } );
        }
    }
} )( );