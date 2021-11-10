<?php
namespace Jan\Component\Database\Managers\Contract;


use Jan\Component\Database\ORM\Query\QueryBuilder;
use Jan\Component\Database\ORM\Repository\EntityRepository;


/**
 * Interface EntityManagerInterface
 *
 * @package Jan\Component\Database\ORM\Contract
*/
interface EntityManagerInterface extends ObjectManagerInterface
{



    public function setClassMap(string $classMap);



    /**
     * @return string
    */
    public function getClassMap(): string;




    /**
     * @return QueryBuilder
    */
    public function createQueryBuilder(): QueryBuilder;



    /**
     * @param string $entity
     *
     * @return mixed
    */
    public function getRepository(string $entity): EntityRepository;




    /**
     * Get connection to database
     *
     * @return mixed
    */
    public function getConnection();




    /**
     * flush changes
     *
     * @return mixed
    */
    public function flush();

}