<?php

defined( 'ABSPATH' ) || exit;

/**
 * Handle Buy Now or Subscribe and Save for WooCommerce Subscriptions Ajax Event.
 * 
 * @class ASP_SSWS_Ajax
 * @package Class
 */
class ASP_SSWS_Ajax {

	/**
	 * Init ASP_SSWS_Ajax.
	 */
	public static function init() {
		$ajax_events = array(
			'buy_now_or_subscribe'                => true,
			'subscribe_via_modal'                 => true,
			'add_to_cart_subscription'            => true,
			'post_ordering'                       => false,
			'json_search_products_and_variations' => false,
		);

		foreach ( $ajax_events as $ajax_event => $nopriv ) {
			add_action( "wp_ajax_asp_ssws_{$ajax_event}", __CLASS__ . "::{$ajax_event}" );

			if ( $nopriv ) {
				add_action( "wp_ajax_nopriv_asp_ssws_{$ajax_event}", __CLASS__ . "::{$ajax_event}" );
			}
		}
	}

	/**
	 * Buy now or Subscribe.
	 */
	public static function buy_now_or_subscribe() {
		check_ajax_referer( 'asp-ssws-buy-now-or-subscribe-handle', 'security' );

		$posted     = $_POST;
		$product_id = isset( $posted[ 'product_id' ] ) ? absint( wp_unslash( $posted[ 'product_id' ] ) ) : 0;
		$level      = isset( $posted[ 'level' ] ) ? wc_clean( wp_unslash( $posted[ 'level' ] ) ) : '';
		$raw_data   = isset( $posted[ 'data' ] ) ? wp_parse_args( wp_unslash( $posted[ 'data' ] ) ) : array();

		if ( ! empty( $raw_data[ 'asp_ssws_pay_option' ] ) ) {
			$subscribe = null;

			switch ( $level ) {
				case 'cart_level':
					$subscribe = ASP_SSWS_Cart_Subscribe::instance();
					$subscribe->read_posted_data( $raw_data, 0 );

					wp_send_json_success( array(
						'html' => $subscribe->get_subscribe_form( false, false, 0 ),
					) );
					break;
				case 'product_level':
					$product   = wc_get_product( $product_id );
					$subscribe = ASP_SSWS_Product_Subscribe::instance();
					$subscribe->read_posted_data( $raw_data, $product );

					if ( isset( $raw_data[ 'asp_ssws_pay_option_via_modal' ][ $product_id ] ) ) {
						$subscribe->via_modal( true );
					}

					add_filter( 'asp_ssws_subscribe_form_args', array( $subscribe, 'maybe_force_subscribe' ) );

					wp_send_json_success( array(
						'html' => $subscribe->get_subscribe_form( false, false, $product ),
					) );
					break;
			}
		}

		wp_die();
	}

	/**
	 * Subscribe via Modal.
	 */
	public static function subscribe_via_modal() {
		check_ajax_referer( 'asp-ssws-subscribe-via-modal-handle', 'security' );

		$posted     = $_POST;
		$product_id = isset( $posted[ 'product_id' ] ) ? absint( wp_unslash( $posted[ 'product_id' ] ) ) : 0;
		$product    = wc_get_product( $product_id );
		$subscribe  = ASP_SSWS_Product_Subscribe::instance();

		if ( $subscribe->is_available( $product ) ) {
			$subscribe->via_modal( true );

			$title = '<span class="asp-ssws-product-title">';
			$title .= $product->get_image( array( 64, 64 ) );
			$title .= '<span>';
			$title .= $product->get_name();
			$title .= '</span></span>';

			wp_send_json_success( array(
				'title' => $title,
				'html'  => $subscribe->get_subscribe_form( true, false, $product ),
			) );
		}

		wp_send_json_error( array( 'message' => esc_html__( 'Something went wrong !!', 'subscribe-and-save-for-woocommerce-subscriptions' ) ) );
	}

	/**
	 * Add to Cart Subscription.
	 */
	public static function add_to_cart_subscription() {
		check_ajax_referer( 'asp-ssws-add-to-cart-subscription-handle', 'security' );

		$posted     = $_POST;
		$product_id = isset( $posted[ 'product_id' ] ) ? absint( wp_unslash( $posted[ 'product_id' ] ) ) : 0;
		$raw_data   = isset( $posted[ 'data' ] ) ? wp_parse_args( wp_unslash( $posted[ 'data' ] ) ) : array();

		$product   = wc_get_product( $product_id );
		$subscribe = ASP_SSWS_Product_Subscribe::instance();
		$subscribe->read_posted_data( $raw_data, $product );

		$quantity     = 1;
		$variation_id = 0;
		$variation    = array();

		/**
		 * Add to cart validation.
		 * 
		 * @since 1.3.0
		 */
		$passed_validation = apply_filters( 'woocommerce_add_to_cart_validation', true, $product_id, $quantity );

		if ( $product && 'variation' === $product->get_type() ) {
			$variation_id = $product_id;
			$product_id   = $product->get_parent_id();
			$variation    = $product->get_variation_attributes();
		}

		if ( $passed_validation && false !== WC()->cart->add_to_cart( $product_id, $quantity, $variation_id, $variation ) ) {
			wp_send_json_success( array(
				'message' => esc_html__( 'Your product has been successfully added to your cart.', 'subscribe-and-save-for-woocommerce-subscriptions' ),
			) );
		}

		wp_send_json_error( array( 'message' => esc_html__( 'Something went wrong !!', 'subscribe-and-save-for-woocommerce-subscriptions' ) ) );
	}

