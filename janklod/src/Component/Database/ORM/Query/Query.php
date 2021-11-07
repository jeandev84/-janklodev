<?php
namespace Jan\Component\Database\ORM\Query;


use Jan\Component\Database\Connection\Contract\QueryInterface;
use Jan\Component\Database\Connection\Contract\QueryResultInterface;
use Jan\Component\Database\ORM\Contract\EntityManagerInterface;



/**
 * Class QueryResult
 *
 * @package Jan\Component\Database\ORM\Query
*/
class Query implements QueryResultInterface
{


      /**
       * @var EntityManagerInterface
      */
      protected $em;




      /**
        * @var QueryInterface
      */
      protected $query;




      /**
        * @param QueryInterface $query
      */
      public function __construct(QueryInterface $query)
      {
            $this->query = $query;
      }



      /**
       * @param EntityManagerInterface $em
      */
      public function setEntityManager(EntityManagerInterface $em)
      {
             $this->em = $em;
      }




      /**
       * @return array
      */
      public function getArrayResult(): ?array
      {
          return $this->query->getArrayResult();
      }




      /**
       * @return mixed
      */
      public function getArrayAssoc()
      {
          return $this->query->getArrayAssoc();
      }



      public function getArrayColumns()
      {
          return $this->query->getArrayColumns();
      }




      /**
       * @return array
      */
      public function getResult(): array
      {
         $results = $this->query->getResult();

         return $this->prepareToPersistResults($results);
      }



      /**
       * @return mixed
      */
      public function getOneOrNullResult()
      {
         $result = $this->query->getOneOrNullResult();

         return $this->prepareToPersistResult($result);
      }




      /**
       * @param $result
      */
      protected function prepareToPersistResult($result)
      {
            if ($this->em instanceof EntityManagerInterface) {
                if (is_object($result)) {
                    $this->em->persist($result);
                }
            }

            return $result;
      }




      /**
       * @param array $results
       * @return array
      */
      protected function prepareToPersistResults(array $results): array
      {
            $collections = [];

            foreach ($results as $result) {
                $collections[] = $this->prepareToPersistResult($result);
            }

            return $collections;
     }
}