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
define( 'DB_NAME', 'local' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '3MmApjal7wqpDRig+e+Ly8R7ZoU96TZXsBDMfnxx361z9PRRl1JPIjot/Lu68vy152ADVNtwZjZotOw5S+aaXA==');
define('SECURE_AUTH_KEY',  '4V6TZoEo/rd6iMf4Y2DwKPd4GZ2FCLc1rF5wvO7l0e+oXSW2ozDpyl4rS28maUv82k3NiizNbVj1zuhCN7fCFQ==');
define('LOGGED_IN_KEY',    'ZZseybr1z+D6Am4+f1Ly7bBaufZgRRiA5qmVTJOf4KnhcPdeUk5W5xI9BjyDiN7IRdV3UZ3NIJ4LAdPwYzRmtg==');
define('NONCE_KEY',        '5BprqSWzaWFKX9UXoieEtJJ7PYsY5eTfU4kIazfGqcVDB1m8eY4CSSyIZvLMr9cnd2Tzu5IPays/4N9TTlkM6A==');
define('AUTH_SALT',        'DqjhKtjkdAB1WIZ9zBpUZAF+T1KA/Wazw9VAxhOQOGStIthjyptrvEi5aC5mq5F4mLcGqG24NZOdob8VhwA3dw==');
define('SECURE_AUTH_SALT', 'opjYdo6idhj9ctCVfaazgR9TP6xoT3XG0XzmTr2TzslVpTOGdRH9CsiydBsSYLpRY5OrAxQiPxWtGGgC/kOnng==');
define('LOGGED_IN_SALT',   'jrX5BHO24rbGhruzzSo+ka3yTP7Lb9vXtVxUQ5Y1k8BUoPeJPqHNSkKY4S9Re9jJEqIEfeDHfMy21uYSYrUZrg==');
define('NONCE_SALT',       'I/D6idPkKnY7yjYKZBtG713LBgyxm0tuc8np2G9DQ8PDm2loU+aXe6jwYUjLPBkt6nOfriFbjadqykO5upf/zw==');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

define( 'WP_DEBUG', true);


/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
