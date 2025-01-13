<?php
/*
Plugin Name:       Generate Random Orders For WooCommerce
Plugin URI:        https://wpzone.co/
Description:       Generates random orders for your WooCommerce store. It's a great tool for testing and populating your store's database with random data.
Version:           1.0.0
Author:            WP Zone
License:           GPLv3+
License URI:       http://www.gnu.org/licenses/gpl.html
Text Domain:       wpz-woocommerce-random-orders
*/

/*
Generate Random Orders For WooCommerce plugin
Copyright (C) 2024  WP Zone

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <https://www.gnu.org/licenses/>.

===

See the licenses directory for the license applicable to this project,
along with licensing and copyright information for any third-party
material used in this project.
*/
defined( 'ABSPATH' ) || die();

class WPZ_Generate_Random_Orders_For_WooCommerce {

	const    VERSION = '1.0.0';
	const    PLUGIN_AUTHOR_URL = 'https://wpzone.co/';
	const    PLUGIN_SLUG = 'wpz-woocommerce-random-orders';
	const    PLUGIN_NAME = 'Generate Random Orders For WooCommerce';
	const    PLUGIN_PAGE = 'admin.php?page=wpz-random-orders';

	public static $plugin_base_url;
	public static $plugin_directory;
	public static $plugin_file;

	public static function setup() {
		self::$plugin_base_url  = plugin_dir_url( __FILE__ );
		self::$plugin_directory = __DIR__ . '/';
		self::$plugin_file      = __FILE__;

		if ( is_admin() ) {
			include_once self::$plugin_directory . 'includes/admin/addons/addons.php';
			include_once self::$plugin_directory . 'includes/admin/notices/admin-notices.php';
			add_action( 'wp_ajax_wpz_random_orders', [ 'WPZ_Generate_Random_Orders_For_WooCommerce', 'ajax_random_orders'] );
			add_action( 'admin_menu', [ 'WPZ_Generate_Random_Orders_For_WooCommerce', 'admin_menu' ], 11 );
		}

		self::load_text_domain();

		add_action( 'load-plugins.php', [ 'WPZ_Generate_Random_Orders_For_WooCommerce', 'plugin_action_links' ], 10 );
		add_action( 'admin_enqueue_scripts', [ 'WPZ_Generate_Random_Orders_For_WooCommerce', 'admin_scripts' ], 10 );

	}

	/**
	 * Add settings link on plugins page
	 *
	 * @since 1.0.0
	 *
	 */
	public static function plugin_action_links() {
		add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), function ( $links ) {
			array_unshift( $links, '<a href="' . WPZ_Generate_Random_Orders_For_WooCommerce::PLUGIN_PAGE . '">' . esc_html__( 'Settings', 'wpz-woocommerce-random-orders' ) . '</a>' );

			return $links;
		} );
	}


	/**
	 * Enqueue scripts for admin page.
	 * Called in setup()
	 *
	 * @param int $hook Hook suffix for the current admin page.
	 *
	 * @since 1.0.0
	 *
	 */
	public static function admin_scripts( $hook ) {
		if ( 'woocommerce_page_wpz-random-orders' === $hook ) {
			wp_enqueue_style( 'wpz-woocommerce-random-orders-admin', self::$plugin_base_url . 'assets/css/admin.min.css', [], self::VERSION );
			wp_enqueue_script( 'wpz-woocommerce-random-orders-admin', self::$plugin_base_url . 'assets/js/admin.min.js', [ 'jquery' ], self::VERSION, true );
		}
	}

	/**
	 * Register Admin Menu Item "Generate Random Orders For WooCommerce"
	 *
	 * @since 1.0.0
	 *
	 */
	public static function admin_menu() {
		add_submenu_page( 'woocommerce', 'WooCommerce Random Orders', 'Random Orders', 'manage_woocommerce', 'wpz-random-orders', [
			'WPZ_Generate_Random_Orders_For_WooCommerce',
			'admin_page'
		] );

	}


	/**
	 * The function outputs the admin page content
	 * Called in admin_menu()
	 *
	 * @since 1.0.0
	 *
	 */
	public static function admin_page() {
		include( self::$plugin_directory . 'includes/admin/admin.php' );

	}

	/**
	 * Loads a plugin’s translated strings.
	 * The .mo file should be named based on the text domain with a dash, and then the locale exactly.
	 *
	 * @since 1.0.0
	 *
	 */
	public static function load_text_domain() {
		load_plugin_textdomain( 'wpz-woocommerce-random-orders', false, self::$plugin_directory . 'languages' );
	}


	public static function ajax_random_orders() {
		check_ajax_referer( 'wpz-random-orders', 'nonce' );

		if ( ! isset( $_POST['n'] ) || ! isset( $_POST['i'] ) ) {
			wp_send_json_error();
		}
		if ( $_POST['i'] > 1 && file_exists( ABSPATH.'/orders.json') ) {
			$data = json_decode( file_get_contents( ABSPATH.'/orders.json' ) );
		}

		if ( ! isset( $data ) || ! is_array( $data ) ) {
			$data = [];
		}

		$args = [ (int) $_POST['n'], (int) $_POST['i'] ];

		ob_start();
		include_once( self::$plugin_directory. 'includes/create-test-order.php' );
		$output = ob_get_clean();

		if ( ! empty( $_POST['deleteJson'] ) ) {
			unlink( ABSPATH.'/orders.json' );
		}

		wp_send_json_success( [
			'nonce'  => wp_create_nonce( 'wpz-random-orders' ),
			'output' => $output
		] );

	}


}

WPZ_Generate_Random_Orders_For_WooCommerce::setup();

