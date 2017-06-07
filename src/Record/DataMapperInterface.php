<?php

namespace ORM\Record;

use ORM\Record;

interface DataMapperInterface
{
    /**
     * Поиск записи в хранилище.
     * @param string $className Название класса записи
     * @param mixed $id Значение ключа.
     * @return Record
     */
    public function getRecordIstance($className, $id);

    /**
     * Сохранение записи.
     * @param Record $record
     */
    public function save(Record $record);

    /**
     * Удаление записи.
     * @param Record $record
     */
    public function delete(Record $record);
}
