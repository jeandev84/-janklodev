<?php
namespace Jan\Component\Auth\Contract;


/**
 *
*/
interface UserInterface
{
      public function getEmail();
      public function getUsername();
      public function getPassword();
      public function getSalt();
      public function ecraseCredentials();
}