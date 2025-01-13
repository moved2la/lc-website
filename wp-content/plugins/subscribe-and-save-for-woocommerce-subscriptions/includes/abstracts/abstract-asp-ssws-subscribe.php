<?php

defined( 'ABSPATH' ) || exit;

/**
 * Abstract Subscribe and Save Class
 * 
 * @class ASP_SSWS_Subscribe
 */
abstract class ASP_SSWS_Subscribe {

	/**
	 * Core data for the subscribed plan.
	 *
	 * @var array
	 */
	protected $data = array();

	/**
	 * Default data for the subscribed plan.
	 *
	 * @var array
	 */
	protected $default_data = array(
		'subscription_enabled'           => null,
		'subscription_plan'              => null,
		'subscription_discount'          => null,
		'subscription_period'            => null,
		'subscription_period_interval'   => null,
		'subscription_length'            => null,
		'subscription_trial_period'      => null,
		'subscription_trial_length'      => null,
		'subscription_sign_up_fee'       => null,
		'subscription_payment_sync_date' => null,
	);

	/**
	 * Rendering via Modal?
	 * 
	 * @var bool
	 */
	protected $via_modal = false;

	/**
	 * Get the subscribe level.
	 * 
	 * @return string
	 */
	public function get_level() {
		return '';
	}

	/**
	 * Checks if the product is supported by the plugin for subscribe.
	 *
	 * @param  WC_Product  $product
	 * @return bool
	 */
	public function is_supported_product_type( $product ) {
		/**
		 * Get the subscribe supported product types.
		 * 
		 * @since 1.0.0
		 */
		return $product && is_callable( array( $product, 'is_type' ) ) && $product->is_type( apply_filters( 'asp_ssws_subscribe_supported_product_types', array( 'simple', 'variable', 'variation' ), $this ) );
	}

	/**
	 * Checks if the product is a WCS subscription-type
	 *
	 * @param  WC_Product  $product
	 * @return bool
	 */
	public function is_subscription_product_type( $product ) {
		return $product && is_callable( array( $product, 'is_type' ) ) && $product->is_type( array( 'subscription', 'subscription_variation', 'variable-subscription' ) );
	}

	/**
	 * Check if subscribe is enabled.
	 * 
	 * @param object $object
	 * @return bool
	 */
	public function enabled( $object ) {
		/**
		 * Check if subscribe is enabled.
		 * 
		 * @since 1.0.0
		 */
		return apply_filters( 'asp_ssws_subscribe_enabled', false, $object, $this );
	}

	/**
	 * Is available to subscribe ?
	 * 
	 * @param object $object
	 * @return bool
	 */
	public function is_available( $object ) {
		/**
		 * Is available to subscribe ?
		 * 
		 * @since 1.0.0
		 */
		return apply_filters( 'asp_ssws_is_available_to_subscribe', $this->enabled( $object ), $object, $this );
	}

	/**
	 * Get the subscribe plans.
	 * 
	 * @return array
	 */
	public function get_subscribe_plans() {
		return array();
	}

	/**
	 * Check if the customer is subscribed.
	 * 
	 * @param WC_Product $product
	 * @return bool
	 */
	public function is_subscribed( $product ) {
		return false;
	}

	/**
	 * Validate the plans and return an array of available subscribe plans to use.
	 * 
	 * @param array $plans
	 * @return array
	 */
	public function validate_subscribe_plans( $plans ) {
		return array_values( array_filter( array_map( 'asp_ssws_get_subscribe_plan', $plans ) ) );
	}

	/**
	 * Get an array of data.
	 * 
	 * @param string $key Subscribed key
	 * @return mixed
	 */
	public function get_data( $key = null ) {
		if ( ! empty( $key ) && is_scalar( $key ) ) {
			return isset( $this->data[ $key ] ) ? $this->data[ $key ] : array();
		}

		return $this->data;
	}

