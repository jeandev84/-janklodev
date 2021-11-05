<?php
namespace Jan\Component\Routing;


use Closure;
use Exception;
use Jan\Component\Routing\Contract\RouteDispatcherInterface;
use Jan\Component\Routing\Contract\RouterInterface;
use Jan\Component\Routing\Exception\NotFoundRouteException;
use Jan\Component\Routing\Exception\RouteException;
use Jan\Component\Routing\Resource\ApiResource;
use Jan\Component\Routing\Resource\WebResource;


/**
 * Class Router
 * @package Jan\Component\Routing
 */
class Router extends RouteCollection implements RouterInterface
{

    /**
     * @var string
    */
    protected $baseURL;




    /**
     * @var Route
    */
    protected $defaultRoute;




    /**
     * Router constructor.
     *
     * @param string|null $baseURL
    */
    public function __construct(string $baseURL = null)
    {
        if ($baseURL) {
            $this->setURL($baseURL);
        }
    }



    /**
     * @param string $baseURL
     * @return Router
    */
    public function setURL(string $baseURL): Router
    {
        $this->baseURL = rtrim($baseURL, '/');

        return $this;
    }




    /**
     * @param string $path
     * @param $callback
     * @param string|null $name
     * @return Route
     * @throws RouteException
     */
    public function get(string $path, $callback, string $name = null): Route
    {
        return $this->map('GET', $path, $callback, $name);
    }




    /**
     * @param string $path
     * @param $callback
     * @param string|null $name
     * @return Route
     * @throws RouteException
     */
    public function post(string $path, $callback, string $name = null): Route
    {
        return $this->map('POST', $path, $callback, $name);
    }





    /**
     * @param string $path
     * @param $callback
     * @param string|null $name
     * @return Route
     * @throws RouteException
     */
    public function put(string $path, $callback, string $name = null): Route
    {
        return $this->map('PUT', $path, $callback, $name);
    }




    /**
     * @param string $path
     * @param $callback
     * @param string|null $name
     * @return Route
     * @throws RouteException
     */
    public function delete(string $path, $callback, string $name = null): Route
    {
        return $this->map('DELETE', $path, $callback, $name);
    }




    /**
     * @param string $path
     * @param $callback
     * @param string|null $name
     * @return Route
     * @throws RouteException
     */
    public function any(string $path, $callback, string $name = null): Route
    {
        return $this->map('GET|POST|PUT|DELETE|PATCH', $path, $callback, $name);
    }




    /**
     * Determine if the current method and path URL match route
     *
     * @param string|null $requestMethod
     * @param string|null $requestUri
     * @return false|Route
     */
    public function match(?string $requestMethod, ?string $requestUri)
    {
        /** @var Route $route */
        foreach ($this->getRoutes() as $route) {
            if ($route->match($requestMethod, $requestUri)) {
                return $route;
            }
        }

        return false;
    }



    /**
     * Add route group
     *
     * @param Closure $routeCallback
     * @param array $prefixes
     * @return RouteCollection
    */
    public function group(Closure $routeCallback, array $prefixes = []): RouteCollection
    {
        return $this->addGroup($routeCallback, $prefixes);
    }




    /**
     * Api resource
     *
     * @param string $path
     * @param string $controller
     * @return $this
     * @throws RouteException
     */
    public function resourceWeb(string $path, string $controller): Router
    {
        return $this->addResource(new WebResource($path, $controller));
    }




    /**
     * route resource
     *
     * @param string $path
     * @param string $controller
     * @return $this
     * @throws RouteException
     */
    public function resourceAPI(string $path, string $controller): Router
    {
        return $this->addResource(new ApiResource($path, $controller));
    }




    /**
     * @param Closure|null $closure
     * @param array $options
     * @return RouteCollection
     */
    public function api(Closure $closure = null, array $options = []): RouteCollection
    {
        if (! $options) {
            $options = $this->getDefaultOptionsApi();
        }

        if (! $closure) {
            $this->addPrefixes($options);
            return $this;
        }

        return $this->group($closure, $options);
    }



    /**
     * Generate route URL
     *
     * @param string $name
     * @param array $parameters
     * @return string
     * @throws Exception
     */
    public function generate(string $name, array $parameters= []): ?string
    {
        if (! $this->hasRoute($name)) {
            throw new \InvalidArgumentException('Invalid route name for generating path.');
        }

        return $this->getRoute($name)->generatePath($parameters);
    }



    /**
     * @param string $name
     * @param array $params
     * @return string
     * @throws Exception
    */
    public function url(string $name, array $params = []): string
    {
        return $this->baseURL . $this->generate($name, $params);
    }


    /**
     * Set handle default route
     *
     * @param Route $route
     * @return RouteCollection
    */
    public function setDefaultRoute(Route $route): RouteCollection
    {
        $this->defaultRoute = $route;

        return $this;
    }



    /**
     * @return Route
    */
    public function getDefaultRoute(): Route
    {
        return $this->defaultRoute;
    }




    /**
     * @return array
    */
    protected function getDefaultOptionsApi(): array
    {
        return [self::PX_PATH => 'api', self::PX_MODULE => 'Api\\'];
    }

}