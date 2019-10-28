<?php

class DB
{
    public static $conn;
    public static function getConnection()
    {
        self::includeConstants();

        if(!isset(self::$conn))
            try{
                //self::$conn = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS, [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"]);
                self::$conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS, [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"]);
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$conn->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING);
                return self::$conn;
            }
            catch (PDOException $exception)
            {
                return $exception;
            }
    }
    public static function includeConstants()
    {
        include dirname(__DIR__)."/config/Constants.php";
    }
}