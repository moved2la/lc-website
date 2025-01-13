<?php

defined( 'ABSPATH' ) || exit;

/**
 * Handle enqueues.
 * 
 * @class ASP_SSWS_Enqueues
 * @package Class
 */
class ASP_SSWS_Enqueues {

	/**
	 * Init ASP_SSWS_Enqueues.
	 */
	public static function init() {
		add_action( 'admin_enqueue_scripts', __CLASS__ . '::admin_scripts', 11 );
		add_action( 'admin_enqueue_scripts', __CLASS__ . '::admin_styles', 11 );
		add_action( 'wp_enqueue_scripts', __CLASS__ . '::frontend_scripts', 11 );
		add_action( 'wp_enqueue_scripts', __CLASS__ . '::frontend_styles', 11 );
		add_filter( 'woocommerce_screen_ids', __CLASS__ . '::load_wc_enqueues' );
	}

	/**
	 * Perform scripts localization in backend.
	 */
	public static function admin_scripts() {
		$screen    = get_current_screen();
		$screen_id = $screen ? $screen->id : '';

		wp_register_script( 'asp-ssws-admin', ASP_SSWS()->plugin_url() . '/assets/js/admin.js', array( 'jquery', 'wc-backbone-modal', 'wc-enhanced-select', 'wc-admin-meta-boxes' ), ASP_SSWS_VERSION, false );

		$billing_period_strings = WC_Subscriptions_Synchroniser::get_billing_period_ranges();
		wp_localize_script( 'asp-ssws-admin', 'asp_ssws_admin_params', array(
			'period'                                  => wcs_get_subscription_period_strings(),
			'subscription_lengths'                    => wcs_get_subscription_ranges(),
			'sync_options'                            => array(
				'week'  => $billing_period_strings[ 'week' ],
				'month' => $billing_period_strings[ 'month' ],
				'year'  => WC_Subscriptions_Synchroniser::get_year_sync_options(),
			),
			'back_to_settings_url'                    => esc_url( admin_url( 'admin.php?page=wc-settings&tab=subscriptions#asp_ssws_subscribe_and_save_landing-description' ) ),
			'back_to_all_subscribe_plans_url'         => esc_url( admin_url( 'edit.php?post_type=asp_subscribe_plan' ) ),
			'back_to_all_product_subscribe_rules_url' => esc_url( admin_url( 'edit.php?post_type=asp_prod_subs_rule' ) ),
			'back_to_all_cart_subscribe_rules_url'    => esc_url( admin_url( 'edit.php?post_type=asp_cart_subs_rule' ) ),
			'i18n_back_to_all_label'                  => esc_attr__( 'Back', 'subscribe-and-save-for-woocommerce-subscriptions' ),
			'i18n_back_to_settings_label'             => esc_attr__( 'Back to settings', 'subscribe-and-save-for-woocommerce-subscriptions' ),
			'i18n_plan_creation_warning'              => esc_attr__( 'Please create atleast one subscribe plan before creating the rule !', 'subscribe-and-save-for-woocommerce-subscriptions' ),
			'i18n_rule_description'                   => ASP_SSWS_Admin::is_screen( $screen_id, 'asp_cart_subs_rule' ) ? wp_kses_post( __( 'Rule description &ndash;&ndash; <small><i>Displayed under cart page</i></small>', 'subscribe-and-save-for-woocommerce-subscriptions' ) ) : wp_kses_post( __( 'Rule description &ndash;&ndash; <small><i>Displayed under shop and product pages</i></small>', 'subscribe-and-save-for-woocommerce-subscriptions' ) ),
		) );

		wp_enqueue_script( 'asp-ssws-admin' );

		if ( ASP_SSWS_Admin::is_screen( $screen_id, array( 'edit-asp_subscribe_plan', 'edit-asp_prod_subs_rule', 'edit-asp_cart_subs_rule' ) ) ) {
			wp_enqueue_script( 'asp-ssws-post-ordering', ASP_SSWS()->plugin_url() . '/assets/js/post-ordering.js', array( 'jquery-ui-sortable' ), ASP_SSWS_VERSION );
		}

		if ( ASP_SSWS_Admin::is_screen( $screen_id, array( 'asp_subscribe_plan', 'edit-asp_subscribe_plan' ) ) ) {
			wp_dequeue_script( 'autosave' );
		}
	}

