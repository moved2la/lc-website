<?php

defined( 'ABSPATH' ) || exit;

/**
 * Subscribe plan.
 * 
 * @class ASP_SSWS_Subscribe_Plan
 * @package Class
 */
class ASP_SSWS_Subscribe_Plan extends WC_Data {

	/**
	 * Subscribe Plan Data array. 
	 *
	 * @var array
	 */
	protected $data = array(
		'name'                           => '',
		'status'                         => '',
		'version'                        => '',
		'slug'                           => '',
		'date_created'                   => null,
		'date_modified'                  => null,
		'priority'                       => 0,
		'definition'                     => 'predefined',
		'subscription_discount'          => '',
		'subscription_sign_up_fee'       => '0',
		'subscription_trial_period'      => 'day',
		'subscription_trial_length'      => '0',
		// Predefined values
		'subscription_period'            => 'month',
		'subscription_period_interval'   => '1',
		'subscription_length'            => '0',
		'subscription_payment_sync_date' => '',
		// Userdefined values
		'subscription_interval_length'   => array(),
	);

	/**
	 * Stores meta in cache for future reads.
	 *
	 * A group must be set to to enable caching.
	 *
	 * @var string
	 */
	protected $cache_group = 'asp_subscribe_plans';

	/**
	 * Which data store to load.
	 *
	 * @var string
	 */
	protected $data_store_name = 'asp_subscribe_plan';

	/**
	 * This is the name of this object type.
	 *
	 * @var string
	 */
	protected $object_type = 'asp_subscribe_plan';

	/**
	 * Get the subscribe plan if ID is passed, otherwise the subscribe plan is new and empty.
	 *
	 * @param  int|object|ASP_SSWS_Subscribe_Plan $subscribe_plan Subscribe Plan to read.
	 */
	public function __construct( $subscribe_plan = 0 ) {
		parent::__construct( $subscribe_plan );

		if ( is_numeric( $subscribe_plan ) && $subscribe_plan > 0 ) {
			$this->set_id( $subscribe_plan );
		} elseif ( $subscribe_plan instanceof self ) {
			$this->set_id( $subscribe_plan->get_id() );
		} elseif ( ! empty( $subscribe_plan->ID ) ) {
			$this->set_id( $subscribe_plan->ID );
		} else {
			$this->set_object_read( true );
		}

		$this->data_store = WC_Data_Store::load( $this->data_store_name );

		if ( $this->get_id() > 0 ) {
			$this->data_store->read( $this );
		}
	}

	/**
	 * Get internal type.
	 *
	 * @return string
	 */
	public function get_type() {
		return 'asp_subscribe_plan';
	}

	/**
	 * Get all valid statuses for this subscribe plan.
	 *
	 * @return array Internal status keys e.g. 'asp-active'
	 */
	public function get_valid_statuses() {
		return array_keys( asp_ssws_get_subscribe_plan_statuses() );
	}

	/**
	 * Updates status of subscribe plan immediately.
	 *
	 * @uses ASP_SSWS_Subscribe_Plan::set_status()
	 * @param string $new_status    Status to change the subscribe plan to. No internal asp- prefix is required.
	 * @return bool
	 */
	public function update_status( $new_status ) {
		if ( ! $this->get_id() ) { // Subscribe plan must exist.
			return false;
		}

		try {
			$this->set_status( $new_status );
			$this->save();
		} catch ( Exception $e ) {
			$this->handle_exception( $e, sprintf( 'Error updating status for subscribe plan #%d', $this->get_id() ) );
			return false;
		}
		return true;
	}

	/**
	 * Log an error about this subscribe plan is exception is encountered.
	 *
	 * @param Exception $e Exception object.
	 * @param string    $message Message regarding exception thrown.
	 */
	protected function handle_exception( $e, $message = 'Error' ) {
		wc_get_logger()->error(
				$message,
				array(
					'subscribe-plan' => $this,
					'error'          => $e,
				)
		);
	}

	/*
	  |--------------------------------------------------------------------------
	  | Conditionals
	  |--------------------------------------------------------------------------
	  |
	  | Checks if a condition is true or false.
	  |
	 */

	/**
	 * Checks the plan status against a passed in status.
	 *
	 * @param array|string $status Status to check.
	 * @return bool
	 */
	public function has_status( $status ) {
		/**
		 * Checks if the plan has status.
		 * 
		 * @since 1.0.0
		 */
		return apply_filters( 'asp_ssws_subscribe_plan_has_status', ( is_array( $status ) && in_array( $this->get_status(), $status, true ) ) || $this->get_status() === $status, $this, $status );
	}

	/*
	  |--------------------------------------------------------------------------
	  | URLs and Endpoints
	  |--------------------------------------------------------------------------
	 */

	/**
	 * Get's the URL to edit the subscribe plan in the backend.
	 *
	 * @return string
	 */
	public function get_edit_subscribe_plan_url() {
		/**
		 * Get the admin subscribe plan edit URL.
		 * 
		 * @since 1.0.0
		 */
		return apply_filters( 'asp_ssws_get_admin_edit_subscribe_plan_url', get_admin_url( null, 'post.php?post=' . $this->get_id() . '&action=edit' ), $this );
	}

