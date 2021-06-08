<?php
class Database
{

    public function get_connection()
    {
        include (dirname(dirname(__DIR__)) . '/secret.php');
        try
        {
            $conn = new PDO("mysql:host=localhost;dbname=szantog82", constant('DB_LOGIN') , constant('DB_PWD'), array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $e)
        {
            echo "Connection failed to db: " . $e->getMessage();
        }

        return $conn;
    }

}

?>