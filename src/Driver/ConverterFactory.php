<?php

namespace ORM\Driver;

use ORM\Query\{Query, Select, Insert, Update};
use ORM\Driver\Converter\{SelectConverter, UpdateConverter, InsertConverter};

class ConverterFactory
{
    /**
     * @param Query $query
     * @return \ORM\Driver\Converter\Converter
     * @throws \Exception
     */
    public static function make(Query $query)
    {
        if ($query instanceof Select) {
            return new SelectConverter($query);
        }
        elseif ($query instanceof Insert) {
            return new InsertConverter($query);
        }
        elseif ($query instanceof Update) {
            return new UpdateConverter($query);
        }

        throw new \LogicException('Не известный тип запроса' . get_class($query));
    }
}
