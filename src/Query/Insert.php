<?php

namespace ORM\Query;

/**
 *
 */
class Insert implements InsertInterface
{
    private $table;
    public function getTable()
    {
        return $this->table;
    }

    public function getValues()
    {
        return $this->values;
    }

    private $values;
    public function setValues(array $values)
    {
        $this->values = $values;
    }

    public function table($tableName)
    {
        $this->table = $tableName;

        return $this;
    }
}
