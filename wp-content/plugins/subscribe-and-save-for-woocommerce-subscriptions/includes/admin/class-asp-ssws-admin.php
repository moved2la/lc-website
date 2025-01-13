<?php
defined( 'ABSPATH' ) || exit;

/**
 * Buy Now or Subscribe and Save for WooCommerce Subscriptions Admin.
 * 
 * @class ASP_SSWS_Admin
 * @package Class
 */
class ASP_SSWS_Admin {

	/**
	 * Success messages.
	 *
	 * @var array
	 */
	protected static $success_messages = array();

	/**
	 * Error messages.
	 *
	 * @var array
	 */
	protected static $error_messages = array();

	/**
	 * Init ASP_SSWS_Admin.
	 */
	public static function init() {
		add_action( 'all_admin_notices', __CLASS__ . '::render_tabs', 5 );
		add_filter( 'woocommerce_subscription_settings', __CLASS__ . '::subscription_settings', 99 );
		add_filter( 'woocommerce_subscriptions_allow_switching_options', __CLASS__ . '::switching_settings' );

		ASP_SSWS_Admin_Post_Types::init();
	}

	/**
	 * Get our screen ids.
	 *
	 * @return array
	 */
	public static function get_screen_ids() {
		$screen_ids = array(
			'asp_prod_subs_rule',
			'asp_cart_subs_rule',
			'asp_subscribe_plan',
			'edit-asp_prod_subs_rule',
			'edit-asp_cart_subs_rule',
			'edit-asp_subscribe_plan',
		);

		/**
		 * Get admin screen ids.
		 * 
		 * @since 1.0.0
		 */
		return apply_filters( 'asp_ssws_screen_ids', $screen_ids );
	}

	/**
	 * Check the screen against the which context.
	 * 
	 * @param string $screen_id
	 * @param string $which
	 * @return bool
	 */
	public static function is_screen( $screen_id, $which = 'any' ) {
		if ( in_array( $screen_id, self::get_screen_ids(), true ) ) {
			if ( is_array( $which ) ) {
				return in_array( $screen_id, $which );
			} else if ( 'any' !== $which ) {
				return ( $screen_id === $which );
			} else {
				return true;
			}
		}

		return false;
	}

