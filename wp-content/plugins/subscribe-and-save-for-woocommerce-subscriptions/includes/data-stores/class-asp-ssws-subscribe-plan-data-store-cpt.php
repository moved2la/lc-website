<?php

defined( 'ABSPATH' ) || exit;

/**
 * Subscribe Plan Data Store CPT
 * 
 * @class ASP_SSWS_Subscribe_Plan_Data_Store_CPT
 * @package Class
 */
class ASP_SSWS_Subscribe_Plan_Data_Store_CPT extends WC_Data_Store_WP implements WC_Object_Data_Store_Interface {

	/**
	 * Internal meta type used to store subscribe plan data.
	 *
	 * @var string
	 */
	protected $meta_type = 'post';

	/**
	 * Data stored in meta keys, but not considered "meta" for an subscribe plan.
	 *
	 * @var array
	 */
	protected $internal_meta_keys = array(
		'_version'                        => 'version',
		'_definition'                     => 'definition',
		'_subscription_discount'          => 'subscription_discount',
		'_subscription_sign_up_fee'       => 'subscription_sign_up_fee',
		'_subscription_trial_period'      => 'subscription_trial_period',
		'_subscription_trial_length'      => 'subscription_trial_length',
		'_subscription_period'            => 'subscription_period',
		'_subscription_period_interval'   => 'subscription_period_interval',
		'_subscription_length'            => 'subscription_length',
		'_subscription_payment_sync_date' => 'subscription_payment_sync_date',
		'_subscription_interval_length'   => 'subscription_interval_length',
	);

	/*
	  |--------------------------------------------------------------------------
	  | CRUD Methods
	  |--------------------------------------------------------------------------
	 */

	/**
	 * Method to create a new subscribe plan in the database.
	 *
	 * @param ASP_SSWS_Subscribe_Plan $subscribe_plan object.
	 */
	public function create( &$subscribe_plan ) {
		$subscribe_plan->set_version( ASP_SSWS_VERSION );
		$subscribe_plan->set_date_created( time() );

		/**
		 * New subscribe plan data
		 * 
		 * @since 1.0.0
		 */
		$id = wp_insert_post( apply_filters( 'asp_ssws_new_subscribe_plan_data', array(
			'post_date'     => gmdate( 'Y-m-d H:i:s', $subscribe_plan->get_date_created( 'edit' )->getOffsetTimestamp() ),
			'post_date_gmt' => gmdate( 'Y-m-d H:i:s', $subscribe_plan->get_date_created( 'edit' )->getTimestamp() ),
			'post_type'     => $subscribe_plan->get_type( 'edit' ),
			'post_status'   => $this->get_post_status( $subscribe_plan ),
			'ping_status'   => 'closed',
			'post_author'   => 1,
			'post_parent'   => 0,
			'menu_order'    => $subscribe_plan->get_priority(),
			'post_title'    => $this->get_post_title( $subscribe_plan ),
			'post_excerpt'  => $this->get_post_excerpt( $subscribe_plan ),
			'post_content'  => $this->get_post_content( $subscribe_plan ),
				) ), true );

		if ( $id && ! is_wp_error( $id ) ) {
			$subscribe_plan->set_id( $id );
			$this->update_post_meta( $subscribe_plan );
			$subscribe_plan->save_meta_data();
			$subscribe_plan->apply_changes();
			$this->clear_caches( $subscribe_plan );

			/**
			 * New subscribe plan
			 * 
			 * @since 1.0.0
			 */
			do_action( 'asp_ssws_new_subscribe_plan', $subscribe_plan->get_id(), $subscribe_plan );
		}
	}

	/**
	 * Method to read an subscribe plan from the database.
	 *
	 * @param ASP_SSWS_Subscribe_Plan $subscribe_plan object.
	 * @throws Exception If passed payment is invalid.
	 */
	public function read( &$subscribe_plan ) {
		$subscribe_plan->set_defaults();
		$post_object = get_post( $subscribe_plan->get_id() );

		if ( ! $subscribe_plan->get_id() || ! $post_object || $subscribe_plan->get_type() !== $post_object->post_type ) {
			throw new Exception( esc_html__( 'Invalid subscribe plan.', 'subscribe-and-save-for-woocommerce-subscriptions' ) );
		}

		$subscribe_plan->set_props(
				array(
					'parent_id'     => 0,
					'date_created'  => 0 < $post_object->post_date_gmt ? $this->string_to_timestamp( $post_object->post_date_gmt ) : null,
					'date_modified' => 0 < $post_object->post_modified_gmt ? $this->string_to_timestamp( $post_object->post_modified_gmt ) : null,
					'status'        => $post_object->post_status,
					'name'          => $post_object->post_title,
					'slug'          => $post_object->post_excerpt,
					'priority'      => $post_object->menu_order,
				)
		);

		$this->read_subscribe_plan_data( $subscribe_plan, $post_object );
		$subscribe_plan->read_meta_data();
		$subscribe_plan->set_object_read( true );
	}

