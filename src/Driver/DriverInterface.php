<?php

namespace ORM\Driver;

use ORM\Query\Query;

interface DriverInterface
{
    /**
     * Выполняет запрос к БД.
     * @param Query $query
     * @return \PDOStatement
     */
    public function execute(Query $query);

    /**
     * @return int
     */
    public function getLastInsertId();
}
