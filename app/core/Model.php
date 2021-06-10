<?php

namespace App\core;

class Model
{
    private static $instance;

    public static function getConn()
    {
        if(!isset(self::$instance)){
            self::$instance = new \PDO("mysql:host=localhost;dbname=db_php_mvc;charset=utf8", 'root', 'admin@123');
        }

        return self::$instance;
    }
}
