<?php

/**
 * Product Subscribe and Save handler.
 *
 * @class ASP_SSWS_Product_Subscribe
 * @package Class
 */
class ASP_SSWS_Product_Subscribe extends ASP_SSWS_Subscribe {

	/**
	 * The single instance of the class.
	 *
	 * @var ASP_SSWS_Product_Subscribe|null
	 */
	protected static $instance = null;

	/**
	 * Gets the main ASP_SSWS_Product_Subscribe Instance.
	 *
	 * @return ASP_SSWS_Product_Subscribe Main instance
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();

			add_filter( 'woocommerce_is_subscription', array( self::$instance, 'enable_subscription' ), 20, 3 );
			add_filter( 'woocommerce_get_price_html', array( self::$instance, 'get_price_html' ), 9999, 2 );
			add_filter( 'woocommerce_product_add_to_cart_text', array( self::$instance, 'add_to_cart_text' ), 9999, 2 );
			add_filter( 'woocommerce_product_add_to_cart_url', array( self::$instance, 'add_to_cart_url' ), 9999, 2 );
			add_filter( 'woocommerce_product_supports', array( self::$instance, 'product_supports' ), 9999, 3 );
			add_filter( 'woocommerce_add_cart_item_data', array( self::$instance, 'add_subscribe_level' ), 20, 3 );

			add_action( 'woocommerce_add_to_cart', array( self::$instance, 'init_subscription_from_session_in_cart' ), 18, 0 );
			add_action( 'woocommerce_cart_loaded_from_session', array( self::$instance, 'load_subscription_from_session_in_cart' ), 4 );
			add_action( 'woocommerce_before_calculate_totals', array( self::$instance, 'load_subscription_from_session_in_cart' ), 4 );
			add_action( 'woocommerce_before_calculate_totals', array( self::$instance, 'add_price_calculation_filter' ), -1 );
			add_action( 'woocommerce_before_product_object_save', array( self::$instance, 'destroy_subscription_cache' ) );

			add_filter( 'woocommerce_available_variation', array( self::$instance, 'add_variation_data' ), 10, 3 );
			add_action( 'wp_loaded', array( self::$instance, 'add_actions_to_render_subscribe_form' ) );

			add_filter( 'wcs_is_product_switchable', array( self::$instance, 'is_product_switchable' ), 100, 2 );
			add_filter( 'woocommerce_subscriptions_can_item_be_switched', array( self::$instance, 'can_switch_item' ), 5, 3 );
			add_filter( 'woocommerce_subscriptions_switch_is_identical_product', array( self::$instance, 'is_identical_product' ), 100, 5 );

			add_action( 'woocommerce_subscription_cart_before_grouping', array( self::$instance, 'fix_trial_in_cart' ), 9 );
			add_filter( 'wcs_recurring_cart_start_date', array( self::$instance, 'fix_trial_in_cart' ), -1 );
			add_filter( 'woocommerce_subscriptions_calculated_total', array( self::$instance, 'fix_trial_in_cart' ), 999 );
		}

		return self::$instance;
	}

	/**
	 * Get the subscribe level.
	 * 
	 * @return string
	 */
	public function get_level() {
		return 'product_level';
	}

	/**
	 * Check if the subscribe enabled on product.
	 * 
	 * @param WC_Product $product
	 * @return bool
	 */
	public function enabled( $product ) {
		if ( in_array( get_option( 'asp_ssws_allow_product_subscribe' ), array( 'yes-optional', 'yes-forced' ) ) && ! $this->is_subscription_product_type( $product ) && $this->is_supported_product_type( $product ) ) {
			$enabled = ! empty( ASP_SSWS_Subscribe_Rules::get_product_rule_applied( $product->get_id(), get_current_user_id() ) );
		} else {
			$enabled = false;
		}

		/**
		 * Check if the subscribe enabled on product.
		 * 
		 * @since 1.0.0
		 */
		return apply_filters( 'asp_ssws_subscribe_enabled', $enabled, $product, $this );
	}

	/**
	 * Check if it is available to subscribe on product.
	 * 
	 * @param WC_Product $product
	 * @return bool
	 */
	public function is_available( $product ) {
		/**
		 * Check if it is available to subscribe on product.
		 * 
		 * @since 1.0.0
		 */
		return apply_filters( 'asp_ssws_is_available_to_subscribe', $this->enabled( $product ), $product, $this );
	}

