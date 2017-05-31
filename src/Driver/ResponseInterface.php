<?php

namespace ORM\Driver;

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
