<?php
namespace Jan\Component\Database\ORM\Repository\Contract;


/**
 * Interface EntityRepositoryInterface
 *
 * @package Jan\Component\Database\ORM\Repository\Contract
*/
interface EntityRepositoryInterface
{
      public function findAll();
      public function findBy();
      public function findOneBy($criteria);
}