	/*
	  |--------------------------------------------------------------------------
	  | Getters
	  |--------------------------------------------------------------------------
	 */

	/**
	 * Get name.
	 *
	 * @param  string $context View or edit context.
	 * @return string
	 */
	public function get_name( $context = 'view' ) {
		return $this->get_prop( 'name', $context );
	}

	/**
	 * Get version.
	 *
	 * @param  string $context View or edit context.
	 * @return string
	 */
	public function get_version( $context = 'view' ) {
		return $this->get_prop( 'version', $context );
	}

	/**
	 * Get slug.
	 *
	 * @param  string $context View or edit context.
	 * @return string
	 */
	public function get_slug( $context = 'view' ) {
		return $this->get_prop( 'slug', $context );
	}

	/**
	 * Get date created.
	 *
	 * @param  string $context View or edit context.
	 * @return WC_DateTime|NULL object if the date is set or null if there is no date.
	 */
	public function get_date_created( $context = 'view' ) {
		return $this->get_prop( 'date_created', $context );
	}

	/**
	 * Get date modified.
	 *
	 * @param  string $context View or edit context.
	 * @return WC_DateTime|NULL object if the date is set or null if there is no date.
	 */
	public function get_date_modified( $context = 'view' ) {
		return $this->get_prop( 'date_modified', $context );
	}

	/**
	 * Get priority.
	 *
	 * @param  string $context View or edit context.
	 * @return int
	 */
	public function get_priority( $context = 'view' ) {
		return $this->get_prop( 'priority', $context );
	}

	/**
	 * Return the subscribe plan statuses without asp- internal prefix.
	 *
	 * @param  string $context View or edit context.
	 * @return string
	 */
	public function get_status( $context = 'view' ) {
		$status = $this->get_prop( 'status', $context );

		if ( empty( $status ) && 'view' === $context ) {
			/**
			 * In view context, return the default status if no status has been set.
			 * 
			 * @since 1.0.0
			 */
			$status = apply_filters( 'asp_ssws_default_subscribe_plan_status', 'active' );
		}
		return $status;
	}

	/**
	 * Get definition.
	 *
	 * @param  string $context View or edit context.
	 * @return string
	 */
	public function get_definition( $context = 'view' ) {
		return $this->get_prop( 'definition', $context );
	}

	/**
	 * Get subscription discount.
	 *
	 * @param  string $context View or edit context.
	 * @return string
	 */
	public function get_subscription_discount( $context = 'view' ) {
		return $this->get_prop( 'subscription_discount', $context );
	}

	/**
	 * Get subscription period.
	 *
	 * @param  string $context View or edit context.
	 * @return string
	 */
	public function get_subscription_period( $context = 'view' ) {
		return $this->get_prop( 'subscription_period', $context );
	}

	/**
	 * Get subscription period interval.
	 *
	 * @param  string $context View or edit context.
	 * @return int
	 */
	public function get_subscription_period_interval( $context = 'view' ) {
		return $this->get_prop( 'subscription_period_interval', $context );
	}

	/**
	 * Get subscription length.
	 *
	 * @param  string $context View or edit context.
	 * @return int
	 */
	public function get_subscription_length( $context = 'view' ) {
		return $this->get_prop( 'subscription_length', $context );
	}

	/**
	 * Get subscription trial period.
	 *
	 * @param  string $context View or edit context.
	 * @return string
	 */
	public function get_subscription_trial_period( $context = 'view' ) {
		return $this->get_prop( 'subscription_trial_period', $context );
	}

	/**
	 * Get subscription trial length.
	 *
	 * @param  string $context View or edit context.
	 * @return int
	 */
	public function get_subscription_trial_length( $context = 'view' ) {
		return $this->get_prop( 'subscription_trial_length', $context );
	}

	/**
	 * Get subscription sign up fee.
	 *
	 * @param  string $context View or edit context.
	 * @return string
	 */
	public function get_subscription_sign_up_fee( $context = 'view' ) {
		return $this->get_prop( 'subscription_sign_up_fee', $context );
	}

	/**
	 * Get subscription payment sync date.
	 *
	 * @param  string $context View or edit context.
	 * @return mixed
	 */
	public function get_subscription_payment_sync_date( $context = 'view' ) {
		return $this->get_prop( 'subscription_payment_sync_date', $context );
	}

	/**
	 * Get subscription interval length.
	 *
	 * @param  string $context View or edit context.
	 * @return array
	 */
	public function get_subscription_interval_length( $context = 'view' ) {
		return $this->get_prop( 'subscription_interval_length', $context );
	}

	/*
	  |--------------------------------------------------------------------------
	  | Setters
	  |--------------------------------------------------------------------------
	  |
	  | Functions for setting subscribe plan data. These should not update anything in the
	  | database itself and should only change what is stored in the class
	  | object.
	 */

