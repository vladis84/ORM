<?php

namespace ORM\Driver\PDO;

use ORM\Driver\DriverInterface;

use ORM\Query\{Query, Select, Insert, Update};
use ORM\Driver\PDO\Converter\{SelectConverter, InsertConverter, UpdateConverter};

/**
 * Драйвер для работы с PDO.
 */
class Driver implements DriverInterface
{
    /**
     * @var \PDO
     */
    private static $connect;

    public function __construct()
    {
        $dsn = 'mysql:dbname=orm;host=127.0.0.1';
        $user = 'root';
        $password = '1234567';

        if (!self::$connect) {
            self::$connect = new \PDO($dsn, $user, $password);
            self::$connect->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }
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
        else {
            throw new \LogicException('Не известный тип запроса - ' . get_class($query));
        }

        $sql = $converter->toSQL();

        $statement = self::$connect->prepare($sql);

        $params = $converter->queryParams();
        $statement->execute($params);

        return new Response($statement, self::$connect);
    }
}
