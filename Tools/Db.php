<?php

require_once dirname(__FILE__) . "/../config/config.php";

class Db
{
    private static $instance = null;
    private static $PDO = null;

    private function __construct()
    {
        self::$PDO = new PDO('mysql:host=' . DB_SERVER . ';dbname=' . DB_NAME, DB_LOGIN, DB_PASS);
        self::$PDO->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }

    /**
     * @return Db
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new Db();
        }
        return self::$instance;
    }

    /**
     * @return PDO
     */
    public static function getPDO()
    {
        if (!self::$instance) {
            self::$instance = new Db();
        }
        return self::$PDO;
    }

    public function fetchAll($sql)
    {
        $statement = self::$PDO->query($sql);
        return $statement->fetchAll();
    }

    public function fetchRow($sql)
    {
        $statement = self::$PDO->query($sql);
        return $statement->fetch();
    }
}