<?php

defined( 'ABSPATH' ) || exit;

/**
 * Admin Post Types handler.
 * 
 * @class ASP_SSWS_Admin_Post_Types
 * @package Class
 */
class ASP_SSWS_Admin_Post_Types {

	/**
	 * Is meta boxes saved once?
	 *
	 * @var bool
	 */
	private static $saved_meta_boxes = false;

	/**
	 * Init ASP_SSWS_Admin_Post_Types.
	 */
	public static function init() {
		self::load_list_types();

		add_filter( 'wp_untrash_post_status', __CLASS__ . '::wp_untrash_post_status', 10, 3 );
		add_filter( 'post_updated_messages', __CLASS__ . '::post_updated_messages' );
		add_filter( 'bulk_post_updated_messages', __CLASS__ . '::bulk_post_updated_messages', 10, 2 );
		add_filter( 'enter_title_here', __CLASS__ . '::enter_title_here', 1, 2 );
		add_action( 'add_meta_boxes', __CLASS__ . '::add_meta_boxes', 100 );
		add_action( 'add_meta_boxes', __CLASS__ . '::remove_meta_boxes', 50 );
		add_action( 'save_post', __CLASS__ . '::save_meta_boxes', 1, 2 );
		add_action( 'asp_ssws_process_asp_subscribe_plan_posted_meta', 'ASP_SSWS_Meta_Box_Subscribe_Plan_Actions::save', 10, 3 );
		add_action( 'asp_ssws_process_asp_prod_subs_rule_posted_meta', 'ASP_SSWS_Meta_Box_Subscribe_Rule_Actions::save', 10, 3 );
		add_action( 'asp_ssws_process_asp_cart_subs_rule_posted_meta', 'ASP_SSWS_Meta_Box_Subscribe_Rule_Actions::save', 10, 3 );
	}

	/**
	 * Load list types.
	 */
	protected static function load_list_types() {
		if ( ! class_exists( 'WC_Admin_List_Table', false ) ) {
			include_once WC_ABSPATH . 'includes/admin/list-tables/abstract-class-wc-admin-list-table.php';
		}

		include_once 'list-tables/class-asp-ssws-admin-list-table-subscribe-plans.php';
		include_once 'list-tables/class-asp-ssws-admin-list-table-product-subscribe-rules.php';
		include_once 'list-tables/class-asp-ssws-admin-list-table-cart-subscribe-rules.php';
	}

	/**
	 * Ensure statuses are correctly reassigned when restoring our posts.
	 *
	 * @param string $new_status      The new status of the post being restored.
	 * @param int    $post_id         The ID of the post being restored.
	 * @param string $previous_status The status of the post at the point where it was trashed.
	 * @return string
	 */
	public static function wp_untrash_post_status( $new_status, $post_id, $previous_status ) {
		if ( in_array( get_post_type( $post_id ), array( 'asp_subscribe_plan', 'asp_prod_subs_rule', 'asp_cart_subs_rule' ), true ) ) {
			$new_status = $previous_status;
		}

		return $new_status;
	}

	/**
	 * Change messages when a post type is updated.
	 *
	 * @param  array $messages Array of messages.
	 * @return array
	 */
	public static function post_updated_messages( $messages ) {
		$messages[ 'asp_prod_subs_rule' ] = array(
			0 => '', // Unused. Messages start at index 1.
			1 => __( 'Subscribe rule updated.', 'subscribe-and-save-for-woocommerce-subscriptions' ),
			4 => __( 'Subscribe rule updated.', 'subscribe-and-save-for-woocommerce-subscriptions' ),
			6 => __( 'Subscribe rule updated.', 'subscribe-and-save-for-woocommerce-subscriptions' ),
			7 => __( 'Subscribe rule saved.', 'subscribe-and-save-for-woocommerce-subscriptions' ),
			8 => __( 'Subscribe rule submitted.', 'subscribe-and-save-for-woocommerce-subscriptions' ),
		);

		$messages[ 'asp_cart_subs_rule' ] = array(
			0 => '', // Unused. Messages start at index 1.
			1 => __( 'Subscribe rule updated.', 'subscribe-and-save-for-woocommerce-subscriptions' ),
			4 => __( 'Subscribe rule updated.', 'subscribe-and-save-for-woocommerce-subscriptions' ),
			6 => __( 'Subscribe rule updated.', 'subscribe-and-save-for-woocommerce-subscriptions' ),
			7 => __( 'Subscribe rule saved.', 'subscribe-and-save-for-woocommerce-subscriptions' ),
			8 => __( 'Subscribe rule submitted.', 'subscribe-and-save-for-woocommerce-subscriptions' ),
		);

		$messages[ 'asp_subscribe_plan' ] = array(
			0 => '', // Unused. Messages start at index 1.
			1 => __( 'Subscribe plan updated.', 'subscribe-and-save-for-woocommerce-subscriptions' ),
			4 => __( 'Subscribe plan updated.', 'subscribe-and-save-for-woocommerce-subscriptions' ),
			6 => __( 'Subscribe plan updated.', 'subscribe-and-save-for-woocommerce-subscriptions' ),
			7 => __( 'Subscribe plan saved.', 'subscribe-and-save-for-woocommerce-subscriptions' ),
			8 => __( 'Subscribe plan submitted.', 'subscribe-and-save-for-woocommerce-subscriptions' ),
		);

		return $messages;
	}