	/**
	 * Gets a prop from from either current pending changes, or the DB itself.
	 *
	 * @param string $prop Name of prop to get.
	 * @param mixed $default Default value for the prop.
	 * @param string $key Subscribed key for the prop.
	 * @return mixed
	 */
	public function get_prop( $prop, $default = null, $key = null ) {
		if ( ! empty( $key ) && is_scalar( $key ) ) {
			return isset( $this->data[ $key ][ $prop ] ) ? $this->data[ $key ][ $prop ] : $default;
		} else {
			return isset( $this->data[ $prop ] ) ? $this->data[ $prop ] : $default;
		}

		return null;
	}

	/**
	 * Sets a prop in a special array so we can track what needs saving the DB later.
	 *
	 * @param string $prop Name of prop to get.
	 * @param mixed  $value Value of the prop.
	 * @param string $key Subscribed key for the prop.
	 */
	public function set_prop( $prop, $value, $key = null ) {
		if ( ! empty( $key ) && is_scalar( $key ) ) {
			$this->data[ $key ][ $prop ] = $value;
		} else {
			$this->data[ $prop ] = $value;
		}
	}

	/**
	 * Read data from the DB.
	 */
	public function read_data() {
	}

	/**
	 * Save the data which is collected in to DB.
	 */
	public function save_data() {
	}

	/**
	 * Delete the data from DB.
	 */
	public function delete_data() {
	}

	/**
	 * Set to true if you are rendering the subscribe form via Modal.
	 * 
	 * @param bool
	 */
	public function via_modal( $bool ) {
		$this->via_modal = wc_string_to_bool( $bool );
	}

	/**
	 * Get the subscribe form via modal.
	 */
	public function get_subscribe_form_via_modal( $wrapper = true, $echo = true, $key = null ) {
		ob_start();

		if ( $wrapper ) {
			echo '<p class="asp-' . esc_attr( $this->get_level() ) . '-subscribe-via-modal-wrapper">';
		}

		wc_get_template( 'link-to-modal.php', $this->get_subscribe_form_via_modal_args( $key ), ASP_SSWS()->template_path(), ASP_SSWS()->plugin_path() . '/templates/' );

		if ( $wrapper ) {
			echo '</p>';
		}

		if ( $echo ) {
			ob_end_flush();
		} else {
			return ob_get_clean();
		}
	}

	/**
	 * Get the subscribe form.
	 */
	public function get_subscribe_form( $wrapper = true, $echo = true, $key = null ) {
		$this->read_data();

		ob_start();

		if ( $wrapper ) {
			echo '<div class="asp-' . esc_attr( $this->get_level() ) . '-subscribe-wrapper">';
		}

		wc_get_template( 'form.php', $this->get_subscribe_form_args( $key ), ASP_SSWS()->template_path(), ASP_SSWS()->plugin_path() . '/templates/' );

		if ( $wrapper ) {
			echo '</div>';
		}

		if ( $echo ) {
			ob_end_flush();
		} else {
			return ob_get_clean();
		}
	}

	/**
	 * Get the subscribe form via modal args.
	 * 
	 * @return array
	 */
	public function get_subscribe_form_via_modal_args( $key = null ) {
		$default_args = array(
			'subscribe_level'      => $this->get_level(),
			'subscribe_product_id' => 0,
			'href_classes'         => array(),
			'subscribe_now_label'  => get_option( 'asp_ssws_subscribe_now_label', 'Subscribe now' ),
		);

		/**
		 * Get the subscribe form via modal args.
		 * 
		 * @since 1.3.0
		 */
		return wp_parse_args( ( array ) apply_filters( 'asp_ssws_subscribe_form_via_modal_args', array() ), $default_args );
	}

