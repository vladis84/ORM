<?php

namespace ORM\Record;

use ORM\Query\{Select, Update, Insert, Delete};

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

        $values = \ORM\ORM::getInstance()->db->execute($select)->one();

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
        $className = get_class($record);

        $values = [];
        foreach (get_object_vars($record) as $property => $value) {
            $column = $className::$fieldsMap[$property] ?? null;
            if ($column) {
                $values[$column] = $value;
            }
        }

        $isNeedUpdate = false;
        $id = $record->{$className::$pk};
        if ($id) {
            $select = Select::create()
                ->table($className::table())
                ->select([$className::$pk])
                ->where([$className::$pk => $id]);
            $isNeedUpdate = (bool) \ORM\ORM::getInstance()->db->execute($select)->getAffectedRows();
        }

        // update
        if ($isNeedUpdate) {
            $query = Update::create()
                ->table($className::table())
                ->setValues($values)
                ->where([$className::$pk => $record->{$className::$pk}]);

            \ORM\ORM::getInstance()->db->execute($query);
        }
        // insert
        else {
            $query =  Insert::create()
                ->table($className::table())
                ->setValues($values);

            $record->{$className::$pk} = \ORM\ORM::getInstance()->db->execute($query)->getLastInsertId($className::$pk);
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(\ORM\Record $record)
    {
        $className = get_class($record);
        $pk = $className::$pk;

        $values = [$pk => $record->$pk];

        $query = Delete::create()
            ->table($className::table())
            ->where($values);

        return (bool) \ORM\ORM::getInstance()->db->execute($query)->getAffectedRows();
    }
}
