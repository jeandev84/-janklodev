<?php
namespace Jan\Foundation\Provider;


use Jan\Component\Console\Console;
use Jan\Component\Container\ServiceProvider\ServiceProvider;


/**
 * Class ConsoleServiceProvider
 *
 * @package Jan\Foundation\Provider
*/
class ConsoleServiceProvider extends ServiceProvider
{

    /**
     * @return mixed
    */
    public function register()
    {
         $this->app->singleton(Console::class, function () {
             return new Console();
         });
    }
}