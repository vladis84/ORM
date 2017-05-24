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
        $query
            ->table(static::table())
            ->select(static::$fieldsMap)
            ->where([static::$pk => $id]);

        $values = \ORM\ORM::getInstance()->storage()->execute($query)->fetch(\PDO::FETCH_ASSOC);

        return new static($values);
    }

    public function save()
    {
        $values = [];
        foreach (get_object_vars($this) as $property => $value) {
            $column = static::$fieldsMap[$property] ?? null;
            if ($column && $value) {
                $values[static::$fieldsMap[$property]] = $value;
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
}
