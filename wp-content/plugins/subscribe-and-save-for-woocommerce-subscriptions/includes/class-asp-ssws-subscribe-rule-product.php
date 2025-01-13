<?php

defined( 'ABSPATH' ) || exit;

/**
 * Subscribe Rule - Product
 * 
 * @class ASP_SSWS_Subscribe_Rule_Product
 * @package Class
 */
class ASP_SSWS_Subscribe_Rule_Product extends ASP_SSWS_Subscribe_Rule {

	/**
	 * Extra data for this object.
	 *
	 * @var array
	 */
	protected $extra_data = array(
		'criteria_product_filter' => 'all-products',
		'criteria_products'       => array(),
		'criteria_product_cats'   => array(),
	);

	/**
	 * Stores meta in cache for future reads.
	 *
	 * A group must be set to to enable caching.
	 *
	 * @var string
	 */
	protected $cache_group = 'asp_product_subscribe_rules';

	/**
	 * Which data store to load.
	 *
	 * @var string
	 */
	protected $data_store_name = 'asp_product_subscribe_rule';

	/**
	 * This is the name of this object type.
	 *
	 * @var string
	 */
	protected $object_type = 'asp_prod_subs_rule';

	/**
	 * Get internal type.
	 *
	 * @return string
	 */
	public function get_type() {
		return 'asp_prod_subs_rule';
	}

	/*
	  |--------------------------------------------------------------------------
	  | Getters
	  |--------------------------------------------------------------------------
	 */

	/**
	 * Get rule criteria product filter.
	 *
	 * @param  string $context View or edit context.
	 * @return string
	 */
	public function get_criteria_product_filter( $context = 'view' ) {
		return $this->get_prop( 'criteria_product_filter', $context );
	}

	/**
	 * Get rule criteria products.
	 *
	 * @param  string $context View or edit context.
	 * @return array
	 */
	public function get_criteria_products( $context = 'view' ) {
		return $this->get_prop( 'criteria_products', $context );
	}

	/**
	 * Get rule criteria product cats.
	 *
	 * @param  string $context View or edit context.
	 * @return array
	 */
	public function get_criteria_product_cats( $context = 'view' ) {
		return $this->get_prop( 'criteria_product_cats', $context );
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
	 * Set rule criteria product filter.
	 *
	 * @param string $value
	 */
	public function set_criteria_product_filter( $value ) {
		$this->set_prop( 'criteria_product_filter', $value );
	}

	/**
	 * Set rule criteria products.
	 *
	 * @param array $value
	 */
	public function set_criteria_products( $value ) {
		$value = is_array( $value ) ? $value : array();
		$this->set_prop( 'criteria_products', $value );
	}

	/**
	 * Set rule criteria products cats.
	 *
	 * @param array $value
	 */
	public function set_criteria_product_cats( $value ) {
		$value = is_array( $value ) ? $value : array();
		$this->set_prop( 'criteria_product_cats', $value );
	}
}
