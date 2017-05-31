<?php

namespace ORM\Driver\PDO\Converter;

use ORM\Query\Insert;

/**
 *
 */
class InsertConverter extends Converter
{
    private $insert;

    public function __construct(Insert $insert)
    {
        $this->insert = $insert;
    }
    
    public function toSQL()
    {
        $insert = $this->insert;
        
        $values  = [];
        foreach (array_keys($insert->getValues()) as $column) {
            $values[]  = "{$column} = :{$column}";
        }

        $sql = sprintf(
            'INSERT INTO %s SET %s',
            $insert->getTable(), 
            join(', ', $values)
        );

        return $sql;
    }

    public function queryParams()
    {
        return $this->prepareParams($this->insert->getValues());
    }
}
