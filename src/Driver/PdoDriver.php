<?php

namespace ORM\Driver;

use ORM\Driver\DriverInterface;

use ORM\Query\{Query, Select, Saved};

/**
 * Драйвер для работы с PDO.
 */
class PdoDriver implements DriverInterface
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
    public function execute(Query $query)
    {
        $converter = ConverterFactory::make($query);

        $sql = $converter->toSQL();

        $statement = self::$connect->prepare($sql);

        $params = $converter->queryParams();
        $statement->execute($params);

        return $statement;
    }

    public function getLastInsertId($column = null): int
    {
        return self::$connect->lastInsertId($column);
    }
}
