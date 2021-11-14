<?php
namespace Jan\Component\Database\ORM\Query;


use Jan\Component\Database\Connection\Connection;
use Jan\Component\Database\Managers\Contract\EntityManagerInterface;
use Jan\Component\Database\ORM\EntityManager;
use Jan\Component\Database\ORM\Query\Builders\MysqlQueryBuilder;
use Jan\Component\Database\ORM\Query\Builders\PostgresQueryBuilder;
use Jan\Component\Database\ORM\Query\Contract\QueryInterface;


/**
 * Class QueryBuilderFactory
 *
 * @package Jan\Component\Database\ORM\Query
*/
class QueryBuilderFactory
{

    /**
     * @var Connection
    */
    protected $connection;



    /**
     * @param Connection $connection
    */
    public function __construct(Connection $connection)
    {
         $this->connection = $connection;
    }



    /**
      * @throws \Exception
     */
     public function make(Query $query)
     {
            $name = $this->connection->getName();

            switch ($name) {
                case 'mysql':
                      $qb = new MysqlQueryBuilder($query);
                    break;
                case 'postgres':
                      $qb = new PostgresQueryBuilder($query);
                    break;
                default:
                    throw new \Exception('unable to get query builder for connection : '. $name);
                    break;
            }

            return $qb;
      }
}