	/**
	 * Check if it is available to show subscribe now option on product.
	 * 
	 * @param WC_Product $product
	 * @return bool
	 */
	public function is_subscribe_now_option_available( $product ) {
		/**
		 * Check if it is available to show subscribe now option on product.
		 * 
		 * @since 1.9.0
		 */
		return apply_filters( 'asp_ssws_is_subscribe_now_option_available', 'yes' === get_option( 'asp_ssws_show_subscribe_now_option', 'yes' ), $product, $this );
	}

	/**
	 * Get the subscribe plans.
	 * 
	 * @param WC_Product $product
	 * @return array
	 */
	public function get_subscribe_plans( $product = null ) {
		$rule_applied = ASP_SSWS_Subscribe_Rules::get_product_rule_applied( $product->get_id(), get_current_user_id() );

		if ( $rule_applied ) {
			$plans = $this->validate_subscribe_plans( asp_ssws_sort_subscribe_plans( $rule_applied->get_subscribe_plans() ) );
		} else {
			$plans = array();
		}

		return $plans;
	}

	/**
	 * Check if the user is subscribed.
	 * 
	 * @param WC_Product $product
	 * @return bool
	 */
	public function is_subscribed( $product ) {
		if ( is_object( $product ) && $this->is_available( $product ) && $this->get_level() === $product->get_meta( '_asp_ssws_subscribed_level', true, 'edit' ) ) {
			$subscribed = true;
		} else {
			$subscribed = false;
		}

		return $subscribed;
	}

	/**
	 * Check if the subscribe plans are allowed to switch.
	 *
	 * @return bool
	 */
	protected function allowed_switching_between_plans() {
		return 'yes' === get_option( 'woocommerce_subscriptions_allow_switching_asp_ssws_subscribe_plans' );
	}

	/**
	 * Delete the data.
	 *
	 * @param string $key
	 */
	public function delete_data( $key = null ) {
		if ( ! empty( $key ) && is_scalar( $key ) ) {
			unset( $this->data[ $key ] );
		}
	}

	/**
	 * Return an array of subscribe form via modal args.
	 * 
	 * @param mixed $product
	 * @return array
	 */
	public function get_subscribe_form_via_modal_args( $product = null ) {
		$product                        = asp_ssws_maybe_get_product_instance( $product );
		$args                           = parent::get_subscribe_form_via_modal_args( $product->get_id() );
		$args[ 'subscribe_product_id' ] = $product->get_id();

		/**
		 * Get the subscribe form via modal args.
		 * 
		 * @since 1.3.0
		 */
		return ( array ) apply_filters( 'asp_ssws_subscribe_form_via_modal_args', $args, $this );
	}

	/**
	 * Return an array of subscribe form args.
	 * 
	 * @param mixed $product
	 * @return array
	 */
	public function get_subscribe_form_args( $product = null ) {
		$product = asp_ssws_maybe_get_product_instance( $product );
		$args    = parent::get_subscribe_form_args( $product->get_id() );

		if ( ! empty( $this->data[ $product->get_id() ] ) ) {
			$this->add_price_calculation_filter();
			$this->add_subscription_cache( $product, $this->data[ $product->get_id() ] );
			$args[ 'subscribe_price_string' ] = WC_Subscriptions_Product::get_price_string( $product, array( 'price' => wc_price( $product->get_price() ) ) );
			$this->destroy_subscription_cache( $product );
			$this->remove_price_calculation_filter();
		}

		$args[ 'subscribe_product_id' ]    = $product->get_id();
		$args[ 'subscribe_plans' ]         = $this->get_subscribe_plans( $product );
		$args[ 'via_modal' ]               = $this->via_modal;
		$args[ 'subscribe_forced' ]        = isset( $_GET[ 'switch-subscription' ], $_GET[ 'item' ] ) || 'yes-forced' === get_option( 'asp_ssws_allow_product_subscribe' ) || $this->via_modal;
		$args[ 'default_subscribe_value' ] = get_option( 'asp_ssws_product_subscribe_default_value' );

		/**
		 * Get the subscribe form args.
		 * 
		 * @since 1.0.0
		 */
		return ( array ) apply_filters( 'asp_ssws_subscribe_form_args', $args, $this );
	}

