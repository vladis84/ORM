<?php

namespace ORM\Query;

/**
 *
 */
interface UpdateInterface extends SaveInterface
{
    /**
     * @param array $values
     * @return static
     */
    public function where(array $values);

    public function getWhere(): array;
}
