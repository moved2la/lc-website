<?php

use Automattic\WooCommerce\StoreApi\Schemas\V1\CartSchema;
use Automattic\WooCommerce\StoreApi\Schemas\V1\CartItemSchema;

/**
 * Store API integration class.
 *
 * @class ASP_SSWS_Store_API
 * @package Class
 */
class ASP_SSWS_Store_API {

	/**
	 * Plugin identifier, unique to each plugin.
	 *
	 * @var string
	 */
	const IDENTIFIER = 'subscribe-and-save-for-woocommerce-subscriptions';

	/**
	 * Bootstraps the class and hooks required data.
	 */
	public static function init() {
		self::extend_store();
	}

	/**
	 * Register cart data handler.
	 */
	public static function extend_store() {
		if ( ! function_exists( 'woocommerce_store_api_register_endpoint_data' ) ) {
			return;
		}

		woocommerce_store_api_register_endpoint_data(
				array(
					'endpoint'        => CartItemSchema::IDENTIFIER,
					'namespace'       => self::IDENTIFIER,
					'data_callback'   => array( __CLASS__, 'extend_cart_item_data' ),
					'schema_callback' => array( __CLASS__, 'extend_cart_item_schema' ),
					'schema_type'     => ARRAY_A,
				)
		);

		woocommerce_store_api_register_endpoint_data(
				array(
					'endpoint'        => CartSchema::IDENTIFIER,
					'namespace'       => self::IDENTIFIER,
					'data_callback'   => array( __CLASS__, 'extend_cart_data' ),
					'schema_callback' => array( __CLASS__, 'extend_cart_schema' ),
					'schema_type'     => ARRAY_A,
				)
		);

		woocommerce_store_api_register_update_callback(
				array(
					'namespace' => self::IDENTIFIER,
					'callback'  => array( __CLASS__, 'handle_update_endpoint' ),
				)
		);
	}

