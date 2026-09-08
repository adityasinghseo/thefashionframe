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
if ( file_exists( __DIR__ . '/wp-config-production.php' ) ) {
	require_once __DIR__ . '/wp-config-production.php';
} else {
	/** The name of the database for WordPress */
	define( 'DB_NAME', getenv( 'DB_NAME' ) ? getenv( 'DB_NAME' ) : 'local' );

	/** Database username */
	define( 'DB_USER', getenv( 'DB_USER' ) ? getenv( 'DB_USER' ) : 'root' );

	/** Database password */
	define( 'DB_PASSWORD', getenv( 'DB_PASSWORD' ) ? getenv( 'DB_PASSWORD' ) : 'root' );

	/** Database hostname */
	define( 'DB_HOST', getenv( 'DB_HOST' ) ? getenv( 'DB_HOST' ) : 'localhost' );
}

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
define( 'AUTH_KEY',          'KVER>-gCRxw;|1ZR)g :>dDd!bFhzgc&X;WwYxd>(~K}mmKn?MwFW<Jun]iL%|G&' );
define( 'SECURE_AUTH_KEY',   '*],i.dU;;aC4.RpD+V5DZ9oj^ysr5 NSpr2=7;Q|<;q6iJ 4I~w>sMtnF`!SoH1(' );
define( 'LOGGED_IN_KEY',     'Mb:_|zlT9+(JEr&-ql#w4O+1cWmIr]EX!(AGi*+ JF5y(dUuTNE!G(8DQI*K21Xt' );
define( 'NONCE_KEY',         'G2!(YJM|D$B ^? iV%e~EXerhA6!6RDOidm$ZX`qFr8Wm+@P?J@}WKQB0fwO[s0C' );
define( 'AUTH_SALT',         '$@1hsygy^TlA)u;yX8aeII4^,Jc~:W|u+~Pno]`Yk[ F:}X,sZyxj^5wTbv_y?P ' );
define( 'SECURE_AUTH_SALT',  'WP[zupVyZeMLL|X+CE(yQebWn65[mVE(9RZFK6F=LFpO{1Y=4IZ63.2<L1F.qM-&' );
define( 'LOGGED_IN_SALT',    '!>s5/6)WFK0S1e%qHhpZ?U$%;KhHob6o?hUgGr]V$:{N8x-`0HF#I/=ghxG6Qmq!' );
define( 'NONCE_SALT',        'PDj8b]I1Uj(#HdRND&*;s0r?~ExD}`Qg1RkxPglk/+!m`a::,LU7dpPf)~li(Bh0' );
define( 'WP_CACHE_KEY_SALT', '>H`A&|>JP5j*lgdo#ffJOO&FB`rn=QMEs.ai cPvsR:~5VM4$^6m8yS.biPwI1[d' );


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
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
