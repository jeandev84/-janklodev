<?php
namespace App\Repository;

use App\Entity\News;
use Jan\Component\Database\ORM\Contract\ManagerRegistryInterface;
use Jan\Component\Database\ORM\Repository\ServiceRepository;


/**
 * Class NewsRepository
 *
 * @package App\Repository
*/
class NewsRepository extends ServiceRepository
{
    /**
     * @param ManagerRegistryInterface $registry
    */
    public function __construct(ManagerRegistryInterface $registry)
    {
        parent::__construct($registry, News::class);
    }
}