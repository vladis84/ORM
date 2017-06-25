<?php

namespace ORM\Driver\DB;

/**
 *
 */
interface ResponseInterface
{
    public function one();

    public function all();

    public function getAffectedRows();

    public function getLastInsertId($column = null);
}