	/**
	 * Read posted data.
	 *
	 * @param array $posted Values of the prop.
	 * @param mixed $product
	 */
	public function read_posted_data( $posted, $product ) {
		$product = asp_ssws_maybe_get_product_instance( $product );
		if ( ! $product ) {
			return;
		}

		if ( ! empty( $posted[ 'data' ] ) ) {
			$posted = wp_parse_args( wp_unslash( $posted[ 'data' ] ) );
		}

		if ( ! $this->is_available( $product ) || empty( $posted[ 'asp_ssws_pay_option' ] ) || empty( $posted[ 'asp_ssws_pay_option' ][ $product->get_id() ] ) ) {
			$this->delete_data( $product->get_id() );
			return;
		}

		$pay_option                      = $posted[ 'asp_ssws_pay_option' ][ $product->get_id() ];
		unset( $posted[ 'asp_ssws_pay_option' ][ $product->get_id() ] );
		$posted[ 'asp_ssws_pay_option' ] = $pay_option;

		parent::read_posted_data( $posted, $product->get_id() );
	}

	/**
	 * Check if the subscribe plan enabled product is adding to cart.
	 * 
	 * @param mixed $product
	 * @return bool
	 */
	public function adding_to_cart( $product ) {
		$product = asp_ssws_maybe_get_product_instance( $product );

		$this->read_posted_data( $_REQUEST, $product );

		if ( $product && 'yes' === $this->get_prop( 'subscription_enabled', null, $product->get_id() ) && asp_ssws_is_subscribe_plan( $this->get_prop( 'subscription_plan', null, $product->get_id() ) ) ) {
			$adding = true;
		} else {
			$adding = false;
		}

		return $adding;
	}

	/**
	 * Enable subscription on product.
	 * 
	 * @param bool $is_subscription
	 * @param int $product_id
	 * @param WC_Product $product
	 * @return bool
	 */
	public function enable_subscription( $is_subscription, $product_id = null, $product = null ) {
		if ( ! $product ) {
			return $is_subscription;
		}

		if ( $this->is_subscribed( $product ) ) {
			return true;
		}

		// Is switch in progress ?
		if ( isset( $_GET[ 'switch-subscription' ], $_GET[ 'item' ] ) ) {
			if ( isset( $_REQUEST[ 'add-to-cart' ] ) && is_numeric( $_REQUEST[ 'add-to-cart' ] ) ) {
				/**
				 * Get the add to cart product ID.
				 * 
				 * @since 1.0.0
				 */
				$product_id = apply_filters( 'woocommerce_add_to_cart_product_id', absint( wp_unslash( $_REQUEST[ 'add-to-cart' ] ) ) );
				$product    = wc_get_product(  ! empty( $_REQUEST[ 'variation_id' ] ) ? absint( wp_unslash( $_REQUEST[ 'variation_id' ] ) ) : $product_id );
			}

			if ( $this->adding_to_cart( $product ) ) {
				$this->add_subscription_cache( $product, $this->data[ $product->get_id() ] );
				$is_subscription = $this->is_subscribed( $product );
				$this->destroy_subscription_cache( $product );
			}
		}

		return $is_subscription;
	}

	/**
	 * Gets the product price HTML.
	 * 
	 * @param string $price_html
	 * @param WC_Product $product
	 * @return string
	 */
	public function get_price_html( $price_html, $product ) {
		$product = asp_ssws_maybe_get_product_instance( $product );

		if ( $this->is_available( $product ) && ! $product->is_type( 'variable' ) ) {
			$rule_applied = ASP_SSWS_Subscribe_Rules::get_product_rule_applied( $product->get_id(), get_current_user_id() );

			if ( $rule_applied && ! empty( $rule_applied->get_description() ) ) {
				/* translators: 1: price html 2: rule description */
				$price_html = sprintf( __( '%1$s <small class="asp-ssws-product-rule-description">%2$s</small>', 'subscribe-and-save-for-woocommerce-subscriptions' ), $price_html, $rule_applied->get_description() );
			}
		}

		return $price_html;
	}

