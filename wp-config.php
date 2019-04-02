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
define('DB_NAME', 'zoi');

/** MySQL database username */
define('DB_USER', 'zoi');

/** MySQL database password */
define('DB_PASSWORD', '310741');

/** MySQL hostname */
define('DB_HOST', 'localhost');

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
define('AUTH_KEY',         'Bu-~]SsU|E:|6+]<([Pq0qq|JyAIc{<>g@M:)W$~p@+qs6m1&Tf(                                                  KM~sbJeX0xu7');
define('SECURE_AUTH_KEY',  '2vA?autv[}#Eb*,-emkbth_}3X4SGUwX6Zeadf,7{~jK85$t*Y^b                                                  qt>:!aH0E:[g');
define('LOGGED_IN_KEY',    '/N} {`9|.Pk?,p|N(QQDp[RiR*1&SJSs=>X$,qmpQ&$SY,-q]bU}                                                  Z/=?~z5:|T4^');
define('NONCE_KEY',        'c5yB;1T/^&3hrV&/l]a/VKi%}/^1Ua*(DX_{c$[pf5-&nH+Sm,5:                                                  vQm)Z6uh1yMT');
define('AUTH_SALT',        'v?<JXI7APR]|-DS+l^`}|4C]P3|HcU-J>Ht8i-0)LT+<OhmrG=1:                                                  Kr(YDW@V`qF$');
define('SECURE_AUTH_SALT', 'l c$;tuS/N%:<3=+=z@DcH_y5THuFF)%_HI$;6WM fF^,2~+%#F}                                                  ,%udZJzH=j1.');
define('LOGGED_IN_SALT',   'trWX1{f<aU];:LT9@I3&lKt[(n|qn,EyB[M w,TjJYI}[szCe>S-                                                  y[s|Mn#n{u!g');
define('NONCE_SALT',       'n{1P^`lk/wOuf6OJ-lkYuEN$d{S<u$!X>SIjCtA+{)j%m8YYvVy;                                                  -]k>okSG]R-L');


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
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