	/**
	 * Get WC search field
	 * 
	 * @param array $args
	 * @param bool $echo
	 * @return string echo search field
	 */
	public static function search_field( $args = array(), $echo = true ) {
		$args = wp_parse_args( $args, array(
			'class'             => '',
			'id'                => '',
			'name'              => '',
			'type'              => '',
			'action'            => '',
			'placeholder'       => '',
			'css'               => '',
			'multiple'          => true,
			'allow_clear'       => true,
			'selected'          => true,
			'limit'             => '-1',
			'include'           => array(),
			'exclude'           => array(),
			'options'           => array(),
			'custom_attributes' => array(),
				) );

		// Custom attribute handling.
		$custom_attributes = array();
		if ( ! empty( $args[ 'custom_attributes' ] ) && is_array( $args[ 'custom_attributes' ] ) ) {
			foreach ( $args[ 'custom_attributes' ] as $attribute => $attribute_value ) {
				$custom_attributes[] = esc_attr( $attribute ) . '="' . esc_attr( $attribute_value ) . '"';
			}
		}

		ob_start();
		?>
		<select 
			id="<?php echo esc_attr( $args[ 'id' ] ); ?>" 
			class="<?php echo esc_attr( $args[ 'class' ] ); ?>" 
			name="<?php echo esc_attr( '' !== $args[ 'name' ] ? $args[ 'name' ] : $args[ 'id' ]  ); ?><?php echo ( $args[ 'multiple' ] ) ? '[]' : ''; ?>" 
			data-action="<?php echo esc_attr( $args[ 'action' ] ); ?>" 
			data-placeholder="<?php echo esc_attr( $args[ 'placeholder' ] ); ?>" 
			data-limit="<?php echo esc_attr( $args[ 'limit' ] ); ?>" 
			data-include="<?php echo wc_esc_json( wp_json_encode( $args[ 'include' ] ) ); ?>" 
			data-exclude="<?php echo wc_esc_json( wp_json_encode( $args[ 'exclude' ] ) ); ?>" 
			<?php echo ( $args[ 'allow_clear' ] ) ? 'data-allow_clear="true"' : ''; ?> 
			<?php echo ( $args[ 'multiple' ] ) ? 'multiple="multiple"' : ''; ?> 
			<?php echo wp_kses_post( implode( ' ', $custom_attributes ) ); ?>
			style="<?php echo esc_attr( $args[ 'css' ] ); ?>">
				<?php
				if ( ! is_array( $args[ 'options' ] ) ) {
					$args[ 'options' ] = ( array ) $args[ 'options' ];
				}

				$args[ 'options' ] = array_filter( $args[ 'options' ] );
				foreach ( $args[ 'options' ] as $id ) {
					$option_value = '';

					switch ( $args[ 'type' ] ) {
						case 'product':
							$product = wc_get_product( $id );
							if ( $product ) {
								$option_value = wp_kses_post( $product->get_formatted_name() );
							}
							break;
						case 'customer':
							$user = get_user_by( 'id', $id );
							if ( $user ) {
								$option_value = ( esc_html( $user->display_name ) . '(#' . absint( $user->ID ) . ' &ndash; ' . esc_html( $user->user_email ) . ')' );
							}
							break;
						default:
							$post = get_post( $id );
							if ( $post ) {
								$option_value = sprintf( '(#%s) %s', $post->ID, wp_kses_post( $post->post_title ) );
							}
							break;
					}

					if ( $option_value ) {
						?>
					<option value="<?php echo esc_attr( $id ); ?>" <?php echo ( $args[ 'selected' ] ) ? 'selected="selected"' : ''; ?>><?php echo wp_kses_post( $option_value ); ?></option>
						<?php
					}
				}
				?>
		</select>
		<?php
		if ( $echo ) {
			ob_end_flush();
		} else {
			return ob_get_clean();
		}
	}

	/**
	 * Return the array of categories for the products.
	 * 
	 * @param  array $args
	 * @return array
	 */
	public static function get_product_terms( $args = array() ) {
		$categories = array();
		$args       = wp_parse_args( $args, array( 'taxonomy' => 'product_cat', 'orderby' => 'name' ) );
		$terms      = get_terms( $args );

		if ( is_array( $terms ) ) {
			foreach ( $terms as $term ) {
				$categories[ $term->term_id ] = $term->name;
			}
		}

		return $categories;
	}

	/**
	 * Get WP User roles
	 * 
	 * @return array
	 */
	public static function get_user_roles() {
		global $wp_roles;

		$user_roles = array();
		foreach ( $wp_roles->roles as $user_role_key => $user_role ) {
			$user_roles[ $user_role_key ] = $user_role[ 'name' ];
		}

		$user_roles[ 'guest' ] = 'Guest';
		return $user_roles;
	}

	/**
	 * Add an success message.
	 *
	 * @param string $text Success to add.
	 */
	public static function add_success( $text ) {
		self::$success_messages[] = $text;
	}

	/**
	 * Add an error message.
	 *
	 * @param string $text Error to add.
	 */
	public static function add_error( $text ) {
		self::$error_messages[] = $text;
	}

	/**
	 * Display a notice message.
	 * 
	 * @param string $text Notice to display.
	 */
	public static function print_notice( $text ) {
		if ( ! empty( $text ) ) {
			echo '<div class="asp-ssws-notice">';
			echo '<p>' . wp_kses_post( $text ) . '</p>';
			echo '</div>';
		}
	}

