<?php

namespace orm;

/**
 *
 */
interface QueryInterface
{
    public function from();

    public function where();

    public function offset();
}
