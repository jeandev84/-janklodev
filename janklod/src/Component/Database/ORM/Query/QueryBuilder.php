<?php
namespace Jan\Component\Database\ORM\Query;

use Jan\Component\Database\Builder\Support\SqlQueryBuilder;
use Jan\Component\Database\Connection\Connection;
use Jan\Component\Database\ORM\Contract\EntityManagerInterface;
use Jan\Component\Database\ORM\EntityManager;


/**
 * Class QueryBuilder
 *
 * @package Jan\Component\Database\ORM\Query
*/
class QueryBuilder extends SqlQueryBuilder
{

      /**
       * @var Connection
      */
      protected $connection;



      /**
       * @var EntityManagerInterface
      */
      protected $em;





      /**
       * @var array
      */
      protected $options = [];




      /**
       * @param Connection $connection
      */
      public function __construct(Connection $connection)
      {
           $this->connection = $connection;
      }



      /**
       * @param EntityManager $em
      */
      public function setEntityManager(EntityManager $em)
      {
          $this->em = $em;
      }



      /**
       * @param array $options
      */
      public function setOptions(array $options)
      {
          $this->options = $options;
      }




      /**
       * @param $key
       * @param $value
      */
      public function setOption($key, $value)
      {
          $this->options[$key] = $value;
      }



      /**
       * @return array
      */
      public function getOptions(): array
      {
          return $this->options;
      }



      /**
       * @return QueryResult
       * @throws \Exception
      */
      public function getQuery(): QueryResult
      {
          $query = $this->connection->query(
              $this->getSQL(),
              $this->getParameters(),
              $this->getOptions()
          );

          $result = new QueryResult($query);
          $result->setEntityManager($this->em);

          return $result;
      }



      /**
       * @return mixed
      */
      public function execute()
      {
          return $this->connection->query($this->getSQL(), $this->getParameters())
                                  ->execute();
      }
}