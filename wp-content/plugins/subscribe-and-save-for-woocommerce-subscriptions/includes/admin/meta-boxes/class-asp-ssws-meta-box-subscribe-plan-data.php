<?php

defined( 'ABSPATH' ) || exit;

/**
 * Subscribe Plan Data.
 * 
 * @class ASP_SSWS_Meta_Box_Subscribe_Plan_Data
 * @package Class
 */
class ASP_SSWS_Meta_Box_Subscribe_Plan_Data {

	/**
	 * Output the metabox.
	 *
	 * @param WP_Post $post
	 */
	public static function output( $post ) {
		global $post, $the_subscribe_plan;

		$the_subscribe_plan = asp_ssws_get_subscribe_plan( $post->ID );
		$subscribe_plan     = $the_subscribe_plan;

		include 'views/html-subscribe-plan-data-panel.php';
	}

	/**
	 * Show definition content/settings.
	 */
	private static function output_panels() {
		global $post, $the_subscribe_plan;

		$subscribe_plan           = $the_subscribe_plan;
		$chosen_discount          = $subscribe_plan->get_subscription_discount();
		$chosen_sign_up_fee       = $subscribe_plan->get_subscription_sign_up_fee();
		$chosen_trial_length      = $subscribe_plan->get_subscription_trial_length();
		$chosen_trial_period      = $subscribe_plan->get_subscription_trial_period();
		$chosen_interval          = $subscribe_plan->get_subscription_period_interval();
		$chosen_length            = $subscribe_plan->get_subscription_length();
		$chosen_period            = $subscribe_plan->get_subscription_period();
		$chosen_payment_sync_date = $subscribe_plan->get_subscription_payment_sync_date();
		$chosen_interval_length   = $subscribe_plan->get_subscription_interval_length();

		include 'views/html-subscribe-plan-predefined-data.php';
		include 'views/html-subscribe-plan-userdefined-data.php';
	}
}
