<?php
namespace Jan\Foundation\Provider;

use Exception;
use Jan\Component\Container\Container;
use Jan\Component\Container\ServiceProvider\Contract\BootableServiceProvider;
use Jan\Component\Container\ServiceProvider\ServiceProvider;
use Jan\Component\Dotenv\Dotenv;
use Jan\Foundation\Application;


/**
 * class AppServiceProvider
 *
 * @package Jan\Foundation\Provider
*/
class AppServiceProvider extends ServiceProvider implements BootableServiceProvider
{

    /**
     * @var array
    */
    protected $classAliases = [
        "Route" =>  "Jan\Foundation\Facade\Routing\Route",
        "Asset" =>  "Jan\Foundation\Facade\Templating\Asset"
    ];



    /**
     * @var array
    */
    protected $facades = [
        "Jan\Foundation\Facade\Routing\Route",
        "Jan\Foundation\Facade\Templating\Asset",
        "Jan\Foundation\Facade\Database\DB",
        "Jan\Foundation\Facade\Database\Schema",
    ];



    /**
     * @throws Exception
    */
    public function boot()
    {
        $this->loadEnvironments();
        $this->loadHelpers();
        $this->loadClassAliases();
        $this->loadFacades();
    }




    /**
     * @throws Exception
    */
    public function register()
    {
        $this->app->singleton(Application::class, function () {
            return Container::getInstance();
        });
    }



    /**
     * load helpers
    */
    protected function loadHelpers()
    {
        require __DIR__.'/../helpers.php';
    }


    /**
     * Load environments
     *
     * @throws Exception
    */
    protected function loadEnvironments()
    {
        // TODO load .env (if prod version) ~ .env.local (if dev version)
        Dotenv::create($this->app->get('path'))->load();

        $this->app->bind('_env.mode', getenv('APP_ENV'));
    }



    /**
     * load class aliases
     */
    protected function loadClassAliases()
    {
        foreach ($this->classAliases as $alias => $className) {
            \class_alias($className, $alias);
        }
    }




    /**
     * load facades
     *
     * @throws Exception
    */
    protected function loadFacades()
    {
        $this->app->addFacades($this->facades);
    }

}