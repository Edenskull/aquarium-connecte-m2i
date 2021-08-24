<?php

class Database
{
    private static $dbHost = "sql4.freemysqlhosting.net";
    private static $dbName = "sql4432430";
    private static $dbUser = "sql4432430";
    private static $dbUserPassword = "vakT5EI9ft";
    private static $connection = null;

    public static function connect()
    {
        try {
            self::$connection = new PDO("mysql:host=" . self::$dbHost . ";dbname=" . self::$dbName, self::$dbUser, self::$dbUserPassword);
            self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            http_response_code(500);
            die($e->getMessage());
        }
        return self::$connection;
    }

    public static function disconnect()
    {
        self::$connection = null;
    }
}

?>
