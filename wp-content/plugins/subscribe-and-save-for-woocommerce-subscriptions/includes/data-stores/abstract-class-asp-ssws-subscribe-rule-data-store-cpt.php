<?php

defined( 'ABSPATH' ) || exit;

/**
 * Subscribe Rule Data Store CPT
 * 
 * @class ASP_SSWS_Subscribe_Rule_Data_Store_CPT
 * @package Class
 */
class ASP_SSWS_Subscribe_Rule_Data_Store_CPT extends WC_Data_Store_WP implements WC_Object_Data_Store_Interface {

	/**
	 * Internal meta type used to store rule data.
	 *
	 * @var string
	 */
	protected $meta_type = 'post';

	/**
	 * Data stored in meta keys, but not considered "meta" for an rule.
	 *
	 * @var array
	 */
	protected $internal_meta_keys = array();

	/**
	 * Data stored in meta key to props.
	 *
	 * @var array
	 */
	protected $internal_meta_key_to_props = array(
		'_version'              => 'version',
		'_slug'                 => 'slug',
		'_criteria_user_filter' => 'criteria_user_filter',
		'_subscribe_plans'      => 'subscribe_plans',
		'_criteria_users'       => 'criteria_users',
		'_criteria_user_roles'  => 'criteria_user_roles',
	);

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->internal_meta_keys = array_merge( $this->internal_meta_keys, array_keys( $this->internal_meta_key_to_props ) );
	}

	/*
	  |--------------------------------------------------------------------------
	  | CRUD Methods
	  |--------------------------------------------------------------------------
	 */

	/**
	 * Method to create a new ID in the database from the new changes.
	 * 
	 * @param  ASP_SSWS_Subscribe_Rule $rule
	 */
	public function create( &$rule ) {
		$rule->set_version( ASP_SSWS_VERSION );
		$rule->set_date_created( time() );

		$id = wp_insert_post( array(
			'post_date'     => gmdate( 'Y-m-d H:i:s', $rule->get_date_created( 'edit' )->getOffsetTimestamp() ),
			'post_date_gmt' => gmdate( 'Y-m-d H:i:s', $rule->get_date_created( 'edit' )->getTimestamp() ),
			'post_type'     => $rule->get_type(),
			'post_status'   => $this->get_post_status( $rule ),
			'ping_status'   => 'closed',
			'post_author'   => 1,
			'post_title'    => $this->get_post_title( $rule ),
			'post_content'  => $rule->get_description(),
			'post_parent'   => 0,
				), true );

		if ( $id && ! is_wp_error( $id ) ) {
			$rule->set_id( $id );
			$this->update_post_meta( $rule );
			$rule->save_meta_data();
			$rule->apply_changes();
			$this->clear_caches( $rule );

			/**
			 * New subscribe rule is created.
			 * 
			 * @since 1.0.0
			 */
			do_action( 'asp_ssws_new_subscribe_rule', $rule->get_id(), $rule );
		}
	}

	/**
	 * Method to read data from the database.
	 * 
	 * @param  ASP_SSWS_Subscribe_Rule $rule
	 */
	public function read( &$rule ) {
		$rule->set_defaults();
		$post = get_post( $rule->get_id() );

		if ( ! $rule->get_id() || ! $post || $post->post_type !== $rule->get_type() ) {
			throw new Exception( esc_html__( 'Invalid subscribe rule.', 'subscribe-and-save-for-woocommerce-subscriptions' ) );
		}

		$rule->set_props(
				array(
					'name'          => $post->post_title,
					'date_created'  => $this->string_to_timestamp( $post->post_date_gmt ),
					'date_modified' => $this->string_to_timestamp( $post->post_modified_gmt ),
					'status'        => $post->post_status,
					'description'   => $post->post_content,
				)
		);

		$this->read_rule_data( $rule, $post );
		$rule->read_meta_data();
		$rule->set_object_read( true );
	}

	/**
	 * Method to update changes in the database.
	 * 
	 * @param  ASP_SSWS_Subscribe_Rule $rule
	 */
	public function update( &$rule ) {
		$rule->save_meta_data();
		$rule->set_version( ASP_SSWS_VERSION );

		if ( ! $rule->get_date_created( 'edit' ) ) {
			$rule->set_date_created( time() );
		}

		$changes = $rule->get_changes();

		// Only update the post when the post data changes.
		if ( array_intersect( array( 'date_created', 'date_modified', 'status', 'name', 'description' ), array_keys( $changes ) ) ) {
			$post_data = array(
				'post_date'         => gmdate( 'Y-m-d H:i:s', $rule->get_date_created( 'edit' )->getOffsetTimestamp() ),
				'post_date_gmt'     => gmdate( 'Y-m-d H:i:s', $rule->get_date_created( 'edit' )->getTimestamp() ),
				'post_status'       => $this->get_post_status( $rule ),
				'post_title'        => $this->get_post_title( $rule ),
				'post_content'      => $rule->get_description(),
				'post_modified'     => isset( $changes[ 'date_modified' ] ) ? gmdate( 'Y-m-d H:i:s', $rule->get_date_modified( 'edit' )->getOffsetTimestamp() ) : current_time( 'mysql' ),
				'post_modified_gmt' => isset( $changes[ 'date_modified' ] ) ? gmdate( 'Y-m-d H:i:s', $rule->get_date_modified( 'edit' )->getTimestamp() ) : current_time( 'mysql', 1 ),
			);

			/**
			 * When updating this object, to prevent infinite loops, use $wpdb
			 * to update data, since wp_update_post spawns more calls to the
			 * save_post action.
			 *
			 * This ensures hooks are fired by either WP itself (admin screen save),
			 * or an update purely from CRUD.
			 */
			if ( doing_action( 'save_post' ) ) {
				$GLOBALS[ 'wpdb' ]->update( $GLOBALS[ 'wpdb' ]->posts, $post_data, array( 'ID' => $rule->get_id() ) );
				clean_post_cache( $rule->get_id() );
			} else {
				wp_update_post( array_merge( array( 'ID' => $rule->get_id() ), $post_data ) );
			}

			$rule->read_meta_data( true ); // Refresh internal meta data, in case things were hooked into `save_post` or another WP hook.
		}

		$this->update_post_meta( $rule );
		$rule->apply_changes();
		$this->clear_caches( $rule );
	}

	/**
	 * Delete an object, set the ID to 0.
	 *
	 * @param  ASP_SSWS_Subscribe_Rule $rule
	 * @param array $args Array of args to pass to the delete method.
	 */
	public function delete( &$rule, $args = array() ) {
		$id   = $rule->get_id();
		$args = wp_parse_args( $args, array(
			'force_delete' => false,
				) );

		if ( ! $id ) {
			return;
		}

		if ( $args[ 'force_delete' ] ) {
			wp_delete_post( $id );
			$rule->set_id( 0 );

			/**
			 * Subscribe rule is deleted.
			 * 
			 * @since 1.0.0
			 */
			do_action( 'asp_ssws_delete_subscribe_rule', $id );
		} else {
			wp_trash_post( $id );
			$rule->set_status( 'trash' );

			/**
			 * Subscribe rule is trashed.
			 * 
			 * @since 1.0.0
			 */
			do_action( 'asp_ssws_trash_subscribe_rule', $id );
		}
	}

	/*
	  |--------------------------------------------------------------------------
	  | Additional Methods
	  |--------------------------------------------------------------------------
	 */

	/**
	 * Get the status to save to the post object.
	 *
	 * @param  ASP_SSWS_Subscribe_Rule $rule
	 * @return string
	 */
	protected function get_post_status( $rule ) {
		$post_status = $rule->get_status( 'edit' );

		if ( ! $post_status ) {
			/**
			 * Get the subscribe rule default status.
			 * 
			 * @since 1.0.0
			 */
			$post_status = apply_filters( 'asp_ssws_default_subscribe_rule_status', 'active' );
		}

		if ( in_array( 'asp-' . $post_status, $rule->get_valid_statuses() ) ) {
			$post_status = 'asp-' . $post_status;
		}

		return $post_status;
	}

	/**
	 * Get the title to save to the post object.
	 *
	 * @param  ASP_SSWS_Subscribe_Rule $rule
	 * @return string
	 */
	protected function get_post_title( $rule ) {
		return $rule->get_name() ? $rule->get_name() : __( 'Subscribe Rule', 'subscribe-and-save-for-woocommerce-subscriptions' );
	}

	/**
	 * Read subscribe rule data from the database.
	 *
	 * @param  ASP_SSWS_Subscribe_Rule $rule
	 * @param object $post_object Post object.
	 */
	protected function read_rule_data( &$rule, $post_object ) {
		foreach ( $this->internal_meta_key_to_props as $meta_key => $prop ) {
			$setter = "set_$prop";
			if ( is_callable( array( $rule, $setter ) ) && metadata_exists( 'post', $rule->get_id(), "$meta_key" ) ) {
				$rule->{$setter}( get_post_meta( $rule->get_id(), "$meta_key", true ) );
			}
		}
	}

	/**
	 * Update meta data in, or delete it from, the database.
	 * As WC defined this method @since 3.6.0 and so we reuse this method here to make it compatible with v3.5.x too.
	 *
	 * @param WC_Data $object The WP_Data object
	 * @param string  $meta_key Meta key to update.
	 * @param mixed   $meta_value Value to save.
	 * @return bool True if updated/deleted.
	 */
	protected function update_or_delete_post_meta( $object, $meta_key, $meta_value ) {
		if ( is_callable( array( get_parent_class( $this ), 'update_or_delete_post_meta' ) ) ) {
			$updated = parent::update_or_delete_post_meta( $object, $meta_key, $meta_value );
		} elseif ( in_array( $meta_value, array( array(), '' ), true ) ) {
			$updated = delete_post_meta( $object->get_id(), $meta_key );
		} else {
			$updated = update_post_meta( $object->get_id(), $meta_key, $meta_value );
		}

		return ( bool ) $updated;
	}

	/**
	 * Helper method that updates all the post meta for an rule.
	 * 
	 * @param  ASP_SSWS_Subscribe_Rule $rule
	 */
	protected function update_post_meta( &$rule ) {
		$updated_props   = array();
		$props_to_update = $this->get_props_to_update( $rule, $this->internal_meta_key_to_props );

		foreach ( $props_to_update as $meta_key => $prop ) {
			$getter = "get_$prop";
			$value  = is_callable( array( $rule, $getter ) ) ? $rule->{$getter}( 'edit' ) : '';
			$value  = is_string( $value ) ? wp_slash( $value ) : $value;

			$updated = $this->update_or_delete_post_meta( $rule, $meta_key, $value );
			if ( $updated ) {
				$updated_props[] = $prop;
			}
		}

		/**
		 * Subscribe rule object updated its props.
		 * 
		 * @since 1.0.0
		 */
		do_action( 'asp_ssws_subscribe_rule_object_updated_props', $rule, $updated_props );
	}

	/**
	 * Clear any caches.
	 *
	 * @param  ASP_SSWS_Subscribe_Rule $rule
	 */
	protected function clear_caches( &$rule ) {
		clean_post_cache( $rule->get_id() );
	}

	/**
	 * Converts a WP post date string into a timestamp.
	 *
	 * @param  string $time_string The WP post date string.
	 * @return int|null The date string converted to a timestamp or null.
	 */
	protected function string_to_timestamp( $time_string ) {
		return '0000-00-00 00:00:00' !== $time_string ? wc_string_to_timestamp( $time_string ) : null;
	}
}
