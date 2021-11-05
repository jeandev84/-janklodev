<?php
namespace Jan\Foundation\Provider;


use Jan\Component\Container\ServiceProvider\ServiceProvider;
use Jan\Component\Http\Middleware\Middleware;


/**
 * Class MiddlewareServiceProvider
 *
 * @package Jan\Foundation\Provider
*/
class MiddlewareServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->singleton('middleware', function () {
            return new Middleware();
        });
    }
}