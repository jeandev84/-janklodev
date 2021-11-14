<?php
namespace Jan\Component\Database\ORM\Record;


use Jan\Component\Database\ORM\EntityManager;
use Jan\Component\Database\ORM\Query\Query;
use Jan\Component\Database\ORM\Query\QueryBuilder;


/**
 * Class ActiveRecord
 *
 * @package Jan\Component\Database\ORM\Record
*/
abstract class ActiveRecord extends Record
{

     /**
      * @var
     */
     protected $qb;


     /**
      * @var array
     */
     protected $wheres = [];



     /**
      * @param EntityManager $em
     */
     public function __construct(EntityManager $em)
     {
         parent::__construct($em);
     }




     /**
      * @throws \Exception
     */
     protected function select(): QueryBuilder
     {
         return $this->em->createQueryBuilder()
                         ->select()
                         ->from($this->getTableName());
     }




     /**
      * @param string $column
      * @param mixed $value
      * @param string $operator
      * @return ActiveRecord
      * @throws \Exception
     */
     public function where(string $column, $value, string $operator = '='): ActiveRecord
     {
         $this->wheres[] = [$column, $value, $operator];

         return $this;
     }




     /**
      * Get result
      * @throws \Exception
     */
     public function get(): array
     {
         $qb = $this->select();

         return $this->getQuery($qb)->getResult();
     }



    /**
      * Get one or null result
      * @throws \Exception
     */
     public function one()
     {
         $qb = $this->select();

         return $this->getQuery($qb)->getOneOrNullResult();
     }




     /**
      * @throws \Exception
     */
     public function all(): array
     {
         $qb = $this->em->createQueryBuilder()
                        ->from($this->getTableName(), 'foo');

         return $qb->getQuery()->getResult();
     }




     /**
      * @param $id
      * @return mixed
      * @throws \Exception
     */
     public function find($id)
     {
         $qb = $this->em->createQueryBuilder()
             ->from($this->getTableName(), 'foo');

         $qb->andWhere("id = :id")
            ->setParameter('id', $id);

         // limit to 1

         return $qb->getQuery()->getOneOrNullResult();
     }





     /**
      * @return mixed
     */
     public function save()
     {
        // TODO something

     }



     /**
      * @return string
     */
     abstract public function getTableName(): string;




     /**
      * @param QueryBuilder $qb
      * @return Query
      * @throws \Exception
     */
     protected function getQuery(QueryBuilder $qb): Query
     {
         if ($this->wheres) {
             foreach ($this->wheres as $where) {
                 list($column, $value, $operator) = $where;
                 $qb->andWhere("$column $operator :$column")
                    ->setParameter($column, $value);
             }
         }

         return $qb->getQuery();
     }
}