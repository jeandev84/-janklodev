<?php
namespace Jan\Component\Database\ORM\Record;

use Exception;
use Jan\Component\Database\Builder\Support\SqlQueryBuilder;
use Jan\Component\Database\ORM\EntityManager;
use Jan\Component\Database\ORM\Query\QueryBuilder;



/**
 * Class Record
 *
 * @package Jan\Component\Database\ORM\Record
*/
class Record
{


    /**
     * @var EntityManager
    */
    protected $em;



    /**
     * @param EntityManager $em
    */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }




    /**
     * @param array $attributes
     * @param string|null $table
     * @return void
     * @throws Exception
    */
    public function insert(array $attributes, string $table)
    {
        $this->em->createQueryBuilder()
                 ->insert($attributes, $table)
                 ->execute();
    }



    /**
     * @param array $attributes
     * @param string|null $table
     * @param array $criteria
     * @return QueryBuilder|void
     * @throws Exception
    */
    public function update(array $attributes, string $table, array $criteria = [])
    {
        $qb = $this->em->createQueryBuilder()->update($attributes, $table);

        if (! $criteria) {
            return $qb;
        }

        foreach (array_keys($criteria) as $column) {
            $qb->where("$column = :{$column}");
        }

        $qb->setParameters($criteria);

        $qb->execute();
    }



    /**
     * @param string $table
     * @param array $criteria
     * @return QueryBuilder|SqlQueryBuilder|void
     * @throws Exception
     */
    public function delete(string $table, array $criteria = [])
    {
        $qb = $this->em->createQueryBuilder()
                       ->delete($table);

        if (! $criteria) {
            return $qb;
        }

        foreach (array_keys($criteria) as $column) {
            $qb->andWhere("$column = :$column");
        }

        $qb->setParameters($criteria)->execute();
    }
}