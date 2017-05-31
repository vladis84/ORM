<?php

namespace ORM;

use ORM\Driver\PDO\Driver;
use ORM\Query\Select;

/**
 *
 */
class Storage
{
    /**
     *
     * @var static|self
     */
    private static $istance;

    /**
     * @var ORM\Driver\DriverInterface
     */
    private $driver;

    /**
     * @var Record[]
     */
    private $recordList = [];

    private function __construct()
    {
        $this->driver = new Driver;

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

    private function getRecordKey(Select $select)
    {
        $recordClass = $select->getRecordClass();
        $pk          = $select->getWhere()[$recordClass::$pk] ?? null;

        return $recordClass . '_' . $pk;
    }

    /**
     * @param Select $select
     * @return \ORM\Record
     */
    public function getRecord(Select $select)
    {
        $recordKey = $this->getRecordKey($select);
        if (isset($this->recordList[$recordKey])) {
            return $this->recordList[$recordKey];
        }

        $response = $this->driver->execute($select);
        $values = $response->one();
        
        $recordClass = $select->getRecordClass();
        $record = new $recordClass;
        $record->populate($values);

        $this->recordList[$recordKey] = $record;

        return $record;
    }
}
