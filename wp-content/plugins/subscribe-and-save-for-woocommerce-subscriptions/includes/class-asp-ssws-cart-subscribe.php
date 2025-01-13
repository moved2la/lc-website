<?php

/**
 * Cart Subscribe and Save handler.
 *
 * @class ASP_SSWS_Cart_Subscribe
 * @package Class
 */
class ASP_SSWS_Cart_Subscribe extends ASP_SSWS_Subscribe {

	/**
	 * The single instance of the class.
	 *
	 * @var ASP_SSWS_Cart_Subscribe|null
	 */
	protected static $instance = null;

	/**
	 * Gets the main ASP_SSWS_Cart_Subscribe Instance.
	 *
	 * @return ASP_SSWS_Cart_Subscribe Main instance
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();

			add_filter( 'woocommerce_is_subscription', array( self::$instance, 'enable_subscription' ), 20, 3 );

			add_action( 'woocommerce_add_to_cart', array( self::$instance, 'init_subscription_from_session_in_cart' ), 19, 0 );
			add_action( 'woocommerce_cart_loaded_from_session', array( self::$instance, 'load_subscription_from_session_in_cart' ), 5 );
			add_action( 'woocommerce_before_calculate_totals', array( self::$instance, 'load_subscription_from_session_in_cart' ), 5 );
			add_action( 'woocommerce_before_calculate_totals', array( self::$instance, 'add_price_calculation_filter' ), -1 );
			add_action( 'woocommerce_before_product_object_save', array( self::$instance, 'destroy_subscription_cache' ) );

			add_action( 'wp_loaded', array( self::$instance, 'add_actions_to_render_subscribe_form' ) );
		}

		return self::$instance;
	}

	/**
	 * Get the subscribe level.
	 * 
	 * @return string
	 */
	public function get_level() {
		return 'cart_level';
	}

	/**
	 * Check if the subscribe enabled on cart.
	 * 
	 * @param WC_Cart $cart
	 * @return bool
	 */
	public function enabled( $cart ) {
		if ( in_array( get_option( 'asp_ssws_allow_cart_subscribe' ), array( 'yes-optional', 'yes-forced' ) ) ) {
			$enabled = ! empty( ASP_SSWS_Subscribe_Rules::get_cart_rule_applied( get_current_user_id() ) );
		} else {
			$enabled = false;
		}

		/**
		 * Check if the subscribe enabled on cart.
		 * 
		 * @since 1.0.0
		 */
		return apply_filters( 'asp_ssws_subscribe_enabled', $enabled, $cart, $this );
	}

	/**
	 * Check if it is available to subscribe on cart.
	 * 
	 * @param WC_Cart $cart
	 * @return bool
	 */
	public function is_available( $cart ) {
		$available = $this->enabled( $cart );

		if ( is_a( $cart, 'WC_Cart' ) && ! empty( $cart->cart_contents ) ) {
			foreach ( $cart->cart_contents as $cart_item ) {
				$subscribed_level = $cart_item[ 'data' ]->get_meta( '_asp_ssws_subscribed_level', true, 'edit' );

				if ( ! empty( $subscribed_level ) && $this->get_level() !== $subscribed_level ) {
					$available = false;
					break;
				}

				if ( $this->is_subscription_product_type( $cart_item[ 'data' ] ) ) {
					$available = false;
					break;
				}

				if ( ! $this->is_supported_product_type( $cart_item[ 'data' ] ) ) {
					$available = false;
					break;
				}

				if ( isset( $cart_item[ 'subscription_renewal' ] ) || isset( $cart_item[ 'subscription_initial_payment' ] ) || isset( $cart_item[ 'subscription_resubscribe' ] ) ) {
					$available = false;
					break;
				}
			}
		}

		/**
		 * Check if it is available to subscribe on cart.
		 * 
		 * @since 1.0.0
		 */
		return apply_filters( 'asp_ssws_is_available_to_subscribe', $available, $cart, $this );
	}

	/**
	 * Get the subscribe plans.
	 * 
	 * @return array
	 */
	public function get_subscribe_plans() {
		$rule_applied = ASP_SSWS_Subscribe_Rules::get_cart_rule_applied( get_current_user_id() );

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
		if ( is_object( $product ) && $this->is_available( WC()->cart ) && $this->get_level() === $product->get_meta( '_asp_ssws_subscribed_level', true, 'edit' ) ) {
			$subscribed = true;
		} else {
			$subscribed = false;
		}

		return $subscribed;
	}

	/**
	 * Read data.
	 */
	public function read_data() {
		if ( WC()->session ) {
			$this->data = WC()->session->get( "asp_ssws_{$this->get_level()}_subscribed_data" );
		}
	}

	/**
	 * Save the data.
	 */
	public function save_data() {
		if ( WC()->session ) {
			WC()->session->set( "asp_ssws_{$this->get_level()}_subscribed_data", $this->data );
		}
	}

	/**
	 * Delete the data.
	 */
	public function delete_data() {
		if ( WC()->session ) {
			WC()->session->__unset( "asp_ssws_{$this->get_level()}_subscribed_data" );
			$this->data = array();
		}
	}