	/**
	 * Get the subscribe form args.
	 * 
	 * @return array
	 */
	public function get_subscribe_form_args( $key = null ) {
		$default_args = array(
			'subscribe_level'                => $this->get_level(),
			'is_subscribed'                  => $this->get_prop( 'subscription_enabled', null, $key ),
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
			'via_modal'                      => false,
			'one_time_purchase_option_label' => get_option( 'asp_ssws_one_time_purchase_option_label' ),
			'subscribe_option_label'         => get_option( 'asp_ssws_subscribe_option_label' ),
			'subscribe_discount_label'       => get_option( 'asp_ssws_subscribe_discount_label' ),
			'subscribe_plan_label'           => get_option( 'asp_ssws_subscribe_plan_label' ),
			'billing_interval_label'         => get_option( 'asp_ssws_subscribe_interval_label' ),
			'billing_period_label'           => get_option( 'asp_ssws_subscribe_period_label' ),
			'billing_expiration_label'       => get_option( 'asp_ssws_subscribe_expiration_label' ),
		);

		$default_subscribe_plan = new ASP_SSWS_Subscribe_Plan( 0 );
		$args                   = array(
			'subscribe_discount'        => $this->get_prop( 'subscription_discount', $default_subscribe_plan->get_subscription_discount(), $key ),
			'chosen_subscribe_interval' => $this->get_prop( 'subscription_period_interval', $default_subscribe_plan->get_subscription_period_interval(), $key ),
			'chosen_subscribe_period'   => $this->get_prop( 'subscription_period', $default_subscribe_plan->get_subscription_period(), $key ),
			'chosen_subscribe_length'   => $this->get_prop( 'subscription_length', $default_subscribe_plan->get_subscription_length(), $key ),
		);

		$subscribe_plan = asp_ssws_get_subscribe_plan( $this->get_prop( 'subscription_plan', null, $key ) );
		if ( $subscribe_plan ) {
			$args[ 'chosen_subscribe_plan' ]     = $subscribe_plan->get_id();
			$args[ 'subscribe_definition' ]      = $subscribe_plan->get_definition();
			$args[ 'subscribe_interval_length' ] = $subscribe_plan->get_subscription_interval_length();
		}

		/**
		 * Get the subscribe form args.
		 * 
		 * @since 1.0.0
		 */
		return wp_parse_args( ( array ) apply_filters( 'asp_ssws_subscribe_form_args', $args, $this ), $default_args );
	}

