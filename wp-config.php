<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wp_livecomplete' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'MQ,En<%lp,v^ ;Ntg([Rvg4);Av3~I!p4GDa3[^|(jh}KA.I(`{O rPh}k=lF[B{' );
define( 'SECURE_AUTH_KEY',  'm39nw}0(h }D,N6k*=~g{VS>Y-QWK4M)v`tY2J>lqJbvAvtyLN&8WhO2dLWPM%<M' );
define( 'LOGGED_IN_KEY',    'LOs^ N$AyRK?og[>;!$^uiaRr!Ca(42P}(i>7jac5@W[ii}--H]~G+u2*i!20rgm' );
define( 'NONCE_KEY',        'mHs&UW{/5`X @1SFSj}WLyj-MzoX1K[IL>{HY%;l3)I_ewbu08A*ej#>H!KYDN+p' );
define( 'AUTH_SALT',        '&YW=<(Fm%|ojR/9CnGWcR/J[a3*V7u?2b.6-U6~9u*!{@%~C[3xpaNJ`++!No@0(' );
define( 'SECURE_AUTH_SALT', '@:|+JF6;^$iiXN 5y)1C/jfEkt0Ll}}({33~MLB%4^AXPQCEE[=k)9mj6lF4i3(I' );
define( 'LOGGED_IN_SALT',   '+7lldH<C*Y7KVk#A(QQM}fvhApIq,s^2WY,VBY3m9EIsu`ADPC(2,ccwDnP;fR[3' );
define( 'NONCE_SALT',       '/~Nk(xm4F-?+oN:%Ji8=RbX })edYdSrf+Pg`sJ}PaAF55%:)W%9kaC^!v{Geb{,' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', true );
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);
@ini_set('display_errors', E_ALL ^ E_DEPRECATED);

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
