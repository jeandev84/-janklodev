<?php
namespace Jan\Component\Http\Bag;


use Jan\Component\Http\Cookie\Cookie;

/**
 * class CookieBag
 * @package Jan\Component\Http\Bag
*/
class CookieBag extends ParameterBag
{


     /**
      * @var string
     */
     protected $path = '/';



     /**
      * @var string
     */
     protected $domain = 'localhost';



     /**
      * @var bool
     */
     protected $httpOnly = false;



     /**
      * @var bool
     */
     protected $secure = false;



     /**
      * CookieBag Constructor.
      * @param array $params
     */
     public function __construct(array $params = [])
     {
         if (! $params) {
             $params = $_COOKIE;
         }

         parent::__construct($params);
     }




     /**
      * @param string $domain
      * @return $this
     */
     public function domain(string $domain): CookieBag
     {
          $this->domain = $domain;

          return $this;
     }



     /**
      * @param bool $secure
      * @return $this
     */
     public function secure(bool $secure = false): CookieBag
     {
          $this->secure = $secure;

          return $this;
     }



     /**
      * @param string $key
      * @param $value
      * @param int $expires
      * @return ParameterBag
     */
     public function set(string $key, $value, int $expires = 3600): ParameterBag
     {
          new Cookie($key, $value, $expires, $this->path, $this->domain, $this->secure, $this->httpOnly);

          return $this;
     }
}