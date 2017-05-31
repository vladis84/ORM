<?php

namespace ORM\Driver;

use ORM\Query\Query;

interface DriverInterface
{
    /**
     * Выполняет запрос к БД.
     * @param Query $query
     * @return ResponseInterface
     */
    public function execute(Query $query) : ResponseInterface;
}