	/**
	 * Set name.
	 *
	 * @param string $value Value to set.
	 */
	public function set_name( $value ) {
		$this->set_prop( 'name', $value );
	}

	/**
	 * Set status.
	 *
	 * @param string $new_status Status to change the subscribe plan to. No internal asp- prefix is required.
	 * @return array details of change
	 */
	public function set_status( $new_status ) {
		$old_status        = $this->get_status();
		$new_status        = asp_ssws_trim_post_status( $new_status );
		$status_exceptions = array( 'auto-draft', 'trash' );

		// If setting the status, ensure it's set to a valid status.
		if ( true === $this->object_read ) {
			// Only allow valid new status.
			if ( ! in_array( 'asp-' . $new_status, $this->get_valid_statuses(), true ) && ! in_array( $new_status, $status_exceptions, true ) ) {
				$new_status = 'active';
			}

			// If the old status is set but unknown (e.g. draft) assume its active for action usage.
			if ( $old_status && ! in_array( 'asp-' . $old_status, $this->get_valid_statuses(), true ) && ! in_array( $old_status, $status_exceptions, true ) ) {
				$old_status = 'active';
			}
		}

		$this->set_prop( 'status', $new_status );

		return array(
			'from' => $old_status,
			'to'   => $new_status,
		);
	}

	/**
	 * Set version.
	 *
	 * @param string $value Value to set.
	 * @throws WC_Data_Exception Exception may be thrown if value is invalid.
	 */
	public function set_version( $value ) {
		$this->set_prop( 'version', $value );
	}

	/**
	 * Set slug.
	 *
	 * @param string $value Value to set.
	 */
	public function set_slug( $value ) {
		$this->set_prop( 'slug', $value );
	}

	/**
	 * Set date created.
	 *
	 * @param  string|integer|null $date UTC timestamp, or ISO 8601 DateTime. If the DateTime string has no timezone or offset, WordPress site timezone will be assumed. Null if there is no date.
	 * @throws WC_Data_Exception Exception may be thrown if value is invalid.
	 */
	public function set_date_created( $date = null ) {
		$this->set_date_prop( 'date_created', $date );
	}

	/**
	 * Set date modified.
	 *
	 * @param  string|integer|null $date UTC timestamp, or ISO 8601 DateTime. If the DateTime string has no timezone or offset, WordPress site timezone will be assumed. Null if there is no date.
	 * @throws WC_Data_Exception Exception may be thrown if value is invalid.
	 */
	public function set_date_modified( $date = null ) {
		$this->set_date_prop( 'date_modified', $date );
	}

	/**
	 * Set priority.
	 *
	 * @param int $value Value to set.
	 */
	public function set_priority( $value ) {
		$this->set_prop( 'priority', absint( $value ) );
	}

	/**
	 * Set definition.
	 *
	 * @param string $value Value to set.
	 */
	public function set_definition( $value ) {
		$this->set_prop( 'definition', $value );
	}

	/**
	 * Set subscription discount.
	 *
	 * @param string $value Value to set.
	 */
	public function set_subscription_discount( $value ) {
		$this->set_prop( 'subscription_discount', wc_format_decimal( $value ) );
	}

	/**
	 * Set subscription period.
	 *
	 * @param string $value Value to set.
	 */
	public function set_subscription_period( $value ) {
		$this->set_prop( 'subscription_period', $value );
	}

	/**
	 * Set subscription period interval.
	 *
	 * @param int $value Value to set.
	 */
	public function set_subscription_period_interval( $value ) {
		$this->set_prop( 'subscription_period_interval', absint( $value ) );
	}

	/**
	 * Set subscription length.
	 *
	 * @param int $value Value to set.
	 */
	public function set_subscription_length( $value ) {
		$this->set_prop( 'subscription_length', absint( $value ) );
	}

	/**
	 * Set subscription trial period.
	 *
	 * @param string $value Value to set.
	 */
	public function set_subscription_trial_period( $value ) {
		$this->set_prop( 'subscription_trial_period', $value );
	}

	/**
	 * Set subscription trial length.
	 *
	 * @param int $value Value to set.
	 */
	public function set_subscription_trial_length( $value ) {
		$this->set_prop( 'subscription_trial_length', absint( $value ) );
	}

	/**
	 * Set subscription sign up fee.
	 *
	 * @param string $value Value to set.
	 */
	public function set_subscription_sign_up_fee( $value ) {
		$this->set_prop( 'subscription_sign_up_fee', wc_format_decimal( $value ) );
	}

	/**
	 * Set subscription payment sync date.
	 *
	 * @param mixed $value Value to set.
	 */
	public function set_subscription_payment_sync_date( $value ) {
		$this->set_prop( 'subscription_payment_sync_date', $value );
	}

	/**
	 * Set subscription interval length.
	 *
	 * @param array $value Value to set.
	 */
	public function set_subscription_interval_length( $value ) {
		$value = is_array( $value ) ? $value : array();
		$this->set_prop( 'subscription_interval_length', $value );
	}
}
