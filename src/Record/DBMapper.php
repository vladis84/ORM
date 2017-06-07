<?php

namespace ORM\Record;

use ORM\Query\{Select, Update, Insert};
use ORM\Driver\PDO\Driver;

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
        $select = Select::create()
            ->table($className::table())
            ->select($className::$fieldsMap)
            ->where([$className::$pk => $id]);

        $values = \ORM\Registry::db()->execute($select)->one();

        /* @var $record Record */
        $record = new $className;
        $record->populate($values);

        return $record;
    }

    /**
     * {@inheritdoc}
     */
    public function save(\ORM\Record $record)
    {
        $values = [];
        foreach (get_object_vars($this) as $property => $value) {
            $column = static::$fieldsMap[$property] ?? null;
            if ($column && $value) {
                $values[$column] = $value;
            }
        }

        // update
        if ($this->{static::$pk}) {
            $query = new Update();
            $query
                ->table(static::table())
                ->setValues($values)
                ->where([static::$pk => $this->{static::$pk}]);

            \ORM\ORM::getInstance()->storage()->execute($query);
        }
        // insert
        else {
            $query = new Insert();
            $query
                ->table(static::table())
                ->setValues($values);

            \ORM\ORM::getInstance()->storage()->execute($query);

            $this->{static::$pk} = \ORM\ORM::getInstance()->storage()->getLastInsertId(static::$pk);
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(\ORM\Record $record)
    {

    }
}
