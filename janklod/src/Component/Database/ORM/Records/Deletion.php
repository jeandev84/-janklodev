<?php
namespace Jan\Component\Database\ORM\Records;


use Exception;
use Jan\Component\Database\ORM\Query\QueryBuilder;
use Jan\Component\Database\Builder\Support\SqlQueryBuilder;
use Jan\Component\Database\ORM\Contract\FlushCommand;
use Jan\Component\Database\ORM\Records\Support\Record;


/**
 * Class Deletion
 *
 * @package Jan\Component\Database\ORM\Records
*/
class Deletion extends Record implements FlushCommand
{

    /**
     * @var array
    */
    protected $objects;



    /**
     * @param $object
    */
    public function remove($object)
    {
        $this->objects[] = $object;
    }




    /**
     * @return void
     * @throws \Exception
    */
    public function execute()
    {
       if ($this->objects) {
           foreach ($this->objects as $object) {
               if (\is_object($object)) {
                   $table = $this->makeTableName($object);
                   if ($id = $object->getId()) {
                       $this->delete($table, ['id' => $id]);
                   }
               }
           }
       }
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