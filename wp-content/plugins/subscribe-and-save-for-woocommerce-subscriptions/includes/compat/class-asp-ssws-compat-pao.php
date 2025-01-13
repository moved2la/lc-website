<?php

defined( 'ABSPATH' ) || exit;

/**
 * Compatibility with Product Add-Ons.
 *
 * @class ASP_SSWS_Compat_PAO
 * @package Class
 */
class ASP_SSWS_Compat_PAO {

	/**
	 * Init ASP_SSWS_Compat_PAO.
	 */
	public static function init() {
		add_filter( 'asp_ssws_subscribe_form_args', __CLASS__ . '::alter_subscribe_form_args', 20, 2 );
	}

	/**
	 * Checks if a product has add-ons.
	 *
	 * @param  mixed    $product
	 * @return bool
	 */
	public static function product_has_addons( $product ) {
		if ( is_object( $product ) && is_a( $product, 'WC_Product' ) ) {
			$product_id = $product->get_id();
		} else {
			$product_id = absint( $product );
		}

		$addons = $product->get_meta( '_product_addons_' . $product_id, true, 'edit' );

		if ( is_null( $addons ) || '' === $addons ) {
			$addons = WC_Product_Addons_Helper::get_product_addons( $product_id, false, false );
			$product->add_meta_data( '_product_addons_' . $product_id, $addons, true );
		}

		$has_addons = ! empty( $addons );
		return $has_addons;
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

		if ( 'product_level' === $subscribe->get_level() && ! empty( $product ) && self::product_has_addons( $product ) ) {
			$subscribe->add_subscription_cache( $product, $subscribe->get_data( $product->get_id() ) );
			$subscribe_price_string = WC_Subscriptions_Product::get_price_string( $product, array( 'price' => '', 'subscription_price' => false ) );
			$subscribe->destroy_subscription_cache( $product );

			$args[ 'subscribe_price_string' ] = $subscribe_price_string;
		}

		return $args;
	}
}
