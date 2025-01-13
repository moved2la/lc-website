<?php

defined( 'ABSPATH' ) || exit;

/**
 * Subscribe Rules handler.
 * 
 * @class ASP_SSWS_Subscribe_Rules
 * @package Class
 */
class ASP_SSWS_Subscribe_Rules {

	/**
	 * Retrieve the active subscribe rules.
	 * 
	 * @var ASP_SSWS_Subscribe_Rule[] 
	 */
	protected static $active_rules = array();

	/**
	 * Get the applied subscribe rule.
	 * 
	 * @var array
	 */
	protected static $applied_rule = array();

	/**
	 * Check whether the active subscribe rule exists.
	 * 
	 * @param string $level 
	 * @return bool
	 */
	public static function active_rule_exists( $level = 'product' ) {
		return ! empty( self::get_active_rules( $level ) );
	}

	/**
	 * Retrieve an array of active subscribe rules.
	 * 
	 * @param string $level 
	 * @return ASP_SSWS_Subscribe_Rule[]
	 */
	public static function get_active_rules( $level = 'product' ) {
		if ( ! isset( self::$active_rules[ $level ] ) ) {
			self::$active_rules[ $level ] = asp_ssws_get_subscribe_rules( $level, array( 'status' => 'active' ) )->rules;
		}

		return self::$active_rules[ $level ];
	}

	/**
	 * Get the product subscribe rule applied.
	 * 
	 * @param int $product_id
	 * @param int $user_id
	 * @return array
	 */
	public static function get_product_rule_applied( $product_id, $user_id ) {
		$level = 'product';

		if ( isset( self::$applied_rule[ $level ][ $user_id ][ $product_id ] ) ) {
			return self::$applied_rule[ $level ][ $user_id ][ $product_id ];
		}

		self::$applied_rule[ $level ][ $user_id ][ $product_id ] = null;

		if ( self::active_rule_exists( $level ) ) {
			$product      = asp_ssws_maybe_get_product_instance( $product_id );
			$product_cats = $product ? asp_ssws_get_product_term_ids( $product->get_parent_id() > 0 ? $product->get_parent_id() : $product->get_id() ) : array();
			$user         = get_user_by( 'id', $user_id );

			foreach ( self::get_active_rules( $level ) as $rule ) {
				$product_rule_satisfied = 0;
				$user_rule_satisfied    = 0;

				switch ( $rule->get_criteria_product_filter() ) {
					case 'included-products':
						if ( in_array( $product_id, $rule->get_criteria_products() ) ) {
							$product_rule_satisfied++;
						}
						break;
					case 'excluded-products':
						if ( ! in_array( $product_id, $rule->get_criteria_products() ) ) {
							$product_rule_satisfied++;
						}
						break;
					case 'included-product-cats':
						if ( count( array_intersect( $product_cats, $rule->get_criteria_product_cats() ) ) > 0 ) {
							$product_rule_satisfied++;
						}
						break;
					case 'excluded-product-cats':
						if ( 0 === count( array_intersect( $product_cats, $rule->get_criteria_product_cats() ) ) ) {
							$product_rule_satisfied++;
						}
						break;
					default:
						$product_rule_satisfied++;
						break;
				}

				switch ( $rule->get_criteria_user_filter() ) {
					case 'included-users':
						if ( in_array( $user_id, $rule->get_criteria_users() ) ) {
							$user_rule_satisfied++;
						}
						break;
					case 'excluded-users':
						if ( ! in_array( $user_id, $rule->get_criteria_users() ) ) {
							$user_rule_satisfied++;
						}
						break;
					case 'included-user-roles':
						if ( ! empty( $user->roles ) && count( array_intersect( $user->roles, $rule->get_criteria_user_roles() ) ) > 0 ) {
							$user_rule_satisfied++;
						}
						break;
					case 'excluded-user-roles':
						if ( ! empty( $user->roles ) && 0 === count( array_intersect( $user->roles, $rule->get_criteria_user_roles() ) ) ) {
							$user_rule_satisfied++;
						}
						break;
					default:
						$user_rule_satisfied++;
						break;
				}

				if ( $product_rule_satisfied > 0 && $user_rule_satisfied > 0 ) {
					self::$applied_rule[ $level ][ $user_id ][ $product_id ] = $rule;
					break;
				}
			}
		}

		return self::$applied_rule[ $level ][ $user_id ][ $product_id ];
	}

	/**
	 * Get the cart subscribe rule applied.
	 * 
	 * @param int $user_id
	 * @return array
	 */
	public static function get_cart_rule_applied( $user_id ) {
		$level = 'cart';

		if ( isset( self::$applied_rule[ $level ][ $user_id ] ) ) {
			return self::$applied_rule[ $level ][ $user_id ];
		}

		self::$applied_rule[ $level ][ $user_id ] = null;

		if ( self::active_rule_exists( $level ) ) {
			$user          = get_user_by( 'id', $user_id );
			$cart_subtotal = asp_ssws_get_cart_subtotal();

			foreach ( self::get_active_rules( $level ) as $rule ) {
				$user_rule_satisfied = 0;

				switch ( $rule->get_criteria_user_filter() ) {
					case 'included-users':
						if ( in_array( $user_id, $rule->get_criteria_users() ) ) {
							$user_rule_satisfied++;
						}
						break;
					case 'excluded-users':
						if ( ! in_array( $user_id, $rule->get_criteria_users() ) ) {
							$user_rule_satisfied++;
						}
						break;
					case 'included-user-roles':
						if ( ! empty( $user->roles ) && count( array_intersect( $user->roles, $rule->get_criteria_user_roles() ) ) > 0 ) {
							$user_rule_satisfied++;
						}
						break;
					case 'excluded-user-roles':
						if ( ! empty( $user->roles ) && 0 === count( array_intersect( $user->roles, $rule->get_criteria_user_roles() ) ) ) {
							$user_rule_satisfied++;
						}
						break;
					default:
						$user_rule_satisfied++;
						break;
				}

				$subtotal_rule_satisfied = 0;
				if ( is_numeric( $rule->get_criteria_min_subtotal() ) && is_numeric( $rule->get_criteria_max_subtotal() ) ) {
					if ( $cart_subtotal >= $rule->get_criteria_min_subtotal() && $cart_subtotal <= $rule->get_criteria_max_subtotal() ) {
						$subtotal_rule_satisfied++;
					}
				} else if ( is_numeric( $rule->get_criteria_min_subtotal() ) ) {
					if ( $cart_subtotal >= $rule->get_criteria_min_subtotal() ) {
						$subtotal_rule_satisfied++;
					}
				} else if ( is_numeric( $rule->get_criteria_max_subtotal() ) ) {
					if ( $cart_subtotal <= $rule->get_criteria_max_subtotal() ) {
						$subtotal_rule_satisfied++;
					}
				} else {
					$subtotal_rule_satisfied++;
				}

				if ( $user_rule_satisfied > 0 && $subtotal_rule_satisfied > 0 ) {
					self::$applied_rule[ $level ][ $user_id ] = $rule;
					break;
				}
			}
		}

		return self::$applied_rule[ $level ][ $user_id ];
	}
}
