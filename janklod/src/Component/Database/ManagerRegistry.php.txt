<?php
namespace Jan\Component\Database\ORM;


use Jan\Component\Database\ORM\Contract\EntityManagerInterface;
use Jan\Component\Database\Managers\Contract\DatabaseManagerInterface;
use Jan\Component\Database\ORM\Contract\ObjectManagerInterface;
use Jan\Component\Database\ORM\Contract\ManagerRegistryInterface;


/**
 * Class ManagerRegistry
 *
 * @package Jan\Component\Database\ORM
*/
class ManagerRegistry implements ManagerRegistryInterface
{


    /**
     * @var DatabaseManagerInterface
    */
    protected $db;



    /**
     * @var ObjectManagerInterface
    */
    protected $em;



    /**
     * @param DatabaseManagerInterface $db
    */
    public function setDatabaseManager(DatabaseManagerInterface $db)
    {
         $this->db = $db;
    }



    /**
     * @param EntityManagerInterface $em
    */
    public function setEntityManager(EntityManagerInterface $em)
    {
        $this->em = $em;
    }



    /**
     * @return DatabaseManagerInterface
    */
    public function getDatabaseManager(): DatabaseManagerInterface
    {
        return $this->db;
    }




    /**
     * @return EntityManagerInterface
    */
    public function getEntityManager(): EntityManagerInterface
    {
        return $this->em;
    }
}