<?php

namespace ORM\Record;

/**
 *
 */
class Repository implements DataMapperInterface
{
    /**
     * @var DataMapperInterface[]
     */
    private $mappers = [];

    public function __construct()
    {
        $this->mappers[] = new MemoryMapper();
        $this->mappers[] = new CacheMapper();
        $this->mappers[] = new DBMapper();
    }

    /**
     * {@inheritdoc}
     */
    public function delete(\ORM\Record $record)
    {
        foreach ($this->mappers as $mapper) {
            $mapper->delete($record);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getRecordIstance($className, $id): \ORM\Record
    {
        foreach ($this->mappers as $key => $mapper) {
            if ($record = $mapper->getRecordIstance($className, $id)) {
                break;
            }
        }

        for ($i = 0; $i < $key; $i++) {
            $this->mappers[$i]->save($record);
        }

        return $record;
    }

    /**
     * {@inheritdoc}
     */
    public function save(\ORM\Record $record)
    {
        foreach ($this->mappers as $mapper) {
            $mapper->save($record);
        }
    }
}
