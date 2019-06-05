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
define('DB_NAME', 'gulp_test');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

define ( 'WP_AUTO_UPDATE_CORE', false);


/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'i/Hw<%~5@s}dX4do7|UxVbPhKMK>!y lXW%i}tee,D9^@]x^N5gKH:>YuV^@,k79');
define('SECURE_AUTH_KEY',  '2?0F4vEW(N,iZlcz;@Q|~V%b)9sNLE+~EpB8epo~{N3uM/Nre>(]ZPW,geX^jdZs');
define('LOGGED_IN_KEY',    '-y_:,Af%mn(0}uk9BoKXMj[my-(:F>PmINw`:A+eWR[d|u++v8SI AjzCI]c@VhJ');
define('NONCE_KEY',        'X^jn0dkd_+B{GfxZ8V^ZAV_BbX)aT7@GZY4V|F30<rXN/K:gOn,;@ju1cO:hDPbt');
define('AUTH_SALT',        '2B]04wu^Eh}P0lO%#qEN3RDZJ(ObZ_T JO5N#3+Vh7-mn*$@COO92^+a$1<qnQH-');
define('SECURE_AUTH_SALT', 'yi;A&$ra(J=@-w7S$k);`)`htxG$eS0:4_Ee4l2uV+1WU_Z^ua0%c:g(T([vKC9n');
define('LOGGED_IN_SALT',   'ur2|1Wl~k528SWjlxp^-C|v8h+`ylegq*P?H7S).sQ~,#DQOj88ado{6.;q!7&_E');
define('NONCE_SALT',       '[8,i!1wP#GD%S1KzG}5WfH0-po1Aq9PitZW@hjZ1|lgCNWaTYY!S:&8q.L8pM[}b');

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
