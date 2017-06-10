<?php

namespace ORM\Driver\DB\PDO\Converter;

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
            $values[]  = ":{$column}";
        }

        $sql = sprintf(
            'INSERT INTO %s (%s) VALUES (%s)',
            $insert->getTable(), 
            join(', ', array_keys($insert->getValues())),
            join(', ', $values)
        );

        return $sql;
    }

    public function queryParams()
    {
        return $this->prepareParams($this->insert->getValues());
    }
}
