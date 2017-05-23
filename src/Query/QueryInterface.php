<?php

namespace ORM\Query;

/**
 * Базовый интерфейс запросов.
 */
interface QueryInterface
{
    /**
     * @param type $tableName
     * @return static
     */
    public function table($tableName);

    /**
     * @return string Название таблицы
     */
    public function getTable();

    
}
