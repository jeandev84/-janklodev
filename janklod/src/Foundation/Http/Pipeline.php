<?php
namespace Jan\Foundation\Http;


use Jan\Component\Container\Container;
use Jan\Component\Http\Middleware\Contract\MiddlewareInterface;
use Jan\Component\Http\Middleware\Middleware;
use Jan\Component\Http\Request\Request;
use Jan\Component\Http\Request\RequestContext;
use Jan\Component\Http\Response\JsonResponse;
use Jan\Component\Http\Response\Response;
use Jan\Component\Routing\Route;
use ReflectionException;


/**
 * Class Pipeline
 *
 * @package Jan\Foundation\Http
*/
class Pipeline
{

    /**
     * Container DI
     *
     * @var Container
    */
    protected $app;




    /**
     * @var Route
    */
    protected $route;




    /**
     * middlewares
     *
     * @var array
     */
    protected $middlewares = [];



    /**
     * Pipeline constructor.
     *
     * @param Container $app
    */
    public function __construct(Container $app)
    {
        $this->app  = $app;
    }



    /**
     * @param array $middlewares
     * @return $this
    */
    public function middlewares(array $middlewares): Pipeline
    {
        $this->middlewares = $middlewares;

        return $this;
    }


    /**
     * @param Route $route
     * @return Pipeline
    */
    public function with(Route $route): Pipeline
    {
        $this->route = $route;

        return $this;
    }


    /**
     * @param Request $request
     * @return Response
     * @throws ReflectionException
     * @throws \Exception
    */
    public function then(Request $request): Response
    {
        $this->app->instance(Request::class, $request);

        /** @var Middleware $middleware */
        $middleware = $this->app['middleware'];


        // add new middlewares and run middleware handle
        $middlewares = array_merge($this->route->getMiddleware(), $this->middlewares);
        $middlewares = $this->resolveMiddlewares($middlewares);
        $middleware->addMiddlewares($middlewares);

        $middleware->handle($request);


        // get response
        $response = $this->callAction($this->route->getCallback(), $this->route->getMatches());

        // set http protocol
        $response->setProtocol($request->getHttpProtocol());

        // return response
        return $response;
    }



    /**
     * @param array $middlewares
     * @return array
     * @throws \Exception
    */
    private function resolveMiddlewares(array $middlewares): array
    {
         $resolves = [];

         foreach ($middlewares as $middleware) {
              if (\is_string($middleware)) {
                   $middleware = $this->app->get($middleware);
              }

              if ($middleware instanceof MiddlewareInterface) {
                  $resolves[] = $middleware;
              }
         }

         return $resolves;
    }



    /**
     * @param $callback
     * @param array $params
     * @return Response
     * @throws ReflectionException
    */
    private function callAction($callback, array $params = []): Response
    {
        if (\is_string($callback) && stripos($callback, '@') !== false) {
            list($controller, $action) = explode('@', $callback, 2);
            $response = $this->app->call($controller, $params, $action);
        }else{
            $response = $this->app->call($callback, $params);
        }

        return $this->resolveResponse($response);
    }



    /**
     * @param mixed|null $response
     * @return Response
    */
    private function resolveResponse($response = null): Response
    {
        if ($response instanceof Response) {
            return $response;
        }

        if(\is_array($response)) {
            return new JsonResponse($response);
        }

        return new Response($response, 200);
    }
}