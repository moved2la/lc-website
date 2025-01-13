<?php

defined( 'ABSPATH' ) || exit;

/**
 * Gets an array of subscribe plan status types.
 * 
 * @return array
 */
function asp_ssws_get_subscribe_plan_statuses() {
	$subscribe_plan_statuses = array(
		'asp-active'   => __( 'Active', 'subscribe-and-save-for-woocommerce-subscriptions' ),
		'asp-inactive' => __( 'Inactive', 'subscribe-and-save-for-woocommerce-subscriptions' ),
	);

	/**
	 * Subscribe plan statuses.
	 * 
	 * @since 1.0.0
	 */
	return apply_filters( 'asp_ssws_subscribe_plan_statuses', $subscribe_plan_statuses );
}

/**
 * Get the nice name for the subscribe plan.
 * 
 * @param string $status_key
 * @return string
 */
function asp_ssws_get_subscribe_plan_status_name( $status_key ) {
	$statuses    = asp_ssws_get_subscribe_plan_statuses();
	$status_key  = asp_ssws_sanitize_subscribe_plan_status_key( $status_key );
	$status_name = isset( $statuses[ $status_key ] ) ? $statuses[ $status_key ] : asp_ssws_trim_post_status( $status_key );

	/**
	 * Nice name for the subscribe plan status.
	 * 
	 * @since 1.0.0
	 */
	return apply_filters( 'asp_ssws_subscribe_plan_status_name', $status_name, $status_key );
}

/**
 * Utility function to standardize subscribe plan status key.
 *
 * @param  string $status_key 
 * @return string
 */
function asp_ssws_sanitize_subscribe_plan_status_key( $status_key ) {
	if ( ! is_string( $status_key ) || empty( $status_key ) ) {
		return '';
	}

	$status_key = asp_ssws_trim_post_status( $status_key );
	$status_key = sprintf( 'asp-%s', $status_key );
	return $status_key;
}

/**
 * Gets an array of subscribe plan definitions.
 *
 * @return array
 */
function asp_ssws_get_subscribe_plan_definitions() {
	return array(
		'predefined'  => __( 'Predefined', 'subscribe-and-save-for-woocommerce-subscriptions' ),
		'userdefined' => __( 'Customer Defined', 'subscribe-and-save-for-woocommerce-subscriptions' ),
	);
}

/**
 * Sort the subscribe plans.
 * 
 * @param array|int $plan_ids
 * @param string $order ASC|DESC
 * @return array
 */
function asp_ssws_sort_subscribe_plans( $plan_ids, $order = 'ASC' ) {
	global $wpdb;
	$_wpdb = &$wpdb;

	if ( ! empty( $plan_ids ) ) {
		$plan_ids = is_array( $plan_ids ) ? $plan_ids : ( array ) $plan_ids;
		$orderby  = 'asc' === strtolower( $order ) ? ' ORDER BY menu_order ASC ' : ' ORDER BY menu_order DESC ';

		$sorted_plans = $_wpdb->get_col( $_wpdb->prepare( "SELECT ID FROM {$_wpdb->posts} WHERE 1=%d AND post_type = 'asp_subscribe_plan' AND post_status = 'asp-active' AND ID IN ('" . implode( "','", $plan_ids ) . "') $orderby", 1 ) );
	} else {
		$sorted_plans = array();
	}

	return $sorted_plans;
}

/**
 * Check whether the given the value is subscribe plan. 
 *
 * @param  mixed $subscribe_plan Post object or post ID of the subscribe plan.
 * @return bool True on success.
 */
function asp_ssws_is_subscribe_plan( $subscribe_plan ) {
	if ( is_object( $subscribe_plan ) && is_a( $subscribe_plan, 'ASP_SSWS_Subscribe_Plan' ) ) {
		$is_subscribe_plan = true;
	} elseif ( is_numeric( $subscribe_plan ) && 'asp_subscribe_plan' === get_post_type( $subscribe_plan ) ) {
		$is_subscribe_plan = true;
	} else {
		$is_subscribe_plan = false;
	}

	/**
	 * Is subscribe plan?
	 * 
	 * @since 1.0.0
	 */
	return apply_filters( 'asp_ssws_is_subscribe_plan', $is_subscribe_plan, $subscribe_plan );
}

