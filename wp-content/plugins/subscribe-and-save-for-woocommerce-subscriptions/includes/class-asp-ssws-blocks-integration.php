<?php

/**
 * A class for integrating with WooCommerce Blocks scripts.
 */
use Automattic\WooCommerce\Blocks\Integrations\IntegrationInterface;

/**
 * Blocks integration class.
 *
 * @class  ASP_SSWS_Blocks_Integration
 * @implements   IntegrationInterface
 * @package Class
 */
class ASP_SSWS_Blocks_Integration implements IntegrationInterface {

	/**
	 * The single instance of the class.
	 *
	 * @var ASP_SSWS_Blocks_Integration
	 */
	protected static $instance = null;

	/**
	 * Main ASP_SSWS_Blocks_Integration instance. Ensures only one instance of ASP_SSWS_Blocks_Integration is loaded or can be loaded.
	 *
	 * @return ASP_SSWS_Blocks_Integration
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * The name of the integration.
	 *
	 * @return string
	 */
	public function get_name() {
		return 'subscribe-and-save-for-woocommerce-subscriptions';
	}

	/**
	 * When called invokes any initialization/setup for the integration.
	 */
	public function initialize() {
		add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_block_editor_assets' ) );
		add_action( 'enqueue_block_assets', array( $this, 'enqueue_block_assets' ) );
	}

	/**
	 * Returns an array of script handles to enqueue in the frontend context.
	 *
	 * @return string[]
	 */
	public function get_script_handles() {
		return array( 'asp-ssws-blocks-integration' );
	}

	/**
	 * Returns an array of script handles to enqueue in the editor context.
	 *
	 * @return string[]
	 */
	public function get_editor_script_handles() {
		return array( 'asp-ssws-blocks-integration' );
	}

	/**
	 * An array of key, value pairs of data made available to the block on the client side.
	 *
	 * @return array
	 */
	public function get_script_data() {
		return array(
			'asp-ssws-blocks-integration'    => 'active',
			/**
			 * Get cart subscribe form display pages.
			 * 
			 * @since 1.0.0
			 */
			'cart_subscribe_allowed_pages'   => ( array ) apply_filters( 'asp_ssws_get_cart_subscribe_form_display_pages', array( 'cart', 'checkout' ) ),
			'one_time_purchase_option_label' => get_option( 'asp_ssws_one_time_purchase_option_label' ),
			'subscribe_option_label'         => get_option( 'asp_ssws_subscribe_option_label' ),
			'subscribe_discount_label'       => get_option( 'asp_ssws_subscribe_discount_label' ),
			'subscribe_plan_label'           => get_option( 'asp_ssws_subscribe_plan_label' ),
			'billing_interval_label'         => get_option( 'asp_ssws_subscribe_interval_label' ),
			'billing_period_label'           => get_option( 'asp_ssws_subscribe_period_label' ),
			'billing_expiration_label'       => get_option( 'asp_ssws_subscribe_expiration_label' ),
		);
	}

	/**
	 * Get the file modified time as a cache buster if we're in dev mode.
	 *
	 * @param string $file Local path to the file.
	 * @return string The cache buster value to use for the given file.
	 */
	protected function get_file_version( $file ) {
		if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG && file_exists( $file ) ) {
			return filemtime( $file );
		}
		return ASP_SSWS_VERSION;
	}

	/**
	 * Enqueue block assets for the editor.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_block_editor_assets() {
		$script_path       = 'blocks/admin/index.js';
		$script_url        = ASP_SSWS()->plugin_url() . "/assets/{$script_path}";
		$script_asset_path = ASP_SSWS_ABSPATH . 'assets/blocks/admin/index.asset.php';
		$script_asset      = file_exists( $script_asset_path ) ? require $script_asset_path : array(
			'dependencies' => array(),
			'version'      => $this->get_file_version( $script_asset_path ),
		);

		wp_register_script(
				'asp-ssws-admin-blocks-integration',
				$script_url,
				$script_asset[ 'dependencies' ],
				$script_asset[ 'version' ],
				true
		);

		wp_enqueue_script( 'asp-ssws-admin-blocks-integration' );
	}

	/**
	 * Enqueue block assets for both editor and front-end.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_block_assets() {
		$script_path = 'blocks/frontend/index.js';
		$style_path  = 'blocks/frontend/index.css';

		$script_url = ASP_SSWS()->plugin_url() . "/assets/{$script_path}";
		$style_url  = ASP_SSWS()->plugin_url() . "/assets/{$style_path}";

		$script_asset_path = ASP_SSWS_ABSPATH . 'assets/blocks/frontend/index.asset.php';
		$style_asset_path  = ASP_SSWS_ABSPATH . 'assets/blocks/frontend/index.css';

		$script_asset = file_exists( $script_asset_path ) ? require $script_asset_path : array(
			'dependencies' => array(),
			'version'      => $this->get_file_version( $script_asset_path ),
		);

		wp_enqueue_style(
				'asp-ssws-blocks-integration',
				$style_url,
				'',
				$this->get_file_version( $style_asset_path ),
				'all'
		);
		wp_register_script(
				'asp-ssws-blocks-integration',
				$script_url,
				$script_asset[ 'dependencies' ],
				$script_asset[ 'version' ],
				true
		);
		wp_set_script_translations(
				'asp-ssws-blocks-integration',
				'subscribe-and-save-for-woocommerce-subscriptions',
				ASP_SSWS_ABSPATH . 'languages/'
		);
	}
}
