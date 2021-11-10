<?php
namespace Jan\Component\Database\ORM\Query;

use Jan\Component\Database\Builder\Support\SqlQueryBuilder;
use Jan\Component\Database\Connection\Connection;
use Jan\Component\Database\Managers\Contract\EntityManagerInterface;



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
          $qm = $this->connection->query(
              $this->getSQL(),
              $this->getParameters()
          );

          $query = new Query($qm);
          $query->setEntityManager($this->em);
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