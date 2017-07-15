<?php

namespace ORM\Driver\DB;

/**
 *
 */
interface ResponseInterface
{
    /**
     * Возвращает одну строку.
     */
    public function one();

    /**
     * Все строки.
     */
    public function all();

    /**
     * Количество затронутых строк.
     */
    public function getAffectedRows();

    /**
     * Последнее инкрементируемое значение.
     * @param string $column
     */
    public function getLastInsertId($column = null);
}
