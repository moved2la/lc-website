<?php

defined( 'ABSPATH' ) || exit;

/**
 * Admin cart subscribe rules handler.
 * 
 * @class ASP_SSWS_Admin_List_Table_Cart_Subscribe_Rules
 * @package Class
 */
class ASP_SSWS_Admin_List_Table_Cart_Subscribe_Rules extends WC_Admin_List_Table {

	/**
	 * Post type.
	 *
	 * @var string
	 */
	protected $list_table_type = 'asp_cart_subs_rule';

	/**
	 * To not show blank slate.
	 *
	 * @param string $which String which tablenav is being shown.
	 */
	public function maybe_render_blank_state( $which ) {
		global $post_type;

		if ( $post_type === $this->list_table_type && 'bottom' === $which ) {
			$counts = ( array ) wp_count_posts( $post_type );
			unset( $counts[ 'auto-draft' ] );
			$count  = array_sum( $counts );

			if ( 0 < $count ) {
				return;
			}

			$this->render_blank_state();

			echo '<style type="text/css">#posts-filter .wp-list-table, #posts-filter .search-box, #posts-filter .tablenav.top, .tablenav.bottom .actions, .tablenav.bottom .tablenav-pages, .wrap .subsubsub:not(.asp-ssws-sub-sections)  { display: none; } #posts-filter .tablenav.bottom { height: auto; } </style>';
		}
	}

	/**
	 * Render blank state.
	 */
	protected function render_blank_state() {
		$plan_counts  = ( array ) wp_count_posts( 'asp_subscribe_plan' );
		unset( $plan_counts[ 'auto-draft' ] );
		$has_one_plan = array_sum( $plan_counts ) > 0;

		echo '<div class="woocommerce-BlankState">';
		echo '<h2 class="woocommerce-BlankState-message">' . esc_html__( 'Cart subscribe rules are a way to create flexible cart level subscribe configuration for your customers. They will appear here once created.', 'subscribe-and-save-for-woocommerce-subscriptions' ) . '</h2>';

		if ( ! $has_one_plan ) {
			echo '<a class="woocommerce-BlankState-cta button-primary button" href="' . esc_url( admin_url( 'post-new.php?post_type=asp_subscribe_plan' ) ) . '">' . esc_html__( 'Create your first subscribe plan', 'subscribe-and-save-for-woocommerce-subscriptions' ) . '</a>';
		}

		echo '<a class="woocommerce-BlankState-cta button-primary button ' . ( $has_one_plan ? '' : 'asp-ssws-not-clickable' ) . '" href="' . esc_url( admin_url( 'post-new.php?post_type=asp_cart_subs_rule' ) ) . '">' . esc_html__( 'Create your first cart subscribe rule', 'subscribe-and-save-for-woocommerce-subscriptions' ) . '</a>';
		echo '</div>';
	}

	/**
	 * Define which columns to show on this screen.
	 *
	 * @param array $columns Existing columns.
	 * @return array
	 */
	public function define_columns( $columns ) {
		$columns = array(
			'cb'             => $columns[ 'cb' ],
			'name'           => __( 'Name', 'subscribe-and-save-for-woocommerce-subscriptions' ),
			'status'         => __( 'Status', 'subscribe-and-save-for-woocommerce-subscriptions' ),
			'selected_plans' => __( 'Selected plans', 'subscribe-and-save-for-woocommerce-subscriptions' ),
			'slug'           => __( 'Slug', 'subscribe-and-save-for-woocommerce-subscriptions' ),
			'date'           => __( 'Date', 'subscribe-and-save-for-woocommerce-subscriptions' ),
		);

		return $columns;
	}

	/**
	 * Define which columns are sortable.
	 *
	 * @param array $columns Existing columns.
	 * @return array
	 */
	public function define_sortable_columns( $columns ) {
		$custom = array(
			'name' => 'post_title',
		);

		return wp_parse_args( $custom, $columns );
	}

	/**
	 * Define bulk actions.
	 *
	 * @param array $actions Existing actions.
	 * @return array
	 */
	public function define_bulk_actions( $actions ) {
		unset( $actions[ 'edit' ] );
		return $actions;
	}

	/**
	 * Get row actions to show in the list table.
	 *
	 * @param array   $actions Array of actions.
	 * @param WP_Post $post Current post object.
	 * @return array
	 */
	public function get_row_actions( $actions, $post ) {
		unset( $actions[ 'inline hide-if-no-js' ] );
		return $actions;
	}

	/**
	 * Handle any custom filters.
	 *
	 * @param array $query_vars Query vars.
	 * @return array
	 */
	public function query_filters( $query_vars ) {
		//Sorting
		if ( empty( $query_vars[ 'orderby' ] ) ) {
			$query_vars[ 'orderby' ] = 'menu_order';
		}

		if ( empty( $query_vars[ 'order' ] ) ) {
			$query_vars[ 'order' ] = 'ASC';
		}

		return $query_vars;
	}

	/**
	 * Render individual columns.
	 *
	 * @param string $column Column ID to render.
	 * @param int    $post_id Post ID.
	 */
	public function render_columns( $column, $post_id ) {
		$subscribe_rule = asp_ssws_get_subscribe_rule( $post_id );

		switch ( $column ) {
			case 'name':
				printf( '<b><a href="%1$s">%2$s</a></b>', esc_url( get_admin_url( null, 'post.php?post=' . $post_id . '&action=edit' ) ), wp_kses_post( $subscribe_rule->get_name() ) );
				break;
			case 'status':
				/* translators: 1: status class 2: status name */
				echo wp_kses_post( sprintf( '<mark class="asp-ssws-status %s"><span>%s</span></mark>', esc_attr( sanitize_html_class( 'status-' . $subscribe_rule->get_status() ) ), esc_html( asp_ssws_get_subscribe_rule_status_name( $subscribe_rule->get_status() ) ) ) );
				break;
			case 'selected_plans':
				$plan_ids = asp_ssws_sort_subscribe_plans( $subscribe_rule->get_subscribe_plans() );

				if ( ! empty( $plan_ids ) ) {
					$plan_names = '';
					foreach ( $plan_ids as $plan_id ) {
						$plan       = asp_ssws_get_subscribe_plan( $plan_id );
						$plan_names .= '<p>';
						$plan_names .= sprintf( '<a href="%1$s" target="_blank">%2$s</a>', esc_url( $plan->get_edit_subscribe_plan_url() ), wp_kses_post( $plan->get_name() ) );
						$plan_names .= '</p>';
					}
				} else {
					$plan_names = '&ndash;';
				}

				echo wp_kses_post( $plan_names );
				break;
			case 'slug':
				echo wp_kses_post( $subscribe_rule->get_slug() );
				break;
		}
	}
}

new ASP_SSWS_Admin_List_Table_Cart_Subscribe_Rules();
