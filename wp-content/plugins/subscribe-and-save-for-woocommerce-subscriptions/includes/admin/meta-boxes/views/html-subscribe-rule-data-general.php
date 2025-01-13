<?php
defined( 'ABSPATH' ) || exit;

/**
 * Before rule general tab.
 * 
 * @since 1.0.0
 */
do_action( 'asp_ssws_admin_before_subscribe_rule_data_general', $subscribe_rule );

$subscribe_plans = asp_ssws_get_subscribe_plans( array( 'status' => 'active' ) );
$selected_plans  = $subscribe_rule->get_subscribe_plans();
?>
<div id="general_rule_data" class="panel woocommerce_options_panel">
	<?php
	/**
	 * Before rule general tab fields.
	 * 
	 * @since 1.0.0
	 */
	do_action( 'asp_ssws_admin_subscribe_rule_data_before_general_fields', $subscribe_rule );
	?>

	<div class="options_group">
		<?php if ( ! empty( $subscribe_rule->get_slug() ) ) { ?>
			<p class="asp-ssws-form-field _slug_field">
				<label for="_slug"><?php esc_html_e( 'Plan Slug', 'subscribe-and-save-for-woocommerce-subscriptions' ); ?></label>
				<strong><?php echo esc_html( $subscribe_rule->get_slug() ); ?></strong>
			</p>
		<?php } ?>

		<p class="asp-ssws-form-field _subscribe_plans_field">
			<label for="_subscribe_plans">
				<?php esc_html_e( 'Subscribe Plans', 'subscribe-and-save-for-woocommerce-subscriptions' ); ?>

				<?php if ( $subscribe_plans->has_plan ) { ?>
					<?php echo wc_help_tip( __( 'Choose active subscribe plans which are available to customers.', 'subscribe-and-save-for-woocommerce-subscriptions' ) ); ?>
				<?php } ?>
			</label>
			<?php
			if ( $subscribe_plans->has_plan ) {
				?>
				<select
					multiple="multiple" 
					name="_subscribe_plans[]" 
					id="subscribe_plans" 
					class="wc-enhanced-select"
					placeholder="<?php esc_attr_e( 'Choose some plans', 'subscribe-and-save-for-woocommerce-subscriptions' ); ?>">
					>
					<?php
					foreach ( $subscribe_plans->plans as $plan ) {
						?>
						<option value="<?php echo esc_attr( $plan->get_id() ); ?>"
						<?php
						if ( is_array( $selected_plans ) ) {
							selected( in_array( ( string ) $plan->get_id(), $selected_plans, true ), true );
						} else {
							selected( $selected_plans, ( string ) $plan->get_id() );
						}
						?>
								><?php echo wp_kses_post( sprintf( '(#%s) %s', $plan->get_id(), $plan->get_name() ) ); ?></option>
								<?php
					}
					?>
				</select> 
				<?php
				echo ' <br><a href="' . esc_url( admin_url( 'edit.php?post_type=asp_subscribe_plan' ) ) . '" class="button-small" target="_blank">' . esc_html__( 'Create or Edit a Subscribe Plan&rarr;', 'subscribe-and-save-for-woocommerce-subscriptions' ) . '</a>';
			} else {
				esc_html_e( 'You have not created any subscribe plans yet.', 'subscribe-and-save-for-woocommerce-subscriptions' );
				echo ' <a href="' . esc_url( admin_url( 'edit.php?post_type=asp_subscribe_plan' ) ) . '" class="button-small" target="_blank">' . esc_html__( 'Create a Subscribe Plan&rarr;', 'subscribe-and-save-for-woocommerce-subscriptions' ) . '</a>';
			}
			?>
		</p>
	</div>
</div>
<?php
/**
 * After rule general tab.
 * 
 * @since 1.0.0
 */
do_action( 'asp_ssws_admin_after_subscribe_rule_data_general', $subscribe_rule );
