<?php

namespace ORM;

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
     * @var Storage
     */
    private $storage;


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
        if (!$this->storage) {
            $this->storage = new Storage();
        }

        return $this->storage;
    }
}
