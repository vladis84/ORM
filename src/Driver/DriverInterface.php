<?php

namespace ORM\Driver;

use ORM\Query\QueryInterface;

interface DriverInterface
{
    /**
     * Выполняет запрос к БД.
     * @param QueryInterface $query
     * @return type Description
     */
    public function execute(QueryInterface $query);
}
