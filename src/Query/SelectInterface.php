<?php

namespace ORM\Query;

/**
 * SELECT.
 */
interface SelectInterface extends QueryInterface
{
    /**
     * @param array $columns
     * @return static
     */
    public function select(array $columns);

    /**
     * @return array
     */
    public function getColumns();

    /**
     *
     * @param array $values
     * @return static
     */
    public function where(array $values);

    public function getWhere(): array;
}
