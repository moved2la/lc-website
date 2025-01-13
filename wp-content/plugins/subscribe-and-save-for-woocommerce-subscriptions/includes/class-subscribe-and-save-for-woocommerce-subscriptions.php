<?php

defined( 'ABSPATH' ) || exit;

require_once __DIR__ . '/vendor/asp-ssws-external-functions.php';
require_once __DIR__ . '/class-asp-ssws-autoloader.php';

/**
 * Main Buy Now or Subscribe and Save for WooCommerce Subscriptions Class.
 *
 * @class ASP_Subscribe_And_Save_For_Woocommerce_Subscriptions
 */
final class ASP_Subscribe_And_Save_For_Woocommerce_Subscriptions {

	/**
	 * The plugin's autoloader instance.
	 *
	 * @var ASP_SSWS_Autoloader
	 */
	protected $autoloader = null;

	/**
	 * The single instance of the class.
	 */
	protected static $instance = null;

	/**
	 * ASP_Subscribe_And_Save_For_Woocommerce_Subscriptions constructor.
	 */
	public function __construct() {
		$this->autoloader = new ASP_SSWS_Autoloader( dirname( __DIR__ ) );
		$this->autoloader->register();

		$this->includes();
		$this->init();
		$this->init_hooks();

		/**
		 * Plugin loaded.
		 * 
		 * @since 1.0.0
		 */
		do_action( 'asp_ssws_loaded' );
	}

	/**
	 * Cloning is forbidden.
	 */
	public function __clone() {
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Cloning is forbidden.', 'subscribe-and-save-for-woocommerce-subscriptions' ), '1.0' );
	}

	/**
	 * Unserializing instances of this class is forbidden.
	 */
	public function __wakeup() {
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Unserializing instances of this class is forbidden.', 'subscribe-and-save-for-woocommerce-subscriptions' ), '1.0' );
	}

	/**
	 * Main ASP_Subscribe_And_Save_For_Woocommerce_Subscriptions Instance.
	 * Ensures only one instance of ASP_Subscribe_And_Save_For_Woocommerce_Subscriptions is loaded or can be loaded.
	 * 
	 * @return ASP_Subscribe_And_Save_For_Woocommerce_Subscriptions - Main instance.
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Get the plugin url.
	 *
	 * @return string
	 */
	public function plugin_url() {
		return untrailingslashit( plugins_url( '/', ASP_SSWS_PLUGIN_FILE ) );
	}

	/**
	 * Get the plugin path.
	 *
	 * @return string
	 */
	public function plugin_path() {
		return untrailingslashit( plugin_dir_path( ASP_SSWS_PLUGIN_FILE ) );
	}

	/**
	 * Get the template path.
	 *
	 * @return string
	 */
	public function template_path() {
		return trailingslashit( dirname( ASP_SSWS_PLUGIN_BASENAME ) );
	}

	/**
	 * Is frontend request ?
	 *
	 * @return bool
	 */
	public function is_frontend() {
		if ( function_exists( 'wcs_is_frontend_request' ) && function_exists( 'wcs_is_checkout_blocks_api_request' ) ) {
			return wcs_is_frontend_request() || wcs_is_checkout_blocks_api_request();
		} else if ( function_exists( 'wcs_is_frontend_request' ) ) {
			return wcs_is_frontend_request();
		}

		return ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' );
	}

	/**
	 * Load Localization files.
	 */
	public function load_plugin_textdomain() {
		if ( function_exists( 'determine_locale' ) ) {
			$locale = determine_locale();
		} else {
			$locale = is_admin() ? get_user_locale() : get_locale();
		}

		/**
		 * Get the plugin locale.
		 * 
		 * @since 1.0.0
		 */
		$locale = apply_filters( 'plugin_locale', $locale, 'subscribe-and-save-for-woocommerce-subscriptions' );

		unload_textdomain( 'subscribe-and-save-for-woocommerce-subscriptions', true );
		load_textdomain( 'subscribe-and-save-for-woocommerce-subscriptions', WP_LANG_DIR . '/subscribe-and-save-for-woocommerce-subscriptions/subscribe-and-save-for-woocommerce-subscriptions-' . $locale . '.mo' );
		load_plugin_textdomain( 'subscribe-and-save-for-woocommerce-subscriptions', false, dirname( ASP_SSWS_PLUGIN_BASENAME ) . '/languages' );
	}

	/**
	 * Includes required files.
	 */
	private function includes() {
		include_once 'asp-ssws-core-functions.php';
	}

