<?php

/**
 * Plugin Name: Buy Now or Subscribe and Save for WooCommerce Subscriptions
 * Description: This plugin offers existing products to purchase as a subscription along with discounts to your customers.
 * Version: 1.9.0
 * Author: AspiringPlugins
 * Author URI: https://woo.com/vendor/aspiringplugins/
 * Text Domain: subscribe-and-save-for-woocommerce-subscriptions
 * Domain Path: /languages
 * 
 * Tested up to: 6.7.1
 * WC tested up to: 9.4.3
 * WC requires at least: 5.0.0
 * WCS tested up to: 6.9.1
 * WCS requires at least: 3.1.0
 * Requires Plugins: woocommerce,woocommerce-subscriptions
 * 
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 * Woo: 18734003637614:c2555c5f6bc06e2cee637e1a221d8e45

 */
defined( 'ABSPATH' ) || exit;

/**
 * Define our plugin constants.
 */
define( 'ASP_SSWS_PLUGIN_FILE', __FILE__ );
define( 'ASP_SSWS_ABSPATH', dirname( ASP_SSWS_PLUGIN_FILE ) . '/' );
define( 'ASP_SSWS_PLUGIN_BASENAME', plugin_basename( ASP_SSWS_PLUGIN_FILE ) );
define( 'ASP_SSWS_VERSION', '1.9.0' );
define( 'ASP_SSWS_MIN_WC_VER', '5.0.0' );
define( 'ASP_SSWS_MIN_WCS_VER', '3.1.0' );

/**
 * WooCommere missing notice.
 */
function asp_ssws_missing_wc_notice() {
	echo "<div class='error'><p>Buy Now or Subscribe and Save for WooCommerce Subscriptions Plugin requires <a href='http://woocommerce.com/' target='_blank'>WooCommerce</a> plugin to be installed and active.</p></div>";
}

/**
 * WooCommere Subscriptions missing notice.
 */
function asp_ssws_missing_wcs_notice() {
	echo "<div class='error'><p>Buy Now or Subscribe and Save for WooCommerce Subscriptions plugin requires <a href='http://woocommerce.com/products/woocommerce-subscriptions/' target='_blank'>WooCommerce Subscriptions</a> plugin to be installed and active.</p></div>";
}

/**
 * WooCommerce not supported notice.
 */
function asp_ssws_wc_not_supported() {
	echo '<div class="error"><p>Buy Now or Subscribe and Save for WooCommerce Subscriptions plugin requires <strong> WooCommerce ' . esc_attr( ASP_SSWS_MIN_WC_VER ) . ' or greater </strong> to be installed and active.</p></div>';
}

/**
 * WooCommerce Subscriptions not supported notice.
 */
function asp_ssws_wcs_not_supported() {
	echo '<div class="error"><p>Buy Now or Subscribe and Save for WooCommerce Subscriptions plugin requires <strong> WooCommerce Subscriptions ' . esc_attr( ASP_SSWS_MIN_WCS_VER ) . ' or greater </strong> to be installed and active.</p></div>';
}

/**
 * Add HPOS support.
 */
add_action( 'before_woocommerce_init', function () {
	if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
		\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
	}
} );

/**
 * Init Buy Now or Subscribe and Save for WooCommerce Subscriptions.
 */
function asp_init_subscribe_and_save_for_woocommerce_subscriptions() {
	if ( ! class_exists( 'WooCommerce' ) ) {
		add_action( 'admin_notices', 'asp_ssws_missing_wc_notice' );
		return;
	}

	if ( version_compare( WC_VERSION, ASP_SSWS_MIN_WC_VER, '<' ) ) {
		add_action( 'admin_notices', 'asp_ssws_wc_not_supported' );
		return;
	}

	if ( ! class_exists( 'WC_Subscriptions' ) ) {
		add_action( 'admin_notices', 'asp_ssws_missing_wcs_notice' );
		return;
	}

	if ( version_compare( WC_Subscriptions::$version, ASP_SSWS_MIN_WCS_VER, '<' ) ) {
		add_action( 'admin_notices', 'asp_ssws_wcs_not_supported' );
		return;
	}

	// Include main class file.
	if ( ! class_exists( 'ASP_Subscribe_And_Save_For_Woocommerce_Subscriptions' ) ) {
		include_once 'includes/class-subscribe-and-save-for-woocommerce-subscriptions.php';
	}

	/**
	 * Returns the main instance of Buy Now or Subscribe and Save for WooCommerce Subscriptions.
	 *
	 * @return ASP_Subscribe_And_Save_For_Woocommerce_Subscriptions
	 */
	function ASP_SSWS() {
		return ASP_Subscribe_And_Save_For_Woocommerce_Subscriptions::instance();
	}

	/**
	 * Allow our plugin to run only if the plugin dependencies are met.
	 */
	ASP_SSWS();
}

add_action( 'plugins_loaded', 'asp_init_subscribe_and_save_for_woocommerce_subscriptions' );
