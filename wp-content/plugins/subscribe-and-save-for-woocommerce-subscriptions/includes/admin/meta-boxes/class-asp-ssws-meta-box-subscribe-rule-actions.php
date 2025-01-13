<?php
defined( 'ABSPATH' ) || exit;

/**
 * Subscribe Rule Actions.
 * 
 * @class ASP_SSWS_Meta_Box_Subscribe_Rule_Actions
 * @package Class
 */
class ASP_SSWS_Meta_Box_Subscribe_Rule_Actions {

	/**
	 * Output the metabox.
	 *
	 * @param WP_Post $post Post object.
	 */
	public static function output( $post ) {
		global $post, $the_subscribe_rule;

		if ( ! is_object( $the_subscribe_rule ) ) {
			if ( asp_ssws_is_subscribe_rule( $post->ID, 'cart' ) ) {
				$the_subscribe_rule = new ASP_SSWS_Subscribe_Rule_Cart( $post->ID );
			} else {
				$the_subscribe_rule = new ASP_SSWS_Subscribe_Rule_Product( $post->ID );
			}
		}

		$subscribe_rule = $the_subscribe_rule;
		?>
		<ul class="order_actions submitbox">
			<?php
			/**
			 * Before subscribe rule actions.
			 * 
			 * @since 1.0.0
			 */
			do_action( 'asp_ssws_subscribe_rule_actions_start', $post->ID );
			?>
			<li class="wide">
				<select name="_status">
					<?php foreach ( asp_ssws_get_subscribe_rule_statuses() as $status_name => $status_label ) { ?>
						<option value="<?php echo esc_attr( $status_name ); ?>" <?php selected( 'asp-' . $subscribe_rule->get_status( 'edit' ), $status_name, true ); ?>><?php echo esc_html( $status_label ); ?></option>
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
			 * After subscribe rule actions.
			 * 
			 * @since 1.0.0
			 */
			do_action( 'asp_ssws_subscribe_rule_actions_end', $post->ID );
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
		if ( asp_ssws_is_subscribe_rule( $post_id, 'cart' ) ) {
			$level          = 'cart';
			$subscribe_rule = new ASP_SSWS_Subscribe_Rule_Cart( $post_id );
		} else {
			$level          = 'product';
			$subscribe_rule = new ASP_SSWS_Subscribe_Rule_Product( $post_id );
		}

		$errors = $subscribe_rule->set_props( array(
			'slug'                    => isset( $posted[ 'post_title' ] ) ? sanitize_title( wp_unslash( $posted[ 'post_title' ] ) ) : '',
			'criteria_product_filter' => isset( $posted[ '_criteria_product_filter' ] ) ? sanitize_title( wp_unslash( $posted[ '_criteria_product_filter' ] ) ) : 'all-products',
			'criteria_user_filter'    => isset( $posted[ '_criteria_user_filter' ] ) ? sanitize_title( wp_unslash( $posted[ '_criteria_user_filter' ] ) ) : 'all-users',
			'subscribe_plans'         => isset( $posted[ '_subscribe_plans' ] ) ? array_values( array_filter( ( array ) wp_unslash( $posted[ '_subscribe_plans' ] ) ) ) : array(),
			'criteria_products'       => isset( $posted[ '_criteria_products' ] ) ? array_values( array_filter( ( array ) wp_unslash( $posted[ '_criteria_products' ] ) ) ) : array(),
			'criteria_product_cats'   => isset( $posted[ '_criteria_product_cats' ] ) ? array_values( array_filter( ( array ) wp_unslash( $posted[ '_criteria_product_cats' ] ) ) ) : array(),
			'criteria_users'          => isset( $posted[ '_criteria_users' ] ) ? array_values( array_filter( ( array ) wp_unslash( $posted[ '_criteria_users' ] ) ) ) : array(),
			'criteria_user_roles'     => isset( $posted[ '_criteria_user_roles' ] ) ? array_values( array_filter( ( array ) wp_unslash( $posted[ '_criteria_user_roles' ] ) ) ) : array(),
			'criteria_min_subtotal'   => isset( $posted[ '_criteria_min_subtotal' ] ) ? wc_clean( wp_unslash( $posted[ '_criteria_min_subtotal' ] ) ) : '',
			'criteria_max_subtotal'   => isset( $posted[ '_criteria_max_subtotal' ] ) ? wc_clean( wp_unslash( $posted[ '_criteria_max_subtotal' ] ) ) : '',
				) );

		if ( ! $subscribe_rule->get_priority() ) {
			$rules = asp_ssws_get_subscribe_rules( $level );
			$order = 1;

			$subscribe_rule->set_priority( $order );

			if ( $rules->has_rule ) {
				foreach ( $rules->rules as $_rule ) {
					$order++;

					$_rule->set_priority( $order );
					$_rule->save();
				}
			}
		}

		if ( is_wp_error( $errors ) ) {
			ASP_SSWS_Admin::add_error( $errors->get_error_message() );
		}

		/**
		 * Rule before save manually.
		 * 
		 * @since 1.0.0
		 */
		do_action( 'asp_ssws_admin_subscribe_rule_before_save', $subscribe_rule, $posted );

		$subscribe_rule->update_status( wc_clean( wp_unslash( $posted[ '_status' ] ) ) );
	}
}
