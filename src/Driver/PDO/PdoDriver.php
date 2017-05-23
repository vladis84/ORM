<?php

namespace ORM\Driver\PDO;

use ORM\Driver\DriverInterface;

use ORM\Query\{
    QueryInterface,
    SelectInterface,
    SaveInterface,
    UpdateInterface
};

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
    public function execute(QueryInterface $query)
    {
        $sql = $this->prepareSql($query);

        $statement = self::$connect->prepare($sql);

        $params = $this->getQueryParams($query);
        $statement->execute($params);

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    private function prepareSql(QueryInterface $query)
    {
        $sql = null;
        
        if ($query instanceof SelectInterface) {
            $columns = [];
            foreach ($query->getColumns() as $alias => $column) {
                $columns[] = $column . ' AS ' . $alias;
            }

            $where = [];
            foreach (array_keys($query->getWhere()) as $column) {
                $where[] = "{$column} = :{$column}";
            }

            $sql = sprintf('SELECT %s FROM %s', join(', ', $columns), $query->getTable());

            if ($where) {
                $sql .= ' WHERE ' . join(' AND ', $where);
            }
        }
        elseif ($query instanceof UpdateInterface) {

            $values = [];
            foreach (array_keys($query->getValues()) as $column) {
                $values[] = "{$column} = :{$column}";
            }

            $where = [];
            foreach (array_keys($query->getWhere()) as $column) {
                $where[] = "{$column} = :{$column}";
            }

            $sql = sprintf('UPDATE %s SET %s ', $query->getTable(), join(', ', $values));

            if ($where) {
                $sql .= ' WHERE ' . join(' AND ', $where);
            }
        }
        else {
            throw new \Exception('Неизвестный тип "' . gettype($query) . '" запроса');
        }
        
        return $sql;
    }

    private function getQueryParams(QueryInterface $query)
    {
        $clause = [];

        if ($query instanceof SelectInterface || $query instanceof UpdateInterface) {
            foreach ($query->getWhere() as $column => $value) {
                $clause[':' . $column] = $value;
            }
        }

        if ($query instanceof SaveInterface) {
            foreach ($query->getValues() as $column => $value) {
                $clause[':' . $column] = $value;
            }
        }


        return $clause;
    }
}
