<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'rmsltddb' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'b7^=}6YP3r/&OBzE%4AJL6.xr&s;P,9AqKv,#V(Fzxi|8+C2Cj?F(?X{UD`PcjDc' );
define( 'SECURE_AUTH_KEY',  'w)XE&y+dkG&Q,JsFpF4p:8Vt%SlfXP5/^`XaDkA+q00Y!>&W[2%{%.oAH?u~xc].' );
define( 'LOGGED_IN_KEY',    'Tn0HciEM5{ZQo#eq@Ys7FH9.PIW6]{X:#$G=)i.k~x5|?u%KR;zElo^<[=Mx.Oy5' );
define( 'NONCE_KEY',        ':iGQH%FxulC G*(,^f@ZlLCW^.HB|IjTZW<4S!fp&|OIdr:/`i|5G~tL`]dV 9!#' );
define( 'AUTH_SALT',        'z3(+ }[a}S(jKY,FnD/;N[M:?Z0OJzQck8&$o<DlfRfUDJ5!-|lavag=X2Kt$y..' );
define( 'SECURE_AUTH_SALT', '<9PPW8!]~-v|s_&JK<*9}.}.{j veI>xb5-@>:Tx=X`iDQBe#m6/eWLr+[vlW~>Y' );
define( 'LOGGED_IN_SALT',   '_Y*]Rm{Wo; &~f%DoDndec.[p.jS#Mtptl>3.cnXyLa4b@qja<N]VV{S-#sHnPI+' );
define( 'NONCE_SALT',       'gA ] >+{0e=+]40}P])7ty31t3}K]G/R?A){G8dSe_?K4+73D]@WcELFLa?&r9o:' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
