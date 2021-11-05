<?php
namespace Jan\Foundation\Facade\Routing;


use Jan\Component\Routing\Router;
use Jan\Component\Container\Facade\Facade;


/**
 * Class Route
 * @package Jan\Foundation\Facade
 * @method static get(string $string, string $string1, string $string2)
 */
class Route extends Facade
{

    /**
     * @return mixed
    */
    protected static function getFacadeAccessor(): string
    {
        return Router::class;
    }
}