<?php

namespace ORM\Driver\DB;

interface DriverInterface
{
    /**
     * Выполняет запрос к БД.
     * @param string $sql
     * @param array $params
     * @return ResponseInterface
     */
    public function execute($sql, array $params = []) : ResponseInterface;
}
