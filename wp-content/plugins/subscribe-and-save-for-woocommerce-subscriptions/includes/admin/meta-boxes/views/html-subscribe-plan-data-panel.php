<?php
defined( 'ABSPATH' ) || exit;

wp_nonce_field( 'asp_ssws_save_data', 'asp_ssws_save_meta_nonce' );
?>
<div class="panel-wrap asp-ssws-plan-data-wrapper">
	<span class="plan-data-hidden-box definition_box hidden"> &mdash;
		<label for="_plan_definition">
			<select name="_plan_definition">
				<?php foreach ( asp_ssws_get_subscribe_plan_definitions() as $value => $label ) { ?>
					<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $value, $subscribe_plan->get_definition(), true ); ?>><?php echo esc_html( $label ); ?></option>
				<?php } ?>
			</select>
		</label>
	</span>    
	<?php
	self::output_panels();
	/**
	 * Plan data panels.
	 * 
	 * @since 1.0.0
	 */
	do_action( 'asp_ssws_plan_data_panels' );
	?>
	<div class="clear"></div>
</div>