	/**
	 * Gets extension data to cart route responses.
	 *
	 * @return array
	 */
	public static function get_cart_data( $cart_item = array() ) {
		$cart_data = array(
			'is_available'                   => false,
			'subscribe_level'                => null,
			'is_subscribed'                  => false,
			'subscribe_price_string'         => '',
			'subscribe_product_id'           => 0,
			'subscribe_discount'             => 0,
			'subscribe_forced'               => false,
			'subscribe_definition'           => '',
			'chosen_subscribe_plan'          => 0,
			'chosen_subscribe_interval'      => null,
			'chosen_subscribe_period'        => null,
			'chosen_subscribe_length'        => null,
			'subscribe_plans'                => array(),
			'subscribe_interval_length'      => array(),
			'default_subscribe_plan'         => '0',
			'default_subscribe_value'        => '',
			'one_time_purchase_option_label' => get_option( 'asp_ssws_one_time_purchase_option_label' ),
			'subscribe_option_label'         => get_option( 'asp_ssws_subscribe_option_label' ),
			'subscribe_discount_label'       => get_option( 'asp_ssws_subscribe_discount_label' ),
			'subscribe_plan_label'           => get_option( 'asp_ssws_subscribe_plan_label' ),
			'billing_interval_label'         => get_option( 'asp_ssws_subscribe_interval_label' ),
			'billing_period_label'           => get_option( 'asp_ssws_subscribe_period_label' ),
			'billing_expiration_label'       => get_option( 'asp_ssws_subscribe_expiration_label' ),
			'subscribe_periods'              => array(),
			'subscribe_intervals'            => array(),
			'subscribe_lengths'              => array(),
			'min_subscribe_length'           => array(),
			'max_subscribe_length'           => array(),
			'cart_rule_description'          => '',
		);

		if ( ASP_SSWS_Cart_Subscribe::instance()->is_available( WC()->cart ) ) {
			$rule_applied   = ASP_SSWS_Subscribe_Rules::get_cart_rule_applied( get_current_user_id() );
			$subscribe_data = ASP_SSWS_Cart_Subscribe::instance()->get_subscribe_form_args();

			$plans = array();
			if ( ! empty( $subscribe_data[ 'subscribe_plans' ] ) ) {
				foreach ( $subscribe_data[ 'subscribe_plans' ] as $plan ) {
					$plans[] = array(
						'id'    => $plan->get_id(),
						'title' => $plan->get_name(),
					);
				}
			}

			$periods   = array();
			$intervals = array();
			$lengths   = array();
			if ( ! empty( $subscribe_data[ 'chosen_subscribe_period' ] ) ) {
				foreach ( wcs_get_subscription_period_interval_strings() as $value => $label ) {
					if (
							isset( $subscribe_data[ 'subscribe_interval_length' ][ $subscribe_data[ 'chosen_subscribe_period' ] ][ 'interval' ][ 'min' ], $subscribe_data[ 'subscribe_interval_length' ][ $subscribe_data[ 'chosen_subscribe_period' ] ][ 'interval' ][ 'max' ] ) &&
							$value >= $subscribe_data[ 'subscribe_interval_length' ][ $subscribe_data[ 'chosen_subscribe_period' ] ][ 'interval' ][ 'min' ] && $value <= $subscribe_data[ 'subscribe_interval_length' ][ $subscribe_data[ 'chosen_subscribe_period' ] ][ 'interval' ][ 'max' ]
					) {
						$intervals[] = array(
							'key'   => $value,
							'title' => $label,
						);
					}
				}

				foreach ( wcs_get_subscription_period_strings() as $value => $label ) {
					if ( isset( $subscribe_data[ 'subscribe_interval_length' ][ $value ][ 'enabled' ] ) && 'yes' === $subscribe_data[ 'subscribe_interval_length' ][ $value ][ 'enabled' ] ) {
						$periods[] = array(
							'key'   => $value,
							'title' => $label,
						);
					}
				}

				if ( isset( $subscribe_data[ 'subscribe_interval_length' ][ $subscribe_data[ 'chosen_subscribe_period' ] ][ 'length' ][ 'min' ], $subscribe_data[ 'subscribe_interval_length' ][ $subscribe_data[ 'chosen_subscribe_period' ] ][ 'length' ][ 'max' ] ) ) {
					$needs_never_expire = true;

					foreach ( asp_ssws_get_subscription_length_ranges( $subscribe_data[ 'chosen_subscribe_period' ], $subscribe_data[ 'chosen_subscribe_interval' ] ) as $value => $label ) {
						if ( $value >= $subscribe_data[ 'subscribe_interval_length' ][ $subscribe_data[ 'chosen_subscribe_period' ] ][ 'length' ][ 'min' ] ) {
							if ( '0' === $subscribe_data[ 'subscribe_interval_length' ][ $subscribe_data[ 'chosen_subscribe_period' ] ][ 'length' ][ 'max' ] ) {
								$needs_never_expire = true;
								$lengths[]          = array(
									'key'   => $value,
									'title' => $label,
								);
							} else if ( $value <= $subscribe_data[ 'subscribe_interval_length' ][ $subscribe_data[ 'chosen_subscribe_period' ] ][ 'length' ][ 'max' ] ) {
								$needs_never_expire = false;
								$lengths[]          = array(
									'key'   => $value,
									'title' => $label,
								);
							}
						}
					}

					if ( $needs_never_expire ) {
						$lengths[] = array(
							'key'   => 0,
							'title' => esc_html__( 'Never expire', 'subscribe-and-save-for-woocommerce-subscriptions' ),
						);
					}
				}
			}

			$cart_data                           = $subscribe_data;
			$cart_data[ 'is_available' ]         = true;
			$cart_data[ 'subscribe_plans' ]      = $plans;
			$cart_data[ 'subscribe_intervals' ]  = $intervals;
			$cart_data[ 'subscribe_periods' ]    = $periods;
			$cart_data[ 'subscribe_lengths' ]    = $lengths;
			$cart_data[ 'min_subscribe_length' ] = current( $lengths );
			$cart_data[ 'max_subscribe_length' ] = end( $lengths );

			if ( $rule_applied && ! empty( $rule_applied->get_description() ) ) {
				/* translators: rule description */
				$cart_data[ 'cart_rule_description' ] = wp_kses_post( sprintf( __( '<span class="asp-ssws-cart-rule-description">%s</span>', 'subscribe-and-save-for-woocommerce-subscriptions' ), $rule_applied->get_description() ) );
			}

			if ( empty( $subscribe_data[ 'default_subscribe_plan' ] ) && count( $subscribe_data[ 'subscribe_plans' ] ) > 0 ) {
				$cart_data[ 'default_subscribe_plan' ] = current( $subscribe_data[ 'subscribe_plans' ] )->get_id();
			}
		} elseif ( ! empty( $cart_item[ 'data' ] ) && ASP_SSWS_Product_Subscribe::instance()->is_available( $cart_item[ 'data' ] ) ) {
			$subscribe_data = ASP_SSWS_Product_Subscribe::instance()->get_subscribe_form_args( $cart_item[ 'data' ] );

			$plans = array();
			if ( ! empty( $subscribe_data[ 'subscribe_plans' ] ) ) {
				foreach ( $subscribe_data[ 'subscribe_plans' ] as $plan ) {
					$plans[] = array(
						'id'    => $plan->get_id(),
						'title' => $plan->get_name(),
					);
				}
			}

			$cart_data                      = $subscribe_data;
			$cart_data[ 'is_available' ]    = true;
			$cart_data[ 'subscribe_plans' ] = $plans;

			if ( empty( $subscribe_data[ 'default_subscribe_plan' ] ) && count( $subscribe_data[ 'subscribe_plans' ] ) > 0 ) {
				$cart_data[ 'default_subscribe_plan' ] = current( $subscribe_data[ 'subscribe_plans' ] )->get_id();
			}
		}

		return $cart_data;
	}

