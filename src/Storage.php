<?php

namespace ORM;

use ORM\Query\{SelectInterface, SaveInterface};

/**
 *
 */
class Storage
{
    public function find(SelectInterface $select)
    {
        $driver = new \ORM\Driver\PDO\PdoDriver();
        
        return $driver->execute($select);
    }

    public function save(SaveInterface $query)
    {
        $driver = new \ORM\Driver\PDO\PdoDriver();

        return $driver->execute($query);
    }
}
