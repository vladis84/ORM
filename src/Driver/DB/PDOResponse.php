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

    /**
     * {@inheritdoc}
     */
    public function all()
    {
        return $this->statement->fetchAll(\PDO::FETCH_ASSOC) ?: [];
    }

    /**
     * {@inheritdoc}
     */
    public function getAffectedRows()
    {
        return $this->statement->rowCount();
    }

    /**
     * {@inheritdoc}
     */
    public function getLastInsertId($column = null)
    {
        return $this->connect->lastInsertId($column);
    }

    /**
     * {@inheritdoc}
     */
    public function one()
    {
        return $this->statement->fetch(\PDO::FETCH_ASSOC) ?: [];
    }
}
