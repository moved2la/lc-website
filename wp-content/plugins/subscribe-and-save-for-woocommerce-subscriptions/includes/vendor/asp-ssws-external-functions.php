<?php

defined( 'ABSPATH' ) || exit;

/**
 * Includes the file.
 *
 * @param string $dir
 */
function asp_ssws_may_include_file( $dir ) {
    if ( is_readable( $dir ) ) {
        require_once $dir;
    }
}
