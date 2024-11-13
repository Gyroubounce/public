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
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

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
define( 'AUTH_KEY',          'o4m9EsiXfA8$_q_~Z[`Pk}(Q2^nBm1o$N3RwJs_eQv0dB7euf9-lcSZ^QfN5I*)P' );
define( 'SECURE_AUTH_KEY',   'UUG&AY&AZ#U)j|B]7&(mg7M 8b/:&eu1Cp]n+NZx*ZO!p}Q=6eEBXJj|laX*2R?y' );
define( 'LOGGED_IN_KEY',     'hr:h[7~;dxgIM=>EP;[^H+9&1h4gqvNNQHW0V$pU.]n>N|6DMWbku):EztlNhxv$' );
define( 'NONCE_KEY',         '`5.zZ]L*Y<yk/JC0W)&Y_R9u?*.#DGrS/2r#qM[]s3I1FCatDL~w,tQ:i*G>Otit' );
define( 'AUTH_SALT',         '5nUbzC$45a7 z>XCiZ6]q%+m!M{u{3AP;8fEhau-{zni2gR_FK1ao<pUIct.@/ P' );
define( 'SECURE_AUTH_SALT',  'A%%UQjN+q=SnBkv>D!_:a?U t87=(?~4iV!Q3>g)*Br1i4NWg!5m_LKv-4oe/ru^' );
define( 'LOGGED_IN_SALT',    '8l$DHsHX`dxq%/>J} bk]<f4ooL?C5&Al2.-][yn(P;k$DRddKGjr%E`]X%%t>l;' );
define( 'NONCE_SALT',        'ip6K%`Fw]CQgtpn.@JOgbt&XGsoc*X6R[n#KXY|6N[0<V2Z{g6yPs9BfcYXL_%Z%' );
define( 'WP_CACHE_KEY_SALT', 'o HeP~WdVGEbyv``(>Pge!>qMh8!9!4wB|?iW|YHzPqyLlb/<KyO!9^McO+n3xxx' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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

define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', true );


define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */
define('WP_CACHE', false);

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
