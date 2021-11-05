<?php
namespace Jan\Foundation\Facade\Database;

use Jan\Component\Container\Facade\Facade;



/**
 * Class DB
 *
 * @package Jan\Foundation\Facade\Database
*/
class DB extends Facade
{
    protected static function getFacadeAccessor(): string
    {
         return 'capsule';
    }
}