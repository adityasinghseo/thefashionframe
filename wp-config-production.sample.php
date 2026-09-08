<?php
/**
 * Hostinger Production Database Settings
 *
 * When deploying to Hostinger:
 * 1. Create a MySQL database and user in Hostinger hPanel -> Databases.
 * 2. Copy this file to "wp-config-production.php" inside public_html.
 * 3. Update the DB_NAME, DB_USER, and DB_PASSWORD below with your Hostinger database details.
 *
 * Note: wp-config-production.php is ignored by git so your server credentials
 * will never be committed or overwritten by git pulls!
 */

define( 'DB_NAME', 'your_hostinger_db_name' );
define( 'DB_USER', 'your_hostinger_db_user' );
define( 'DB_PASSWORD', 'your_hostinger_db_password' );
define( 'DB_HOST', 'localhost' );