	/**
	 * Read posted data.
	 *
	 * @param array $posted Values of the prop.
	 * @param mixed $key Subscribed key for the prop.
	 */
	public function read_posted_data( $posted, $key ) {
		if ( empty( $posted[ 'asp_ssws_pay_option' ] ) ) {
			$this->delete_data( $key );
			return;
		}

		if ( 'subscribe' !== sanitize_key( wp_unslash( $posted[ 'asp_ssws_pay_option' ] ) ) ) {
			$this->delete_data( $key );
			$this->set_prop( 'subscription_enabled', 'no', $key );
			return;
		}

		$subscribe_plan = asp_ssws_get_subscribe_plan( ( ! empty( $posted[ 'asp_ssws_subscribe_plan' ] ) ? absint( wp_unslash( $posted[ 'asp_ssws_subscribe_plan' ] ) ) : 0 ) );
		if ( ! $subscribe_plan ) {
			return;
		}

		$this->set_prop( 'subscription_enabled', 'yes', $key );
		$this->set_prop( 'subscription_plan', $subscribe_plan->get_id(), $key );
		$this->set_prop( 'subscription_discount', $subscribe_plan->get_subscription_discount(), $key );
		$this->set_prop( 'subscription_sign_up_fee', $subscribe_plan->get_subscription_sign_up_fee(), $key );
		$this->set_prop( 'subscription_trial_period', $subscribe_plan->get_subscription_trial_period(), $key );
		$this->set_prop( 'subscription_trial_length', $subscribe_plan->get_subscription_trial_length(), $key );

		switch ( $subscribe_plan->get_definition() ) {
			case 'userdefined':
				if ( ! empty( $posted[ 'asp_ssws_subscribe_period_interval' ] ) ) {
					$chosen_period   = sanitize_title( wp_unslash( $posted[ 'asp_ssws_subscribe_period' ] ) );
					$chosen_interval = absint( wp_unslash( $posted[ 'asp_ssws_subscribe_period_interval' ] ) );
					$chosen_length   = absint( wp_unslash( $posted[ 'asp_ssws_subscribe_length' ] ) );
					$length_ranges   = asp_ssws_get_subscription_length_ranges( $chosen_period, $chosen_interval );

					if ( ! array_key_exists( $chosen_length, $length_ranges ) ) {
						$chosen_length = key( $length_ranges );
					}
				} else {
					$default_subscribe_plan = new ASP_SSWS_Subscribe_Plan( 0 );
					$chosen_period          = $default_subscribe_plan->get_subscription_period();
					$chosen_interval        = $default_subscribe_plan->get_subscription_period_interval();
					$chosen_length          = $default_subscribe_plan->get_subscription_length();
				}

				$chosen_plan_not_available = true;
				foreach ( $subscribe_plan->get_subscription_interval_length() as $period => $value ) {
					if ( 'yes' === $value[ 'enabled' ] && $period === $chosen_period ) {
						$this->set_prop( 'subscription_period', $chosen_period, $key );
						$this->set_prop( 'subscription_period_interval', $chosen_interval, $key );
						$this->set_prop( 'subscription_length', $chosen_length, $key );
						$chosen_plan_not_available = false;
						break;
					}
				}

				if ( $chosen_plan_not_available ) {
					$no_plan_available = true;

					foreach ( $subscribe_plan->get_subscription_interval_length() as $period => $value ) {
						if ( 'yes' === $value[ 'enabled' ] ) {
							$this->set_prop( 'subscription_period', $period, $key );
							$this->set_prop( 'subscription_period_interval', $value[ 'interval' ][ 'min' ], $key );
							$this->set_prop( 'subscription_length', $value[ 'length' ][ 'max' ], $key );
							$no_plan_available = false;
							break;
						}
					}

					if ( $no_plan_available ) {
						$this->set_prop( 'subscription_period', '', $key );
						$this->set_prop( 'subscription_period_interval', '1', $key );
						$this->set_prop( 'subscription_length', '0', $key );
					}
				}

				$this->save_data();
				break;
			case 'predefined':
				$this->set_prop( 'subscription_period', $subscribe_plan->get_subscription_period(), $key );
				$this->set_prop( 'subscription_period_interval', $subscribe_plan->get_subscription_period_interval(), $key );
				$this->set_prop( 'subscription_length', $subscribe_plan->get_subscription_length(), $key );
				$this->set_prop( 'subscription_payment_sync_date', $subscribe_plan->get_subscription_payment_sync_date(), $key );
				$this->save_data();
				break;
		}

		/**
		 * After reading posted data.
		 * 
		 * @since 1.7.0
		 */
		do_action( 'asp_ssws_subscribe_form_after_reading_posted_data', $posted, $key, $this );
	}

