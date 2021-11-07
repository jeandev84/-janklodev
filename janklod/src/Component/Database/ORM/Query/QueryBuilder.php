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
       * @var array
      */
      protected $queryOptions = [];




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
       * @param array $queryOptions
      */
      public function setQueryOptions(array $queryOptions)
      {
          $this->queryOptions = $queryOptions;
      }




      /**
       * @param $key
       * @param $value
      */
      public function setQueryOption($key, $value)
      {
          $this->queryOptions[$key] = $value;
      }



      /**
       * @return array
      */
      public function getQueryOptions(): array
      {
          return $this->queryOptions;
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

          $this->prepareQueryToPersistence($query);

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




     /**
      * @param Query $query
     */
     protected function prepareQueryToPersistence(Query $query)
     {
         $this->prepareToPersistResults($query->getResult());
         $this->prepareToPersistResult($query->getOneOrNullResult());
     }



     /**
      * @param $result
     */
     protected function prepareToPersistResult($result)
     {
         if (is_object($result)) {
             $this->em->persist($result);
         }
     }



    /**
     * @param array $results
    */
    protected function prepareToPersistResults(array $results)
    {
        foreach ($results as $result) {
            $this->prepareToPersistResult($result);
        }
    }
}