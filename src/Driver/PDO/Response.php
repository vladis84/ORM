<?php

namespace ORM\Driver\PDO;

use ORM\Driver\ResponseInterface;

/**
 *
 */
class Response implements ResponseInterface
{
    private $statement;
    private $connect;

    public function __construct(\PDOStatement $statement, \PDO $connect)
    {
        $this->statement = $statement;
        $this->connect   = $connect;
    }

    public function all()
    {
        return $this->statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getAffectedRows()
    {
        return $this->statement->rowCount();
    }

    public function getLastInsertId($column = null)
    {
        return $this->connect->lastInsertId($column);
    }

    public function one()
    {
        return $this->statement->fetch(\PDO::FETCH_ASSOC);
    }
}
