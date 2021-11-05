<?php
namespace App\Http\Controller;


use App\Http\Controller\Common\BaseController;
use App\Repository\UserRepository;
use Jan\Component\Http\Request\Request;
use Jan\Component\Http\Response\Response;



/**
 * Class SiteController
 *
 * @package App\Http\Controller
*/
class SiteController extends BaseController
{

    /**
     * @param Request $request
     * @param UserRepository $repository
     * @return Response
     * @throws \Exception
    */
    public function index(Request $request, UserRepository $repository): Response
    {
        /*
        $users = $repository->findAll();

        foreach ($users as $user) {
            $this->em->remove($user);
        }

        $this->em->flush();
        */

        return $this->render('site/index.php');
    }




   /**
    * @param Request $request
    * @return Response
    * @throws \Exception
   */
   public function contact(Request $request): Response
   {
        $data = [];

        $method = $request->getMethod();

        if ($method === 'PUT') {
            $data = $request->request->all();
        }

        return $this->render('site/contact.php', compact('data', 'method'));
   }

}


/*
$user = $repository->findOne(4);

$user->setEmail('marieloise@live.fr')
    ->setUsername('marieloise')
    ->setRegion('Москва')
;


$this->em->flush();

$user = $repository->findOneBy(['id' => 4]);
dd($user);

$users = $repository->findAll();

dump($users);


$i = 1;
foreach ($users as $user) {
    $user->setEmail('f'. $i .'@gmail.com');
    $i++;
}


$this->em->flush();
*/