	/**
	 * Renders tabs on our custom post types pages.
	 */
	public static function render_tabs() {
		$current_screen = get_current_screen();
		if ( ! $current_screen || ! self::is_screen( $current_screen->id ) ) {
			return;
		}

		/**
		 * Get the admin tabs.
		 * 
		 * @since 1.0.0
		 */
		$tabs = apply_filters( 'asp_ssws_admin_tabs', array(
			'subscribe_plans' => array(
				'title' => __( 'Plans', 'subscribe-and-save-for-woocommerce-subscriptions' ),
				'url'   => admin_url( 'edit.php?post_type=asp_subscribe_plan' ),
			),
			'rules'           => array(
				'title'    => __( 'Rules', 'subscribe-and-save-for-woocommerce-subscriptions' ),
				'url'      => admin_url( 'edit.php?post_type=asp_prod_subs_rule' ),
				'sections' => array(
					'product_subscribe_rule' => array(
						'label' => __( 'Product Subscribe Rules', 'subscribe-and-save-for-woocommerce-subscriptions' ),
						'url'   => admin_url( 'edit.php?post_type=asp_prod_subs_rule' ),
					),
					'cart_subscribe_rule'    => array(
						'label' => __( 'Cart Subscribe Rules', 'subscribe-and-save-for-woocommerce-subscriptions' ),
						'url'   => admin_url( 'edit.php?post_type=asp_cart_subs_rule' ),
					),
				),
			),
				) );

		if ( self::is_screen( $current_screen->id, array( 'asp_prod_subs_rule', 'asp_cart_subs_rule', 'edit-asp_prod_subs_rule', 'edit-asp_cart_subs_rule' ) ) ) {
			$current_tab = 'rules';
		} else {
			$current_tab = 'subscribe_plans';
		}

		if ( ! empty( $tabs ) ) {
			$current_section = '';

			if ( 'rules' === $current_tab ) {
				if ( self::is_screen( $current_screen->id, array( 'asp_cart_subs_rule', 'edit-asp_cart_subs_rule' ) ) ) {
					$current_section = 'cart_subscribe_rule';
				} else {
					$current_section = 'product_subscribe_rule';
				}
			}
			?>
			<div class="wrap woocommerce">
				<nav class="nav-tab-wrapper woo-nav-tab-wrapper">
					<?php foreach ( $tabs as $tab_id => $tab ) : ?>
						<?php $class = $tab_id === $current_tab ? array( 'nav-tab', 'nav-tab-active' ) : array( 'nav-tab' ); ?>
						<?php printf( '<a href="%1$s" class="%2$s">%3$s</a>', esc_url( $tab[ 'url' ] ), implode( ' ', array_map( 'sanitize_html_class', $class ) ), esc_html( $tab[ 'title' ] ) ); ?>
					<?php endforeach; ?>
				</nav>

				<?php if ( ! empty( $current_section ) ) : ?>
					<ul class="subsubsub asp-ssws-sub-sections">
						<?php foreach ( $tabs as $tab_id => $tab ) : ?>
							<?php if ( ! empty( $tab[ 'sections' ] ) ) : ?>
								<?php
								$array_keys = array_keys( $tab[ 'sections' ] );
								foreach ( $tab[ 'sections' ] as $section_id => $args ) {
									echo '<li><a href="' . esc_url( $args[ 'url' ] ) . '" class="' . ( $current_section === $section_id ? 'current' : '' ) . '">' . esc_html( $args[ 'label' ] ) . '</a> ' . ( end( $array_keys ) === $section_id ? '' : '|' ) . ' </li>';
								}
								?>
							<?php endif; ?>
						<?php endforeach; ?>
					</ul>
					<br class="clear">
				<?php endif; ?>
			</div>
			<?php
		}
	}

