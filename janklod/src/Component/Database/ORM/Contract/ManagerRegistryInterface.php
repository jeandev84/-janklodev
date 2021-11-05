<?php
namespace Jan\Component\Database\ORM\Contract;


use Jan\Component\Database\Managers\Contract\DatabaseManagerInterface;


/**
 * Class ManagerRegistryInterface
 *
 * @package Jan\Component\Database\ORM\Contract
*/
interface ManagerRegistryInterface
{
     public function getDatabaseManager(): DatabaseManagerInterface;
     public function getEntityManager(): EntityManagerInterface;
}