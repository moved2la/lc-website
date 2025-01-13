<?php
/**
 * Predefined data panel.
 */
defined( 'ABSPATH' ) || exit;

if ( empty( $chosen_period ) ) {
	$chosen_period = 'day';
}

if ( WC_Subscriptions_Synchroniser::is_syncing_enabled() ) {
	// Determine whether to display the week/month sync fields or the annual sync fields
	$display_week_month_select = ! in_array( $chosen_period, array( 'month', 'week' ) ) ? 'display: none;' : '';
	$display_annual_select     = 'year' !== $chosen_period ? 'display: none;' : '';

	if ( is_array( $chosen_payment_sync_date ) ) {
		$payment_day   = absint( $chosen_payment_sync_date[ 'day' ] );
		$payment_month = 0 === $payment_day ? 0 : $chosen_payment_sync_date[ 'month' ];
	} else {
		$payment_day   = $chosen_payment_sync_date;
		$payment_month = 0;
	}
}
?>
<div id="predefined_plan_data" class="panel woocommerce_options_panel">
	<div class="options_group subscription_pricing">

		<?php
		// Subscription Discount %
		woocommerce_wp_text_input(
				array(
					'id'          => '_subscription_discount',
					'name'        => '_plan[predefined][subscription_discount]',
					'class'       => 'wc_input_subscription_discount wc_input_price short',
					'label'       => __( 'Subscription discount %', 'subscribe-and-save-for-woocommerce-subscriptions' ),
					'placeholder' => __( 'e.g. 5', 'subscribe-and-save-for-woocommerce-subscriptions' ),
					'description' => __( 'Discount to be applied on the regular/sale price of the product.', 'subscribe-and-save-for-woocommerce-subscriptions' ),
					'desc_tip'    => true,
					'type'        => 'text',
					'value'       => $chosen_discount,
				)
		);
		?>

		<p class="form-field _subscription_interval_fields _subscription_interval_field">
			<label for="_subscription_interval"><?php esc_html_e( 'Subscription interval', 'subscribe-and-save-for-woocommerce-subscriptions' ); ?></label>
			<span class="wrap">
				<label for="_subscription_period_interval" class="wcs_hidden_label"><?php esc_html_e( 'Subscription interval', 'subscribe-and-save-for-woocommerce-subscriptions' ); ?></label>
				<select id="_subscription_period_interval" name="_plan[predefined][subscription_period_interval]" class="wc_input_subscription_period_interval">
					<?php foreach ( wcs_get_subscription_period_interval_strings() as $value => $label ) { ?>
						<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $value, $chosen_interval, true ); ?>><?php echo esc_html( $label ); ?></option>
					<?php } ?>
				</select>
				<label for="_subscription_period" class="wcs_hidden_label"><?php esc_html_e( 'Subscription period', 'subscribe-and-save-for-woocommerce-subscriptions' ); ?></label>
				<select id="_subscription_period" name="_plan[predefined][subscription_period]" class="wc_input_subscription_period last" >
					<?php foreach ( wcs_get_subscription_period_strings() as $value => $label ) { ?>
						<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $value, $chosen_period, true ); ?>><?php echo esc_html( $label ); ?></option>
					<?php } ?>
				</select>
			</span>
			<?php echo wp_kses_post( wcs_help_tip( __( 'Choose the subscription billing interval and period.', 'subscribe-and-save-for-woocommerce-subscriptions' ) ) ); ?>
		</p>

		<?php
		// Subscription Length
		woocommerce_wp_select(
				array(
					'id'          => '_subscription_length',
					'name'        => '_plan[predefined][subscription_length]',
					'class'       => 'wc_input_subscription_length select short',
					'label'       => __( 'Stop renewing after', 'subscribe-and-save-for-woocommerce-subscriptions' ),
					'options'     => wcs_get_subscription_ranges( $chosen_period ),
					'desc_tip'    => true,
					'description' => __( 'Automatically expire the subscription after this length of time. This length is in addition to any free trial or amount of time provided before a synchronised first renewal date.', 'subscribe-and-save-for-woocommerce-subscriptions' ),
					'value'       => $chosen_length,
				)
		);

		// Sign-up Fee
		woocommerce_wp_text_input(
				array(
					'id'                => '_subscription_sign_up_fee',
					'name'              => '_plan[predefined][subscription_sign_up_fee]',
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
				<input type="text" id="_subscription_trial_length" name="_plan[predefined][subscription_trial_length]" class="wc_input_subscription_trial_length" value="<?php echo esc_attr( $chosen_trial_length ); ?>" />
				<label for="_subscription_trial_period" class="wcs_hidden_label"><?php esc_html_e( 'Subscription Trial Period', 'subscribe-and-save-for-woocommerce-subscriptions' ); ?></label>
				<select id="_subscription_trial_period" name="_plan[predefined][subscription_trial_period]" class="wc_input_subscription_trial_period last" >
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

		<?php if ( WC_Subscriptions_Synchroniser::is_syncing_enabled() ) { ?>
			<div class="subscription_sync_week_month" style="<?php echo esc_attr( $display_week_month_select ); ?>">
				<?php
				woocommerce_wp_select(
						array(
							'id'          => '_subscription_payment_sync_date',
							'name'        => '_plan[predefined][subscription_payment_sync_date]',
							'class'       => 'wc_input_subscription_payment_sync select short',
							'label'       => __( 'Synchronise renewals', 'subscribe-and-save-for-woocommerce-subscriptions' ),
							'options'     => WC_Subscriptions_Synchroniser::get_billing_period_ranges( $chosen_period ),
							'description' => __( 'Align the payment date for all customers who purchase this subscription to a specific day of the week or month.', 'subscribe-and-save-for-woocommerce-subscriptions' ),
							'desc_tip'    => true,
							'value'       => $chosen_payment_sync_date,
						)
				);
				?>
			</div>

			<div class="subscription_sync_annual" style="<?php echo esc_attr( $display_annual_select ); ?>">
				<p class="form-field _subscription_payment_sync_date_day_field">
					<label for="_subscription_payment_sync_date_day"><?php esc_html_e( 'Synchronise renewals', 'subscribe-and-save-for-woocommerce-subscriptions' ); ?></label>
					<span class="wrap">

						<label for="_subscription_payment_sync_date_month" class="wcs_hidden_label"><?php esc_html_e( 'Month for Synchronisation', 'subscribe-and-save-for-woocommerce-subscriptions' ); ?></label>
						<select id="_subscription_payment_sync_date_month" name="_plan[predefined][subscription_payment_sync_date_month]" class="wc_input_subscription_payment_sync short" >
							<?php foreach ( WC_Subscriptions_Synchroniser::get_year_sync_options() as $value => $label ) { ?>
								<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $value, $payment_month, true ); ?>><?php echo esc_html( $label ); ?></option>
							<?php } ?>
						</select>

						<?php $daysInMonth = $payment_month ? gmdate( 't', wc_string_to_timestamp( "2001-{$payment_month}-01" ) ) : 0; ?>
						<input type="number" id="_subscription_payment_sync_date_day" name="_plan[predefined][subscription_payment_sync_date_day]" class="wc_input_subscription_payment_sync last" value="<?php echo esc_attr( $payment_day ); ?>" placeholder="<?php echo esc_attr_x( 'Day', 'input field placeholder for day field for annual subscriptions', 'subscribe-and-save-for-woocommerce-subscriptions' ); ?>" step="1" min="<?php echo esc_attr( min( 1, $daysInMonth ) ); ?>" max="<?php echo esc_attr( $daysInMonth ); ?>" <?php disabled( 0, $payment_month, true ); ?> />
					</span>
					<?php
					// translators: placeholder is a year (e.g. "2016")
					echo wp_kses_post( wcs_help_tip( sprintf( _x( 'Align the payment date for this subscription to a specific day of the year. If the date has already taken place this year, the first payment will be processed in %s. Set the day to 0 to disable payment syncing for this product.', 'used in subscription product edit screen', 'subscribe-and-save-for-woocommerce-subscriptions' ), gmdate( 'Y', wcs_date_to_time( '+1 year' ) ) ) ) );
					?>
				</p>
			</div>
		<?php } ?>
	</div>

	<?php
	/**
	 * Pre defined data.
	 * 
	 * @since 1.0.0
	 */
	do_action( 'asp_ssws_plan_options_predefined_data' );
	?>
</div>
