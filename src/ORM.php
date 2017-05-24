<?php

namespace ORM;

use ORM\Driver\PdoDriver;

/**
 *
 */
class ORM
{
    /**
     *
     * @var static|self
     */
    private static $istance;

    /**
     * @var PdoDriver
     */
    private $driver;


    private function __construct()
    {
    }

    /**
     * @return static|self
     */
    public static function getInstance()
    {
        if (!self::$istance) {
            self::$istance = new static;
        }

        return self::$istance;
    }

    public function storage()
    {
        if (!$this->driver) {
            $this->driver = new PdoDriver();
        }

        return $this->driver;
    }
}
