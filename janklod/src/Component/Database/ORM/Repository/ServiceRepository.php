<?php
namespace Jan\Component\Database\ORM\Repository;


use Jan\Component\Database\Managers\Contract\ManagerRegistryInterface;


/**
 * Class ServiceRepository
 *
 * @package Jan\Component\Database\ORM\Repository
*/
class ServiceRepository extends EntityRepository
{
    /**
     * @param ManagerRegistryInterface $registry
     * @param $entityClass
    */
    public function __construct(ManagerRegistryInterface $registry, $entityClass)
    {
          parent::__construct($registry, $entityClass);
    }
}