	/**
	 * Method to update an subscribe plan in the database.
	 *
	 * @param ASP_SSWS_Subscribe_Plan $subscribe_plan object.
	 */
	public function update( &$subscribe_plan ) {
		$subscribe_plan->save_meta_data();
		$subscribe_plan->set_version( ASP_SSWS_VERSION );

		if ( null === $subscribe_plan->get_date_created( 'edit' ) ) {
			$subscribe_plan->set_date_created( time() );
		}

		$changes = $subscribe_plan->get_changes();

		// Only update the post when the post data changes.
		if ( array_intersect( array( 'date_created', 'date_modified', 'status', 'name', 'slug', 'priority' ), array_keys( $changes ) ) ) {
			$post_data = array(
				'post_date'         => gmdate( 'Y-m-d H:i:s', $subscribe_plan->get_date_created( 'edit' )->getOffsetTimestamp() ),
				'post_date_gmt'     => gmdate( 'Y-m-d H:i:s', $subscribe_plan->get_date_created( 'edit' )->getTimestamp() ),
				'post_status'       => $this->get_post_status( $subscribe_plan ),
				'post_author'       => 1,
				'post_parent'       => 0,
				'menu_order'        => $subscribe_plan->get_priority(),
				'post_title'        => $this->get_post_title( $subscribe_plan ),
				'post_excerpt'      => $this->get_post_excerpt( $subscribe_plan ),
				'post_content'      => $this->get_post_content( $subscribe_plan ),
				'post_modified'     => isset( $changes[ 'date_modified' ] ) ? gmdate( 'Y-m-d H:i:s', $subscribe_plan->get_date_modified( 'edit' )->getOffsetTimestamp() ) : current_time( 'mysql' ),
				'post_modified_gmt' => isset( $changes[ 'date_modified' ] ) ? gmdate( 'Y-m-d H:i:s', $subscribe_plan->get_date_modified( 'edit' )->getTimestamp() ) : current_time( 'mysql', 1 ),
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
				$GLOBALS[ 'wpdb' ]->update( $GLOBALS[ 'wpdb' ]->posts, $post_data, array( 'ID' => $subscribe_plan->get_id() ) );
				clean_post_cache( $subscribe_plan->get_id() );
			} else {
				wp_update_post( array_merge( array( 'ID' => $subscribe_plan->get_id() ), $post_data ) );
			}
			$subscribe_plan->read_meta_data( true ); // Refresh internal meta data, in case things were hooked into `save_post` or another WP hook.
		}

		$this->update_post_meta( $subscribe_plan );
		$subscribe_plan->apply_changes();
		$this->clear_caches( $subscribe_plan );
	}

	/**
	 * Method to delete an subscribe plan from the database.
	 *
	 * @param ASP_SSWS_Subscribe_Plan $subscribe_plan object.
	 * @param array $args Array of args to pass to the delete method.
	 */
	public function delete( &$subscribe_plan, $args = array() ) {
		$id   = $subscribe_plan->get_id();
		$args = wp_parse_args( $args, array(
			'force_delete' => false,
				) );

		if ( ! $id ) {
			return;
		}

		if ( $args[ 'force_delete' ] ) {
			wp_delete_post( $id );
			$subscribe_plan->set_id( 0 );

			/**
			 * Delete subscribe plan
			 * 
			 * @since 1.0.0
			 */
			do_action( 'asp_ssws_delete_subscribe_plan', $id );
		} else {
			wp_trash_post( $id );
			$subscribe_plan->set_status( 'trash' );

			/**
			 * Trash subscribe plan
			 * 
			 * @since 1.0.0
			 */
			do_action( 'asp_ssws_trash_subscribe_plan', $id );
		}
	}

