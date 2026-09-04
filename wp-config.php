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
define( 'DB_NAME', 'wordpress' );

/** Database username */
define( 'DB_USER', 'admin' );

/** Database password */
define( 'DB_PASSWORD', '123' );

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
define( 'AUTH_KEY',         '<]L8gBJn:JMX&M&-asBYrw/.e-#2)DFRY~:)Nmq1y?{|>Yl63B5%U#EZJZQ6M+]5' );
define( 'SECURE_AUTH_KEY',  'c3H=Xz|d(N3,jw*uLSUwPTRQqlF}90KoX}E-cqv0 /`Id2`T l:S FnIOVYfi>vX' );
define( 'LOGGED_IN_KEY',    'Y~_^wz@7=5Yv>@/tq]^DAkp,0>46-`/X3RI1$sBBftp B>q03{cl* hEiAz+)v3*' );
define( 'NONCE_KEY',        'a@Cp5xk2okOq[ut^t41D:#``:VAf]N}k*W/q[lYgiU}I@hT/]*>Z8?ao~MYi0ewZ' );
define( 'AUTH_SALT',        '{PRaT5`|l?m2y/2}Bx0_O2xu31-9Gj^tMe)p*0dK_|7)0d_OUA ,kn^Yv;C$%4ab' );
define( 'SECURE_AUTH_SALT', 'QOzAF>XIK{lGCb<NA7sY<mJMOM)h~BWL|p.!<?%IcmMzph4Rg<D/?bL*,gl#ChNL' );
define( 'LOGGED_IN_SALT',   'PiQOE+>D60Qi_#k5~3{hVs;G9x%gad8gaT] 0SRN{pGLiSu7Ie(JQ|up88$-_GL?' );
define( 'NONCE_SALT',       'fP6#j>^[?/jWvb/sA-|jl?8GQReAy(#xy{x,PV}}X]LNgk`Wcox tt/KDJzQ&!g ' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
