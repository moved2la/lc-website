<?php

defined( 'ABSPATH' ) || exit;

/**
 * Buy Now or Subscribe and Save for WooCommerce Subscriptions Autoloader.
 * 
 * @class ASP_SSWS_Autoloader
 */
class ASP_SSWS_Autoloader {

	/**
	 * The base path for autoloading.
	 *
	 * @var string
	 */
	protected $base_path = '';

	/**
	 * Construct ASP_SSWS_Autoloader
	 * 
	 * @param string $base_path
	 */
	public function __construct( $base_path ) {
		$this->base_path = untrailingslashit( $base_path );
	}

	/**
	 * Destructor.
	 */
	public function __destruct() {
		$this->unregister();
	}

	/**
	 * Determine whether we should autoload a given class.
	 *
	 * @param string $class The class name.
	 * @return bool
	 */
	protected function should_autoload( $class ) {
		// We're not using namespaces, so if the class has namespace separators, skip.
		if ( false !== strpos( $class, '\\' ) ) {
			return false;
		}

		//Make sure our classes are going to load
		return false !== strpos( $class, 'asp_ssws_' );
	}

	/**
	 * Determine if the class is one of our abstract classes.
	 *
	 * @param string $class The class name.
	 * @return bool
	 */
	protected function is_class_abstract( $class ) {
		static $abstracts = array(
			'asp_ssws_subscribe'        => true,
			'asp_ssws_subscribe_rule'   => true,
			'asp_ssws_admin_list_table' => true,
		);

		return isset( $abstracts[ $class ] );
	}

	/**
	 * Gets the base path for a given class.
	 *
	 * @return string
	 */
	public function get_class_base_path( $class ) {
		return $this->base_path;
	}

	/**
	 * Get the relative path for the class location.
	 * This handles all of the special class locations and exceptions.
	 *
	 * @param string $class The class name
	 * @return string 
	 */
	protected function get_relative_class_path( $class ) {
		$path = '/includes';

		if ( $this->is_class_abstract( $class ) ) {
			$path .= '/abstracts';
		} elseif ( false !== strpos( $class, '_data_store' ) ) {
			$path .= '/data-stores';
		} elseif ( false !== strpos( $class, 'meta_box_' ) ) {
			$path .= '/admin/meta-boxes';
		} elseif ( false !== strpos( $class, 'list_table_' ) ) {
			$path .= '/admin/list-tables';
		} elseif ( false !== strpos( $class, 'admin' ) ) {
			$path .= '/admin';
		}

		return trailingslashit( $path );
	}

	/**
	 * Convert the class name into an appropriate file name.
	 *
	 * @param string $class The class name.
	 * @return string The file name.
	 */
	protected function get_file_name( $class ) {
		$file_prefix = 'class-';

		if ( $this->is_class_abstract( $class ) ) {
			$file_prefix = 'abstract-';
		}

		return $file_prefix . str_replace( '_', '-', $class ) . '.php';
	}

	/**
	 * Register the autoloader.
	 */
	public function register() {
		spl_autoload_register( array( $this, 'autoload' ) );
	}

	/**
	 * Unregister the autoloader.
	 */
	public function unregister() {
		spl_autoload_unregister( array( $this, 'autoload' ) );
	}

	/**
	 * Autoload a class.
	 *
	 * @param string $class The class name to autoload.
	 */
	public function autoload( $class ) {
		$class = strtolower( $class );

		if ( $this->should_autoload( $class ) ) {
			$full_path = $this->get_class_base_path( $class ) . $this->get_relative_class_path( $class ) . $this->get_file_name( $class );

			asp_ssws_may_include_file( $full_path );
		}
	}
}
