<?php
namespace Jan\Foundation\Provider;

use Exception;
use Jan\Component\Container\ServiceProvider\ServiceProvider;
use Jan\Component\FileSystem\FileSystem;
use Jan\Component\Routing\Router;
use Jan\Component\Routing\Route;
use Jan\Foundation\Routing\DefaultController;


/**
 * class RouteServiceProvider
 *
 * @package Jan\Foundation\Provider
*/
class RouteServiceProvider extends ServiceProvider
{

    /**
     * @return void
     * @throws Exception
    */
    public function register()
    {
       $this->app->singleton(Router::class, function () {

            # set host in Kernel $router->setURL('http://localhost:8000');
            $router = new Router();

            $router->setDefaultRoute($this->makeDefaultRoute())
                   ->setNamespace('App\\Http\\Controller')
            ;

            return $router;
       });


       $this->loadRoutes($this->app->get(FileSystem::class));

        $this->app->bind('_routes',  function (Router $router) {
            return $router->getRoutes();
        });
    }



    /**
     * @throws Exception
    */
    protected function loadRoutes(FileSystem $fs)
    {
        # load routes
        $fs->load('/routes/api.php');
        $fs->load('/routes/web.php');
    }


    /**
     * @return Route
    */
    protected function makeDefaultRoute(): Route
    {
        return new Route(['GET'], '/', DefaultController::class .'@index', 'route.default');
    }
}