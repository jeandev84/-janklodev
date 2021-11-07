<?php
namespace Jan\Component\Database\ORM\Query;



use Jan\Component\Database\Connection\Connection;
use Jan\Component\Database\ORM\EntityManager;
use Jan\Component\Database\ORM\Query\Builders\MysqlQueryBuilder;
use Jan\Component\Database\ORM\Query\Builders\PostgresQueryBuilder;


/**
 * Class QueryBuilderFactory
 *
 * @package Jan\Component\Database\ORM\Query
*/
class QueryBuilderFactory
{
     /**
      * @throws \Exception
     */
     public static function make(Connection $connection)
     {
            $name = $connection->getName();

            switch ($name) {
                case 'mysql':
                      $qb = new MysqlQueryBuilder($connection);
                    break;
                case 'postgres':
                      $qb = new PostgresQueryBuilder($connection);
                    break;
                default:
                    throw new \Exception('unable to get query builder for connection : '. get_class($connection));
                    break;
            }

            return $qb;
      }
}