<?php
/**
 * Userdefined data panel.
 */
defined( 'ABSPATH' ) || exit;

$range_strings = array(
	'min' => __( 'Min', 'subscribe-and-save-for-woocommerce-subscriptions' ),
	'max' => __( 'Max', 'subscribe-and-save-for-woocommerce-subscriptions' ),
);
?>
<div id="userdefined_plan_data" class="panel woocommerce_options_panel">
	<div class="options_group subscription_pricing">

		<?php
		// Subscription Discount %
		woocommerce_wp_text_input(
				array(
					'id'          => '_subscription_discount',
					'name'        => '_plan[userdefined][subscription_discount]',
					'class'       => 'wc_input_subscription_discount wc_input_price short',
					'label'       => __( 'Subscription discount %', 'subscribe-and-save-for-woocommerce-subscriptions' ),
					'placeholder' => __( 'e.g. 5', 'subscribe-and-save-for-woocommerce-subscriptions' ),
					'description' => __( 'Discount to be applied on the regular/sale price of the product.', 'subscribe-and-save-for-woocommerce-subscriptions' ),
					'desc_tip'    => true,
					'type'        => 'text',
					'value'       => $chosen_discount,
				)
		);

		// Sign-up Fee
		woocommerce_wp_text_input(
				array(
					'id'                => '_subscription_sign_up_fee',
					'name'              => '_plan[userdefined][subscription_sign_up_fee]',
					'class'             => 'wc_input_subscription_initial_price wc_input_price  short',
					// translators: %s is a currency symbol / code
					'label'             => sprintf( __( 'Sign-up fee (%s)', 'subscribe-and-save-for-woocommerce-subscriptions' ), get_woocommerce_currency_symbol() ),
					'placeholder'       => _x( 'e.g. 9.90', 'example price', 'subscribe-and-save-for-woocommerce-subscriptions' ),
					'description'       => __( 'Optionally include an amount to be charged at the outset of the subscription. The sign-up fee will be charged immediately, even if the product has a free trial or the payment dates are synced.', 'subscribe-and-save-for-woocommerce-subscriptions' ),
					'desc_tip'          => true,
					'type'              => 'text',
					'data_type'         => 'price',
					'custom_attributes' => array(
						'step' => 'any',
						'min'  => '0',
					),
					'value'             => $chosen_sign_up_fee,
				)
		);
		?>

		<p class="form-field _subscription_trial_length_field">
			<label for="_subscription_trial_length"><?php esc_html_e( 'Free trial', 'subscribe-and-save-for-woocommerce-subscriptions' ); ?></label>
			<span class="wrap">
				<input type="text" id="_subscription_trial_length" name="_plan[userdefined][subscription_trial_length]" class="wc_input_subscription_trial_length" value="<?php echo esc_attr( $chosen_trial_length ); ?>" />
				<label for="_subscription_trial_period" class="wcs_hidden_label"><?php esc_html_e( 'Subscription Trial Period', 'subscribe-and-save-for-woocommerce-subscriptions' ); ?></label>
				<select id="_subscription_trial_period" name="_plan[userdefined][subscription_trial_period]" class="wc_input_subscription_trial_period last" >
					<?php foreach ( wcs_get_available_time_periods() as $value => $label ) { ?>
						<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $value, $chosen_trial_period, true ); ?>><?php echo esc_html( $label ); ?></option>
					<?php } ?>
				</select>
			</span>
			<?php
			// translators: placeholder is trial period validation message if passed an invalid value (e.g. "Trial period can not exceed 4 weeks")
			echo wp_kses_post( wcs_help_tip( sprintf( _x( 'An optional period of time to wait before charging the first recurring payment. Any sign up fee will still be charged at the outset of the subscription. %s', 'Trial period field tooltip on Edit Product administration screen', 'subscribe-and-save-for-woocommerce-subscriptions' ), WC_Subscriptions_Admin::get_trial_period_validation_message() ) ) );
			?>
		</p>

		<div class="_subscription_interval_length_field">
			<label for="_subscription_interval_length"><?php esc_html_e( 'Subscription interval and length', 'subscribe-and-save-for-woocommerce-subscriptions' ); ?></label>
			<div>
				<table class="wp-list-table widefat striped">
					<thead>
						<tr>
							<th><?php esc_html_e( 'Period', 'subscribe-and-save-for-woocommerce-subscriptions' ); ?></th>
							<th><?php esc_html_e( 'Interval', 'subscribe-and-save-for-woocommerce-subscriptions' ); ?></th>
							<th><?php esc_html_e( 'Stop renewing after', 'subscribe-and-save-for-woocommerce-subscriptions' ); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ( wcs_get_subscription_period_strings() as $period => $period_label ) { ?>
							<tr>
								<td class="period_cell">
									<input type="checkbox" name="_plan[userdefined][subscription_interval_length][<?php echo esc_attr( $period ); ?>][enabled]" 
									<?php
									if ( isset( $chosen_interval_length[ $period ][ 'enabled' ] ) ) {
										checked( $chosen_interval_length[ $period ][ 'enabled' ], 'yes', true );
									} else {
										checked( true, true, true );
									}
									?>

										   value="yes">
									&nbsp;<b><?php echo esc_html( ucfirst( $period_label ) ); ?></b>
								</td>

								<td class="interval_cell">
									<?php foreach ( $range_strings as $range => $range_label ) { ?>
										<div>
											<label for="_range_label"><b><?php echo esc_html( $range_label ); ?></b></label>
											<select name="_plan[userdefined][subscription_interval_length][<?php echo esc_attr( $period ); ?>][interval][<?php echo esc_attr( $range ); ?>]">
												<?php
												foreach ( wcs_get_subscription_period_interval_strings() as $value => $label ) {
													if ( 'max' === $range && 1 === $value ) {
														continue;
													}
													?>
													<option value="<?php echo esc_attr( $value ); ?>"
													<?php
													if ( isset( $chosen_interval_length[ $period ][ 'interval' ][ $range ] ) ) {
														selected( $value, ( string ) $chosen_interval_length[ $period ][ 'interval' ][ $range ] );
													} else if ( 'max' === $range && 6 === $value ) {
														selected( $value, '6' );
													}
													?>
															>
																<?php if ( 1 === $value ) { ?>
																	<?php
																	/* translators: 1: period label */
																	printf( esc_html__( 'every %1$s', 'subscribe-and-save-for-woocommerce-subscriptions' ), esc_html( $period_label ) );
																	?>
																<?php } else { ?>
																	<?php
																	/* translators: 1: period value 2: period label */
																	printf( esc_html__( 'every %1$s %2$s', 'subscribe-and-save-for-woocommerce-subscriptions' ), esc_html( asp_ssws_get_number_suffix( $value ) ), esc_html( $period_label ) );
																	?>
																<?php } ?>
													</option>
													<?php
												}
												?>
											</select>
										</div>
									<?php } ?>
								</td>

								<td class="length_cell">
									<?php foreach ( $range_strings as $range => $range_label ) { ?>
										<div>
											<label for="_range_label"><b><?php echo esc_html( $range_label ); ?></b></label>
											<select name="_plan[userdefined][subscription_interval_length][<?php echo esc_attr( $period ); ?>][length][<?php echo esc_attr( $range ); ?>]">
												<?php
												foreach ( wcs_get_subscription_ranges( $period ) as $value => $label ) {
													if ( 'min' === $range && 0 === $value ) {
														continue;
													}
													?>
													<option value="<?php echo esc_attr( $value ); ?>"
													<?php
													if ( isset( $chosen_interval_length[ $period ][ 'length' ][ $range ] ) ) {
														selected( $value, ( string ) $chosen_interval_length[ $period ][ 'length' ][ $range ] );
													}
													?>
															><?php echo esc_html( $label ); ?></option>
															<?php
												}
												?>
											</select>
										</div>
									<?php } ?>
								</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<?php
	/**
	 * User defined data.
	 * 
	 * @since 1.0.0
	 */
	do_action( 'asp_ssws_plan_options_userdefined_data' );
	?>
</div>
