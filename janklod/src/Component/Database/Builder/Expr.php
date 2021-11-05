<?php
namespace Jan\Component\Database\Builder;


use Jan\Component\Database\Builder\Support\SqlQueryBuilder;

/**
 * class Expr
 *
 * @package Jan\Component\Database\Builder
*/
class Expr
{


    /**
     * @var SqlQueryBuilder
    */
    protected $qb;


    /**
     * Expr constructor.
     *
     * @param SqlQueryBuilder $qb
    */
    public function __construct(SqlQueryBuilder $qb)
    {
        $this->qb = $qb;
    }


    /**
     * @param $value1
     * @param $value2
    */
    public function eq($value1, $value2)
    {

    }




    /**
     * @param $value1
     * @param $value2
    */
    public function neq($value1, $value2)
    {

    }



    /**
     * @param $sql
     * @return SqlQueryBuilder
    */
    public function avg($sql): SqlQueryBuilder
    {
        return $this->qb;
    }


    /**
     * @return SqlQueryBuilder
    */
    public function count(): SqlQueryBuilder
    {
        return $this->qb;
    }


    /**
     * @return SqlQueryBuilder
     */
    public function andX(): SqlQueryBuilder
    {
        return $this->qb;
    }




    /**
     * @return SqlQueryBuilder
    */
    public function orX(): SqlQueryBuilder
    {
        return $this->qb;
    }



    /**
     * @param $value
     * @param array $data
    */
    public function in($value, array $data)
    {

    }


    /**
     * @param $value
     * @param array $data
    */
    public function notIn($value, array $data)
    {

    }



    /**
     * @param $value
    */
    public function isNull($value)
    {

    }
}