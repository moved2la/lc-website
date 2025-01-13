<?php

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'ASP_SSWS_Subscribe_Rule_Data_Store_CPT', false ) ) {
	include_once ASP_SSWS_ABSPATH . 'includes/data-stores/abstract-class-asp-ssws-subscribe-rule-data-store-cpt.php';
}

/**
 * Product Subscribe Rule Data Store CPT
 * 
 * @class ASP_SSWS_Subscribe_Rule_Product_Data_Store_CPT
 * @package Class
 */
class ASP_SSWS_Subscribe_Rule_Product_Data_Store_CPT extends ASP_SSWS_Subscribe_Rule_Data_Store_CPT {

	/**
	 * Data stored in meta key to props.
	 *
	 * @var array
	 */
	protected $internal_meta_key_to_props = array(
		'_version'                 => 'version',
		'_slug'                    => 'slug',
		'_criteria_product_filter' => 'criteria_product_filter',
		'_criteria_user_filter'    => 'criteria_user_filter',
		'_subscribe_plans'         => 'subscribe_plans',
		'_criteria_products'       => 'criteria_products',
		'_criteria_product_cats'   => 'criteria_product_cats',
		'_criteria_users'          => 'criteria_users',
		'_criteria_user_roles'     => 'criteria_user_roles',
	);

	/**
	 * Get the title to save to the post object.
	 *
	 * @param  ASP_SSWS_Subscribe_Rule_Product $rule
	 * @return string
	 */
	protected function get_post_title( $rule ) {
		return $rule->get_name() ? $rule->get_name() : __( 'Product Subscribe Rule', 'subscribe-and-save-for-woocommerce-subscriptions' );
	}
}
