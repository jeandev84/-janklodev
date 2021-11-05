<?php
namespace Jan\Component\Database\Builder\Queries;

use Jan\Component\Database\Builder\SqlBuilder;


/**
 * class Insert
 *
 * @package Jan\Component\Database\Builder\Queries
*/
class Insert extends SqlBuilder
{

    /**
     * @var array
    */
    protected $attributes = [];



    /**
     * @param array $attributes
    */
    public function __construct(array $attributes)
    {
         $this->attributes = array_keys($attributes);
    }



    /**
     * @return string
    */
    public function getName(): string
    {
         return 'insert';
    }



    /**
     * @return string
    */
    public function buildSQL(): string
    {
        $columns = '`' . implode('`, `', $this->attributes) . '`';

        /* $bindPlaceholders = implode(', ', array_fill(0, count($fields), '?')); */
        /* $bindPlaceholders = "':" . implode("', ':", $fields) ."'"; */

        $placeholders = ":" . implode(", :", $this->attributes);

        return sprintf('INSERT INTO %s (%s) VALUES (%s)', $this->table, $columns, $placeholders);
    }



    /**
     * @return bool
    */
    public function isStart(): bool
    {
        return true;
    }
}