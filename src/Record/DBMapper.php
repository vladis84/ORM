<?php

namespace ORM\Record;

/**
 * Ищет в базе данных.
 */
class DBMapper implements DataMapperInterface
{
    /**
     * {@inheritdoc}
     */
    public function getRecordIstance($className, $id)
    {
        $values = [];
        if ($id) {
            $values = $this->select($className, $id)->one();
        }

        /* @var $record Record */
        $record = new $className;
        $record->populate($values);

        return $record;
    }

    /**
     * Поиск записи в хранилище.
     * @param string $className Название класса записи
     * @param mixed $id Значение ключа.
     * @return \ORM\Driver\DB\DriverInterface
     */
    private function select($className, $id)
    {
        $columns = [];
        foreach ($className::$fieldsMap as $alias => $column) {
            $columns[] = sprintf("%s AS '%s'", $column, $alias);
        }

        $pk = $className::$pk;

        $sql = sprintf(
            'SELECT %s FROM %s WHERE %3$s = :%3$s',
            join(', ', $columns),
            $className::table(),
            $pk
        );

        return \ORM\ORM::getInstance()->db->execute($sql, [$pk => $id]);
    }

    /**
     * {@inheritdoc}
     */
    public function save(\ORM\Record $record)
    {
        $className = get_class($record);
        $id = $record->{$className::$pk};

        $isNeedUpdate = false;
        if ($id) {
            $isNeedUpdate = (bool) $this->select($className, $id)->getAffectedRows();
        }

        // update
        if ($isNeedUpdate) {
            $this->update($record);
        }
        // insert
        else {
            $this->insert($record);
        }

        return true;
    }

    private function update(\ORM\Record $record)
    {
        $className = get_class($record);
        $pk = $className::$pk;
        $id = $record->$pk;

        $values = [];
        $params = [];
        foreach (get_object_vars($record) as $property => $value) {
            $column = $className::$fieldsMap[$property] ?? null;
            if ($column && $column != $pk) {
                $values[] = "{$column} = :{$column}";
                $params[$column] = $value;
            }
        }

        $sql = sprintf(
            'UPDATE %s SET %s WHERE %3$s = :%3$s',
            $className::table(),
            join(', ', $values),
            $pk
        );

        $params[$pk] = $id;

        \ORM\ORM::getInstance()->db->execute($sql, $params);
    }

    private function insert(\ORM\Record $record)
    {
        $className = get_class($record);
        $pk = $className::$pk;

        $values = [];
        $params = [];
        foreach (get_object_vars($record) as $property => $value) {
            $column = $className::$fieldsMap[$property] ?? null;
            if ($column) {
                $values[] = ":{$column}";
                $params[$column] = $value;
            }
        }

        $columns = array_keys($params);

        $sql = sprintf(
            'INSERT INTO %s (%s) VALUES (%s)',
            $className::table(),
            join(', ', $columns),
            join(', ', $values)
        );

        $record->$pk = \ORM\ORM::getInstance()->db->execute($sql, $params)->getLastInsertId($pk);
    }

    /**
     * {@inheritdoc}
     */
    public function delete(\ORM\Record $record)
    {
        $className = get_class($record);
        $pk = $className::$pk;

        $params = [$pk => $record->$pk];

        $sql = sprintf(
            'DELETE FROM %s WHERE %2$s = :%2$s',
            $className::table(),
            $pk
        );

        return (bool) \ORM\ORM::getInstance()->db->execute($sql, $params)->getAffectedRows();
    }
}
