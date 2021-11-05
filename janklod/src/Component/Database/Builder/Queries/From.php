<?php
namespace Jan\Component\Database\Builder\Queries;

use Jan\Component\Database\Builder\SqlBuilder;


/**
 * Class From
 * 
 * @package Jan\Component\Database\Builder\Queries
*/
class From extends SqlBuilder
{


    /**
     * @param string $table
    */
    public function __construct(string $table)
    {
        $this->table = $table;
    }



    /**
     * @return string
    */
    public function getName(): string
    {
        return 'from';
    }


    /**
     * @return string
    */
    public function buildSQL(): string
    {
        return sprintf('FROM %s %s', $this->table, $this->alias);
    }
}