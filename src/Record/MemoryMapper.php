<?php

namespace ORM\Record;

/**
 * Ищет в оперативной памяти.
 */
class MemoryMapper implements DataMapperInterface
{
    private $records = [];

    private function getRecordKey(\ORM\Record $record)
    {
        $id        = $record->{$record::$pk};
        $className = get_class($record);

        return $this->generateKey($className, $id);
    }

    private function generateKey($className, $id)
    {
        return $className . '_' . $id;
    }

    /**
     * {@inheritdoc}
     */
    public function getRecordIstance($className, $id)
    {
        $recordKey = $this->generateKey($className, $id);

        return $this->records[$recordKey] ?? null;
    }

    /**
     * {@inheritdoc}
     */
    public function save(\ORM\Record $record)
    {
        $recordKey = $this->getRecordKey($record);

        $this->records[$recordKey] = $record;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(\ORM\Record $record)
    {
        $recordKey = $this->getRecordKey($record);

        $this->records[$recordKey] = null;
    }
}
