<?php

namespace ORM\Query;

/**
 * Запрос на удаление.
 */
class Delete extends Query
{
    private $where = [];

    public function where(array $values)
    {
        $this->where = $values;

        return $this;
    }

    public function getWhere(): array
    {
        return $this->where;
    }
}
