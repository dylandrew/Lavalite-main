<?php
//Dev or Prod
define('IS_DEV', false);

//Database Config
define('DB_DRIVER', 'mysql');
define('DB_HOST', getenv('MYSQLHOST') ?: 'localhost');
define('DB_PORT', getenv('MYSQLPORT') ?: '3306');
define('DB_NAME', getenv('MYSQLDATABASE') ?: 'danar_dylan_andrew_db');
define('DB_USERNAME', getenv('MYSQLUSER') ?: 'root');
define('DB_PASSWORD', getenv('MYSQLPASSWORD') ?: 'dylanpogi06');
define('DB_CHARSET', 'utf8mb4');
define('DB_PREFIX', '');
define('DB_PATH', '');