	/**
	 * Specify custom bulk actions messages for different post types.
	 *
	 * @param  array $bulk_messages Array of messages.
	 * @param  array $bulk_counts Array of how many objects were updated.
	 * @return array
	 */
	public static function bulk_post_updated_messages( $bulk_messages, $bulk_counts ) {
		$bulk_messages[ 'asp_prod_subs_rule' ] = array(
			/* translators: %s: subscribe rule count */
			'updated'   => _n( '%s subscribe rule updated.', '%s subscribe rules updated.', $bulk_counts[ 'updated' ], 'subscribe-and-save-for-woocommerce-subscriptions' ),
			/* translators: %s: subscribe rule count */
			'locked'    => _n( '%s subscribe rule not updated, somebody is editing it.', '%s subscribe rules not updated, somebody is editing them.', $bulk_counts[ 'locked' ], 'subscribe-and-save-for-woocommerce-subscriptions' ),
			/* translators: %s: subscribe rule count */
			'deleted'   => _n( '%s subscribe rule permanently deleted.', '%s subscribe rules permanently deleted.', $bulk_counts[ 'deleted' ], 'subscribe-and-save-for-woocommerce-subscriptions' ),
			/* translators: %s: subscribe rule count */
			'trashed'   => _n( '%s subscribe rule moved to the Trash.', '%s subscribe rules moved to the Trash.', $bulk_counts[ 'trashed' ], 'subscribe-and-save-for-woocommerce-subscriptions' ),
			/* translators: %s: subscribe rule count */
			'untrashed' => _n( '%s subscribe rule restored from the Trash.', '%s subscribe rules restored from the Trash.', $bulk_counts[ 'untrashed' ], 'subscribe-and-save-for-woocommerce-subscriptions' ),
		);

		$bulk_messages[ 'asp_cart_subs_rule' ] = array(
			/* translators: %s: subscribe rule count */
			'updated'   => _n( '%s subscribe rule updated.', '%s subscribe rules updated.', $bulk_counts[ 'updated' ], 'subscribe-and-save-for-woocommerce-subscriptions' ),
			/* translators: %s: subscribe rule count */
			'locked'    => _n( '%s subscribe rule not updated, somebody is editing it.', '%s subscribe rules not updated, somebody is editing them.', $bulk_counts[ 'locked' ], 'subscribe-and-save-for-woocommerce-subscriptions' ),
			/* translators: %s: subscribe rule count */
			'deleted'   => _n( '%s subscribe rule permanently deleted.', '%s subscribe rules permanently deleted.', $bulk_counts[ 'deleted' ], 'subscribe-and-save-for-woocommerce-subscriptions' ),
			/* translators: %s: subscribe rule count */
			'trashed'   => _n( '%s subscribe rule moved to the Trash.', '%s subscribe rules moved to the Trash.', $bulk_counts[ 'trashed' ], 'subscribe-and-save-for-woocommerce-subscriptions' ),
			/* translators: %s: subscribe rule count */
			'untrashed' => _n( '%s subscribe rule restored from the Trash.', '%s subscribe rules restored from the Trash.', $bulk_counts[ 'untrashed' ], 'subscribe-and-save-for-woocommerce-subscriptions' ),
		);

		$bulk_messages[ 'asp_subscribe_plan' ] = array(
			/* translators: %s: subscribe plan count */
			'updated'   => _n( '%s subscribe plan updated.', '%s subscribe plans updated.', $bulk_counts[ 'updated' ], 'subscribe-and-save-for-woocommerce-subscriptions' ),
			/* translators: %s: subscribe plan count */
			'locked'    => _n( '%s subscribe plan not updated, somebody is editing it.', '%s subscribe plans not updated, somebody is editing them.', $bulk_counts[ 'locked' ], 'subscribe-and-save-for-woocommerce-subscriptions' ),
			/* translators: %s: subscribe plan count */
			'deleted'   => _n( '%s subscribe plan permanently deleted.', '%s subscribe plans permanently deleted.', $bulk_counts[ 'deleted' ], 'subscribe-and-save-for-woocommerce-subscriptions' ),
			/* translators: %s: subscribe plan count */
			'trashed'   => _n( '%s subscribe plan moved to the Trash.', '%s subscribe plans moved to the Trash.', $bulk_counts[ 'trashed' ], 'subscribe-and-save-for-woocommerce-subscriptions' ),
			/* translators: %s: subscribe plan count */
			'untrashed' => _n( '%s subscribe plan restored from the Trash.', '%s subscribe plans restored from the Trash.', $bulk_counts[ 'untrashed' ], 'subscribe-and-save-for-woocommerce-subscriptions' ),
		);

		return $bulk_messages;
	}

