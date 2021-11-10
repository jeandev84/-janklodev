<?php
namespace Jan\Component\Database\ORM\Repository;


use Jan\Component\Database\ORM\Helpers\InflectorObject;
use Jan\Component\Database\ORM\Query\QueryBuilder;
use Jan\Component\Database\Managers\Contract\EntityManagerInterface;
use Jan\Component\Database\Managers\Contract\ManagerRegistryInterface;


/**
 * Class EntityRepository
 *
 * @package Jan\Component\Database\ORM\Repository
*/
class EntityRepository
{


    use InflectorObject;


    /**
     * @var EntityManagerInterface
    */
    protected $em;


    /**
     * @var string
    */
    protected $entityClass;



    /**
     * EntityRepository constructor.
     *
     * @param ManagerRegistryInterface $registry
     * @param $entityClass
    */
    public function __construct(ManagerRegistryInterface $registry, $entityClass)
    {
         $this->em = $registry->getEntityManager();
         $this->em->setClassMap($entityClass);
         $this->entityClass = $entityClass;
    }


    /**
     * @param string $alias
     * @return QueryBuilder
     * @throws \Exception
    */
    public function createQueryBuilder(string $alias): QueryBuilder
    {
         $qb = $this->em->createQueryBuilder();

         return $qb->select()->from($this->entityClass, $alias);
    }



    /**
     * @throws \Exception
    */
    public function createNativeQueryBuilder(): QueryBuilder
    {
        return $this->em->createQueryBuilder()
                        ->select()
                        ->from($this->entityClass);
    }




    /**
     * @param array $criteria
     * @return mixed
     * @throws \Exception
    */
    public function findOneBy(array $criteria)
    {
          $qb = $this->createNativeQueryBuilder();

          foreach (array_keys($criteria) as $field) {
              $qb->andWhere(sprintf('%s = :%s', $field, $field));
          }

          $qb->setParameters($criteria);

          return $qb->getQuery()->getOneOrNullResult();
    }


    /**
     * @return array
     * @throws \Exception
    */
    public function findAll(): array
    {
        $qb = $this->createNativeQueryBuilder();
        return $qb->getQuery()->getResult();
    }
}