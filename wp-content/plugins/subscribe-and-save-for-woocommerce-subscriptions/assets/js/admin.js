/* global asp_ssws_admin_params, ajaxurl, tinymce */

jQuery( function( $ ) {
    'use strict';

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

    // Add buttons to subscribe plan and email template screen.
    var $subscribe_plans_screen = $( 'body.edit-php.post-type-asp_subscribe_plan' ),
            $subscribe_rules_screen = $( 'body.edit-php.post-type-asp_prod_subs_rule,body.edit-php.post-type-asp_cart_subs_rule' ),
            // Edit
            $edit_subscribe_plan_screen = $( 'body.post-new-php.post-type-asp_subscribe_plan,body.post-php.post-type-asp_subscribe_plan' ),
            $edit_product_subscribe_rule_screen = $( 'body.post-new-php.post-type-asp_prod_subs_rule,body.post-php.post-type-asp_prod_subs_rule' ),
            $edit_cart_subscribe_rule_screen = $( 'body.post-new-php.post-type-asp_cart_subs_rule,body.post-php.post-type-asp_cart_subs_rule' ),
            // List
            $subscribe_plans_screen_title = $subscribe_plans_screen.find( '.wp-header-end' ),
            $subscribe_rules_screen_title = $subscribe_rules_screen.find( '.wp-header-end' ),
            // Edit
            $edit_subscribe_plan_screen_title = $edit_subscribe_plan_screen.find( '.wp-header-end' ),
            $edit_product_subscribe_rule_screen_title = $edit_product_subscribe_rule_screen.find( '.wp-header-end' ),
            $edit_cart_subscribe_rule_screen_title = $edit_cart_subscribe_rule_screen.find( '.wp-header-end' );

    if ( $subscribe_plans_screen_title.length > 0 ) {
        $subscribe_plans_screen_title.before( '&nbsp;<a class="page-title-action" href="' + asp_ssws_admin_params.back_to_settings_url + '">' + asp_ssws_admin_params.i18n_back_to_settings_label + '</a>' );
    }

    if ( $subscribe_rules_screen_title.length > 0 ) {
        $subscribe_rules_screen_title.before( '&nbsp;<a class="page-title-action" href="' + asp_ssws_admin_params.back_to_settings_url + '">' + asp_ssws_admin_params.i18n_back_to_settings_label + '</a>' );
    }

    if ( $edit_subscribe_plan_screen_title.length > 0 ) {
        $edit_subscribe_plan_screen_title.before( '<a class="page-title-action" href="' + asp_ssws_admin_params.back_to_all_subscribe_plans_url + '">' + asp_ssws_admin_params.i18n_back_to_all_label + '</a>' );
        $edit_subscribe_plan_screen_title.before( '&nbsp;&nbsp;<a class="page-title-action" href="' + asp_ssws_admin_params.back_to_settings_url + '">' + asp_ssws_admin_params.i18n_back_to_settings_label + '</a>' );
    }

    if ( $edit_product_subscribe_rule_screen_title.length > 0 ) {
        $edit_product_subscribe_rule_screen_title.before( '<a class="page-title-action" href="' + asp_ssws_admin_params.back_to_all_product_subscribe_rules_url + '">' + asp_ssws_admin_params.i18n_back_to_all_label + '</a>' );
        $edit_product_subscribe_rule_screen_title.before( '&nbsp;&nbsp;<a class="page-title-action" href="' + asp_ssws_admin_params.back_to_settings_url + '">' + asp_ssws_admin_params.i18n_back_to_settings_label + '</a>' );
    }

    if ( $edit_cart_subscribe_rule_screen_title.length > 0 ) {
        $edit_cart_subscribe_rule_screen_title.before( '<a class="page-title-action" href="' + asp_ssws_admin_params.back_to_all_cart_subscribe_rules_url + '">' + asp_ssws_admin_params.i18n_back_to_all_label + '</a>' );
        $edit_cart_subscribe_rule_screen_title.before( '&nbsp;&nbsp;<a class="page-title-action" href="' + asp_ssws_admin_params.back_to_settings_url + '">' + asp_ssws_admin_params.i18n_back_to_settings_label + '</a>' );
    }

    $( 'a.asp-ssws-not-clickable' ).click( function( e ) {
        e.preventDefault();
        window.alert( asp_ssws_admin_params.i18n_plan_creation_warning );
        return false;
    } );

    $( '#asp_ssws_allow_product_subscribe' ).change( function() {
        $( '#asp_ssws_product_subscribe_default_value' ).closest( 'tr' ).hide();

        if ( 'yes-optional' === this.value ) {
            $( '#asp_ssws_product_subscribe_default_value' ).closest( 'tr' ).show();
        }

        if ( 'no' === this.value ) {
            $( this ).closest( 'td' ).find( '.description' ).hide();
        } else {
            $( this ).closest( 'td' ).find( '.description' ).show();
        }
    } ).change();

    $( '#asp_ssws_allow_cart_subscribe' ).change( function() {
        $( '#asp_ssws_cart_subscribe_default_value' ).closest( 'tr' ).hide();

        if ( 'yes-optional' === this.value ) {
            $( '#asp_ssws_cart_subscribe_default_value' ).closest( 'tr' ).show();
        }

        if ( 'no' === this.value ) {
            $( this ).closest( 'td' ).find( '.description' ).hide();
        } else {
            $( this ).closest( 'td' ).find( '.description' ).show();
        }
    } ).change();

    // Type box.
    if ( $( 'body' ).hasClass( 'wc-wp-version-gte-55' ) ) {
        $( '.plan-data-hidden-box' ).appendTo( '#asp_ssws_subscribe_plan_data .hndle' );
    } else {
        $( '.plan-data-hidden-box' ).appendTo( '#asp_ssws_subscribe_plan_data .hndle span' );
    }

    $( function() {
        // Prevent inputs in meta box headings opening/closing contents.
        $( '#asp_ssws_subscribe_plan_data' ).find( '.hndle' ).unbind( 'click.postboxes' );
        $( '#asp_ssws_subscribe_plan_data' ).on( 'click', '.hndle', function( event ) {

            // If the user clicks on some form input inside the h3 the box should not be toggled.
            if ( $( event.target ).filter( 'input, option, label, select' ).length ) {
                return;
            }

            $( '#asp_ssws_subscribe_plan_data' ).toggleClass( 'closed' );
        } );
    } );

    // Sitewide Plan options
    var metaboxes_subscribe_plan_data = {
        $wrapper : $( '#asp_ssws_subscribe_plan_data' ),
        init : function() {
            if ( 0 === this.$wrapper.length ) {
                return false;
            }

            this.$wrapper.on( 'change', 'select[name="_plan_definition"]', this.definitionSelected ).find( 'select[name="_plan_definition"]' ).change();
        },
        definitionSelected : function( e ) {
            e.preventDefault();

            metaboxes_subscribe_plan_data.$wrapper.find( '.woocommerce_options_panel' ).hide();
            metaboxes_subscribe_plan_data.$wrapper.find( '#' + this.value + '_plan_data' ).show();

            if ( 'predefined' === this.value ) {
                metaboxes_subscribe_plan_data.$wrapper.find( '#predefined_plan_data' ).on( 'change', '#_subscription_period,#_subscription_period_interval', metaboxes_subscribe_plan_data.predefinedPeriodSelected );
                metaboxes_subscribe_plan_data.$wrapper.find( '#predefined_plan_data' ).on( 'change', '#_subscription_payment_sync_date_month', metaboxes_subscribe_plan_data.syncDateMonthChanged );
                metaboxes_subscribe_plan_data.$wrapper.find( '#predefined_plan_data #_subscription_period' ).change();
            } else {
                metaboxes_subscribe_plan_data.$wrapper.find( '#userdefined_plan_data' ).on( 'change', '._subscription_interval_length_field .period_cell input', metaboxes_subscribe_plan_data.userdefinedPeriodSelected );
                metaboxes_subscribe_plan_data.$wrapper.find( '#userdefined_plan_data ._subscription_interval_length_field .period_cell input' ).change();
            }
        },
        daysInMonth : function( month ) {
            return new Date( Date.UTC( 2001, month, 0 ) ).getUTCDate();
        },
        predefinedPeriodSelected : function( e ) {
            var $length_element = metaboxes_subscribe_plan_data.$wrapper.find( '#predefined_plan_data #_subscription_length' ),
                    $sync_date_element = metaboxes_subscribe_plan_data.$wrapper.find( '#predefined_plan_data #_subscription_payment_sync_date' ),
                    chosen_billingPeriod = metaboxes_subscribe_plan_data.$wrapper.find( '#predefined_plan_data #_subscription_period' ).val(),
                    chosen_sync_date = $sync_date_element.val(),
                    chosen_length = $length_element.val();

            if ( 'day' === chosen_billingPeriod ) {
                metaboxes_subscribe_plan_data.$wrapper.find( '#predefined_plan_data .subscription_sync_week_month,#predefined_plan_data .subscription_sync_annual' ).hide();
                metaboxes_subscribe_plan_data.$wrapper.find( '#predefined_plan_data #_subscription_payment_sync_date' ).val( 0 );
                metaboxes_subscribe_plan_data.$wrapper.find( '#predefined_plan_data #_subscription_payment_sync_date_day,#predefined_plan_data #_subscription_payment_sync_date_month' ).val( 0 ).trigger( 'change' );
            } else if ( 'year' === chosen_billingPeriod ) {
                metaboxes_subscribe_plan_data.$wrapper.find( '#predefined_plan_data .subscription_sync_week_month' ).hide();
                metaboxes_subscribe_plan_data.$wrapper.find( '#predefined_plan_data .subscription_sync_annual' ).show();
                metaboxes_subscribe_plan_data.$wrapper.find( '#predefined_plan_data #_subscription_payment_sync_date' ).val( 0 ).hide();
            } else {
                metaboxes_subscribe_plan_data.$wrapper.find( '#predefined_plan_data .subscription_sync_week_month' ).show();
                metaboxes_subscribe_plan_data.$wrapper.find( '#predefined_plan_data .subscription_sync_annual' ).hide();
                metaboxes_subscribe_plan_data.$wrapper.find( '#predefined_plan_data #_subscription_payment_sync_date' ).val( 0 ).show();
                metaboxes_subscribe_plan_data.$wrapper.find( '#predefined_plan_data #_subscription_payment_sync_date_day,#predefined_plan_data #_subscription_payment_sync_date_month' ).val( 0 ).trigger( 'change' );

                $sync_date_element.empty();
                $.each( asp_ssws_admin_params.sync_options[chosen_billingPeriod], function( key, description ) {
                    $sync_date_element.append( $( '<option></option>' ).attr( 'value', key ).text( description ) );
                } );

                $sync_date_element.val( 0 );
                $sync_date_element.children( 'option' ).each( function() {
                    if ( this.value === chosen_sync_date ) {
                        $sync_date_element.val( chosen_sync_date );
                        return false;
                    }
                } );
            }

            $length_element.empty();
            $.each( asp_ssws_admin_params.subscription_lengths[ chosen_billingPeriod ], function( length, description ) {
                if ( 0 === parseInt( length ) || 0 === ( parseInt( length ) % metaboxes_subscribe_plan_data.$wrapper.find( '#predefined_plan_data #_subscription_period_interval' ).val() ) ) {
                    $length_element.append( $( '<option></option>' ).attr( 'value', length ).text( description ) );
                }
            } );

            $length_element.val( 0 );
            $length_element.children( 'option' ).each( function() {
                if ( this.value === chosen_length ) {
                    $length_element.val( chosen_length );
                    return false;
                }
            } );
        },
        userdefinedPeriodSelected : function( e ) {
            e.preventDefault();

            if ( this.checked ) {
                $( e.currentTarget ).closest( 'tr' ).find( '.interval_cell select, .length_cell select' ).prop( 'disabled', false );
            } else {
                $( e.currentTarget ).closest( 'tr' ).find( '.interval_cell select, .length_cell select' ).prop( 'disabled', true );
            }
        },
        syncDateMonthChanged : function( e ) {
            var $syncDateDayElement = $( e.currentTarget ).closest( '.wrap' ).find( '#_subscription_payment_sync_date_day' );

            if ( $( e.currentTarget ).val() > 0 ) {
                $syncDateDayElement.val( 1 ).attr( { step : "1", min : "1", max : metaboxes_subscribe_plan_data.daysInMonth( $( e.currentTarget ).val() ) } ).prop( 'disabled', false );
            } else {
                $syncDateDayElement.val( 0 ).prop( 'disabled', true );
            }
        },
    };

    var metaboxes_subscribe_rule_data = {
        $wrapper : $( '#asp_ssws_subscribe_rule_data' ),
        init : function() {
            if ( 0 === this.$wrapper.length ) {
                return false;
            }

            this.wrapDescription();
            this.$wrapper.on( 'click', '.asp_ssws_subscribe_rule_data_tabs li.active', this.activeTab )
                    .find( '.asp_ssws_subscribe_rule_data_tabs li.active' ).click();
        },
        wrapDescription : function() {
            var editorWrapper = $( '#postdivrich' );

            if ( editorWrapper.length ) {
                editorWrapper.addClass( 'postbox asp-ssws-rule-description' );
                editorWrapper.prepend(
                        '<h2 class="postbox-header"><label>' +
                        asp_ssws_admin_params.i18n_rule_description +
                        '</label></h2>'
                        );
            }
        },
        activeTab : function( e ) {
            e.preventDefault();

            if ( $( e.currentTarget ).is( '.general_tab' ) ) {
                metaboxes_subscribe_rule_data.general.init();
            } else if ( $( e.currentTarget ).is( '.criteria_tab' ) ) {
                metaboxes_subscribe_rule_data.criteria.init();
            }
        },
        general : {
            $wrapper : $( '#general_rule_data .options_group' ),
            init : function() {

            }
        },
        criteria : {
            $wrapper : $( '#criteria_rule_data .options_group' ),
            init : function() {
                this.$wrapper
                        .on( 'change', '#_criteria_product_filter', this.productFilterChanged )
                        .on( 'change', '#_criteria_user_filter', this.userFilterChanged )

                        .find( '#_criteria_product_filter,#_criteria_user_filter' ).change();
            },
            productFilterChanged : function( e ) {
                e.preventDefault();

                $( e.currentTarget ).closest( 'div' ).find( '._criteria_products_field,._criteria_product_cats_field' ).hide();

                if ( 'included-products' === $( e.currentTarget ).val() || 'excluded-products' === $( e.currentTarget ).val() ) {
                    $( e.currentTarget ).closest( 'div' ).find( '._criteria_products_field' ).show();
                } else if ( 'included-product-cats' === $( e.currentTarget ).val() || 'excluded-product-cats' === $( e.currentTarget ).val() ) {
                    $( e.currentTarget ).closest( 'div' ).find( '._criteria_product_cats_field' ).show();
                }
            },
            userFilterChanged : function( e ) {
                e.preventDefault();

                $( e.currentTarget ).closest( 'div' ).find( '._criteria_users_field,._criteria_user_roles_field' ).hide();

                if ( 'included-users' === $( e.currentTarget ).val() || 'excluded-users' === $( e.currentTarget ).val() ) {
                    $( e.currentTarget ).closest( 'div' ).find( '._criteria_users_field' ).show();
                } else if ( 'included-user-roles' === $( e.currentTarget ).val() || 'excluded-user-roles' === $( e.currentTarget ).val() ) {
                    $( e.currentTarget ).closest( 'div' ).find( '._criteria_user_roles_field' ).show();
                }
            }
        }
    };

    metaboxes_subscribe_plan_data.init();
    metaboxes_subscribe_rule_data.init();
} );
