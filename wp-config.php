<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link https://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('WP_CACHE', true); //Added by WP-Cache Manager
define( 'WPCACHEHOME', '/home/resonate/public_html/wp-content/plugins/wp-super-cache/' ); //Added by WP-Cache Manager
define('DB_NAME', 'resonate_resoBase');

/** MySQL database username */
define('DB_USER', 'resonate_wpAdmin');

/** MySQL database password */
define('DB_PASSWORD', 'go^iLT.6{xQt');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         'IyK{pEK0$L>Rn^Tf`Z]Li?QLkEwk[M,j_|jzcLcU,QnD7mAVENqzX5lvX$}+Q?>t');
define('SECURE_AUTH_KEY',  'huB@$Fcv|my0SOitQ|n/@YTc-A[lD-KK>g?@K`h##oDQt|N9I8Y<C9{F!T(Yv_ZF');
define('LOGGED_IN_KEY',    'WoK@Ajzn+X4B/4&&.R*kS,y^:,~aB|ymT-tA8*9)4nUn!%tW*R;N5h7]xGxP-4W(');
define('NONCE_KEY',        '|YI3M0P*ggb&:/z]?)H1YDlpYhk[VdkK*}4^pO{c<TZd`!#-z=t?lpn9bK +b-!O');
define('AUTH_SALT',        '~Bd_#25uVxsrQpU@R=;Sy4>ID|N)+z xxA?T~k1f<eC4^Vbm|H*4Su9g#UFg|Z;5');
define('SECURE_AUTH_SALT', '|L@/hMHqepd|rNdnokVlXs6-P8JwpAWFf3XSGjycl~x gC~4zS(6{Zyke!Wq(DqR');
define('LOGGED_IN_SALT',   'Hm4.5FqYnZ#Tvcd0OY:zR[=kj9-5]jn|^k@(xA+nrMX=QP#F2(1:[!9M3w|A=3[v');
define('NONCE_SALT',       '-+>O1j|PwX%z3l0I,TF!c8>l!^Fxh5XVt!W]n:u2UfyI> `A71::GQIz;68@iy3>');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'pres_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define( 'WP_DEBUG', false );
// error_reporting(0);
// @ini_set('display_errors', 0);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

// define( 'WP_MEMORY_LIMIT', '64M' );
