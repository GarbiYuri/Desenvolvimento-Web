
<?php
//src/database/Connection.php

class Connection
{
    private static $instance = null;

    public static function getConnection()
    {
        if (self::$instance === null) {
            $config = require __DIR__ . '/../../config/config.php';
            
            self::$instance = new PDO(
                "mysql:host={$config['host']};dbname={$config['dbname']}",
                 $config['user'],
                 $config['password'],
                 [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        }

        return self::$instance;
    }
}