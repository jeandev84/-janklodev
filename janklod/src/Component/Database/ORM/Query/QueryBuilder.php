<?php
namespace Jan\Component\Database\ORM\Query;

use Jan\Component\Database\Builder\Support\SqlQueryBuilder;
use Jan\Component\Database\Connection\Connection;
use Jan\Component\Database\Connection\PDO\PdoQuery;
use Jan\Component\Database\Connection\Query;
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
       * @param Connection $connection
      */
      public function __construct(Connection $connection)
      {
           $this->connection = $connection;
      }



      /**
       * @param EntityManagerInterface $em
      */
      public function setEntityManager(EntityManagerInterface $em)
      {
          $this->em = $em;
      }



      /**
       * @return Query
       * @throws \Exception
      */
      public function getQuery(): Query
      {
          $query = $this->connection->query(
              $this->getSQL(),
              $this->getParameters()
          );

          if ($query instanceof PdoQuery) {
              $query->entityClass($this->em->getClassMap());
          }

          $this->em->prepareQueryToPersistence($query);


          return $query;
      }



      /**
       * @return mixed
      */
      public function execute()
      {
          return $this->connection->query($this->getSQL(), $this->getParameters())
                                  ->execute();
      }




     /**
      * @param string $table
      * @return SqlQueryBuilder
     */
      public function table(string $table): SqlQueryBuilder
      {
          $table = $this->generateTableName($table);

          return parent::table($table);
      }



      /**
      * @param string $context
      * @return string
     */
     protected function generateTableName(string $context): string
     {
         if (class_exists($context)) {
            $tableName =  (new \ReflectionClass($context))->getShortName();
            return mb_strtolower(trim($tableName, 's')). 's';
         }

         return $context;
     }
}