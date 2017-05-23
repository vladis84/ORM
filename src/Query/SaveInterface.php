<?php

namespace ORM\Query;

/**
 *
 */
interface SaveInterface extends QueryInterface
{
    /**
     * @param array $values
     * @return static
     */
    public function setValues(array $values);

    /**
     * @return array
     */
    public function getValues();
}
