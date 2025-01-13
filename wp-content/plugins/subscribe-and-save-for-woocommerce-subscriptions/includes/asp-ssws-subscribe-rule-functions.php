<?php

defined( 'ABSPATH' ) || exit;

/**
 * Check whether the given the value is subscribe rule. 
 *
 * @param  mixed $the_subscribe_rule Post object or post ID of the rule.
 * @return bool True on success.
 */
function asp_ssws_is_subscribe_rule( $the_subscribe_rule, $level = 'product' ) {
	$is_rule = false;

	if ( 'cart' === $level ) {
		if ( is_object( $the_subscribe_rule ) && is_a( $the_subscribe_rule, 'ASP_SSWS_Subscribe_Rule_Cart' ) ) {
			$is_rule = true;
		} elseif ( is_numeric( $the_subscribe_rule ) && 'asp_cart_subs_rule' === get_post_type( $the_subscribe_rule ) ) {
			$is_rule = true;
		}
	} elseif ( is_object( $the_subscribe_rule ) && is_a( $the_subscribe_rule, 'ASP_SSWS_Subscribe_Rule_Product' ) ) {
		$is_rule = true;
	} elseif ( is_numeric( $the_subscribe_rule ) && 'asp_prod_subs_rule' === get_post_type( $the_subscribe_rule ) ) {
		$is_rule = true;
	}

	return $is_rule;
}

/**
 * Get the subscribe rule.
 * 
 * @param ASP_SSWS_Subscribe_Rule $subscribe_rule
 * @param bool $wp_error
 * @return bool|\ASP_SSWS_Subscribe_Rule
 */
function asp_ssws_get_subscribe_rule( $subscribe_rule, $wp_error = false ) {
	if ( ! $subscribe_rule ) {
		return false;
	}

	try {
		if ( asp_ssws_is_subscribe_rule( $subscribe_rule, 'cart' ) ) {
			$subscribe_rule = new ASP_SSWS_Subscribe_Rule_Cart( $subscribe_rule );
		} else {
			$subscribe_rule = new ASP_SSWS_Subscribe_Rule_Product( $subscribe_rule );
		}
	} catch ( Exception $e ) {
		return $wp_error ? new WP_Error( 'error', $e->getMessage() ) : false;
	}

	return $subscribe_rule;
}

/**
 * Get the subscribe rule statuses.
 * 
 * @return array
 */
function asp_ssws_get_subscribe_rule_statuses() {
	$rule_statuses = array(
		'asp-active'   => __( 'Active', 'subscribe-and-save-for-woocommerce-subscriptions' ),
		'asp-inactive' => __( 'Inactive', 'subscribe-and-save-for-woocommerce-subscriptions' ),
	);

	return $rule_statuses;
}

/**
 * Get the subscribe rule status name.
 * 
 * @param string $status
 * @return string
 */
function asp_ssws_get_subscribe_rule_status_name( $status ) {
	$statuses = asp_ssws_get_subscribe_rule_statuses();
	$status   = asp_ssws_trim_post_status( $status );
	$status   = isset( $statuses[ "asp-{$status}" ] ) ? $statuses[ "asp-{$status}" ] : $status;
	return $status;
}

/**
 * See if a string is an subscribe rule status.
 *
 * @param  string $maybe_status Status, including any asp- prefix.
 * @return bool
 */
function asp_ssws_is_subscribe_rule_status( $maybe_status ) {
	$statuses = asp_ssws_get_subscribe_rule_statuses();
	return isset( $statuses[ $maybe_status ] );
}

/**
 * Prepare the subscribe rule name to display.
 * 
 * @param ASP_SSWS_Subscribe_Rule $subscribe_rule
 * @param string $where admin|frontend
 * @return string 
 */
function asp_ssws_get_subscribe_rule_name( $subscribe_rule, $where = 'frontend' ) {
	if ( asp_ssws_is_subscribe_rule( $subscribe_rule, 'product' ) || asp_ssws_is_subscribe_rule( $subscribe_rule, 'cart' ) ) {
		if ( 'admin' === $where ) {
			return sprintf( '%1$s (#%2$s)', $subscribe_rule->get_name(), $subscribe_rule->get_id() );
		} else {
			return $subscribe_rule->get_name();
		}
	} else {
		return '';
	}
}

/**
 * Return the array of subscribe rules based upon the args requested.
 * 
 * @param array $args
 * @return object
 */