	/**
	 * Change add to cart text.
	 *
	 * @param string $text
	 * @param WC_Product $product
	 * @return string
	 */
	public function add_to_cart_text( $text, $product ) {
		$product = asp_ssws_maybe_get_product_instance( $product );

		if ( $this->is_available( $product ) && ! $product->is_type( 'variable' ) && 'yes-forced' === get_option( 'asp_ssws_allow_product_subscribe' ) ) {
			$text = __( 'Select options', 'subscribe-and-save-for-woocommerce-subscriptions' );
		}

		return $text;
	}

	/**
	 * Change add to cart URL.
	 *
	 * @param string $url
	 * @param WC_Product $product
	 * @return string
	 */
	public function add_to_cart_url( $url, $product ) {
		$product = asp_ssws_maybe_get_product_instance( $product );

		if ( $this->is_available( $product ) && ! $product->is_type( 'variable' ) && 'yes-forced' === get_option( 'asp_ssws_allow_product_subscribe' ) ) {
			$url = $product->get_permalink();
		}

		return $url;
	}

	/**
	 * Product supported feature.
	 * 
	 * @param bool $bool
	 * @param array $feature
	 * @param WC_Product $product
	 * @return bool
	 */
	public function product_supports( $bool, $feature, $product ) {
		$product = asp_ssws_maybe_get_product_instance( $product );

		if ( $this->is_available( $product ) && ! $product->is_type( 'variable' ) && 'yes-forced' === get_option( 'asp_ssws_allow_product_subscribe' ) ) {
			$bool = 'ajax_add_to_cart' === $feature ? false : true;
		}

		return $bool;
	}

	/**
	 * Add the subscribe level to the cart item data.
	 * 
	 * @param array $cart_item_data
	 * @param int $product_id
	 * @param int $variation_id
	 * @return array
	 */
	public function add_subscribe_level( $cart_item_data, $product_id, $variation_id ) {
		$product = wc_get_product( $variation_id > 0 ? $variation_id : $product_id );

		if ( $this->adding_to_cart( $product ) ) {
			$cart_item_data[ 'asp_subscribed' ] = $this->data[ $product->get_id() ];
		}

		return $cart_item_data;
	}

	/**
	 * Load the subscription from session in cart.
	 * 
	 * @param WC_Cart $cart
	 */
	public function load_subscription_from_session_in_cart( $cart ) {
		foreach ( $cart->cart_contents as $cart_item_key => $cart_item ) {
			if ( empty( $cart_item[ 'asp_subscribed' ] ) ) {
				continue;
			}

			if ( ! $this->is_available( $cart->cart_contents[ $cart_item_key ][ 'data' ] ) || isset( $cart_item[ 'subscription_renewal' ] ) || isset( $cart_item[ 'subscription_initial_payment' ] ) || isset( $cart_item[ 'subscription_resubscribe' ] ) ) {
				$this->destroy_subscription_cache( $cart->cart_contents[ $cart_item_key ][ 'data' ] );
				continue;
			}

			if ( ! asp_ssws_is_subscribe_plan( $cart_item[ 'asp_subscribed' ][ 'subscription_plan' ] ) ) {
				$this->destroy_subscription_cache( $cart->cart_contents[ $cart_item_key ][ 'data' ] );
				continue;
			}

			$this->add_subscription_cache( $cart->cart_contents[ $cart_item_key ][ 'data' ], $cart_item[ 'asp_subscribed' ] );
		}
	}

	/**
	 * Add the price filter dependent hooks. 
	 */
	public function add_price_calculation_filter() {
		add_filter( 'woocommerce_product_get_price', array( self::$instance, 'calculate_subscription_price' ), 99, 2 );
		add_filter( 'woocommerce_product_variation_get_price', array( self::$instance, 'calculate_subscription_price' ), 99, 2 );
		add_filter( 'woocommerce_product_get_regular_price', array( self::$instance, 'calculate_subscription_price' ), 99, 2 );
		add_filter( 'woocommerce_product_variation_get_regular_price', array( self::$instance, 'calculate_subscription_price' ), 99, 2 );
	}

