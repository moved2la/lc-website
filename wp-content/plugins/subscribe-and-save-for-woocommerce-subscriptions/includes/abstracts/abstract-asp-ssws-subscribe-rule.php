<?php

defined( 'ABSPATH' ) || exit;

/**
 * Subscribe Rule.
 * 
 * @class ASP_SSWS_Subscribe_Rule
 * @package Class
 */
class ASP_SSWS_Subscribe_Rule extends WC_Data {

	/**
	 * Rule Data array. 
	 *
	 * @var array
	 */
	protected $data = array(
		'name'                 => '',
		'status'               => '',
		'version'              => '',
		'slug'                 => '',
		'description'          => '',
		'date_created'         => null,
		'date_modified'        => null,
		'priority'             => 0,
		'subscribe_plans'      => array(),
		'criteria_user_filter' => 'all-users',
		'criteria_users'       => array(),
		'criteria_user_roles'  => array(),
	);

	/**
	 * Stores meta in cache for future reads.
	 *
	 * A group must be set to to enable caching.
	 *
	 * @var string
	 */
	protected $cache_group = '';

	/**
	 * Which data store to load.
	 *
	 * @var string
	 */
	protected $data_store_name = '';

	/**
	 * This is the name of this object type.
	 *
	 * @var string
	 */
	protected $object_type = '';

	/**
	 * Get the rule if ID is passed, otherwise the rule is new and empty.
	 *
	 * @param  int|object|ASP_SSWS_Subscribe_Rule $rule Rule to read.
	 */
	public function __construct( $rule = 0 ) {
		parent::__construct( $rule );

		if ( is_numeric( $rule ) && $rule > 0 ) {
			$this->set_id( $rule );
		} elseif ( $rule instanceof self ) {
			$this->set_id( $rule->get_id() );
		} elseif ( ! empty( $rule->ID ) ) {
			$this->set_id( $rule->ID );
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
		return 'asp_prod_subs_rule';
	}

	/**
	 * Get all valid statuses for this rule.
	 *
	 * @return array Internal status keys e.g. 'asp-active'
	 */
	public function get_valid_statuses() {
		return array_keys( asp_ssws_get_subscribe_rule_statuses() );
	}

	/**
	 * Updates status of rule immediately.
	 *
	 * @uses ASP_SSWS_Subscribe_Rule::set_status()
	 * @param string $new_status    Status to change the rule to. No internal asp- prefix is required.
	 * @return bool
	 */
	public function update_status( $new_status ) {
		if ( ! $this->get_id() ) { // Rule must exist.
			return false;
		}

		try {
			$this->set_status( $new_status );
			$this->save();
		} catch ( Exception $e ) {
			$this->handle_exception( $e, sprintf( 'Error updating status for subscribe rule #%d', $this->get_id() ) );
			return false;
		}
		return true;
	}

	/**
	 * Log an error about this rule is exception is encountered.
	 *
	 * @param Exception $e Exception object.
	 * @param string    $message Message regarding exception thrown.
	 */
	protected function handle_exception( $e, $message = 'Error' ) {
		wc_get_logger()->error(
				$message,
				array(
					'subscribe-rule' => $this,
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
	 * Checks the subscribe rule status against a passed in status.
	 *
	 * @param array|string $status Status to check.
	 * @return bool
	 */
	public function has_status( $status ) {
		/**
		 * Checks if the subscribe rule has status.
		 * 
		 * @since 1.0.0
		 */
		return apply_filters( 'asp_ssws_subscribe_rule_has_status', ( is_array( $status ) && in_array( $this->get_status(), $status, true ) ) || $this->get_status() === $status, $this, $status );
	}

	/*
	  |--------------------------------------------------------------------------
	  | URLs and Endpoints
	  |--------------------------------------------------------------------------
	 */

	/**
	 * Get's the URL to edit the rule in the backend.
	 *
	 * @return string
	 */
	public function get_edit_subscribe_rule_url() {
		/**
		 * Get the admin subscribe rule edit URL.
		 * 
		 * @since 1.0.0
		 */
		return apply_filters( 'asp_ssws_get_admin_edit_subscribe_rule_url', get_admin_url( null, 'post.php?post=' . $this->get_id() . '&action=edit' ), $this );
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
	 * Get description.
	 *
	 * @param  string $context View or edit context.
	 * @return string
	 */
	public function get_description( $context = 'view' ) {
		return $this->get_prop( 'description', $context );
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
	 * Return the rule statuses without asp- internal prefix.
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
			$status = apply_filters( 'asp_ssws_default_subscribe_rule_status', 'active' );
		}
		return $status;
	}

	/**
	 * Get rule subscribe plans.
	 *
	 * @param  string $context View or edit context.
	 * @return array
	 */
	public function get_subscribe_plans( $context = 'view' ) {
		return $this->get_prop( 'subscribe_plans', $context );
	}

	/**
	 * Get rule criteria user filter.
	 *
	 * @param  string $context View or edit context.
	 * @return string
	 */
	public function get_criteria_user_filter( $context = 'view' ) {
		return $this->get_prop( 'criteria_user_filter', $context );
	}

	/**
	 * Get rule criteria users.
	 *
	 * @param  string $context View or edit context.
	 * @return array
	 */
	public function get_criteria_users( $context = 'view' ) {
		return $this->get_prop( 'criteria_users', $context );
	}

	/**
	 * Get rule criteria user roles.
	 *
	 * @param  string $context View or edit context.
	 * @return array
	 */
	public function get_criteria_user_roles( $context = 'view' ) {
		return $this->get_prop( 'criteria_user_roles', $context );
	}

	/*
	  |--------------------------------------------------------------------------
	  | Setters
	  |--------------------------------------------------------------------------
	  |
	  | Functions for setting rule data. These should not update anything in the
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
	 * @param string $new_status Status to change the rule to. No internal asp- prefix is required.
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
	 * Set description.
	 *
	 * @param string $value Value to set.
	 */
	public function set_description( $value ) {
		$this->set_prop( 'description', $value );
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
	 * Set rule subscribe plans.
	 *
	 * @param array $value Value to set.
	 */
	public function set_subscribe_plans( $value ) {
		$value = is_array( $value ) ? $value : array();
		$this->set_prop( 'subscribe_plans', $value );
	}

	/**
	 * Set rule criteria user filter.
	 *
	 * @param string $value
	 */
	public function set_criteria_user_filter( $value ) {
		$this->set_prop( 'criteria_user_filter', $value );
	}

	/**
	 * Set rule criteria users.
	 *
	 * @param array $value
	 */
	public function set_criteria_users( $value ) {
		$value = is_array( $value ) ? $value : array();
		$this->set_prop( 'criteria_users', $value );
	}

	/**
	 * Set rule criteria user roles.
	 *
	 * @param array $value
	 */
	public function set_criteria_user_roles( $value ) {
		$value = is_array( $value ) ? $value : array();
		$this->set_prop( 'criteria_user_roles', $value );
	}
}
