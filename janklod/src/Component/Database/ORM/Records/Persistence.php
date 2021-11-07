<?php
namespace Jan\Component\Database\ORM\Records;


use Exception;
use Jan\Component\Database\ORM\Contract\FlushCommand;
use Jan\Component\Database\ORM\Query\QueryBuilder;
use Jan\Component\Database\ORM\Records\Support\Record;



/**
 * Class Persistence
 *
 * @package Jan\Component\Database\ORM\Records
*/
class Persistence extends Record implements FlushCommand
{

    /**
     * @var array
    */
    protected $objects = [];




    /**
     * @param object $object
    */
    public function persist($object)
    {
        if (is_object($object)) {
            $this->objects[] = $object;
        }
    }



    /**
     * @return array
    */
    public function getObjects(): array
    {
        return $this->objects;
    }




    /**
     * execute records
     *
     * @return void
     * @throws Exception
    */
    public function execute()
    {
        if ($this->objects) {
            foreach ($this->objects as $object) {

                $attributes = $this->getAttributes($object);
                $table = $this->makeTableName($object);

                if ($id = $object->getId()) {
                    $this->update($attributes, $table, ['id' => $id]);
                }else{
                    $this->insert($attributes, $table);
                }
            }
        }
    }



    /**
     * @param $object
     * @return array
    */
    public function getAttributes($object): array
    {
        $params = $this->getProperties($object);
        unset($params['id']);

        return $params;
    }




    /**
     * @param array $attributes
     * @param string|null $table
     * @return mixed
     * @throws Exception
    */
    public function insert(array $attributes, string $table)
    {
        return $this->em->createQueryBuilder()
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
}