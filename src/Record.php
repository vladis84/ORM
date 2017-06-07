<?php

namespace ORM;

/**
 *
 */
class Record
{
    /**
     * [propertyName => colum_name]
     * @var array
     */
    public static $fieldsMap = [];

    public static $pk = 'id';

    public static function table()
    {
        $shortClassName = preg_replace('/(\w+$)/', '$1', static::class);

        $tableName = preg_replace_callback(
            '/([A-Z])/',
            function ($matches) {
                return '_' . lcfirst($matches[0]);
            },
            lcfirst($shortClassName)
        );

        return strtolower($tableName);
    }

    public function populate(array $values = [])
    {
        foreach ($values as $property => $value) {
            if (property_exists($this, $property)) {
                $this->{$property} = $value;
            }
        }
    }

    public static function getInstance($id)
    {
        return Registry::recordRepository()->getRecordIstance(static::class, $id);
    }

    public function save()
    {
        $mapper = new RecordMapper();
        $mapper->save($this);
    }

    public function delete()
    {
        $mapper = new RecordMapper();
        $mapper->delete($this);
    }
}
