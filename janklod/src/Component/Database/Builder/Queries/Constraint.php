<?php
namespace Jan\Component\Database\Builder\Queries;


use Jan\Component\Database\Builder\SqlBuilder;

/**
 * class Constraint
 *
 * @package Jan\Component\Database\Builder\Queries
*/
class Constraint extends SqlBuilder
{

    /**
     * @var string
    */
    protected $condition;


    /**
     * @var string
    */
    protected $operator;


    /**
     * @param string $condition
     * @param string|null $operator
    */
    public function __construct(string $condition, string $operator = null)
    {
         $this->condition = $condition;
         $this->operator  = $operator;
    }


    /**
     * @param string|null $operator
    */
    public function setOperator(?string $operator)
    {
        $this->operator = $operator;
    }


    /**
     * @return string
    */
    public function getName(): string
    {
         return 'where';
    }



    /**
     * @return string
    */
    public function buildSQL(): string
    {
        return sprintf('%s %s', $this->operator, $this->condition);
    }
}