	/**
	 * Change title boxes in admin.
	 *
	 * @param string  $text Text to shown.
	 * @param WP_Post $post Current post object.
	 * @return string
	 */
	public static function enter_title_here( $text, $post ) {
		switch ( $post->post_type ) {
			case 'asp_subscribe_plan':
				$text = esc_html__( 'Plan name', 'subscribe-and-save-for-woocommerce-subscriptions' );
				break;
			case 'asp_prod_subs_rule':
			case 'asp_cart_subs_rule':
				$text = esc_html__( 'Rule name', 'subscribe-and-save-for-woocommerce-subscriptions' );
				break;
		}

		return $text;
	}

	/**
	 * Add Metaboxes.
	 */
	public static function add_meta_boxes() {
		add_meta_box( 'asp_ssws_subscribe_rule_data', __( 'Rule data', 'subscribe-and-save-for-woocommerce-subscriptions' ), 'ASP_SSWS_Meta_Box_Subscribe_Rule_Data::output', 'asp_prod_subs_rule', 'normal', 'high' );
		add_meta_box( 'asp_ssws_subscribe_rule_actions', __( 'Actions', 'subscribe-and-save-for-woocommerce-subscriptions' ), 'ASP_SSWS_Meta_Box_Subscribe_Rule_Actions::output', 'asp_prod_subs_rule', 'side', 'high' );

		add_meta_box( 'asp_ssws_subscribe_rule_data', __( 'Rule data', 'subscribe-and-save-for-woocommerce-subscriptions' ), 'ASP_SSWS_Meta_Box_Subscribe_Rule_Data::output', 'asp_cart_subs_rule', 'normal', 'high' );
		add_meta_box( 'asp_ssws_subscribe_rule_actions', __( 'Actions', 'subscribe-and-save-for-woocommerce-subscriptions' ), 'ASP_SSWS_Meta_Box_Subscribe_Rule_Actions::output', 'asp_cart_subs_rule', 'side', 'high' );

		add_meta_box( 'asp_ssws_subscribe_plan_data', __( 'Plan type', 'subscribe-and-save-for-woocommerce-subscriptions' ), 'ASP_SSWS_Meta_Box_Subscribe_Plan_Data::output', 'asp_subscribe_plan', 'normal', 'high' );
		add_meta_box( 'asp_ssws_subscribe_plan_actions', __( 'Plan actions', 'subscribe-and-save-for-woocommerce-subscriptions' ), 'ASP_SSWS_Meta_Box_Subscribe_Plan_Actions::output', 'asp_subscribe_plan', 'side', 'high' );
	}

	/**
	 * Remove Metaboxes.
	 */
	public static function remove_meta_boxes() {
		remove_meta_box( 'commentsdiv', 'asp_prod_subs_rule', 'normal' );
		remove_meta_box( 'commentsdiv', 'asp_cart_subs_rule', 'normal' );
		remove_meta_box( 'commentsdiv', 'asp_subscribe_plan', 'normal' );

		remove_meta_box( 'submitdiv', 'asp_prod_subs_rule', 'side' );
		remove_meta_box( 'submitdiv', 'asp_cart_subs_rule', 'side' );
		remove_meta_box( 'submitdiv', 'asp_subscribe_plan', 'side' );
	}

	/**
	 * Check if we're saving, the trigger an action based on the post type.
	 *
	 * @param  int    $post_id Post ID.
	 * @param  object $post Post object.
	 */
	public static function save_meta_boxes( $post_id, $post ) {
		$post_id = absint( $post_id );

		// $post_id and $post are required
		if ( empty( $post_id ) || empty( $post ) || self::$saved_meta_boxes ) {
			return;
		}

		// Dont' save meta boxes for revisions or autosaves.
		if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || is_int( wp_is_post_revision( $post ) ) || is_int( wp_is_post_autosave( $post ) ) ) {
			return;
		}

		// Check the nonce.
		if ( empty( $_POST[ 'asp_ssws_save_meta_nonce' ] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST[ 'asp_ssws_save_meta_nonce' ] ) ), 'asp_ssws_save_data' ) ) {
			return;
		}

		// Check the post being saved == the $post_id to prevent triggering this call for other save_post events.
		$posted = $_POST;
		if ( empty( $posted[ 'post_ID' ] ) || absint( $posted[ 'post_ID' ] ) !== $post_id ) {
			return;
		}

		// Check user has permission to edit.
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		self::$saved_meta_boxes = true;

		if ( in_array( $post->post_type, array( 'asp_subscribe_plan', 'asp_prod_subs_rule', 'asp_cart_subs_rule' ), true ) ) {
			/**
			 * Process our post types save.
			 * 
			 * @since 1.0.0
			 */
			do_action( "asp_ssws_process_{$post->post_type}_posted_meta", $post_id, $post, $posted );
		}
	}
}
