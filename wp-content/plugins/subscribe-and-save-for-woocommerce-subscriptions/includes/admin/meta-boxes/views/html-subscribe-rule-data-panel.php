<?php
defined( 'ABSPATH' ) || exit;
?>
<div class="panel-wrap asp-ssws-rule-data-panel-wrap">       
	<ul class="asp_ssws_subscribe_rule_data_tabs wc-tabs">
		<?php foreach ( self::get_rule_data_tabs() as $key => $_tab ) : ?>
			<li class="<?php echo esc_attr( $key ); ?>_options <?php echo esc_attr( $key ); ?>_tab <?php echo esc_attr( isset( $_tab[ 'class' ] ) ? implode( ' ', ( array ) $_tab[ 'class' ] ) : ''  ); ?>">
				<a href="#<?php echo esc_attr( $_tab[ 'target' ] ); ?>"><span><?php echo esc_html( $_tab[ 'label' ] ); ?></span></a>
			</li>
		<?php endforeach; ?>
		<?php
		/**
		 * Rule data tabs.
		 * 
		 * @since 1.0.0
		 */
		do_action( 'asp_ssws_subscribe_rule_data_panel_tabs' );
		?>
	</ul>
	<?php
	self::output_tabs();

	/**
	 * Rule data tab content.
	 * 
	 * @since 1.0.0
	 */
	do_action( 'asp_ssws_subscribe_rule_data_panels' );
	?>
</div>
<div class="clear"></div>
