<?php
namespace Jan\Foundation\Facade\Database;

use Jan\Component\Container\Facade\Facade;


/**
 * Class Schema
 *
 * @package Jan\Foundation\Facade\Database
*/
class Schema extends Facade
{
     protected static function getFacadeAccessor(): string
     {
          return 'capsule.schema';
     }
}