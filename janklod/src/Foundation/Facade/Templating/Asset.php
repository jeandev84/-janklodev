<?php
namespace Jan\Foundation\Facade\Templating;

use Jan\Component\Container\Facade\Facade;


/**
 * class Asset
 *
 * @package Jan\Foundation\Facade\Templating
*/
class Asset extends Facade
{
     protected static function getFacadeAccessor(): string
     {
         return \Jan\Component\Templating\Asset::class;
     }
}