	/**
	 * Initializes the plugin.
	 */
	private function init() {
		ASP_SSWS_Enqueues::init();
		ASP_SSWS_Ajax::init();
		ASP_SSWS_Blocks_Compatibility::init();

		if ( is_admin() ) {
			ASP_SSWS_Admin::init();
		}

		if ( $this->is_frontend() ) {
			ASP_SSWS_Product_Subscribe::instance();
			ASP_SSWS_Cart_Subscribe::instance();
			ASP_SSWS_Form_Handler::init();
		}
	}

	/**
	 * Hooks into actions and filters.
	 */
	private function init_hooks() {
		add_filter( 'plugin_action_links_' . ASP_SSWS_PLUGIN_BASENAME, array( $this, 'plugin_action_links' ) );
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );
		add_action( 'init', array( $this, 'register_post_types' ) );
		add_action( 'init', array( $this, 'register_post_statuses' ) );
		add_action( 'init', array( $this, 'other_plugin_support_includes' ), 20 );
		add_filter( 'woocommerce_data_stores', array( $this, 'add_data_stores' ) );

		add_action( 'woocommerce_checkout_create_subscription', array( $this, 'update_subscription_meta' ), 10, 4 );
		add_action( 'woocommerce_checkout_create_order_line_item', array( $this, 'update_subscription_item_meta' ), 10, 4 );
		add_action( 'woocommerce_subscriptions_switched_item', array( $this, 'subscriptions_switched' ), 10, 2 );
		add_filter( 'woocommerce_hidden_order_itemmeta', array( $this, 'hidden_subscription_itemmeta' ) );
	}

	/**
	 * Include classes for other plugins support.
	 */
	public function other_plugin_support_includes() {
		include_once 'compat/class-asp-ssws-compat-nyp.php';
		include_once 'compat/class-asp-ssws-compat-pao.php';

		if ( class_exists( 'WC_Name_Your_Price' ) ) {
			ASP_SSWS_Compat_NYP::init();
		}

		if ( class_exists( 'WC_Product_Addons' ) && defined( 'WC_PRODUCT_ADDONS_VERSION' ) && version_compare( WC_PRODUCT_ADDONS_VERSION, '6.7.0' ) >= 0 ) {
			ASP_SSWS_Compat_PAO::init();
		}
	}

	/*
	  |--------------------------------------------------------------------------
	  | Helper Methods
	  |--------------------------------------------------------------------------
	 */

	/**
	 * Show action links on the plugin screen.
	 *
	 * @param   mixed $links Plugin Action links
	 * @return  array
	 */
	public function plugin_action_links( $links ) {
		$setting_page_link = '<a  href="' . admin_url( 'admin.php?page=wc-settings&tab=subscriptions#asp_ssws_subscribe_and_save_landing-description' ) . '">' . esc_html__( 'Settings', 'subscribe-and-save-for-woocommerce-subscriptions' ) . '</a>';
		array_unshift( $links, $setting_page_link );
		return $links;
	}

	/**
	 * Register core post types.
	 */
	public function register_post_types() {
		if ( ! post_type_exists( 'asp_prod_subs_rule' ) ) {
			register_post_type( 'asp_prod_subs_rule', array(
				'labels'              => array(
					'name'               => __( 'Product Subscribe Rules', 'subscribe-and-save-for-woocommerce-subscriptions' ),
					'singular_name'      => __( 'Product Subscribe Rule', 'subscribe-and-save-for-woocommerce-subscriptions' ),
					'menu_name'          => __( 'Product Subscribe Rules', 'subscribe-and-save-for-woocommerce-subscriptions' ),
					'add_new'            => __( 'Add rule', 'subscribe-and-save-for-woocommerce-subscriptions' ),
					'add_new_item'       => __( 'Add new subscribe rule', 'subscribe-and-save-for-woocommerce-subscriptions' ),
					'new_item'           => __( 'New subscribe rule', 'subscribe-and-save-for-woocommerce-subscriptions' ),
					'edit_item'          => __( 'Edit subscribe rule', 'subscribe-and-save-for-woocommerce-subscriptions' ),
					'view_item'          => __( 'View subscribe rule', 'subscribe-and-save-for-woocommerce-subscriptions' ),
					'search_items'       => __( 'Search subscribe rules', 'subscribe-and-save-for-woocommerce-subscriptions' ),
					'not_found'          => __( 'No subscribe rules found.', 'subscribe-and-save-for-woocommerce-subscriptions' ),
					'not_found_in_trash' => __( 'No subscribe rules found in Trash.', 'subscribe-and-save-for-woocommerce-subscriptions' ),
				),
				'description'         => __( 'This is where store product subscribe rules are stored.', 'subscribe-and-save-for-woocommerce-subscriptions' ),
				'public'              => false,
				'capability_type'     => 'post',
				'show_ui'             => true,
				'publicly_queryable'  => false,
				'exclude_from_search' => true,
				'show_in_menu'        => false,
				'hierarchical'        => false,
				'show_in_nav_menus'   => false,
				'show_in_admin_bar'   => false,
				'rewrite'             => false,
				'query_var'           => false,
				'supports'            => array( 'title', 'editor' ),
				'has_archive'         => false,
				'map_meta_cap'        => true,
			) );
		}

		if ( ! post_type_exists( 'asp_cart_subs_rule' ) ) {
			register_post_type( 'asp_cart_subs_rule', array(
				'labels'              => array(
					'name'               => __( 'Cart Subscribe Rules', 'subscribe-and-save-for-woocommerce-subscriptions' ),
					'singular_name'      => __( 'Cart Subscribe Rule', 'subscribe-and-save-for-woocommerce-subscriptions' ),
					'menu_name'          => __( 'Cart Subscribe Rules', 'subscribe-and-save-for-woocommerce-subscriptions' ),
					'add_new'            => __( 'Add rule', 'subscribe-and-save-for-woocommerce-subscriptions' ),
					'add_new_item'       => __( 'Add new subscribe rule', 'subscribe-and-save-for-woocommerce-subscriptions' ),
					'new_item'           => __( 'New subscribe rule', 'subscribe-and-save-for-woocommerce-subscriptions' ),
					'edit_item'          => __( 'Edit subscribe rule', 'subscribe-and-save-for-woocommerce-subscriptions' ),
					'view_item'          => __( 'View subscribe rule', 'subscribe-and-save-for-woocommerce-subscriptions' ),
					'search_items'       => __( 'Search subscribe rules', 'subscribe-and-save-for-woocommerce-subscriptions' ),
					'not_found'          => __( 'No subscribe rules found.', 'subscribe-and-save-for-woocommerce-subscriptions' ),
					'not_found_in_trash' => __( 'No subscribe rules found in Trash.', 'subscribe-and-save-for-woocommerce-subscriptions' ),
				),
				'description'         => __( 'This is where store cart subscribe rules are stored.', 'subscribe-and-save-for-woocommerce-subscriptions' ),
				'public'              => false,
				'capability_type'     => 'post',
				'show_ui'             => true,
				'publicly_queryable'  => false,
				'exclude_from_search' => true,
				'show_in_menu'        => false,
				'hierarchical'        => false,
				'show_in_nav_menus'   => false,
				'show_in_admin_bar'   => false,
				'rewrite'             => false,
				'query_var'           => false,
				'supports'            => array( 'title', 'editor' ),
				'has_archive'         => false,
				'map_meta_cap'        => true,
			) );
		}

		if ( ! post_type_exists( 'asp_subscribe_plan' ) ) {
			register_post_type( 'asp_subscribe_plan', array(
				'labels'              => array(
					'name'               => __( 'Subscribe Plans', 'subscribe-and-save-for-woocommerce-subscriptions' ),
					'singular_name'      => _x( 'Subscribe Plan', 'asp_subscribe_plan post type singular name', 'subscribe-and-save-for-woocommerce-subscriptions' ),
					'menu_name'          => _x( 'Subscribe Plans', 'Admin menu name', 'subscribe-and-save-for-woocommerce-subscriptions' ),
					'add_new'            => __( 'Add plan', 'subscribe-and-save-for-woocommerce-subscriptions' ),
					'add_new_item'       => __( 'Add new subscribe plan', 'subscribe-and-save-for-woocommerce-subscriptions' ),
					'new_item'           => __( 'New subscribe plan', 'subscribe-and-save-for-woocommerce-subscriptions' ),
					'edit_item'          => __( 'Edit subscribe plan', 'subscribe-and-save-for-woocommerce-subscriptions' ),
					'view_item'          => __( 'View subscribe plan', 'subscribe-and-save-for-woocommerce-subscriptions' ),
					'search_items'       => __( 'Search subscribe plans', 'subscribe-and-save-for-woocommerce-subscriptions' ),
					'not_found'          => __( 'No subscribe plans found.', 'subscribe-and-save-for-woocommerce-subscriptions' ),
					'not_found_in_trash' => __( 'No subscribe plans found in Trash.', 'subscribe-and-save-for-woocommerce-subscriptions' ),
				),
				'description'         => __( 'This is where store subscribe plans are stored.', 'subscribe-and-save-for-woocommerce-subscriptions' ),
				'public'              => false,
				'capability_type'     => 'post',
				'show_ui'             => true,
				'publicly_queryable'  => false,
				'exclude_from_search' => true,
				'show_in_menu'        => false,
				'hierarchical'        => false,
				'show_in_nav_menus'   => false,
				'show_in_admin_bar'   => false,
				'rewrite'             => false,
				'query_var'           => false,
				'supports'            => array( 'title' ),
				'has_archive'         => false,
				'map_meta_cap'        => true,
			) );
		}

		/**
		 * After register post type
		 * 
		 * @since 1.0.0
		 */
		do_action( 'asp_ssws_after_register_post_type' );
	}

	/**
	 * Register our post statuses.
	 */
	public function register_post_statuses() {
		$our_statuses = array(
			'asp-' => array(
				'active'   => array(
					'label'                     => _x( 'Active', 'subscribe plan/subscribe rule status name', 'subscribe-and-save-for-woocommerce-subscriptions' ),
					'public'                    => true,
					'exclude_from_search'       => false,
					'show_in_admin_all_list'    => true,
					'show_in_admin_status_list' => true,
					/* translators: %s: status name */
					'label_count'               => _n_noop( 'Active <span class="count">(%s)</span>', 'Active <span class="count">(%s)</span>' ),
				),
				'inactive' => array(
					'label'                     => _x( 'Inactive', 'subscribe plan/subscribe rule status name', 'subscribe-and-save-for-woocommerce-subscriptions' ),
					'public'                    => true,
					'exclude_from_search'       => false,
					'show_in_admin_all_list'    => true,
					'show_in_admin_status_list' => true,
					/* translators: %s: status name */
					'label_count'               => _n_noop( 'Inactive <span class="count">(%s)</span>', 'Inactive <span class="count">(%s)</span>' ),
				),
			),
		);

		foreach ( $our_statuses as $prefix => $statuses ) {
			foreach ( $statuses as $status => $args ) {
				register_post_status( $prefix . $status, $args );
			}
		}
	}

	/**
	 * Add our data stores to WC.
	 * 
	 * @param array $data_stores
	 * @return array
	 */
	public function add_data_stores( $data_stores ) {
		$data_stores[ 'asp_product_subscribe_rule' ] = 'ASP_SSWS_Subscribe_Rule_Product_Data_Store_CPT';
		$data_stores[ 'asp_cart_subscribe_rule' ]    = 'ASP_SSWS_Subscribe_Rule_Cart_Data_Store_CPT';
		$data_stores[ 'asp_subscribe_plan' ]         = 'ASP_SSWS_Subscribe_Plan_Data_Store_CPT';
		return $data_stores;
	}

	/**
	 * Get the subscription meta.
	 */
	public function get_subscription_meta() {
		/**
		 * Get the subscription meta.
		 * 
		 * @since 1.0.0
		 */
		return apply_filters( 'asp_ssws_get_subscription_meta', array(
			'_asp_ssws_subscribed_plan' => '0',
				) );
	}

	/**
	 * Update subscription meta while creating subscription.
	 * 
	 * @param WC_Subscription $subscription
	 * @param array $posted_data
	 * @param WC_Order $order
	 * @param WC_Cart $cart
	 */
	public function update_subscription_meta( $subscription, $posted_data, $order, $cart ) {
		$meta = self::get_subscription_meta();

		foreach ( $meta as $key => $default_value ) {
			$subscription->update_meta_data( $key, wcs_cart_pluck( $cart, $key, $default_value ) );
		}
	}

	/**
	 * Update subscription item meta after subscription item created.
	 * 
	 * @param WC_Order_Item $item
	 * @param string $cart_item_key
	 * @param array $cart_item
	 * @param WC_Subscription $subscription
	 */
	public function update_subscription_item_meta( $item, $cart_item_key, $cart_item, $subscription ) {
		if ( wcs_is_subscription( $subscription ) ) {
			$meta = self::get_subscription_meta();

			foreach ( $meta as $key => $default_value ) {
				$item->update_meta_data( $key, WC_Subscriptions_Product::get_meta_data( $cart_item[ 'data' ], $key, $default_value ) );
			}
		}
	}

	/**
	 * Update subscription meta after subscription is switched.
	 * 
	 * @param WC_Subscription $subscription
	 * @param WC_Order_Item $new_order_item
	 */
	public function subscriptions_switched( $subscription, $new_order_item ) {
		$meta = self::get_subscription_meta();

		foreach ( $meta as $key => $default_value ) {
			$subscription->update_meta_data( $key, $new_order_item->get_meta( $key ) );
			$subscription->save_meta_data();
		}
	}

	/**
	 * Hide subscription meta.
	 * 
	 * @return array
	 */
	public function hidden_subscription_itemmeta( $hidden ) {
		$meta   = array_keys( self::get_subscription_meta() );
		$hidden = array_merge( $meta, $hidden );
		return $hidden;
	}
}
