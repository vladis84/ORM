<?php

namespace ORM\Query;

/**
 *
 */
class Select extends Query
{
    private $where = [];

    public function where(array $values)
    {
        $this->where = $values;

        return $this;
    }

    public function getWhere(): array
    {
        return $this->where;
    }

    private $columns;

    /**
     * 
     */
    public function select(array $columns)
    {
        $this->columns = $columns;

        return $this;
    }

    public function getColumns()
    {
        return $this->columns;
    }

    public function one()
    {
        return \ORM\Storage::getInstance()->find($this);
    }
}