	/**
	 * Remove the price filter dependent hooks. 
	 */
	public function remove_price_calculation_filter() {
		remove_filter( 'woocommerce_product_get_price', array( self::$instance, 'calculate_subscription_price' ), 99 );
		remove_filter( 'woocommerce_product_variation_get_price', array( self::$instance, 'calculate_subscription_price' ), 99 );
		remove_filter( 'woocommerce_product_get_regular_price', array( self::$instance, 'calculate_subscription_price' ), 99 );
		remove_filter( 'woocommerce_product_variation_get_regular_price', array( self::$instance, 'calculate_subscription_price' ), 99 );
	}

	/**
	 * Add the variation data on demand which will used upon selecting each variation.
	 * 
	 * @param array $variation_data
	 * @param WC_Product_Variable $variable
	 * @param WC_Product_Variation $variation
	 * @return array
	 */
	public function add_variation_data( $variation_data, $variable, $variation ) {
		if ( $this->is_available( $variation ) ) {
			$variation_data[ 'asp_subscribe_form' ]          = $this->get_subscribe_form( true, false, $variation );
			$variation_data[ 'asp_single_add_to_cart_text' ] = $variation->single_add_to_cart_text();
		}

		return $variation_data;
	}

	/**
	 * To render the subscribe form.
	 */
	public function add_actions_to_render_subscribe_form() {
		/**
		 * Get the subscribe now option link shop page position.
		 * 
		 * @since 1.3.0
		 */
		$hook = sanitize_title( apply_filters( 'asp_ssws_get_subscribe_now_option_link_shop_page_position', 'woocommerce_after_shop_loop_item' ) );
		add_action( $hook, array( self::$instance, 'maybe_render_subscribe_now_option_link' ), 8 );

		/**
		 * Get subscribe form product page position.
		 * 
		 * @since 1.0.0
		 */
		$hook = sanitize_title( apply_filters( 'asp_ssws_get_subscribe_form_product_page_position', 'woocommerce_before_add_to_cart_button' ) );
		add_action( $hook, array( self::$instance, 'maybe_render_subscribe_form' ) );
	}

	/**
	 * Maybe render the subscribe now option link.
	 */
	public function maybe_render_subscribe_now_option_link() {
		global $product;

		$product = asp_ssws_maybe_get_product_instance( $product );

		if ( $this->is_available( $product ) && ! $product->is_type( 'variable' ) && $this->is_subscribe_now_option_available( $product ) ) {
			$this->get_subscribe_form_via_modal( true, true, $product );
		}
	}

	/**
	 * Maybe render the subscribe form.
	 */
	public function maybe_render_subscribe_form() {
		global $product, $post;

		if ( empty( $product ) ) {
			$product = $post && 'product' === get_post_type( $post ) ? $post->ID : false;
		}

		$product = asp_ssws_maybe_get_product_instance( $product );

		if ( $this->is_available( $product ) ) {
			$this->get_subscribe_form( true, true, $product );
		}
	}

	/**
	 * Allow the non WCS product to be switchable.
	 *
	 * @param  boolean     $is_switchable
	 * @param  WC_Product  $product
	 * @return boolean
	 */
	public function is_product_switchable( $is_switchable, $product ) {
		if ( empty( $product ) || ! ( $product instanceof WC_Product ) ) {
			return $is_switchable;
		}

		if ( ! $this->allowed_switching_between_plans() ) {
			return $is_switchable;
		}

		if ( ! $is_switchable ) {
			$is_switchable = $this->is_available( $product );
		}

		if ( ! $is_switchable && $product->get_parent_id() > 0 ) {
			$parent_product = wc_get_product( $product->get_parent_id() );

			if ( $parent_product ) {
				$child_ids = $parent_product->get_children();

				foreach ( $child_ids as $child_id ) {
					$child_product = wc_get_product( $child_id );

					if ( $this->is_available( $child_product ) ) {
						$is_switchable = true;
						break;
					}
				}
			}
		}

		return $is_switchable;
	}

