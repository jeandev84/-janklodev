<?php
namespace Jan\Component\Database\Managers\Contract;



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