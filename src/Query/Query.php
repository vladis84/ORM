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
