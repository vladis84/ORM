<?php

namespace ORM\Driver\DB\PDO\Converter;

use ORM\Query\Delete;

/**
 *
 */
class DeleteConverter extends Converter
{
    private $delete;

    public function __construct(Delete $delete)
    {
        $this->delete = $delete;
    }

    public function toSQL()
    {
        $delete = $this->delete;
        
        $where  = [];
        foreach (array_keys($delete->getWhere()) as $column) {
            $where[]  = ":{$column}";
        }

        $sql = sprintf(
            'DELETE FROM %s WHERE %s',
            $delete->getTable(), 
            join(', ', $where)
        );

        return $sql;
    }

    public function queryParams()
    {
        return $this->prepareParams($this->delete->getWhere());
    }
}
