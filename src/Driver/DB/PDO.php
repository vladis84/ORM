<?php

namespace ORM\Driver\DB;


/**
 * Драйвер для работы с PDO.
 */
class PDO implements DriverInterface
{
    /**
     * @var \PDO
     */
    private $connect;

    public $dsn;
    public $user;
    public $password;

    private function connect()
    {
        if (!$this->connect) {
            $this->connect = new \PDO($this->dsn, $this->user, $this->password);
            $this->connect->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }

        return $this->connect;
    }

    /**
     * {@inheritdoc}
     */
    public function execute($sql, array $params = []) : ResponseInterface
    {
        $statement = $this->connect()->prepare($sql);

        $statement->execute($params);

        return new PDOResponse($statement, $this->connect());
    }
}