	/**
	 * Return an array of subscribe form args.
	 * 
	 * @return array
	 */
	public function get_subscribe_form_args( $key = null ) {
		$args          = parent::get_subscribe_form_args( $key );
		$dummy_product = new WC_Product( 0 );

		$this->remove_price_calculation_filter();
		$this->add_subscription_cache( $dummy_product, $this->data );
		/* translators: 1: subscribed period and interval */
		$args[ 'subscribe_price_string' ] = sprintf( __( 'Bill %s', 'subscribe-and-save-for-woocommerce-subscriptions' ), WC_Subscriptions_Product::get_price_string( $dummy_product, array( 'price' => '', 'subscription_price' => false ) ) );
		$this->destroy_subscription_cache( $dummy_product );
		$this->add_price_calculation_filter();

		$args[ 'subscribe_plans' ]         = $this->get_subscribe_plans();
		$args[ 'subscribe_forced' ]        = 'yes-forced' === get_option( 'asp_ssws_allow_cart_subscribe' );
		$args[ 'default_subscribe_value' ] = get_option( 'asp_ssws_cart_subscribe_default_value' );

		/**
		 * Get the form args.
		 * 
		 * @since 1.0.0
		 */
		return ( array ) apply_filters( 'asp_ssws_subscribe_form_args', $args, $this );
	}

	/**
	 * Read posted data.
	 *
	 * @param array $posted Values of the prop.
	 * @param mixed $key
	 */
	public function read_posted_data( $posted, $key ) {
		if ( ! $this->is_available( WC()->cart ) || empty( $posted[ 'asp_ssws_pay_option' ] ) || empty( $posted[ 'asp_ssws_pay_option' ][ $key ] ) ) {
			$this->delete_data();
			return;
		}

		$pay_option                      = $posted[ 'asp_ssws_pay_option' ][ $key ];
		unset( $posted[ 'asp_ssws_pay_option' ][ $key ] );
		$posted[ 'asp_ssws_pay_option' ] = $pay_option;

		parent::read_posted_data( $posted, $key );
	}

	/**
	 * Load the subscription from session in cart.
	 * 
	 * @param WC_Cart $cart
	 */
	public function load_subscription_from_session_in_cart( $cart ) {
		if ( ! $this->is_available( $cart ) ) {
			$this->delete_data();
			return;
		}

		$this->read_data();

		if ( 'yes' === $this->get_prop( 'subscription_enabled' ) && ! asp_ssws_is_subscribe_plan( $this->get_prop( 'subscription_plan' ) ) ) {
			$this->delete_data();
		}

		if ( 'yes' === $this->get_prop( 'subscription_enabled' ) ) {
			foreach ( $cart->cart_contents as $cart_item_key => $cart_item ) {
				$this->add_subscription_cache( $cart->cart_contents[ $cart_item_key ][ 'data' ], $this->data );
			}
		} else {
			foreach ( $cart->cart_contents as $cart_item_key => $cart_item ) {
				$this->destroy_subscription_cache( $cart->cart_contents[ $cart_item_key ][ 'data' ] );
			}
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
	 * WP add_actions to render subscribe form.
	 */
	public function add_actions_to_render_subscribe_form() {
		/**
		 * Get cart subscribe form display pages.
		 * 
		 * @since 1.0.0
		 */
		$pages_to_render = ( array ) apply_filters( 'asp_ssws_get_cart_subscribe_form_display_pages', array( 'cart', 'checkout' ) );

		if ( in_array( 'cart', $pages_to_render ) ) {
			/**
			 * Get subscribe form cart page position.
			 * 
			 * @since 1.0.0
			 */
			$hook = sanitize_title( apply_filters( 'asp_ssws_get_subscribe_form_cart_page_position', 'woocommerce_before_cart_totals' ) );
			add_action( $hook, array( self::$instance, 'maybe_render_subscribe_form' ) );
		}

		if ( in_array( 'checkout', $pages_to_render ) ) {
			/**
			 * Get subscribe form checkout page position.
			 * 
			 * @since 1.0.0
			 */
			$hook = sanitize_title( apply_filters( 'asp_ssws_get_subscribe_form_checkout_page_position', 'woocommerce_checkout_order_review' ) );
			add_action( $hook, array( self::$instance, 'maybe_render_subscribe_form' ), 5 );
		}
	}

	/**
	 * Maybe render the subscribe form.
	 */
	public function maybe_render_subscribe_form() {
		if ( $this->is_available( WC()->cart ) ) {
			$rule_applied = ASP_SSWS_Subscribe_Rules::get_cart_rule_applied( get_current_user_id() );

			if ( $rule_applied && ! empty( $rule_applied->get_description() ) ) {
				/* translators: rule description */
				echo wp_kses_post( sprintf( __( '<span class="asp-ssws-cart-rule-description">%s</span>', 'subscribe-and-save-for-woocommerce-subscriptions' ), $rule_applied->get_description() ) );
			}

			$this->get_subscribe_form( true, true, 0 );
		}
	}
}
