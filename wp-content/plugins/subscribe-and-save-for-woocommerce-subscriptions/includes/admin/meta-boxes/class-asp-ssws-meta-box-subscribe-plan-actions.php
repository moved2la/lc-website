<?php
defined( 'ABSPATH' ) || exit;

/**
 * Subscribe Plan Actions.
 * 
 * @class ASP_SSWS_Meta_Box_Subscribe_Plan_Actions
 * @package Class
 */
class ASP_SSWS_Meta_Box_Subscribe_Plan_Actions {

	/**
	 * Output the metabox.
	 *
	 * @param WP_Post $post Post object.
	 */
	public static function output( $post ) {
		global $post, $the_subscribe_plan;

		if ( ! is_object( $the_subscribe_plan ) ) {
			$the_subscribe_plan = asp_ssws_get_subscribe_plan( $post->ID );
		}

		$subscribe_plan = $the_subscribe_plan;
		?>
		<ul class="order_actions submitbox">
			<?php
			/**
			 * Metabox start
			 * 
			 * @since 1.0.0
			 */
			do_action( 'asp_ssws_subscribe_plan_actions_start', $post->ID );
			?>
			<li class="wide">
				<select name="_status">
					<?php foreach ( asp_ssws_get_subscribe_plan_statuses() as $status_name => $status_label ) { ?>
						<option value="<?php echo esc_attr( $status_name ); ?>" <?php selected( 'asp-' . $subscribe_plan->get_status(), $status_name, true ); ?>><?php echo esc_html( $status_label ); ?></option>
					<?php } ?>
				</select>
			</li>
			<li class="wide">
				<div id="delete-action">
					<?php
					if ( current_user_can( 'delete_post', $post->ID ) ) {
						if ( ! EMPTY_TRASH_DAYS ) {
							$delete_text = __( 'Delete permanently', 'subscribe-and-save-for-woocommerce-subscriptions' );
						} else {
							$delete_text = __( 'Move to Trash', 'subscribe-and-save-for-woocommerce-subscriptions' );
						}
						?>
						<a class="submitdelete deletion" href="<?php echo esc_url( get_delete_post_link( $post->ID ) ); ?>"><?php echo esc_html( $delete_text ); ?></a>
						<?php
					}
					?>
				</div>
				<button type="submit" class="button save_order button-primary" name="save" value="<?php echo 'auto-draft' === $post->post_status ? esc_attr__( 'Create', 'subscribe-and-save-for-woocommerce-subscriptions' ) : esc_attr__( 'Update', 'subscribe-and-save-for-woocommerce-subscriptions' ); ?>"><?php echo 'auto-draft' === $post->post_status ? esc_html__( 'Create', 'subscribe-and-save-for-woocommerce-subscriptions' ) : esc_html__( 'Update', 'subscribe-and-save-for-woocommerce-subscriptions' ); ?></button>
			</li>
			<?php
			/**
			 * Metabox end
			 * 
			 * @since 1.0.0
			 */
			do_action( 'asp_ssws_subscribe_plan_actions_end', $post->ID );
			?>
		</ul>
		<?php
	}

