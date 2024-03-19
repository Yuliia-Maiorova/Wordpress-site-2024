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
define( 'DB_NAME', 'wordpress' );

/** Database username */
define( 'DB_USER', 'wordpress' );

/** Database password */
define( 'DB_PASSWORD', '<kyungsoo27>' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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

define('AUTH_KEY',         '#3+Qz)yh4K]DO:3/+]fl2BS@+JF<?3}$@$-KeXDXe5?Mav!WtRSFUGuW:mTmI![i');
define('SECURE_AUTH_KEY',  'o|s|gmYrrm}A|VYN3EKKN#>#Mk}+WoY%$VB;oMUy&PDuq|T_uL,z<g;z1U?]){k|');
define('LOGGED_IN_KEY',    'C} %KACV:-|H6E~(v+Af,``}f(@~;9{q%gNRw#MqPM2ot9xmM7SdFP|DV(~7zxi>');
define('NONCE_KEY',        'z6QRl=c.;^v9@ZnO+J3KN;{Mk.{G#m*~$j|xDgBGh]_eNt7tWq-|>h804V<)UI8P');
define('AUTH_SALT',        'N3Oe1%g-xoK)s-?}?}skx&V(h|y6CUG*!*/#g3..A9PZkk7SBq+>|5$uPQs0kI@(');
define('SECURE_AUTH_SALT', 'R;R>]LR9fx&e0`B@^WE,!i^C$~Yj%1B^|cVS|~n#|1=Jvp&HyJY?;i2[G;AY*$+E');
define('LOGGED_IN_SALT',   '<cJ66]cJGMl/C3]#F@+F{uZ2:]sP15flk5]cPmo}@E^q-+Pb8u)/Ene0T:R{J{$W');
define('NONCE_SALT',       'O2Uy7L3lS-;5g.WPvM-6Z+7!4XlwKVf6$Kf,Y;925X$3Mu-RVCx67/F|9Q8TkB9n');

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
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
