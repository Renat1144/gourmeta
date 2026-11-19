<?php

define( 'DB_NAME', 'gourmeta' );
define( 'DB_USER', 'gourmeta' );
define( 'DB_PASSWORD', trim( file_get_contents( '/run/secrets/db_password' ) ) );
define( 'DB_HOST', 'db' );
define( 'DB_CHARSET', 'utf8' );
define( 'DB_COLLATE', '' );

$table_prefix = 'wp_';

$gourmeta_local_salt = trim( file_get_contents( '/run/secrets/wp_salt' ) );
foreach ( array( 'AUTH_KEY', 'SECURE_AUTH_KEY', 'LOGGED_IN_KEY', 'NONCE_KEY', 'AUTH_SALT', 'SECURE_AUTH_SALT', 'LOGGED_IN_SALT', 'NONCE_SALT' ) as $gourmeta_local_key ) {
	define( $gourmeta_local_key, hash_hmac( 'sha512', $gourmeta_local_key, $gourmeta_local_salt ) );
}
unset( $gourmeta_local_salt, $gourmeta_local_key );

define( 'WP_HOME', getenv( 'GOURMETA_LOCAL_URL' ) );
define( 'WP_SITEURL', WP_HOME );
define( 'WP_ENVIRONMENT_TYPE', 'local' );
define( 'AUTOMATIC_UPDATER_DISABLED', true );
define( 'DISABLE_WP_CRON', true );
define( 'WP_HTTP_BLOCK_EXTERNAL', true );

if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}
require_once ABSPATH . 'wp-settings.php';
