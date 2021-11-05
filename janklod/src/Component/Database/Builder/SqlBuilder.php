<?php
namespace Jan\Component\Database\Builder;


use Jan\Component\Database\Builder\Contract\SqlBuilderInterface;



/**
 * SqlBuilder
 *
 * @package Jan\Component\Database\Builder
*/
abstract class SqlBuilder implements SqlBuilderInterface
{

    /**
     * @var string
    */
    protected $alias;



    /**
     * @var string
    */
    protected $table;



    /**
     * @param string|null $alias
    */
    public function setAlias(?string $alias)
    {
        $this->alias = $alias;
    }


    /**
     * @param string $table
    */
    public function setTable(string $table)
    {
        $this->table = $table;
    }


    /**
     * @return false
    */
    public function isStart(): bool
    {
         return false;
    }



    /**
     * @return string
    */
    abstract public function getName(): string;


    /**
     * @return string
    */
    abstract public function buildSQL(): string;
}