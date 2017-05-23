<?php

namespace ORM;

use ORM\Query\{Select, Update};

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

        $tableName = preg_replace('/([A-Z])/', '_$1', lcfirst($shortClassName));

        return strtolower($tableName);
    }

    public function __construct(array $values = [])
    {
        foreach ($values as $property => $value) {
            if (property_exists($this, $property)) {
                $this->{$property} = $value;
            }
        }
    }

    public static function getInstance($id)
    {
        $query = new Select();
        $query->table(static::table())
            ->select(static::$fieldsMap)
            ->where(['id' => $id]);

        $values = \ORM\ORM::getInstance()->storage()->find($query);

        return new static($values[0]);
    }

    public function save()
    {
        // update
        if ($this->{static::$pk}) {
            $query = new Update();
            $query->where([static::$pk => $this->{static::$pk}]);
        }

        $values = [];
        foreach (get_object_vars($this) as $property => $value) {
            if (isset(static::$fieldsMap[$property])) {
                $values[static::$fieldsMap[$property]] = $value;
            }
        }

        $query
            ->table(static::table())
            ->setValues($values);

        \ORM\ORM::getInstance()->storage()->save($query);
    }
}
