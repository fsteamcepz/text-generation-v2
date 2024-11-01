<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'text_generation' );

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
define( 'AUTH_KEY',         '[caxFfk;KLzqlh`UM%EB>#wfG@99)3#t`_+UY0~CuH*M2XdAmjpI6:PU3D=d5qSh' );
define( 'SECURE_AUTH_KEY',  'j^e|X:o(JDpQ/Hsz{2j t(I a<t)_0 3[z/X&L!:dG[lSt+JrMy:6kI8]tU@b]!&' );
define( 'LOGGED_IN_KEY',    'LfZs+lW]>Kf>wjWM6+j@yb~/^*7V4x:%JU,Q4Dy]s75ZW:S@n1dz=ar&Hh]Mm&~p' );
define( 'NONCE_KEY',        '*F-7nC*W%L<R[5?tY;!FB(zh5}8KnH?w5Uo_Wvla~Ow9}z@32Vw-Q62`YMC`?qnf' );
define( 'AUTH_SALT',        'EWzt/vX+m*S>;g7dgbHge{RK)9<u)[o7k%dq?@1IJD6ble2NU+)o)T- VArB+dEH' );
define( 'SECURE_AUTH_SALT', 'ftgO0K#3It%5/C!%|!@`@<tfccz#~Wcgn <2Q$9/7[AMW!b2r2AYk_%:^L8qzsAE' );
define( 'LOGGED_IN_SALT',   'ZsCYe,~bg`qezrx4jkw}T~2u8^jaS|LvRl^;,$=2!.P2sXHuwoz)w/V=%GS-4l22' );
define( 'NONCE_SALT',       'nbMxo=+-BPa9:{W])r|G%,~B[<0((JCX(C5]|?)uxvc.(/tI|47OJBnaNUTVaz[X' );

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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);	/* true */

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
