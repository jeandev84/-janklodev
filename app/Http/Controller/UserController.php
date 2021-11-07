<?php
namespace App\Http\Controller;


use App\Entity\User;
use App\Http\Controller\Common\BaseController;
use App\Repository\UserRepository;
use Jan\Component\Http\Request\Request;
use Jan\Component\Http\Response\Response;



/**
 * Class UserController
 *
 * @package App\Http\Controller
*/
class UserController extends BaseController
{

    /**
     * @param Request $request
     * @param UserRepository $repository
     * @return Response
     * @throws \Exception
    */
    public function index(Request $request, UserRepository $repository): Response
    {
        $users = $repository->findAll();

        /*
        // Update
        $i = 1;
        foreach ($users as $user) {
            $email = $user->getEmail() . $i;
            $user->setEmail($email);
            $user->setUsername($email);
            $i++;
        }

        $this->em->flush();


        // Remove
        $user = $repository->findOneBy(['id' => 2]);

        $this->em->remove($user);

        $this->em->flush();
        */


        return $this->render('users/index.php', compact('users'));

    }


    /**
     * @param Request $request
     * @param UserRepository $repository
     * @return Response
     * @throws \Exception
    */
   public function register(Request $request, UserRepository $repository): Response
   {
        if ($data = $request->request->all()) {

            $hash = password_hash($data['password'], PASSWORD_DEFAULT);

            $user = $repository->findOneBy(['email' => $data['email']]);

            if ($user instanceof User) {
                 throw new \Exception('User this email : ' . $data['email'] . ' already exist.');
            }

            $user = new User();

            $user->setEmail($data['email'])
                 ->setUsername($data['username'])
                 ->setName($data['name'])
                 ->setSurname($data['surname'])
                 ->setPatronymic($data['patronymic'])
                 ->setPassword($hash)
                 ->setCity($data['city'])
                 ->setRegion($data['region']);


            $this->em->persist($user);

            $this->em->flush();

            // redirect to home page or route LOGIN
            /* header('Location: http://localhost:8888/'); */
            header('Location: /users');
            exit();
        }

        return $this->render('users/register.php', [
            'message' => 'User successfully created.'
        ]);
   }


    /**
     * @throws \Exception
    */
    public function reset(UserRepository $repository)
   {
        $users = $repository->findAll();

        foreach ($users as $user) {
            $this->em->remove($user);
        }

        $this->em->flush();

        header('Location: /users');
        exit;
   }


   /**
     * @param UserRepository $repository
     * @param $id
     * @return Response
     * @throws \Exception
   */
   public function edit(UserRepository $repository, $id): Response
   {
       $user = $repository->findOneBy(['id' => $id]);

       if (! $user) {
           throw new \Exception("User with id {$id} does not exist.");
       }

       // TODO if submitted and valid data we will save data. otherwise show a form
       if ($form = true) {
           // header('Location: /users');
       }

       return $this->render('users/edit.php', compact('user'));
   }



   public function remove(UserRepository $repository, $id): Response
   {
       $user = $repository->findOneBy(['id' => $id]);

       if (! $user) {
           header('Location: /users');
           echo "User with id {$id} does not exist.";
           exit;
       }

       $this->em->remove($user);
       $this->em->flush();

       header('Location: /users');
       exit;
   }



   /*
   protected function primitiveMethodGetUsers()
   {
       $conn = $this->em->getConnection();

       $stmt = $conn->query('SELECT * FROM users');
       $stmt->setFetchMode(\PDO::FETCH_CLASS, 'App\\Entity\\User');
       return $stmt->fetchAll();
   }
   */
}