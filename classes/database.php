<?php

// Include the configuration file
include_once(__DIR__ . "/../settings/settings.php");

class Db {
    private static $conn;

    public static function getConnection() {
        // Get database settings from SETTINGS constant
        $host = SETTINGS['db']['host'];
        $user = SETTINGS['db']['user'];
        $password = SETTINGS['db']['password'];
        $dbname = SETTINGS['db']['database'];

        if (self::$conn === null) {
            self::$conn = new mysqli($host, $user, $password, $dbname);
            /*if (self::$conn->connect_error) {
                die("Connection failed: " . self::$conn->connect_error);
            }*/
            return self::$conn;
        }
            return self::$conn;
    }
}
?>
