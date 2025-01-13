<?php

defined( 'ABSPATH' ) || exit;

include_once 'asp-ssws-subscribe-rule-functions.php';
include_once 'asp-ssws-subscribe-plan-functions.php';

/**
 * Maybe get the product instance.
 *
 * @param mixed $product
 * @return WC_Product
 */
function asp_ssws_maybe_get_product_instance( $product ) {
	if ( ! is_a( $product, 'WC_Product' ) ) {
		$product = wc_get_product( $product );
	}

	return $product;
}

/**
 * Check if the product is subscribed.
 * 
 * @param WC_Product $product
 * @param string $level Values are either 'product_level' | 'cart_level' | 'any'
 * @return boolean
 */
function asp_ssws_is_product_subscribed( $product, $level = 'any' ) {
	if ( is_object( $product ) ) {
		if ( 'any' === $level ) {
			return ASP_SSWS_Product_Subscribe::instance()->is_subscribed( $product ) || ASP_SSWS_Cart_Subscribe::instance()->is_subscribed( $product );
		} else if ( 'product_level' === $level ) {
			return ASP_SSWS_Product_Subscribe::instance()->is_subscribed( $product );
		} else if ( 'cart_level' === $level ) {
			return ASP_SSWS_Cart_Subscribe::instance()->is_subscribed( $product );
		}
	}

	return false;
}

/**
 * Check if the cart contains subscribed product.
 * 
 * @param string $level Values are either 'product_level' | 'cart_level' | 'any'
 * @return boolean
 */
function asp_ssws_cart_contains_subscribed_product( $level = 'any' ) {
	if ( ! is_null( WC()->cart ) ) {
		foreach ( WC()->cart->cart_contents as $cart_item ) {
			if ( ! empty( $cart_item[ 'data' ] ) && asp_ssws_is_product_subscribed( $cart_item[ 'data' ], $level ) ) {
				return true;
			}
		}
	}

	return false;
}

/**
 * Get the cart subtotal.
 * 
 * @return float
 */
function asp_ssws_get_cart_subtotal() {
	$subtotal = 0;

	if ( ! is_null( WC()->cart ) ) {
		foreach ( WC()->cart->cart_contents as $cart_item ) {
			remove_filter( 'woocommerce_product_get_price', array( ASP_SSWS_Cart_Subscribe::instance(), 'calculate_subscription_price' ), 99, 2 );
			remove_filter( 'woocommerce_product_variation_get_price', array( ASP_SSWS_Cart_Subscribe::instance(), 'calculate_subscription_price' ), 99, 2 );
			$price    = $cart_item[ 'data' ]->get_price();
			add_filter( 'woocommerce_product_get_price', array( ASP_SSWS_Cart_Subscribe::instance(), 'calculate_subscription_price' ), 99, 2 );
			add_filter( 'woocommerce_product_variation_get_price', array( ASP_SSWS_Cart_Subscribe::instance(), 'calculate_subscription_price' ), 99, 2 );
			$subtotal += ( float ) $price * ( float ) $cart_item[ 'quantity' ];
		}
	}

	return $subtotal;
}

/**
 * Get Number Suffix to Display.
 * 
 * @param int $number
 * @return string
 */
function asp_ssws_get_number_suffix( $number ) {
	// Special case 'teenth'
	if ( ( $number / 10 ) / 10 != 1 ) {
		// Handle 1st, 2nd, 3rd
		switch ( $number % 10 ) {
			case 1:
				return $number . 'st';
			case 2:
				return $number . 'nd';
			case 3:
				return $number . 'rd';
		}
	}
	// Everything else is 'nth'
	return $number . 'th';
}

/**
 * Gets an array of subscription length ranges based upon given period and interval.
 * 
 * @param string $period
 * @param int $interval
 * @return array
 */
function asp_ssws_get_subscription_length_ranges( $period, $interval = 1 ) {
	$ranges = array();

	foreach ( wcs_get_subscription_ranges( $period ) as $length => $label ) {
		if ( 0 === absint( $length ) || 0 === ( absint( $length ) % $interval ) ) {
			$ranges[ $length ] = $label;
		}
	}

	return $ranges;
}

/**
 * Trim our post status without prefix.
 * 
 * @param string $status
 * @return string
 */
function asp_ssws_trim_post_status( $status ) {
	$status = 'asp-' === substr( $status, 0, 4 ) ? substr( $status, 4 ) : $status;
	return $status;
}

/**
 * Get all terms for a product by ID, including hierarchy
 *
 * @param  int $product_id Product ID.
 * @param  string $taxonomy Taxonomy slug.
 * @return array
 */
function asp_ssws_get_product_term_ids( $product_id, $taxonomy = 'product_cat' ) {
	$product_terms = wc_get_product_term_ids( $product_id, $taxonomy );

	foreach ( $product_terms as $product_term ) {
		$product_terms = array_merge( $product_terms, get_ancestors( $product_term, $taxonomy ) );
	}

	return $product_terms;
}
