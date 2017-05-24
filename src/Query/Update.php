<?php

namespace ORM\Query;

/**
 *
 */
class Update extends Saved
{
    private $where;

    public function getWhere()
    {
        return $this->where;
    }
    
    public function where(array $values)
    {
        $this->where = $values;

        return $this;
    }
}