	/*
	  |--------------------------------------------------------------------------
	  | Additional Methods
	  |--------------------------------------------------------------------------
	 */

	/**
	 * Get the subscribe plan status to save to the post object.
	 *
	 * @param  ASP_SSWS_Subscribe_Plan $subscribe_plan object.
	 * @return string
	 */
	protected function get_post_status( $subscribe_plan ) {
		$subscribe_plan_status = $subscribe_plan->get_status( 'edit' );

		if ( ! $subscribe_plan_status ) {
			/**
			 * Get subscribe plan default status
			 * 
			 * @since 1.0.0
			 */
			$subscribe_plan_status = apply_filters( 'asp_ssws_default_subscribe_plan_status', 'active' );
		}

		$post_status = $subscribe_plan_status;

		if ( ! in_array( $post_status, array( 'auto-draft', 'draft', 'trash' ), true ) && in_array( 'asp-' . $post_status, $subscribe_plan->get_valid_statuses() ) ) {
			$post_status = 'asp-' . $post_status;
		}

		return $post_status;
	}

	/**
	 * Excerpt for post.
	 *
	 * @param  ASP_SSWS_Subscribe_Plan $subscribe_plan object.
	 * @return string
	 */
	protected function get_post_excerpt( $subscribe_plan ) {
		return $subscribe_plan->get_slug();
	}

	/**
	 * Content for post.
	 *
	 * @param  ASP_SSWS_Subscribe_Plan $subscribe_plan object.
	 * @return string
	 */
	protected function get_post_content( $subscribe_plan ) {
		return '';
	}

	/**
	 * Get a title for the new post type.
	 *
	 * @return string
	 */
	protected function get_post_title( $subscribe_plan ) {
		return $subscribe_plan->get_name() ? $subscribe_plan->get_name() : __( 'Subscribe plan', 'subscribe-and-save-for-woocommerce-subscriptions' );
	}

	/**
	 * Read subscribe plan data.
	 *
	 * @param ASP_SSWS_Subscribe_Plan $subscribe_plan object.
	 * @param object   $post_object Post object.
	 */
	protected function read_subscribe_plan_data( &$subscribe_plan, $post_object ) {
		foreach ( $this->internal_meta_keys as $meta_key => $prop ) {
			$setter = "set_$prop";
			if ( is_callable( array( $subscribe_plan, $setter ) ) ) {
				$subscribe_plan->{$setter}( get_post_meta( $subscribe_plan->get_id(), "$meta_key", true ) );
			}
		}

		// Gets extra data associated with the subscribe plan if needed.
		foreach ( $subscribe_plan->get_extra_data_keys() as $key ) {
			$setter = "set_{$key}";
			if ( is_callable( array( $subscribe_plan, $setter ) ) ) {
				$subscribe_plan->{$setter}( get_post_meta( $subscribe_plan->get_id(), "_{$key}", true ) );
			}
		}
	}

	/**
	 * Updates all the post meta for an subscribe plan based.
	 *
	 * @param ASP_SSWS_Subscribe_Plan $subscribe_plan object.
	 */
	protected function update_post_meta( &$subscribe_plan ) {
		$updated_props   = array();
		$props_to_update = $this->get_props_to_update( $subscribe_plan, $this->internal_meta_keys );

		foreach ( $props_to_update as $meta_key => $prop ) {
			$getter = "get_$prop";
			$value  = is_callable( array( $subscribe_plan, $getter ) ) ? $subscribe_plan->{$getter}( 'edit' ) : '';
			$value  = is_string( $value ) ? wp_slash( $value ) : $value;

			switch ( $prop ) {
				case 'date_created':
				case 'date_modified':
					$value = ! is_null( $value ) ? $value->getTimestamp() : '';
					break;
			}

			$updated = $this->update_or_delete_post_meta( $subscribe_plan, $meta_key, $value );
			if ( $updated ) {
				$updated_props[] = $prop;
			}
		}

		/**
		 * Subscribe plan updated props
		 * 
		 * @since 1.0.0
		 */
		do_action( 'asp_ssws_subscribe_plan_object_updated_props', $subscribe_plan, $updated_props );
	}

	/**
	 * Clear any caches.
	 *
	 * @param ASP_SSWS_Subscribe_Plan $subscribe_plan object.
	 */
	protected function clear_caches( &$subscribe_plan ) {
		clean_post_cache( $subscribe_plan->get_id() );
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
