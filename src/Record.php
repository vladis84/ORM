<?php

namespace ORM;

use ORM\Query\{Select, Update, Insert};

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
        $select = Select::create(static::class)
            ->table(static::table())
            ->select(static::$fieldsMap)
            ->where([static::$pk => $id]);

        $record = \ORM\Storage::getInstance()->getRecord($select);

        return $record;
    }

    public function save()
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

    public function delete()
    {
    }
}
