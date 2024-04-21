<?php

class Basket
{
    private static $instance = null;
    private $items = [];

    private function __construct() {}

    private function __clone() {}

    private function __wakeup() {}

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Basket();
        }
        return self::$instance;
    }
}