	/**
	 * Ajax request handling for post ordering.
	 */
	public static function post_ordering() {
		global $wpdb;

		$posted = $_REQUEST;
		if ( ! isset( $posted[ 'id' ] ) ) {
			wp_die( -1 );
		}

		$sorting_id  = absint( $posted[ 'id' ] );
		$post_type   = get_post_type( $sorting_id );
		$previd      = absint( isset( $posted[ 'previd' ] ) ? $posted[ 'previd' ] : 0 );
		$nextid      = absint( isset( $posted[ 'nextid' ] ) ? $posted[ 'nextid' ] : 0 );
		$menu_orders = wp_list_pluck( $wpdb->get_results( $wpdb->prepare( "SELECT ID, menu_order FROM {$wpdb->posts} WHERE post_type=%s ORDER BY menu_order ASC, post_title ASC", esc_sql( $post_type ) ) ), 'menu_order', 'ID' );
		$index       = 0;

		foreach ( $menu_orders as $id => $menu_order ) {
			$id = absint( $id );

			if ( $sorting_id === $id ) {
				continue;
			}
			if ( $nextid === $id ) {
				$index++;
			}
			$index++;
			$menu_orders[ $id ] = $index;
			$wpdb->update( $wpdb->posts, array( 'menu_order' => $index ), array( 'ID' => $id ) );
		}

		if ( isset( $menu_orders[ $previd ] ) ) {
			$menu_orders[ $sorting_id ] = $menu_orders[ $previd ] + 1;
		} elseif ( isset( $menu_orders[ $nextid ] ) ) {
			$menu_orders[ $sorting_id ] = $menu_orders[ $nextid ] - 1;
		} else {
			$menu_orders[ $sorting_id ] = 0;
		}

		$wpdb->update( $wpdb->posts, array( 'menu_order' => $menu_orders[ $sorting_id ] ), array( 'ID' => $sorting_id ) );
		wp_send_json( $menu_orders );
	}

	/**
	 * JSON Search Products and Variations only
	 */
	public static function json_search_products_and_variations() {
		self::json_search_any_posts( array( 'post_type' => array( 'product', 'product_variation' ) ) );
	}

	/**
	 * JSON Search any Posts
	 */
	private static function json_search_any_posts( $args = array() ) {
		check_ajax_referer( 'search-products', 'security' );

		$requested = $_GET;
		$args      = wp_parse_args( $args, array(
			'post_type'      => 'any',
			'post_status'    => 'publish',
			'order'          => 'ASC',
			'orderby'        => 'parent title',
			'fields'         => 'ids',
			'posts_per_page' => -1,
				) );

		if ( isset( $requested[ 'exclude' ] ) && ! empty( $requested[ 'exclude' ] ) ) {
			if ( is_array( $requested[ 'exclude' ] ) ) {
				$args[ 'post__not_in' ] = array_map( 'absint', $requested[ 'exclude' ] );
			} else {
				$args[ 'post__not_in' ] = array_map( 'absint', explode( ',', $requested[ 'exclude' ] ) );
			}
		}

		if ( isset( $requested[ 'include' ] ) && ! empty( $requested[ 'include' ] ) ) {
			if ( is_array( $requested[ 'include' ] ) ) {
				$args[ 'post__in' ] = array_map( 'absint', $requested[ 'include' ] );
			} else {
				$args[ 'post__in' ] = array_map( 'absint', explode( ',', $requested[ 'include' ] ) );
			}
		}

		if ( isset( $requested[ 'term' ] ) ) {
			$term = ( string ) wc_clean( stripslashes( $requested[ 'term' ] ) );

			if ( is_numeric( $term ) ) {
				$args[ 'post__in' ] = ! empty( $args[ 'post__in' ] ) ? array_merge( $args[ 'post__in' ], array( absint( $term ), 0 ) ) : array( absint( $term ), 0 );
			} else {
				$args[ 's' ] = $term;
			}
		} else {
			$args[ 's' ] = '';
		}

		if ( isset( $requested[ 'limit' ] ) && is_numeric( $requested[ 'limit' ] ) ) {
			$args[ 'posts_per_page' ] = $requested[ 'limit' ];
		}

		$post_ids    = get_posts( $args );
		$found_posts = array();

		if ( ! empty( $post_ids ) ) {
			foreach ( $post_ids as $post_id ) {
				$found_posts[ $post_id ] = sprintf( '%1$s (#%2$s)', get_the_title( $post_id ), $post_id );
			}
		}

		wp_send_json( $found_posts );
	}
}
