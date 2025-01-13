<?php

defined( 'ABSPATH' ) || exit;

/**
 * Compatibility with Name Your Price.
 *
 * @class ASP_SSWS_Compat_NYP
 * @package Class
 */
class ASP_SSWS_Compat_NYP {

	/**
	 * Init ASP_SSWS_Compat_NYP.
	 */
	public static function init() {
		add_filter( 'asp_ssws_is_subscribe_now_option_available', __CLASS__ . '::hide_subscribe_now_option', 20, 3 );
		add_filter( 'asp_ssws_subscribe_form_args', __CLASS__ . '::alter_subscribe_form_args', 20, 2 );
		add_action( 'asp_ssws_subscribe_form_after_adding_subscription_cache', __CLASS__ . '::reset_discount', 20, 3 );
	}

	/**
	 * Hide subscribe now option.
	 * 
	 * @param  bool $bool
	 * @param  WC_Product $product
	 * @param  ASP_SSWS_Product_Subscribe $subscribe
	 * @return bool
	 */
	public static function hide_subscribe_now_option( $bool, $product, $subscribe ) {
		if ( 'product_level' === $subscribe->get_level() && ! empty( $product ) && WC_Name_Your_Price_Helpers::is_nyp( $product ) ) {
			$bool = false;
		}

		return $bool;
	}

	/**
	 * Alter subscribe form values.
	 *
	 * @param  array $args
	 * @param  ASP_SSWS_Product_Subscribe $subscribe
	 * @return array
	 */
	public static function alter_subscribe_form_args( $args, $subscribe ) {
		$product = ! empty( $args[ 'subscribe_product_id' ] ) ? wc_get_product( $args[ 'subscribe_product_id' ] ) : false;

		if ( 'product_level' === $subscribe->get_level() && ! empty( $product ) && WC_Name_Your_Price_Helpers::is_nyp( $product ) ) {
			$subscribe->add_subscription_cache( $product, $subscribe->get_data( $product->get_id() ) );
			$subscribe_price_string = WC_Subscriptions_Product::get_price_string( $product, array( 'price' => '', 'subscription_price' => false ) );
			$subscribe->destroy_subscription_cache( $product );

			$args[ 'subscribe_discount' ]     = 0;
			$args[ 'subscribe_price_string' ] = $subscribe_price_string;
		}

		return $args;
	}

	/**
	 * Reset discount.
	 * 
	 * @param  WC_Product $product
	 * @param  array $data
	 * @param  ASP_SSWS_Product_Subscribe $subscribe
	 */
	public static function reset_discount( $product, $data, $subscribe ) {
		if ( 'product_level' === $subscribe->get_level() && ! empty( $product ) && WC_Name_Your_Price_Helpers::is_nyp( $product ) ) {
			$product->delete_meta_data( '_asp_subscription_discount' );
		}
	}
}
