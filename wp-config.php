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
define('FS_METHOD','direct');

//define( 'WP_CONTENT_DIR', '/Applications/XAMPP/xamppfiles/htdocs/wordpresstest/wp-content' );


define( 'DB_NAME', 'wordpresstest' );

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
define( 'AUTH_KEY',         'czX(4*~SeaoC*7cSK2Cw(x~+0k4^VJb{W.M,xq4zZ(`d>]lq%epzQd<ke$K[E90q' );
define( 'SECURE_AUTH_KEY',  'GK=im8<cD9J=/t`:i;P6f!=`I!R3[FeW#XIg[~]T}ARoE 5!W`ya9l:Bfu6^JF!3' );
define( 'LOGGED_IN_KEY',    '9v$*2?}UZ&DO_f9R:|?iSG(Bwm/l/9y8+#T58Ha/_hYrqBn{Y@`)D#gTCVfn.M~$' );
define( 'NONCE_KEY',        'T9BaloS5u+1QbXCmu}Q_ T:@zq,ul2%:i VO!FoCf;/}4U={M@Z[x8JHN{ehKZT1' );
define( 'AUTH_SALT',        '?$/T/uNTs|SeBF|{s-IcE#d/c{z`sO Ea8IvQD]=/mcc8Kmue2OlTE`Ootk4?6Vv' );
define( 'SECURE_AUTH_SALT', 'K_s-?L-m#7=T)3>%ZL|kv=jZn-wI$1DYC/f?k81~?7(wI;`2aQN!v|ljN<_I%^zL' );
define( 'LOGGED_IN_SALT',   ')H5pw$htc}XNw@DV[E]u0C8%r!8 )Gx K8f>Yr3Lz18,O?v6EpD&hVH-d76CSQ.a' );
define( 'NONCE_SALT',       ')tyK|c0f!v/t_[j1r]k_=N#-3hV=WEsUCw0Pnl}^vb]>;GOAcyPVy|wB/hn8l;yy' );

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