	/**
	 * Add the product object cache.
	 * 
	 * @param WC_Product $product
	 * @param array $data
	 */
	public function add_subscription_cache( $product, $data = array() ) {
		$data = wp_parse_args( $data, $this->default_data );

		if ( ! $this->is_subscription_product_type( $product ) ) {
			$product->add_meta_data( '_asp_ssws_subscribed_level', $this->get_level(), true );
			$product->add_meta_data( '_asp_ssws_subscribed_plan', $data[ 'subscription_plan' ], true );
			$product->add_meta_data( '_asp_subscription_discount', $data[ 'subscription_discount' ], true );
			$product->add_meta_data( '_subscription_price', $product->get_price(), true );
			$product->add_meta_data( '_subscription_sign_up_fee', $data[ 'subscription_sign_up_fee' ], true );
			$product->add_meta_data( '_subscription_period', $data[ 'subscription_period' ], true );
			$product->add_meta_data( '_subscription_period_interval', $data[ 'subscription_period_interval' ], true );
			$product->add_meta_data( '_subscription_length', $data[ 'subscription_length' ], true );
			$product->add_meta_data( '_subscription_trial_period', $data[ 'subscription_trial_period' ], true );
			$product->add_meta_data( '_subscription_trial_length', $data[ 'subscription_trial_length' ], true );
			$product->add_meta_data( '_subscription_payment_sync_date', $data[ 'subscription_payment_sync_date' ], true );

			/**
			 * After adding subscription cache to the product.
			 * 
			 * @since 1.7.0
			 */
			do_action( 'asp_ssws_subscribe_form_after_adding_subscription_cache', $product, $data, $this );
		}
	}

	/**
	 * Destroy the product object cache before data saves in to the database.
	 * 
	 * @param WC_Product $product
	 */
	public function destroy_subscription_cache( $product ) {
		if ( ! $this->is_subscription_product_type( $product ) ) {
			$product->delete_meta_data( '_asp_ssws_subscribed_level' );
			$product->delete_meta_data( '_asp_ssws_subscribed_plan' );
			$product->delete_meta_data( '_asp_subscription_discount' );
			$product->delete_meta_data( '_subscription_price' );
			$product->delete_meta_data( '_subscription_sign_up_fee' );
			$product->delete_meta_data( '_subscription_period' );
			$product->delete_meta_data( '_subscription_period_interval' );
			$product->delete_meta_data( '_subscription_length' );
			$product->delete_meta_data( '_subscription_trial_period' );
			$product->delete_meta_data( '_subscription_trial_length' );
			$product->delete_meta_data( '_subscription_payment_sync_date' );
		}
	}

	/**
	 * Enable the non WCS product as subscription.
	 * 
	 * @param bool $is_subscription
	 * @param int $product_id
	 * @param WC_Product $product
	 * @return bool
	 */
	public function enable_subscription( $is_subscription, $product_id = null, $product = null ) {
		if ( $this->is_subscribed( $product ) ) {
			$is_subscription = true;
		}

		return $is_subscription;
	}

	/**
	 * Init the subscription from session while adding to cart.
	 */
	public function init_subscription_from_session_in_cart() {
		$this->load_subscription_from_session_in_cart( WC()->cart );
	}

	/**
	 * Load the subscription from session in cart.
	 * 
	 * @param WC_Cart $cart
	 */
	public function load_subscription_from_session_in_cart( $cart ) {
	}

	/**
	 * Calculate the subscription price.
	 * 
	 * @param float $price
	 * @param WC_Product $product
	 * @return float
	 */
	public function calculate_subscription_price( $price, $product ) {
		/**
		 * Need to calculate subscription price?
		 * 
		 * @since 1.0.0
		 */
		if ( $this->is_subscribed( $product ) && apply_filters( 'asp_ssws_calculate_subscription_price', true, $product, $this ) ) {
			$subscription_price            = floatval( $price );
			$subscription_discount         = $product->get_meta( '_asp_subscription_discount', true, 'edit' );
			$subscription_discounted       = is_numeric( $subscription_discount ) && $subscription_discount > 0 ? ( $subscription_price * $subscription_discount ) / 100 : 0;
			$subscription_discounted_price = max( 0, ( $subscription_price - wc_format_decimal( $subscription_discounted ) ) );
			$price                         = $subscription_discounted_price;
		}

		return $price;
	}

	/**
	 * To render the subscribe form.
	 */
	public function add_actions_to_render_subscribe_form() {
	}

	/**
	 * Maybe render the subscribe now option link.
	 */
	public function maybe_render_subscribe_now_option_link() {
	}

	/**
	 * Maybe render the subscribe form.
	 */
	public function maybe_render_subscribe_form() {
	}
}
