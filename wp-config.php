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
define( 'DB_NAME', 'wp_real_estate' );

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
define( 'AUTH_KEY',         '(5LR{~wLd-p!5WZp>Uzwytc#y:<bnEbAK~$!>t~LBGo,WEFa%_sE]oC|sB:))n?M' );
define( 'SECURE_AUTH_KEY',  '.IY<`N<uaJ:DT/JJaV(YJT3MjmM|MJw%u8TxDWUt-1}]7P~g3QGw-O{J?)iCOSJS' );
define( 'LOGGED_IN_KEY',    'Yfc*=3HZO/.:0sZtXIMHkdsuN-a({-|,PmGC56q,<m#wt{2,uq:Sk.}MSNLU/JtP' );
define( 'NONCE_KEY',        '^KBd*h[GrVtcOnF*?EKm_SdJAYCg{qw6S/|e;ul#p*p$<k3HD ^QB!PCLF*E*-J1' );
define( 'AUTH_SALT',        '|tW8M%{S.>`p7,L>.KLGZONsp#4=09d ?7VKhnn^Y4?cdRSvj*{;p7CF^sJ[l^ka' );
define( 'SECURE_AUTH_SALT', '~syQ:C q,GZphR:+8)x>B(tW7)_$XXvB?H?{ti*b,+Ay0/KJXNiH&zmV)k|Fxl{g' );
define( 'LOGGED_IN_SALT',   'nmm,})ZBEw;?9p%7,-C)3eS).?wZFbISH.n?d:qXB7syP]?~`sgm*C@Ls7>t. $e' );
define( 'NONCE_SALT',       'TLzE]E]FV>HqQI98b[lr`DDCg3KOav)n`?c=hmL@)7n[- w8f>U;[<?:4{c,?%F5' );

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
