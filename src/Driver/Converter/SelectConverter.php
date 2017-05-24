<?php

namespace ORM\Driver\Converter;

use ORM\Query\Select;

/**
 *
 */
class SelectConverter extends Converter
{
    /**
     * @var Select
     */
    private $select;

    public function __construct(Select $select)
    {
        $this->select = $select;
    }

    public function toSQL()
    {
        $select = $this->select;

        $columns = [];
        foreach ($select->getColumns() as $alias => $column) {
            $columns[] = sprintf("%s AS '%s'", $column, $alias);
        }

        $where = [];
        foreach (array_keys($select->getWhere()) as $column) {
            $where[] = $this->prepareColumn($column);
        }

        $sql = sprintf('SELECT %s FROM %s', join(', ', $columns), $select->getTable());

        if ($where) {
            $sql .= ' WHERE ' . join(' AND ', $where);
        }

        return $sql;
    }

    public function queryParams()
    {
        return $this->prepareParams($this->select->getWhere());
    }
}
