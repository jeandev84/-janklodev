<?php
namespace Jan\Component\Database\Connection;

use Jan\Component\Database\Connection\Contract\QueryInterface;


/**
 * Class Query
 *
 * @package Jan\Component\Database\Connection
*/
abstract class Query implements QueryInterface
{


    /**
     * @var string
    */
    protected $sql;




    /**
     * @var array
    */
    protected $params = [];




    /**
     * @param string $sql
     * @return $this
    */
    public function query(string $sql): Query
    {
        $this->sql = $sql;

        return $this;
    }



    /**
     * @param array $params
     * @return Query
    */
    public function params(array $params): Query
    {
        $this->params = $params;

        return $this;
    }
}