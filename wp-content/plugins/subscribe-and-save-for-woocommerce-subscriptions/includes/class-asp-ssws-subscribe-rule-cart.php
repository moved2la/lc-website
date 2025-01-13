<?php

defined( 'ABSPATH' ) || exit;

/**
 * Subscribe Rule - Cart
 * 
 * @class ASP_SSWS_Subscribe_Rule_Cart
 * @package Class
 */
class ASP_SSWS_Subscribe_Rule_Cart extends ASP_SSWS_Subscribe_Rule {

	/**
	 * Stores meta in cache for future reads.
	 *
	 * A group must be set to to enable caching.
	 *
	 * @var string
	 */
	protected $cache_group = 'asp_cart_subscribe_rules';

	/**
	 * Which data store to load.
	 *
	 * @var string
	 */
	protected $data_store_name = 'asp_cart_subscribe_rule';

	/**
	 * This is the name of this object type.
	 *
	 * @var string
	 */
	protected $object_type = 'asp_cart_subs_rule';

	/**
	 * Extra data for this object.
	 *
	 * @var array
	 */
	protected $extra_data = array(
		'criteria_min_subtotal' => '',
		'criteria_max_subtotal' => '',
	);

	/**
	 * Get internal type.
	 *
	 * @return string
	 */
	public function get_type() {
		return 'asp_cart_subs_rule';
	}

	/*
	  |--------------------------------------------------------------------------
	  | Getters
	  |--------------------------------------------------------------------------
	 */

	/**
	 * Get rule criteria min subtotal.
	 *
	 * @param  string $context View or edit context.
	 * @return string
	 */
	public function get_criteria_min_subtotal( $context = 'view' ) {
		return $this->get_prop( 'criteria_min_subtotal', $context );
	}

	/**
	 * Get rule criteria max subtotal.
	 *
	 * @param  string $context View or edit context.
	 * @return string
	 */
	public function get_criteria_max_subtotal( $context = 'view' ) {
		return $this->get_prop( 'criteria_max_subtotal', $context );
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
	 * Set rule criteria min subtotal.
	 *
	 * @param float $value
	 */
	public function set_criteria_min_subtotal( $value ) {
		$this->set_prop( 'criteria_min_subtotal', wc_format_decimal( $value ) );
	}

	/**
	 * Set rule criteria max subtotal.
	 *
	 * @param float $value
	 */
	public function set_criteria_max_subtotal( $value ) {
		$this->set_prop( 'criteria_max_subtotal', wc_format_decimal( $value ) );
	}
}
