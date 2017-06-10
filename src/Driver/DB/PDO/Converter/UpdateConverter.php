<?php

namespace ORM\Driver\DB\PDO\Converter;

use ORM\Query\Update;

/**
 *
 */
class UpdateConverter extends Converter
{
    /**
     * @var Update
     */
    private $update;

    public function __construct(Update $update)
    {
        $this->update = $update;
    }

    public function toSQL()
    {
        $update = $this->update;
        
        $values = [];
        foreach (array_keys($update->getValues()) as $column) {
            $values[] = "{$column} = :{$column}";
        }

        $where = [];
        foreach (array_keys($update->getWhere()) as $column) {
            $where[] = $this->prepareColumn($column);
        }

        $sql = sprintf('UPDATE %s SET %s ', $update->getTable(), join(', ', $values));

        if ($where) {
            $sql .= ' WHERE ' . join(' AND ', $where);
        }
        
        return $sql;
    }

    public function queryParams()
    {
        $params = array_merge($this->update->getValues(), $this->update->getWhere());

        return $this->prepareParams($params);
    }
}