	/**
	 * Do not allow switching to the non supported subscription item.
	 *
	 * @param  boolean          $can
	 * @param  WC_Order_Item    $item
	 * @param  WC_Subscription  $subscription
	 * @return boolean
	 */
	public function can_switch_item( $can, $item, $subscription ) {
		if ( ! $this->allowed_switching_between_plans() ) {
			return $can;
		}

		$allowed_to_subscribe_items_count = 0;

		foreach ( $subscription->get_items() as $item ) {
			$product = $item->get_product();

			if ( $product && $this->is_supported_product_type( $product ) ) {
				$allowed_to_subscribe_items_count++;
			}
		}

		if ( $allowed_to_subscribe_items_count > 1 ) {
			$can = false;
		}

		return $can;
	}

	/**
	 * Check whether the non WCS product is identical?
	 *
	 * @param  boolean         $is_identical
	 * @param  int             $product_id
	 * @param  int             $quantity
	 * @param  int             $variation_id
	 * @param  WC_Subscription $subscription
	 * @return boolean
	 */
	public function is_identical_product( $is_identical, $product_id, $quantity, $variation_id, $subscription ) {
		if ( ! $this->allowed_switching_between_plans() ) {
			return $is_identical;
		}

		if ( $is_identical ) {
			$product = wc_get_product( $variation_id > 0 ? $variation_id : $product_id );

			if ( $this->adding_to_cart( $product ) ) {
				$is_identical = ( $subscription->get_billing_period() === $this->get_prop( 'subscription_period', null, $product->get_id() ) && $subscription->get_billing_interval() == $this->get_prop( 'subscription_period_interval', null, $product->get_id() ) ) ? true : false;
			}
		}

		return $is_identical;
	}

	/**
	 * Force subscribe based upon the current request.
	 * 
	 * @param array $args
	 * @return array
	 */
	public function maybe_force_subscribe( $args ) {
		if (
				isset( $_GET[ 'switch-subscription' ], $_GET[ 'item' ] ) ||
				'yes-forced' === get_option( 'asp_ssws_allow_product_subscribe' ) ||
				$this->via_modal ||
				( isset( $_POST[ 'security' ], $_POST[ 'is_switch_request' ] ) && wp_verify_nonce( wc_clean( wp_unslash( $_POST[ 'security' ] ) ), 'asp-ssws-buy-now-or-subscribe-handle' ) && wc_string_to_bool( wc_clean( $_POST[ 'is_switch_request' ] ) ) )
		) {
			$args[ 'subscribe_forced' ] = true;
		} else {
			$args[ 'subscribe_forced' ] = false;
		}

		return $args;
	}

	/**
	 * Fix trial not set in cart.
	 */
	public function fix_trial_in_cart( $total = '' ) {
		remove_action( 'woocommerce_subscription_cart_before_grouping', 'WC_Subscriptions_Synchroniser::maybe_unset_free_trial' );
		remove_filter( 'wcs_recurring_cart_start_date', 'WC_Subscriptions_Synchroniser::maybe_unset_free_trial', 0, 1 );
		remove_filter( 'woocommerce_subscriptions_calculated_total', 'WC_Subscriptions_Synchroniser::maybe_unset_free_trial', 10000, 1 );

		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			// Dont override trial length set while resubscribing, unless proration is disabled.
			if ( WC_Subscriptions_Synchroniser::is_product_synced( $cart_item[ 'data' ] ) && ( ! isset( $cart_item[ 'subscription_resubscribe' ] ) || ! WC_Subscriptions_Synchroniser::is_sync_proration_enabled() ) ) {

				// When reinstating the trial length, set resubscribes trial length to 0 so we don't grant a second trial period.
				if ( isset( $cart_item[ 'subscription_resubscribe' ] ) ) {
					$trial_length = 0;
				} elseif ( $cart_item[ 'data' ]->get_meta( '_asp_ssws_subscribed_plan', true, 'edit' ) ) {
					$trial_length = WC_Subscriptions_Product::get_trial_length( $cart_item[ 'data' ] );
				} else {
					$trial_length = WC_Subscriptions_Product::get_trial_length( wcs_get_canonical_product_id( $cart_item ) );
				}

				wcs_set_objects_property( WC()->cart->cart_contents[ $cart_item_key ][ 'data' ], 'subscription_trial_length', $trial_length, 'set_prop_only' );
			}
		}

		return $total;
	}
}
