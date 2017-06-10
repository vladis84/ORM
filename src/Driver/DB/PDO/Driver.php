<?php

namespace ORM\Driver\DB\PDO;

use ORM\Driver\DriverInterface;

use ORM\Query\{Query, Select, Insert, Update, Delete};
use ORM\Driver\DB\PDO\Converter\{SelectConverter, InsertConverter, UpdateConverter, DeleteConverter};

/**
 * Драйвер для работы с PDO.
 */
class Driver implements DriverInterface
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
    public function execute(Query $query) : \ORM\Driver\ResponseInterface
    {
        if ($query instanceof Select) {
            $converter = new SelectConverter($query);
        }
        elseif ($query instanceof Insert) {
            $converter = new InsertConverter($query);
        }
        elseif ($query instanceof Update) {
            $converter = new UpdateConverter($query);
        }
        elseif ($query instanceof Delete) {
            $converter = new DeleteConverter($query);
        }
        else {
            throw new \LogicException('Не известный тип запроса - ' . get_class($query));
        }

        $sql = $converter->toSQL();

        $statement = $this->connect()->prepare($sql);

        $params = $converter->queryParams();
        $statement->execute($params);

        return new Response($statement, $this->connect());
    }
}