	/**
	 * Return the array of our settings to WC Subscriptions.
	 * 
	 * @param array $settings
	 * @return array
	 */
	public static function subscription_settings( $settings ) {
		$misc_section_start = wp_list_filter( $settings, array( 'id' => 'woocommerce_subscriptions_miscellaneous', 'type' => 'title' ) );
		array_splice( $settings, key( $misc_section_start ), 0, array(
			array( 'type' => 'title', 'id' => 'asp_ssws_subscribe_and_save_landing', 'desc' => ' ' ),
			array( 'type' => 'sectionend', 'id' => 'asp_ssws_subscribe_and_save_landing' ),
			array(
				'name' => _x( 'Subscribe & Save', 'options section heading', 'subscribe-and-save-for-woocommerce-subscriptions' ),
				'type' => 'title',
				'id'   => 'asp_ssws_subscribe_and_save',
				'desc' => __( 'Allow your existing products to purchase as a subscription along with discounts to your customers.', 'subscribe-and-save-for-woocommerce-subscriptions' ),
			),
			array(
				'name'     => __( 'Allow Product Subscribe', 'subscribe-and-save-for-woocommerce-subscriptions' ),
				'id'       => 'asp_ssws_allow_product_subscribe',
				'default'  => 'no',
				'type'     => 'select',
				'options'  => array(
					'yes-optional' => __( 'Yes, subscribe is optional', 'subscribe-and-save-for-woocommerce-subscriptions' ),
					'yes-forced'   => __( 'Yes, subscribe is mandatory', 'subscribe-and-save-for-woocommerce-subscriptions' ),
					'no'           => __( 'No', 'subscribe-and-save-for-woocommerce-subscriptions' ),
				),
				'desc_tip' => __( 'Allow customers to subscribe for the product.', 'subscribe-and-save-for-woocommerce-subscriptions' ),
				'desc'     => sprintf( '<a href="%1$s" class="button-small" target="_blank"><b>%2$s</b></a>', admin_url( 'edit.php?post_type=asp_prod_subs_rule' ), __( 'Create or Edit Product Subscribe Rule&rarr;', 'subscribe-and-save-for-woocommerce-subscriptions' ) ),
			),
			array(
				'name'    => __( 'Default Product Subscribe Selection', 'subscribe-and-save-for-woocommerce-subscriptions' ),
				'id'      => 'asp_ssws_product_subscribe_default_value',
				'default' => 'one-time',
				'type'    => 'select',
				'options' => array(
					'one-time'  => __( 'One-time purchase', 'subscribe-and-save-for-woocommerce-subscriptions' ),
					'subscribe' => __( 'Subscribe & Save', 'subscribe-and-save-for-woocommerce-subscriptions' ),
				),
			),
			array(
				'name'     => __( 'Allow Cart Subscribe', 'subscribe-and-save-for-woocommerce-subscriptions' ),
				'id'       => 'asp_ssws_allow_cart_subscribe',
				'default'  => 'no',
				'type'     => 'select',
				'options'  => array(
					'yes-optional' => __( 'Yes, subscribe is optional', 'subscribe-and-save-for-woocommerce-subscriptions' ),
					'yes-forced'   => __( 'Yes, subscribe is mandatory', 'subscribe-and-save-for-woocommerce-subscriptions' ),
					'no'           => __( 'No', 'subscribe-and-save-for-woocommerce-subscriptions' ),
				),
				'desc_tip' => __( 'Allow customers to subscribe for the whole cart items as a single subscription.', 'subscribe-and-save-for-woocommerce-subscriptions' ),
				'desc'     => sprintf( '<a href="%1$s" class="button-small" target="_blank"><b>%2$s</b></a>', admin_url( 'edit.php?post_type=asp_cart_subs_rule' ), __( 'Create or Edit Cart Subscribe Rule&rarr;', 'subscribe-and-save-for-woocommerce-subscriptions' ) ),
			),
			array(
				'name'    => __( 'Default Cart Subscribe Selection', 'subscribe-and-save-for-woocommerce-subscriptions' ),
				'id'      => 'asp_ssws_cart_subscribe_default_value',
				'default' => 'one-time',
				'type'    => 'select',
				'options' => array(
					'one-time'  => __( 'One-time purchase', 'subscribe-and-save-for-woocommerce-subscriptions' ),
					'subscribe' => __( 'Subscribe & Save', 'subscribe-and-save-for-woocommerce-subscriptions' ),
				),
			),
			array( 'type' => 'sectionend', 'id' => 'asp_ssws_subscribe_and_save' ),
			array(
				'name' => _x( 'Subscribe & Save Miscellaneous', 'options section heading', 'subscribe-and-save-for-woocommerce-subscriptions' ),
				'type' => 'title',
				'id'   => 'asp_ssws_subscribe_and_save_miscellaneous',
			),
			array(
				'name'    => __( 'Subscribe Now in Shop Page', 'subscribe-and-save-for-woocommerce-subscriptions' ),
				'id'      => 'asp_ssws_show_subscribe_now_option',
				'default' => 'yes',
				'type'    => 'checkbox',
				'desc'    => __( 'If enabled, the subscribe now link will be visible only for simple products on archives.', 'subscribe-and-save-for-woocommerce-subscriptions' ),
			),
			array( 'type' => 'sectionend', 'id' => 'asp_ssws_subscribe_and_save_miscellaneous' ),
			array(
				'name' => _x( 'Subscribe & Save Labels', 'options section heading', 'subscribe-and-save-for-woocommerce-subscriptions' ),
				'type' => 'title',
				'id'   => 'asp_ssws_subscribe_and_save_labels',
			),
			array(
				'name'    => __( 'One-time Purchase Option Label', 'subscribe-and-save-for-woocommerce-subscriptions' ),
				'id'      => 'asp_ssws_one_time_purchase_option_label',
				'default' => 'One-time purchase',
				'type'    => 'text',
			),
			array(
				'name'    => __( 'Subscribe & Save Option Label', 'subscribe-and-save-for-woocommerce-subscriptions' ),
				'id'      => 'asp_ssws_subscribe_option_label',
				'default' => 'Subscribe & Save',
				'type'    => 'text',
			),
			array(
				'name'    => __( 'Subscribe Now Label', 'subscribe-and-save-for-woocommerce-subscriptions' ),
				'id'      => 'asp_ssws_subscribe_now_label',
				'default' => 'Subscribe now',
				'type'    => 'text',
			),
			array(
				'name'    => __( 'Billing Plan Label', 'subscribe-and-save-for-woocommerce-subscriptions' ),
				'id'      => 'asp_ssws_subscribe_plan_label',
				'default' => 'Billing plan',
				'type'    => 'text',
			),
			array(
				'name'    => __( 'Billing Discount Label', 'subscribe-and-save-for-woocommerce-subscriptions' ),
				'id'      => 'asp_ssws_subscribe_discount_label',
				'default' => 'Save {subscribe_discount}%',
				'type'    => 'text',
			),
			array(
				'name'    => __( 'Billing Interval Label', 'subscribe-and-save-for-woocommerce-subscriptions' ),
				'id'      => 'asp_ssws_subscribe_interval_label',
				'default' => 'Billing interval',
				'type'    => 'text',
			),
			array(
				'name'    => __( 'Billing Period Label', 'subscribe-and-save-for-woocommerce-subscriptions' ),
				'id'      => 'asp_ssws_subscribe_period_label',
				'default' => 'Billing period',
				'type'    => 'text',
			),
			array(
				'name'    => __( 'Billing Expiration Label', 'subscribe-and-save-for-woocommerce-subscriptions' ),
				'id'      => 'asp_ssws_subscribe_expiration_label',
				'default' => 'Billing expiration',
				'type'    => 'text',
			),
			array( 'type' => 'sectionend', 'id' => 'asp_ssws_subscribe_and_save_labels' ),
		) );

		return $settings;
	}

	/**
	 * Add switching option for subscribe plans.
	 * 
	 * @param array $data
	 * @return array
	 */
	public static function switching_settings( $data ) {
		return array_merge( $data, array(
			array(
				'id'    => 'asp_ssws_subscribe_plans',
				'label' => __( 'Between Subscribe Plans', 'subscribe-and-save-for-woocommerce-subscriptions' ),
			),
				) );
	}
}
