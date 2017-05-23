<?php

namespace ORM\Query;

/**
 *
 */
class Update implements UpdateInterface
{
    public function getTable()
    {
        return $this->table;
    }

    private $table;

    public function table($tableName)
    {
        $this->table = $tableName;

        return $this;
    }

    public function getValues()
    {
        return $this->values;
    }

    private $values;

    public function setValues(array $values)
    {
        $this->values = $values;

        return $this;
    }

    private $where;

    public function getWhere(): array
    {
        return $this->where;
    }
    
    public function where(array $values)
    {
        $this->where = $values;

        return $this;
    }
}
