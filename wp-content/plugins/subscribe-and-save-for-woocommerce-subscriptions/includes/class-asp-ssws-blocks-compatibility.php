<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Blocks Compatibility.
 *
 * @class ASP_SSWS_Blocks_Compatibility
 * @package Class
 */
class ASP_SSWS_Blocks_Compatibility {

	/**
	 * Min required plugin versions to check.
	 *
	 * @var array
	 */
	private static $required = array(
		'blocks' => '7.0.0',
	);

	/**
	 * Initialize.
	 */
	public static function init() {
		// When WooCommerceBlocks is loaded, set up the Integration class.
		add_action( 'woocommerce_blocks_loaded', __CLASS__ . '::setup_blocks_integration' );
		add_action( 'woocommerce_blocks_loaded', 'ASP_SSWS_Store_API::init' );
	}

	/**
	 * Sets up the Blocks integration class.
	 */
	public static function setup_blocks_integration() {
		if ( ! class_exists( '\Automattic\WooCommerce\Blocks\Package' ) || version_compare( \Automattic\WooCommerce\Blocks\Package::get_version(), self::$required[ 'blocks' ] ) <= 0 ) {
			return;
		}

		/**
		 * Filter the compatible blocks.
		 * 
		 * @since 1.0.0
		 */
		$compatible_blocks = apply_filters( 'asp_ssws_compatible_blocks', array( 'cart', 'checkout', 'mini-cart' ) );
		foreach ( $compatible_blocks as $block_name ) {
			add_action(
					"woocommerce_blocks_{$block_name}_block_registration",
					function ( $registry ) {
						$registry->register( ASP_SSWS_Blocks_Integration::instance() );
					}
			);
		}
	}
}

ASP_SSWS_Blocks_Compatibility::init();
