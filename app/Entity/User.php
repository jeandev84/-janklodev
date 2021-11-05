<?php
namespace App\Entity;


use Jan\Component\Auth\Contract\UserInterface;
use Jan\Component\Collection\ArrayCollection;

/**
 *
*/
class User implements UserInterface
{

      /**
       * @var integer
      */
      protected $id;


      /**
       * @var string
      */
      protected $email;


      /**
       * @var string
      */
      protected $username;


      /**
       * @var string
      */
      protected $password;


      /**
       * @var string
      */
      protected $surname;


      /**
       * @var string
      */
      protected $name;



      /**
       * @var string
      */
      protected $patronymic;



      /**
       * @var string
      */
      protected $region;



      /**
       * @var string
      */
      protected $city;


      /**
       * @var array
      */
      // protected $files = [];



      public function __construct()
      {
          // $this->files = new ArrayCollection();
      }


      public function getId()
      {
          return $this->id;
      }





      /**
       * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @param mixed $surname
     * @return User
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPatronymic()
    {
        return $this->patronymic;
    }

    /**
     * @param mixed $patronymic
     * @return User
     */
    public function setPatronymic($patronymic)
    {
        $this->patronymic = $patronymic;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * @param mixed $region
     * @return User
     */
    public function setRegion($region)
    {
        $this->region = $region;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     * @return User
    */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }



    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }



    /**
     * @return mixed
     */
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    /**
     * @return mixed
     */
    public function ecraseCredentials()
    {
        // TODO: Implement ecraseCredentials() method.
    }


    /**
     * @return string
    */
    public function getFullName(): string
    {
        return implode(' ', [
           $this->surname,
           $this->name,
           $this->patronymic
        ]);
    }
}