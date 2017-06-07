<?php

namespace ORM\Query;

/**
 * Базовый интерфейс запросов.
 */
abstract class Query
{
    /**
     * @var string
     */
    private $table;

    /**
     * @return static
     */
    public static function create()
    {
        $query = new static;

        return $query;
    }


    function getRecordClass()
    {
        return $this->recordClass;
    }


    /**
     * @param string $tableName
     * @return static
     */
    public function table($tableName)
    {
        $this->table = $tableName;

        return $this;
    }

    /**
     * @return string Название таблицы
     */
    public function getTable()
    {
        return $this->table;
    }
}
