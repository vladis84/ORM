<?php

namespace ORM;

use ORM\Query\Select;

/**
 *
 */
class Repository
{
    public $recordClassName;

    protected $select;

    protected function makeSelect()
    {
        $tableName = $this->recordClassName::table();
        $columns = [$this->recordClassName::$pk];

        return Select::create()
            ->table($tableName)
            ->select($columns);
    }


    final protected function getRecordIstance($id)
    {
        $records = [];
        $response = \ORM\ORM::getInstance()->db->execute($select);
        $pk = $this->recordClassName::$pk;
        $recordRepository =  \ORM\ORM::getInstance()->recordRepository;

        foreach ($response->all() as $value) {
            $records[] = $recordRepository->getRecordIstance($this->recordClassName, $value[$pk]);
        }

        return $records;
    }
}
