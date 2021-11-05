<?php
namespace Jan\Component\Http\Cookie;


/**
 * class Cookie
 * @package Jan\Component\Http\Cookie
*/
class Cookie
{
     /**
      * @param string $name
      * @param $value
      * @param int $expires
      * @param string $path
      * @param string $domain
      * @param bool $secure
      * @param bool $httpOnly
     */
     public function __construct(
         string $name,
         $value,
         int $expires = 3600,
         string $path = '/',
         string $domain = 'localhost',
         bool $secure = false,
         bool $httpOnly = false
     )
     {
         setcookie(
             $name,
             $value,
             time() + $expires,
             $path,
             $domain,
             $secure,
             $httpOnly
         );
     }




     /**
      * @param string $key
      * @return bool
     */
     public function has(string $key): bool
     {
        return isset($_COOKIE[$key]);
     }




     /**
      * @param string $key
      * @param null $default
      * @return mixed|null
     */
      public function get(string $key, $default = null)
      {
          return $_COOKIE[$key] ?? $default;
      }




      /**
       * @return array
      */
      public function all(): array
      {
          return $_COOKIE;
      }
}