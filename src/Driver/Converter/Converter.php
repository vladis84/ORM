<?php

namespace ORM\Driver\Converter;

/**
 *
 */
abstract class Converter
{
    abstract public function toSQL();

    abstract public function queryParams();

    protected function prepareParams(array $params)
    {
        $result = [];

        foreach ($params as $column => $value) {
            $result[':' . $column] = $value;
        }

        return $result;
    }

    protected function prepareColumn($column)
    {
        return "{$column} = :{$column}";
    }
}
