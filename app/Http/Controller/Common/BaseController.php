<?php
namespace App\Http\Controller\Common;

use Jan\Component\Database\ORM\EntityManager;
use Jan\Foundation\Routing\Controller;


/**
 * Class BaseController
 *
 * @package App\Http\Controller\Common
*/
class BaseController extends Controller
{
    /**
     * @var EntityManager
    */
    protected $em;


    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

}