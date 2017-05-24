<?php

namespace ORM\Query;

/**
 *
 */
abstract class Saved extends Query
{
    private $values;

    /**
     * @param array $values
     * @return static
     */
    public function setValues(array $values)
    {
        $this->values = $values;

        return $this;
    }

    /**
     * @return array
     */
    public function getValues()
    {
        return $this->values;
    }
}
