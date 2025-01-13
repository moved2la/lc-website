<?php
defined( 'ABSPATH' ) || exit;

/**
 * Before rule criteria tab.
 * 
 * @since 1.0.0
 */
do_action( 'asp_ssws_admin_before_subscribe_rule_data_criteria', $subscribe_rule );

$product_cats = ASP_SSWS_Admin::get_product_terms( array( 'taxonomy' => 'product_cat' ) );
$user_roles   = ASP_SSWS_Admin::get_user_roles();
?>
<div id="criteria_rule_data" class="panel woocommerce_options_panel">
	<div class="options_group">

		<?php if ( 'asp_prod_subs_rule' === $subscribe_rule->get_type() ) : ?>

			<p class="asp-ssws-form-field _criteria_product_filter_field">
				<label for="_criteria_product_filter">
					<?php esc_html_e( 'Product Filter', 'subscribe-and-save-for-woocommerce-subscriptions' ); ?>
				</label>
				<select id="_criteria_product_filter" name="_criteria_product_filter">
					<option value="all-products" <?php selected( 'all-products', $subscribe_rule->get_criteria_product_filter(), true ); ?>><?php esc_html_e( 'All products', 'subscribe-and-save-for-woocommerce-subscriptions' ); ?></option>
					<option value="included-products" <?php selected( 'included-products', $subscribe_rule->get_criteria_product_filter(), true ); ?>><?php esc_html_e( 'Include products', 'subscribe-and-save-for-woocommerce-subscriptions' ); ?></option>		
					<option value="excluded-products" <?php selected( 'excluded-products', $subscribe_rule->get_criteria_product_filter(), true ); ?>><?php esc_html_e( 'Exclude products', 'subscribe-and-save-for-woocommerce-subscriptions' ); ?></option>		
					<option value="included-product-cats" <?php selected( 'included-product-cats', $subscribe_rule->get_criteria_product_filter(), true ); ?>><?php esc_html_e( 'Include categories', 'subscribe-and-save-for-woocommerce-subscriptions' ); ?></option>
					<option value="excluded-product-cats" <?php selected( 'excluded-product-cats', $subscribe_rule->get_criteria_product_filter(), true ); ?>><?php esc_html_e( 'Exclude categories', 'subscribe-and-save-for-woocommerce-subscriptions' ); ?></option>	
				</select>
			</p>

			<p class="asp-ssws-form-field _criteria_products_field">
				<label for="_criteria_products">
					<?php esc_html_e( 'Select Products', 'subscribe-and-save-for-woocommerce-subscriptions' ); ?>
				</label>
				<?php
				ASP_SSWS_Admin::search_field( array(
					'class'       => 'wc-product-search',
					'id'          => '_criteria_products',
					'type'        => 'product',
					'multiple'    => true,
					'action'      => 'asp_ssws_json_search_products_and_variations',
					'placeholder' => __( 'Search for a product&hellip;', 'subscribe-and-save-for-woocommerce-subscriptions' ),
					'options'     => $subscribe_rule->get_criteria_products(),
				) );
				?>
			</p>

			<p class="asp-ssws-form-field _criteria_product_cats_field">
				<label for="_criteria_product_cats">
					<?php esc_html_e( 'Select Product Categories', 'subscribe-and-save-for-woocommerce-subscriptions' ); ?>
				</label>
				<select name="_criteria_product_cats[]" multiple="multiple" class="wc-enhanced-select">
					<?php foreach ( $product_cats as $key => $val ) : ?>
						<?php if ( is_array( $val ) ) : ?>
							<optgroup label="<?php echo esc_attr( $key ); ?>">
								<?php foreach ( $val as $option_key_inner => $option_value_inner ) : ?>
									<option value="<?php echo esc_attr( $option_key_inner ); ?>" <?php selected( in_array( ( string ) $option_key_inner, $subscribe_rule->get_criteria_product_cats(), true ), true ); ?>><?php echo esc_html( $option_value_inner ); ?></option>
								<?php endforeach; ?>
							</optgroup>
						<?php else : ?>
							<option value="<?php echo esc_attr( $key ); ?>" <?php selected( in_array( $key, $subscribe_rule->get_criteria_product_cats() ), true, true ); ?>><?php echo esc_html( $val ); ?></option>
						<?php endif; ?>
					<?php endforeach; ?>
				</select>
			</p>

		<?php endif; ?>

		<p class="asp-ssws-form-field _criteria_user_filter_field">
			<label for="_criteria_user_filter"><?php esc_html_e( 'User Filter', 'subscribe-and-save-for-woocommerce-subscriptions' ); ?></label>
			<select id="_criteria_user_filter" name="_criteria_user_filter">
				<option value="all-users" <?php selected( 'all-users', $subscribe_rule->get_criteria_user_filter(), true ); ?>><?php esc_html_e( 'All users', 'subscribe-and-save-for-woocommerce-subscriptions' ); ?></option>
				<option value="included-users" <?php selected( 'included-users', $subscribe_rule->get_criteria_user_filter(), true ); ?>><?php esc_html_e( 'Include users', 'subscribe-and-save-for-woocommerce-subscriptions' ); ?></option>		
				<option value="excluded-users" <?php selected( 'excluded-users', $subscribe_rule->get_criteria_user_filter(), true ); ?>><?php esc_html_e( 'Exclude users', 'subscribe-and-save-for-woocommerce-subscriptions' ); ?></option>		
				<option value="included-user-roles" <?php selected( 'included-user-roles', $subscribe_rule->get_criteria_user_filter(), true ); ?>><?php esc_html_e( 'Include user roles', 'subscribe-and-save-for-woocommerce-subscriptions' ); ?></option>
				<option value="excluded-user-roles" <?php selected( 'excluded-user-roles', $subscribe_rule->get_criteria_user_filter(), true ); ?>><?php esc_html_e( 'Exclude user roles', 'subscribe-and-save-for-woocommerce-subscriptions' ); ?></option>	
			</select>
		</p>

		<p class="asp-ssws-form-field _criteria_users_field">
			<label for="_criteria_users">
				<?php esc_html_e( 'Select Users', 'subscribe-and-save-for-woocommerce-subscriptions' ); ?>
			</label>
			<?php
			ASP_SSWS_Admin::search_field( array(
				'class'       => 'wc-customer-search',
				'id'          => '_criteria_users',
				'type'        => 'customer',
				'multiple'    => true,
				'placeholder' => __( 'Search for a user&hellip;', 'subscribe-and-save-for-woocommerce-subscriptions' ),
				'options'     => $subscribe_rule->get_criteria_users(),
			) );
			?>
		</p>

		<p class="asp-ssws-form-field _criteria_user_roles_field">
			<label for="_criteria_user_roles">
				<?php esc_html_e( 'Select User Roles', 'subscribe-and-save-for-woocommerce-subscriptions' ); ?>
			</label>
			<select name="_criteria_user_roles[]" multiple="multiple" class="wc-enhanced-select">
				<?php foreach ( $user_roles as $key => $val ) : ?>
					<?php if ( is_array( $val ) ) : ?>
						<optgroup label="<?php echo esc_attr( $key ); ?>">
							<?php foreach ( $val as $option_key_inner => $option_value_inner ) : ?>
								<option value="<?php echo esc_attr( $option_key_inner ); ?>" <?php selected( in_array( ( string ) $option_key_inner, $subscribe_rule->get_criteria_user_roles(), true ), true ); ?>><?php echo esc_html( $option_value_inner ); ?></option>
							<?php endforeach; ?>
						</optgroup>
					<?php else : ?>
						<option value="<?php echo esc_attr( $key ); ?>" <?php selected( in_array( $key, $subscribe_rule->get_criteria_user_roles() ), true, true ); ?>><?php echo esc_html( $val ); ?></option>
					<?php endif; ?>
				<?php endforeach; ?>
			</select>
		</p>

		<?php if ( 'asp_cart_subs_rule' === $subscribe_rule->get_type() ) : ?>

			<p class="asp-ssws-form-field _criteria_min_subtotal_field">
				<label for="_criteria_min_subtotal">
					<?php esc_html_e( 'Minimum Subtotal', 'subscribe-and-save-for-woocommerce-subscriptions' ); ?>
				</label>

				<input type="text" class="wc_input_price" id="_criteria_min_subtotal" name="_criteria_min_subtotal" value="<?php echo esc_attr( $subscribe_rule->get_criteria_min_subtotal() ); ?>"/>
			</p>

			<p class="asp-ssws-form-field _criteria_max_subtotal_field">
				<label for="_criteria_max_subtotal">
					<?php esc_html_e( 'Maximum Subtotal', 'subscribe-and-save-for-woocommerce-subscriptions' ); ?>
				</label>

				<input type="text" class="wc_input_price" id="_criteria_max_subtotal" name="_criteria_max_subtotal" value="<?php echo esc_attr( $subscribe_rule->get_criteria_max_subtotal() ); ?>"/>
			</p>

		<?php endif; ?>
	</div>
</div>
<?php
/**
 * After rule criteria tab.
 * 
 * @since 1.0.0
 */
do_action( 'asp_ssws_admin_after_subscribe_rule_data_criteria', $subscribe_rule );