/**
 * Get the subscribe plan.
 * 
 * @param ASP_SSWS_Subscribe_Plan $the_subscribe_plan
 * @return bool|\ASP_SSWS_Subscribe_Plan
 */
function asp_ssws_get_subscribe_plan( $the_subscribe_plan ) {
	if ( ! did_action( 'asp_ssws_after_register_post_type' ) ) {
		wc_doing_it_wrong( __FUNCTION__, 'asp_ssws_get_subscribe_plan should not be called before post types are registered (asp_ssws_after_register_post_type action)', '1.0.0' );
		return false;
	}

	if ( asp_ssws_is_subscribe_plan( $the_subscribe_plan ) ) {
		$subscribe_plan = new ASP_SSWS_Subscribe_Plan( $the_subscribe_plan );
	} else {
		$subscribe_plan = false;
	}

	/**
	 * Get subscribe plan.
	 * 
	 * @since 1.0.0
	 */
	return apply_filters( 'asp_ssws_get_subscribe_plan', $subscribe_plan );
}

/**
 * Get the subscribe plan name.
 * 
 * @param mixed $the_subscribe_plan
 * @return string
 */
function asp_ssws_get_subscribe_plan_name( $the_subscribe_plan ) {
	$subscribe_plan = asp_ssws_get_subscribe_plan( $the_subscribe_plan );
	return $subscribe_plan ? $subscribe_plan->get_name() : '';
}

/**
 * Gets an array of subscribe plans.
 * 
 * @param array $args
 * @return ASP_SSWS_Subscribe_Plan[]
 */
function asp_ssws_get_subscribe_plans( $args = array() ) {
	$default_args = array(
		'status'   => array_keys( asp_ssws_get_subscribe_plan_statuses() ),
		'page'     => 1,
		'offset'   => 0,
		'limit'    => -1,
		'paginate' => true,
		'return'   => 'objects',
		'orderby'  => 'menu_order',
		'order'    => 'ASC',
	);

	/**
	 * Subscribe plan query args.
	 * 
	 * @since 1.0.0
	 */
	$args       = apply_filters( 'asp_ssws_get_subscribe_plans_query_args', wp_parse_args( $args, $default_args ), $args );
	$query_args = array(
		'post_type'      => 'asp_subscribe_plan',
		'fields'         => 'ids',
		'page'           => ( int ) $args[ 'page' ],
		'offset'         => ( int ) $args[ 'offset' ],
		'posts_per_page' => ( int ) $args[ 'limit' ],
		'order'          => $args[ 'order' ],
		'no_found_rows'  => ( bool ) ( false === $args[ 'paginate' ] ),
		'meta_query'     => isset( $args[ 'meta_query' ] ) ? $args[ 'meta_query' ] : array(),
	);

	// Add the 'asp-' prefix to status if needed.
	$query_args[ 'post_status' ] = array_map( 'asp_ssws_sanitize_subscribe_plan_status_key', array_unique( array_filter( ( array ) $args[ 'status' ] ) ) );

	$result = new WP_Query( $query_args );

	if ( $args[ 'paginate' ] ) {
		$return = ( object ) array(
					'plans'         => 'objects' === $args[ 'return' ] ? array_filter( array_map( 'asp_ssws_get_subscribe_plan', $result->posts ) ) : $result->posts,
					'total'         => $result->found_posts,
					'has_plan'      => $result->found_posts > 0,
					'max_num_pages' => $result->max_num_pages,
		);
	} else {
		$return = 'objects' === $args[ 'return' ] ? array_filter( array_map( 'asp_ssws_get_subscribe_plan', $result->posts ) ) : $result->posts;
	}

	/**
	 * Get subscribe plans.
	 * 
	 * @since 1.0.0
	 */
	return apply_filters( 'asp_ssws_got_subscribe_plans', $return, $args );
}