	/**
	 * Register product data into cart/items endpoint.
	 *
	 * @param  array $cart_item Current cart item data.
	 * @return array $item_data Registered deposits product data.
	 */
	public static function extend_cart_item_data( $cart_item ) {
		return self::get_cart_data( $cart_item );
	}

	/**
	 * Register product schema into cart/items endpoint.
	 *
	 * @return array Registered schema.
	 */
	public static function extend_cart_item_schema() {
		return self::extend_cart_schema();
	}

	/**
	 * Adds extension data to cart route responses.
	 *
	 * @return array
	 */
	public static function extend_cart_data() {
		return self::get_cart_data();
	}

	/**
	 * Register schema into cart endpoint.
	 *
	 * @return  array  Registered schema.
	 */
	public static function extend_cart_schema() {
		return array(
			'is_available'                   => array(
				'description' => __( 'Check if the cart/product is available to subscribe.', 'subscribe-and-save-for-woocommerce-subscriptions' ),
				'type'        => 'boolean',
				'context'     => array( 'view', 'edit' ),
				'readonly'    => true,
			),
			'subscribe_level'                => array(
				'description' => __( 'Subscribe level.', 'subscribe-and-save-for-woocommerce-subscriptions' ),
				'type'        => array( 'string', 'null' ),
				'context'     => array( 'view', 'edit' ),
				'readonly'    => true,
			),
			'is_subscribed'                  => array(
				'description' => __( 'Check if the subscription enabled.', 'subscribe-and-save-for-woocommerce-subscriptions' ),
				'type'        => 'boolean',
				'context'     => array( 'view', 'edit' ),
				'readonly'    => true,
			),
			'subscribe_price_string'         => array(
				'description' => __( 'Subscribe price string.', 'subscribe-and-save-for-woocommerce-subscriptions' ),
				'type'        => array( 'string', 'null' ),
				'context'     => array( 'view', 'edit' ),
				'readonly'    => true,
			),
			'subscribe_product_id'           => array(
				'description' => __( 'Subscribe product ID.', 'subscribe-and-save-for-woocommerce-subscriptions' ),
				'type'        => 'integer',
				'context'     => array( 'view', 'edit' ),
				'readonly'    => true,
			),
			'subscribe_discount'             => array(
				'description' => __( 'Subscribe product discount.', 'subscribe-and-save-for-woocommerce-subscriptions' ),
				'type'        => 'integer',
				'context'     => array( 'view', 'edit' ),
				'readonly'    => true,
			),
			'subscribe_forced'               => array(
				'description' => __( 'Check if the subscription is forced.', 'subscribe-and-save-for-woocommerce-subscriptions' ),
				'type'        => 'boolean',
				'context'     => array( 'view', 'edit' ),
				'readonly'    => true,
			),
			'subscribe_definition'           => array(
				'description' => __( 'Subscribe definition.', 'subscribe-and-save-for-woocommerce-subscriptions' ),
				'type'        => 'string',
				'context'     => array( 'view', 'edit' ),
				'readonly'    => true,
			),
			'chosen_subscribe_plan'          => array(
				'description' => __( 'Chosen subscribe plan.', 'subscribe-and-save-for-woocommerce-subscriptions' ),
				'type'        => 'integer',
				'context'     => array( 'view', 'edit' ),
				'readonly'    => true,
			),
			'chosen_subscribe_interval'      => array(
				'description' => __( 'Chosen subscribe interval.', 'subscribe-and-save-for-woocommerce-subscriptions' ),
				'type'        => array( 'string', 'null' ),
				'context'     => array( 'view', 'edit' ),
				'readonly'    => true,
			),
			'chosen_subscribe_period'        => array(
				'description' => __( 'Chosen subscribe period.', 'subscribe-and-save-for-woocommerce-subscriptions' ),
				'type'        => array( 'string', 'null' ),
				'context'     => array( 'view', 'edit' ),
				'readonly'    => true,
			),
			'chosen_subscribe_length'        => array(
				'description' => __( 'Chosen subscribe length.', 'subscribe-and-save-for-woocommerce-subscriptions' ),
				'type'        => array( 'string', 'null' ),
				'context'     => array( 'view', 'edit' ),
				'readonly'    => true,
			),
			'subscribe_plans'                => array(
				'description' => __( 'Subscribe plans.', 'subscribe-and-save-for-woocommerce-subscriptions' ),
				'type'        => 'array',
				'context'     => array( 'view', 'edit' ),
				'readonly'    => true,
			),
			'subscribe_interval_length'      => array(
				'description' => __( 'Subscribe interval length.', 'subscribe-and-save-for-woocommerce-subscriptions' ),
				'type'        => 'array',
				'context'     => array( 'view', 'edit' ),
				'readonly'    => true,
			),
			'default_subscribe_plan'         => array(
				'description' => __( 'Default subscribe plan.', 'subscribe-and-save-for-woocommerce-subscriptions' ),
				'type'        => 'integer',
				'context'     => array( 'view', 'edit' ),
				'readonly'    => true,
			),
			'default_subscribe_value'        => array(
				'description' => __( 'Default subscribe value.', 'subscribe-and-save-for-woocommerce-subscriptions' ),
				'type'        => 'string',
				'context'     => array( 'view', 'edit' ),
				'readonly'    => true,
			),
			'one_time_purchase_option_label' => array(
				'description' => __( 'One-time purchase option label.', 'subscribe-and-save-for-woocommerce-subscriptions' ),
				'type'        => 'string',
				'context'     => array( 'view', 'edit' ),
				'readonly'    => true,
			),
			'subscribe_option_label'         => array(
				'description' => __( 'Subscribe option label.', 'subscribe-and-save-for-woocommerce-subscriptions' ),
				'type'        => 'string',
				'context'     => array( 'view', 'edit' ),
				'readonly'    => true,
			),
			'subscribe_discount_label'       => array(
				'description' => __( 'Subscribe discount label.', 'subscribe-and-save-for-woocommerce-subscriptions' ),
				'type'        => 'string',
				'context'     => array( 'view', 'edit' ),
				'readonly'    => true,
			),
			'subscribe_plan_label'           => array(
				'description' => __( 'Subscribe plan label.', 'subscribe-and-save-for-woocommerce-subscriptions' ),
				'type'        => 'string',
				'context'     => array( 'view', 'edit' ),
				'readonly'    => true,
			),
			'billing_interval_label'         => array(
				'description' => __( 'Billing interval label.', 'subscribe-and-save-for-woocommerce-subscriptions' ),
				'type'        => 'string',
				'context'     => array( 'view', 'edit' ),
				'readonly'    => true,
			),
			'billing_period_label'           => array(
				'description' => __( 'Billing period label.', 'subscribe-and-save-for-woocommerce-subscriptions' ),
				'type'        => 'string',
				'context'     => array( 'view', 'edit' ),
				'readonly'    => true,
			),
			'billing_expiration_label'       => array(
				'description' => __( 'Billing expiration label.', 'subscribe-and-save-for-woocommerce-subscriptions' ),
				'type'        => 'string',
				'context'     => array( 'view', 'edit' ),
				'readonly'    => true,
			),
			'subscribe_periods'              => array(
				'description' => __( 'Subscribe periods.', 'subscribe-and-save-for-woocommerce-subscriptions' ),
				'type'        => 'array',
				'context'     => array( 'view', 'edit' ),
				'readonly'    => true,
			),
			'subscribe_intervals'            => array(
				'description' => __( 'Subscribe intervals.', 'subscribe-and-save-for-woocommerce-subscriptions' ),
				'type'        => 'array',
				'context'     => array( 'view', 'edit' ),
				'readonly'    => true,
			),
			'subscribe_lengths'              => array(
				'description' => __( 'Subscribe lengths.', 'subscribe-and-save-for-woocommerce-subscriptions' ),
				'type'        => 'array',
				'context'     => array( 'view', 'edit' ),
				'readonly'    => true,
			),
			'min_subscribe_length'           => array(
				'description' => __( 'Min subscribe length.', 'subscribe-and-save-for-woocommerce-subscriptions' ),
				'type'        => 'array',
				'context'     => array( 'view', 'edit' ),
				'readonly'    => true,
			),
			'max_subscribe_length'           => array(
				'description' => __( 'Max subscribe length.', 'subscribe-and-save-for-woocommerce-subscriptions' ),
				'type'        => 'array',
				'context'     => array( 'view', 'edit' ),
				'readonly'    => true,
			),
		);
	}

	/**
	 * Handle our actions through StoreAPI.
	 *
	 * @param array $args
	 */
	public static function handle_update_endpoint( $args ) {
		switch ( $args[ 'action' ] ) {
			case 'buy_now_or_subscribe':
				if ( isset( $args[ 'value' ][ 'pay_option' ] ) ) {
					$posted = array(
						'asp_ssws_pay_option'                => array( 0 => $args[ 'value' ][ 'pay_option' ] ),
						'asp_ssws_subscribe_plan'            => $args[ 'value' ][ 'subscribe_plan_selected' ],
						'asp_ssws_subscribe_period_interval' => $args[ 'value' ][ 'subscribe_interval_selected' ],
						'asp_ssws_subscribe_period'          => $args[ 'value' ][ 'subscribe_period_selected' ],
						'asp_ssws_subscribe_length'          => $args[ 'value' ][ 'subscribe_length_selected' ],
					);
				} else {
					$posted = array();
				}

				ASP_SSWS_Cart_Subscribe::instance()->read_posted_data( $posted, 0 );
				break;
		}
	}
}