function asp_ssws_get_subscribe_rules( $level = 'product', $args = array() ) {
	global $wpdb;
	$wpdb_ref = &$wpdb;

	$args = wp_parse_args( $args, array(
		'status'      => array_keys( asp_ssws_get_subscribe_rule_statuses() ),
		'include_ids' => array(),
		'exclude_ids' => array(),
		's'           => '',
		'page'        => 1,
		'limit'       => -1,
		'paginate'    => true,
		'return'      => 'objects',
		'orderby'     => 'menu_order',
		'order'       => 'ASC',
			) );

	// Add the 'asp-' prefix to status if needed.
	if ( ! empty( $args[ 'status' ] ) ) {
		if ( is_array( $args[ 'status' ] ) ) {
			foreach ( $args[ 'status' ] as &$status ) {
				if ( asp_ssws_is_subscribe_rule_status( 'asp-' . $status ) ) {
					$status = 'asp-' . $status;
				}
			}
		} elseif ( asp_ssws_is_subscribe_rule_status( 'asp-' . $args[ 'status' ] ) ) {
			$args[ 'status' ] = 'asp-' . $args[ 'status' ];
		}
	}

	// Statuses
	if ( is_array( $args[ 'status' ] ) ) {
		$allowed_statuses = " AND post_status IN ('" . implode( "','", $args[ 'status' ] ) . "') ";
	} else {
		$allowed_statuses = " AND post_status = '" . esc_sql( $args[ 'status' ] ) . "' ";
	}

	// Search term
	if ( ! empty( $args[ 's' ] ) ) {
		$term          = str_replace( '#', '', wc_clean( wp_unslash( $args[ 's' ] ) ) );
		$search_fields = array();

		$search_where = " AND ( 
                 (ID LIKE '%%" . $wpdb_ref->esc_like( $term ) . "%%') OR
                 (post_title LIKE '%%" . $wpdb_ref->esc_like( $term ) . "%%') OR
                 (post_excerpt LIKE '%%" . $wpdb_ref->esc_like( $term ) . "%%') OR
                 (post_content LIKE '%%" . $wpdb_ref->esc_like( $term ) . "%%') OR 
                 (pm.meta_value LIKE '%%" . $wpdb_ref->esc_like( $term ) . "%%' AND pm.meta_key IN ('" . implode( "','", array_map( 'esc_sql', $search_fields ) ) . "'))
                ) ";
	} else {
		$search_where = '';
	}

	// Includes
	if ( ! empty( $args[ 'include_ids' ] ) ) {
		$include_ids = " AND ID IN ('" . implode( "','", $args[ 'include_ids' ] ) . "') ";
	} else {
		$include_ids = '';
	}

	// Excludes
	if ( ! empty( $args[ 'exclude_ids' ] ) ) {
		$exclude_ids = " AND ID NOT IN ('" . implode( "','", $args[ 'exclude_ids' ] ) . "') ";
	} else {
		$exclude_ids = '';
	}

	// Order by
	switch ( ! empty( $args[ 'orderby' ] ) ? $args[ 'orderby' ] : 'menu_order' ) {
		case 'ID':
			$orderby = ' ORDER BY ' . esc_sql( $args[ 'orderby' ] ) . ' ';
			break;
		default:
			$orderby = ' ORDER BY menu_order ';
			break;
	}

	// Order
	if ( ! empty( $args[ 'order' ] ) && 'desc' === strtolower( $args[ 'order' ] ) ) {
		$order = ' DESC ';
	} else {
		$order = ' ASC ';
	}

	// Paging
	if ( $args[ 'limit' ] >= 0 ) {
		$page   = absint( $args[ 'page' ] );
		$page   = $page ? $page : 1;
		$offset = absint( ( $page - 1 ) * $args[ 'limit' ] );
		$limits = 'LIMIT ' . $offset . ', ' . $args[ 'limit' ];
	} else {
		$limits = '';
	}

	$rule_ids = $wpdb_ref->get_col(
			$wpdb_ref->prepare( "
                             SELECT DISTINCT ID FROM {$wpdb_ref->posts} AS p
                             INNER JOIN {$wpdb_ref->postmeta} AS pm ON (p.ID = pm.post_id)
                             WHERE 1=1 AND post_type = '%s' $allowed_statuses $search_where $include_ids $exclude_ids
                             $orderby $order $limits 
                            ", ( 'product' === $level ? 'asp_prod_subs_rule' : "asp_{$level}_subs_rule" )
			) );

	if ( 'objects' === $args[ 'return' ] ) {
		$rules = array_filter( array_combine( $rule_ids, array_map( 'asp_ssws_get_subscribe_rule', $rule_ids ) ) );
	} else {
		$rules = $rule_ids;
	}

	if ( $args[ 'paginate' ] ) {
		$rules_count = count( $rules );
		$return      = ( object ) array(
					'rules'         => $rules,
					'total'         => $rules_count,
					'has_rule'      => $rules_count > 0,
					'max_num_pages' => $args[ 'limit' ] > 0 ? ceil( $rules_count / $args[ 'limit' ] ) : 1,
		);
	} else {
		$return = $rules;
	}

	/**
	 * Get subscribe rules.
	 * 
	 * @since 1.0.0
	 */
	return apply_filters( 'asp_ssws_got_subscribe_rules', $return, $args, $level );
}