	/**
	 * Load styles in backend.
	 */
	public static function admin_styles() {
		wp_register_style( 'asp-ssws-admin', ASP_SSWS()->plugin_url() . '/assets/css/admin.css', array( 'woocommerce_admin_styles', 'wc-admin-layout' ), ASP_SSWS_VERSION, 'all', false );
		wp_enqueue_style( 'asp-ssws-admin' );
	}

	/**
	 * Perform scripts localization in frontend.
	 */
	public static function frontend_scripts() {
		global $post;
		$product_id = $post && 'product' === get_post_type( $post ) ? $post->ID : false;
		$product    = ! empty( $product_id ) ? wc_get_product( $product_id ) : false;

		wp_register_script( 'jquery-confirm', ASP_SSWS()->plugin_url() . '/assets/jquery-confirm/jquery-confirm.min.js', array( 'jquery' ), ASP_SSWS_VERSION, false );
		wp_register_script( 'asp-ssws-subscribe-form', ASP_SSWS()->plugin_url() . '/assets/js/subscribe-form.js', array( 'jquery-confirm' ), ASP_SSWS_VERSION, false );
		wp_register_script( 'asp-ssws-frontend', ASP_SSWS()->plugin_url() . '/assets/js/frontend.js', array( 'asp-ssws-subscribe-form' ), ASP_SSWS_VERSION, false );

		wp_localize_script( 'asp-ssws-subscribe-form', 'asp_ssws_subscribe_form_params', array(
			'ajax_url'                         => admin_url( 'admin-ajax.php' ),
			'cart_url'                         => esc_url( wc_get_cart_url() ),
			'is_switch_request'                => isset( $_GET[ 'switch-subscription' ], $_GET[ 'item' ] ),
			'buynow_or_subscribe_nonce'        => wp_create_nonce( 'asp-ssws-buy-now-or-subscribe-handle' ),
			'subscribe_via_modal_nonce'        => wp_create_nonce( 'asp-ssws-subscribe-via-modal-handle' ),
			'add_to_cart_subscription_nonce'   => wp_create_nonce( 'asp-ssws-add-to-cart-subscription-handle' ),
			'i18n_subscribe_button_text'       => get_option( 'woocommerce_subscriptions_add_to_cart_button_text' ),
			'i18n_proceed_to_cart_button_text' => esc_html__( 'Proceed to cart', 'subscribe-and-save-for-woocommerce-subscriptions' ),
			'i18n_success_text'                => esc_html__( 'Success', 'subscribe-and-save-for-woocommerce-subscriptions' ),
			'i18n_error_text'                  => esc_html__( 'Error', 'subscribe-and-save-for-woocommerce-subscriptions' ),
			'i18n_single_add_to_cart_text'     => $product ? $product->single_add_to_cart_text() : esc_html__( 'Add to cart', 'woocommerce' ),
		) );

		wp_enqueue_script( 'asp-ssws-frontend' );
	}

	/**
	 * Load styles in frontend.
	 */
	public static function frontend_styles() {
		wp_register_style( 'jquery-confirm', ASP_SSWS()->plugin_url() . '/assets/jquery-confirm/jquery-confirm.min.css', array(), ASP_SSWS_VERSION, 'all', false );
		wp_register_style( 'asp-ssws-frontend', ASP_SSWS()->plugin_url() . '/assets/css/frontend.css', array( 'jquery-confirm' ), ASP_SSWS_VERSION, 'all', false );
		wp_enqueue_style( 'asp-ssws-frontend' );
	}

	/**
	 * Add our screens to WC screens.
	 * 
	 * @param array $screen_ids
	 * @return array
	 */
	public static function load_wc_enqueues( $screen_ids ) {
		$screen    = get_current_screen();
		$screen_id = $screen ? $screen->id : '';

		if ( in_array( $screen_id, ASP_SSWS_Admin::get_screen_ids() ) ) {
			$screen_ids[] = $screen_id;
		}

		return $screen_ids;
	}
}
