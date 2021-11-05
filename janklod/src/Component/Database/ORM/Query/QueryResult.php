<?php
namespace Jan\Component\Database\ORM\Query;

use Exception;
use Jan\Component\Database\Connection\Contract\QueryInterface;
use Jan\Component\Database\ORM\EntityManager;



/**
 * Class QueryResult (Adaptor)
 *
 * @package Jan\Component\Database\ORM\Query
*/
class QueryResult
{

      /**
       * @var QueryInterface
      */
      protected $query;



      /**
       * @var EntityManager
      */
      protected $em;




      /**
       * @param QueryInterface $query
      */
      public function __construct(QueryInterface $query)
      {
          $this->query = $query;
      }



      /**
       * @param EntityManager $em
      */
      public function setEntityManager(EntityManager $em)
      {
           $this->em = $em;
      }





      /**
       * @return array|false
       * @throws Exception
      */
      public function getArrayResult()
      {
          return $this->query->getArrayResult();
     }



     /**
      * @return array|false
      * @throws Exception
     */
     public function getArrayAssoc()
     {
         return $this->query->getArrayAssoc();
     }




     /**
      * @throws Exception
     */
     public function getArrayColumns()
     {
         return $this->query->getArrayColumns();
     }





     /**
      * @return array
      * @throws Exception
     */
     public function getResult(): array
     {
        $results =  $this->query->getResult();

        return $this->collects($results);
     }




     /**
      * @return mixed
      * @throws Exception
     */
     public function getFirstResult()
     {
         return $this->getResult()[0];
     }



    /**
     * @return mixed
     * @throws Exception
    */
    public function getOneOrNullResult()
    {
        $result =  $this->query->getOneOrNullResult();

        return $this->collect($result);
    }




    /**
     * @param mixed $result
     * @return mixed
    */
    protected function collect($result)
    {
        if ($this->em instanceof EntityManager) {
            if (\is_object($result)) {
                $this->em->persist($result);
            }
        }

        return $result;
    }



    /**
     * @param array $results
     * @return array
    */
    protected function collects(array $results): array
    {
        foreach ($results as $result) {
            $this->collect($result);
        }

        return $results;
    }
}