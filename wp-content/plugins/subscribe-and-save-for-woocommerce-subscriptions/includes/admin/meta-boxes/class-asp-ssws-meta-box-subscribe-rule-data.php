<?php

defined( 'ABSPATH' ) || exit;

/**
 * Subscribe Rule Data.
 * 
 * @class ASP_SSWS_Meta_Box_Subscribe_Rule_Data
 * @package Class
 */
class ASP_SSWS_Meta_Box_Subscribe_Rule_Data {

	/**
	 * Output the metabox.
	 *
	 * @param WP_Post $post
	 */
	public static function output( $post ) {
		global $post, $the_subscribe_rule;

		if ( ! is_object( $the_subscribe_rule ) ) {
			if ( asp_ssws_is_subscribe_rule( $post->ID, 'cart' ) ) {
				$the_subscribe_rule = new ASP_SSWS_Subscribe_Rule_Cart( $post->ID );
			} else {
				$the_subscribe_rule = new ASP_SSWS_Subscribe_Rule_Product( $post->ID );
			}
		}

		$subscribe_rule = $the_subscribe_rule;
		$rule_post      = $post;

		wp_nonce_field( 'asp_ssws_save_data', 'asp_ssws_save_meta_nonce' );

		include 'views/html-subscribe-rule-data-panel.php';
	}

	/**
	 * Show tab content/settings.
	 */
	private static function output_tabs() {
		global $post, $the_subscribe_rule;

		$subscribe_rule = $the_subscribe_rule;

		include 'views/html-subscribe-rule-data-general.php';
		include 'views/html-subscribe-rule-data-criteria.php';
	}

	/**
	 * Return array of tabs to show.
	 *
	 * @return array
	 */
	private static function get_rule_data_tabs() {
		/**
		 * Get admin subscribe rule data tabs.
		 * 
		 * @since 1.0.0
		 */
		$tabs = apply_filters( 'asp_ssws_admin_subscribe_rule_data_tabs', array(
			'general'  => array(
				'label'  => __( 'General', 'subscribe-and-save-for-woocommerce-subscriptions' ),
				'target' => 'general_rule_data',
			),
			'criteria' => array(
				'label'  => __( 'Criteria', 'subscribe-and-save-for-woocommerce-subscriptions' ),
				'target' => 'criteria_rule_data',
			),
				) );

		return $tabs;
	}
}