	/**
	 * Save meta box data.
	 *
	 * @param int $post_id
	 * @param WP_Post $post
	 */
	public static function save( $post_id, $post, $posted ) {
		$plan_id                        = $post_id;
		$subscribe_plan                 = asp_ssws_get_subscribe_plan( $plan_id );
		$plan_definition                = isset( $posted[ '_plan_definition' ] ) ? sanitize_title( wp_unslash( $posted[ '_plan_definition' ] ) ) : 'predefined';
		$subscription_period            = isset( $posted[ '_plan' ][ $plan_definition ][ 'subscription_period' ] ) ? wc_clean( wp_unslash( $posted[ '_plan' ][ $plan_definition ][ 'subscription_period' ] ) ) : 'month';
		$subscription_payment_sync_date = '';
		$subscription_interval_length   = array();

		if ( 'predefined' === $plan_definition ) {
			if ( 'year' === $subscription_period ) {
				$subscription_payment_sync_date = array(
					'day'   => isset( $posted[ '_plan' ][ $plan_definition ][ 'subscription_payment_sync_date_day' ] ) ? $posted[ '_plan' ][ $plan_definition ][ 'subscription_payment_sync_date_day' ] : 0,
					'month' => isset( $posted[ '_plan' ][ $plan_definition ][ 'subscription_payment_sync_date_month' ] ) ? $posted[ '_plan' ][ $plan_definition ][ 'subscription_payment_sync_date_month' ] : '01',
				);
			} else {
				$subscription_payment_sync_date = isset( $posted[ '_plan' ][ $plan_definition ][ 'subscription_payment_sync_date' ] ) ? wc_clean( wp_unslash( $posted[ '_plan' ][ $plan_definition ][ 'subscription_payment_sync_date' ] ) ) : null;
			}
		}

		if ( 'userdefined' === $plan_definition ) {
			$raw_interval_length = isset( $posted[ '_plan' ][ $plan_definition ][ 'subscription_interval_length' ] ) ? array_filter( ( array ) wp_unslash( $posted[ '_plan' ][ $plan_definition ][ 'subscription_interval_length' ] ) ) : array();

			foreach ( wcs_get_subscription_period_strings() as $period => $label ) {
				$subscription_interval_length[ $period ][ 'enabled' ] = isset( $raw_interval_length[ $period ][ 'enabled' ] ) ? 'yes' : 'no';

				if ( ! isset( $raw_interval_length[ $period ] ) ) {
					continue;
				}

				$subscription_interval_length[ $period ] = $raw_interval_length[ $period ];

				if ( isset( $raw_interval_length[ $period ][ 'interval' ][ 'min' ], $raw_interval_length[ $period ][ 'interval' ][ 'max' ] ) ) {
					$min_interval = $raw_interval_length[ $period ][ 'interval' ][ 'min' ];
					$max_interval = $raw_interval_length[ $period ][ 'interval' ][ 'max' ];

					if ( $min_interval >= $max_interval ) {
						$subscription_interval_length[ $period ][ 'interval' ][ 'min' ] = '1';
					}
				}

				if ( isset( $raw_interval_length[ $period ][ 'length' ][ 'min' ], $raw_interval_length[ $period ][ 'length' ][ 'max' ] ) ) {
					$min_length = $raw_interval_length[ $period ][ 'length' ][ 'min' ];
					$max_length = $raw_interval_length[ $period ][ 'length' ][ 'max' ];

					if ( $min_length >= $max_length ) {
						$subscription_interval_length[ $period ][ 'length' ][ 'min' ] = '1';
					}
				}
			}
		}

		$errors = $subscribe_plan->set_props( array(
			'definition'                     => $plan_definition,
			'slug'                           => isset( $posted[ 'post_title' ] ) ? sanitize_title( wp_unslash( $posted[ 'post_title' ] ) ) : '',
			'subscription_discount'          => isset( $posted[ '_plan' ][ $plan_definition ][ 'subscription_discount' ] ) ? wc_clean( wp_unslash( $posted[ '_plan' ][ $plan_definition ][ 'subscription_discount' ] ) ) : '',
			'subscription_sign_up_fee'       => isset( $posted[ '_plan' ][ $plan_definition ][ 'subscription_sign_up_fee' ] ) ? wc_clean( wp_unslash( $posted[ '_plan' ][ $plan_definition ][ 'subscription_sign_up_fee' ] ) ) : '0',
			'subscription_trial_period'      => isset( $posted[ '_plan' ][ $plan_definition ][ 'subscription_trial_period' ] ) ? wc_clean( wp_unslash( $posted[ '_plan' ][ $plan_definition ][ 'subscription_trial_period' ] ) ) : 'day',
			'subscription_trial_length'      => isset( $posted[ '_plan' ][ $plan_definition ][ 'subscription_trial_length' ] ) ? wc_clean( wp_unslash( $posted[ '_plan' ][ $plan_definition ][ 'subscription_trial_length' ] ) ) : '0',
			'subscription_period_interval'   => isset( $posted[ '_plan' ][ $plan_definition ][ 'subscription_period_interval' ] ) ? wc_clean( wp_unslash( $posted[ '_plan' ][ $plan_definition ][ 'subscription_period_interval' ] ) ) : '1',
			'subscription_length'            => isset( $posted[ '_plan' ][ $plan_definition ][ 'subscription_length' ] ) ? wc_clean( wp_unslash( $posted[ '_plan' ][ $plan_definition ][ 'subscription_length' ] ) ) : '0',
			'subscription_period'            => $subscription_period,
			'subscription_payment_sync_date' => $subscription_payment_sync_date,
			'subscription_interval_length'   => $subscription_interval_length,
				) );

		if ( ! $subscribe_plan->get_priority() ) {
			$subscribe_plans = asp_ssws_get_subscribe_plans();
			$order           = 1;

			$subscribe_plan->set_priority( $order );

			if ( $subscribe_plans->has_plan ) {
				foreach ( $subscribe_plans->plans as $plan ) {
					$order++;

					$plan->set_priority( $order );
					$plan->save();
				}
			}
		}

		if ( is_wp_error( $errors ) ) {
			ASP_SSWS_Admin::add_error( $errors->get_error_message() );
		}

		/**
		 * Subscribe plan before save manually.
		 * 
		 * @since 1.0.0
		 */
		do_action( 'asp_ssws_admin_subscribe_plan_before_save', $subscribe_plan, $posted );

		$subscribe_plan->update_status( wc_clean( wp_unslash( $posted[ '_status' ] ) ) );
	}
}
