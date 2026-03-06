<?php
/**
 * AgriStack — Database Configuration
 */

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'agristack_db');
define('DB_PORT', 3306);

define('BASE_URL', 'https://agristack.infinityfree.me');
define('APP_NAME', 'AgriStack');
define('APP_VERSION', '1.0.0');

class Database {
    private static ?mysqli $instance = null;

    public static function getInstance(): mysqli {
        if (self::$instance === null) {
            self::$instance = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
            if (self::$instance->connect_error) {
                die('Database connection failed: ' . self::$instance->connect_error);
            }
            self::$instance->set_charset('utf8mb4');
        }
        return self::$instance;
    }

    private function __construct() {}
    private function __clone() {}
}
