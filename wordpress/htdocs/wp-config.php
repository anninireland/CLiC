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
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'bitnami_wordpress');

/** MySQL database username */
define('DB_USER', 'bn_wordpress');

/** MySQL database password */
define('DB_PASSWORD', 'f87f6352fb');

/** MySQL hostname */
define('DB_HOST', 'localhost:3306');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'fc27b1ba192e384be79a9520818fef6660a149ca2d622e6c271d9c84ef388ee8');
define('SECURE_AUTH_KEY',  'fa6c65d5cfa21ca056ea536c11f01c40e356fb2dc18aa79052e3c93493ead599');
define('LOGGED_IN_KEY',    '5b796b207f4fcb43bfe79a390ff45d28e7653ba08c3a15a962ffc45e40bb4e36');
define('NONCE_KEY',        'a81964e62e80a34772a3efb68aa3085e69eca60b3c053655a6b8f9321d296e7b');
define('AUTH_SALT',        '904f91199e35ad4002d6c252c3ddce1310fbfd61d07a701f6f2d904bdb69ad18');
define('SECURE_AUTH_SALT', 'ee0c0395bbfce301a57838facc1aacd9c854d0e4a1d3bf6bd14e6c4a76ee67ff');
define('LOGGED_IN_SALT',   '25336ab19b7e595cb2c1d14df6a18645bf7fc74a62e9c947795aec95e639911b');
define('NONCE_SALT',       'c835c7d7230f0b91e447036ba6dfe0a39e3e1012b67e9ac1fc853f828d14171d');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', true );
define( 'SCRIPT_DEBUG', true );
define( 'SAVEQUERIES', true );

/* That's all, stop editing! Happy blogging. */
/**
 * The WP_SITEURL and WP_HOME options are configured to access from any hostname or IP address.
 * If you want to access only from an specific domain, you can modify them. For example:
 *  define('WP_HOME','http://example.com');
 *  define('WP_SITEURL','http://example.com');
 *
*/

define('WP_SITEURL', 'http://' . $_SERVER['HTTP_HOST'] . '/wordpress');
define('WP_HOME', 'http://' . $_SERVER['HTTP_HOST'] . '/wordpress');


/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

define('WP_TEMP_DIR', 'C:/xampp/apps/wordpress/tmp');


/*
Added code: 
*/


