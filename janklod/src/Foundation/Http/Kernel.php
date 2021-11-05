<?php
namespace Jan\Foundation\Http;

use Exception;
use Jan\Component\Config\Config;
use Jan\Component\Dotenv\Dotenv;
use Jan\Component\Http\Request\Request;
use Jan\Component\Http\Response\Response;
use Jan\Component\Routing\Exception\NotFoundRouteException;
use Jan\Component\Routing\Route;
use Jan\Component\Routing\Router;
use Jan\Contract\Http\Kernel as HttpKernelContract;
use Jan\Foundation\Application;
use Jan\Foundation\Middleware\SessionStartMiddleware;
use Jan\Foundation\Routing\RouteDispatcher;


/**
 * Class Kernel
 *
 * @package Jan\Foundation\Http
*/
class Kernel implements HttpKernelContract
{


    /**
     * @var Application
     */
    protected $app;




    /**
     * @var Router
     */
    protected $router;



    /**
     * @var array
    */
    protected $priorityMiddlewares = [
        SessionStartMiddleware::class
    ];



    /**
     * @var array
    */
    protected $routeMiddlewares = [];




    /**
     * Kernel constructor.
     * @param Application $app
     * @param Router $router
    */
    public function __construct(Application $app, Router $router)
    {
        $this->app    = $app;
        $this->router = $router;
    }




    /**
     * @param Request $request
     * @return Response
     * @throws Exception
    */
    public function handle(Request $request): Response
    {
        try {

            $response = $this->dispatchRoute($request);

        } catch (Exception $e) {

            // $this->app->get('capsule')->purge();
            // dump($this->app->get('_env.mode'));
            $response = $this->renderException($e);
        }

        // TODO call all events ()


        // send the response
        return $response;
    }




    /**
     * @param Request $request
     * @return Response
     * @throws Exception
    */
    protected function dispatchRoute(Request $request): Response
    {
        return (new Pipeline($this->app))
               ->middlewares($this->getMiddlewares())
               ->with($this->getCurrentRoute($request))
               ->then($request);
    }



    /**
     * @return array
    */
    protected function getMiddlewares(): array
    {
        return array_merge($this->priorityMiddlewares, $this->routeMiddlewares);
    }




    /**
     * @param Request $request
     * @return Route
     * @throws NotFoundRouteException
    */
    protected function getCurrentRoute(Request $request): Route
    {
        $dispatcher = new RouteDispatcher($this->router);

        $route = $dispatcher->dispatch($request);

        // add current route
        $this->app->instance('_currentRoute', $route);

        return $route;
    }


    /**
     * @param Exception $e
     * @return Response
    */
    protected function renderException(Exception $e): Response
    {
        /* dd($e); */
        return new Response($e->getMessage(), $e->getCode());
    }



    /**
     * @param Request $request
     * @param Response $response
     * @return void
     * @throws Exception
    */
    public function terminate(Request $request, Response $response)
    {
         $this->app->terminate($request, $response);
    }
}