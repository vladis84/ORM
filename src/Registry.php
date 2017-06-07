<?php

namespace ORM;

/**
 *
 */
class Registry
{
    private static $recordRepository;

    /**
     *
     * @return \ORM\Record\Repository
     */
    public static function recordRepository()
    {
        if (!self::$recordRepository) {
            self::$recordRepository = new \ORM\Record\Repository();
        }

        return self::$recordRepository;
    }

    private static $db;

    /**
     *
     * @return \ORM\Driver\PDO\Driver
     */
    public static function db()
    {
        if (!self::$db) {
            self::$db = new \ORM\Driver\PDO\Driver();
        }

        return self::$db;
    }
}
