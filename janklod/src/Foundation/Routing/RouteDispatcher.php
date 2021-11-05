<?php
namespace Jan\Foundation\Routing;


use Jan\Component\Http\Request\Request;
use Jan\Component\Routing\Exception\NotFoundRouteException;
use Jan\Component\Routing\Route;
use Jan\Component\Routing\Router;
use Jan\Contract\Routing\RouteDispatcherInterface;



/**
 * Class RouteDispatcher
 *
 * @package Jan\Foundation\Routing
*/
class RouteDispatcher implements RouteDispatcherInterface
{

    /**
     * @var Router
    */
    protected $router;



    /**
     * @param Router $router
    */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }



    /**
     * @param Request $request
     * @return Route
     * @throws NotFoundRouteException
    */
    public function dispatch(Request $request): Route
    {
        if (! $this->router->getRoutes()) {
            return $this->router->getDefaultRoute();
        } else {

            $route = $this->router->match($request->getMethod(), $path = $request->getUri()->getPath());

            if (!$route instanceof Route) {
                throw new NotFoundRouteException(sprintf('Route (%s) not found.', $path), 404);
            }

            $request->setAttributes([
                '_routeName'    => $route->getName(),
                '_routeHandler' => $route->getCallback(),
                '_routeParams'  => $route->getMatches()
            ]);

            // add current route
            return $route;
        }
    }


}