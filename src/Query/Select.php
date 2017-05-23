<?php

namespace ORM\Query;

/**
 *
 */
class Select implements SelectInterface
{
    private $table;

    /**
     * {@inheritdoc}
     */
    public function table($table)
    {
        $this->table = $table;

        return $this;
    }

    public function getTable()
    {
        return $this->table;
    }

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
     * {@inheritdoc}
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
}
