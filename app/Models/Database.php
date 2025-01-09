<?php
namespace App\Models;

use PDO;

class Database {
    private static $connection;

    public static function connect() {
        if (!self::$connection) {
            $config = require_once dirname(__DIR__, 2) . "/config/database.php";
            self::$connection = new PDO(
                "mysql:host={$config['host']};dbname={$config['dbname']}",
                $config['user'],
                $config['password']
            );
            self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$connection;
    }
}
