<?php

namespace ORM\Driver\DB;

/**
 *
 */
class PDOResponse implements ResponseInterface
{
    /**
     * @var \PDOStatement
     */
    private $statement;

    /**
     * @var \PDO
     */
    private $connect;

    public function __construct(\PDOStatement $statement, \PDO $connect)
    {
        $this->statement = $statement;
        $this->connect   = $connect;
    }

    public function all()
    {
        return $this->statement->fetchAll(\PDO::FETCH_ASSOC) ?: [];
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
        return $this->statement->fetch(\PDO::FETCH_ASSOC) ?: [];
    }
}
