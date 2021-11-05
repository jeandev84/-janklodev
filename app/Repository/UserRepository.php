<?php
namespace App\Repository;

use App\Entity\User;
use Jan\Component\Database\ORM\Contract\ManagerRegistryInterface;
use Jan\Component\Database\ORM\Repository\ServiceRepository;


/**
 * Class UserRepository
 *
 * @package App\Repository
*/
class UserRepository extends ServiceRepository
{

      /**
       * @param ManagerRegistryInterface $registry
      */
      public function __construct(ManagerRegistryInterface $registry)
      {
            parent::__construct($registry, User::class);
      }



      /**
       * @param $id
       * @return mixed
      */
      /*
      public function findOne($id)
      {
         $qb = $this->createQueryBuilder('u')
                    ->where('id = :id')
                    ->setParameter('id', $id);

         return $this->getOne($qb);
      }
      */
}