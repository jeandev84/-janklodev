<?php
namespace Jan\Component\Routing;


use Closure;
use Jan\Component\Routing\Contract\RouteCollectionInterface;
use Jan\Component\Routing\Exception\RouteException;
use Jan\Component\Routing\Resource\Support\Resource;



/**
 * Class RouteCollection
 * @package Jan\Component\Routing
*/
class RouteCollection implements RouteCollectionInterface
{
     const PX_PATH       = 'prefix';
     const PX_MODULE     = 'module';
     const PX_MIDDLEWARE = 'middleware';
     const PX_NAME       = 'name';


     /**
      * Get global namespace
      *
      * @var string
     */
     protected $namespace;





     /**
      * routes
      *
      * @var array
     */
     protected $routes = [];



     /**
      * @var array
     */
     protected $groups = [];




     /**
      * @var array
     */
     protected $resources = [];



     /**
       * @var array
     */
     protected $patterns = [];




     /**
      * route prefixes
      *
      * @var array
    */
    protected $prefixes = [
        self::PX_PATH       => '',
        self::PX_MODULE     => '',
        self::PX_NAME       => '',
        self::PX_MIDDLEWARE => []
    ];



     /**
      * @param array $prefixes
      * @return $this
     */
     public function addPrefixes(array $prefixes): RouteCollection
     {
         $this->prefixes = array_merge($this->prefixes, $prefixes);

         return $this;
     }



     /**
      * @param string $name
      * @param null $default
      * @return mixed|null
     */
     public function getPrefixValue(string $name, $default = null)
     {
         return $this->prefixes[$name] ?? $default;
     }



     /**
      * Remove prefixes
     */
     public function removePrefixes()
     {
         $this->prefixes = [];
     }




     /**
      * Remove prefix
      *
      * @param $index
     */
     public function removePrefix($index)
     {
          unset($this->prefixes[$index]);
     }



     /**
      * @param Route $route
      * @return Route
     */
     public function addRoute(Route $route): Route
     {
           $this->routes[] = $route;

          return $route;
     }




    /**
     * @param $name
     * @param $regex
     * @return RouteCollection
    */
    public function patterns($name, $regex = null): RouteCollection
    {
        $patterns = \is_array($name) ? $name : [$name => $regex];

        $this->patterns = array_merge($this->patterns, $patterns);

        return $this;
    }


    /**
     * route group
     *
     * @param Closure $routes
     * @param array $options
     * @return RouteCollection
    */
    public function addGroup(Closure $routes, array $options = []): RouteCollection
    {
        $this->addPrefixes($options);

        $namespacePrefix =$this->getModuleNamespace();

        $routes($this);

        $routeGroups = $this->getRoutesByModule($namespacePrefix);

        $this->groups = array_merge($this->groups, $routeGroups);

        $this->removePrefixes();

        return $this;
    }



    /**
     * @return mixed|null
    */
    protected function getModuleNamespace()
    {
        if (! $this->getPrefixValue(self::PX_MODULE)) {
            $this->addPrefixes([self::PX_MODULE => 'Module\\']);
        }

        return $this->getPrefixValue(self::PX_MODULE);
    }




    /**
     * @param Resource $resource
     * @return $this
     * @throws RouteException
    */
    public function addResource(Resource $resource): RouteCollection
    {
        $controller = $this->prepareRouteCallback($resource->getController());

        foreach ($resource->getData() as $action => $params) {
            $this->resources[$controller][$action] = $this->makeRoute($params);
        }

        return $this;
    }



    /**
     * @param array $params
     * @return Route
     * @throws RouteException
    */
    protected function makeRoute(array $params): Route
    {
        $route = $this->map($params['methods'], $params['path'], $params['callback'], $params['name']);

        $route->where($params['patterns']);

        return $route;
    }



    /**
     * @return array
    */
    public function getResources(): array
    {
        return $this->resources;
    }



    /**
     * @return array
    */
    public function getRoutesByPrefix(): array
    {
        $routeGroups = [];

        /** @var Route $route */
        foreach ($this->getRoutes() as $route) {
            if ($routePrefix = $route->getOption(self::PX_PATH)) {
                $routeGroups[$routePrefix][] = $route;
            }
        }

        return $routeGroups;
    }



    /**
     * @param string $module
     * @return array
    */
    public function getRoutesByModule(string $module): array
    {
        $routes = [];

        /** @var Route $route */
        foreach ($this->getRoutes() as $route) {
            if ($module == $route->getOption(self::PX_MODULE)) {
                $routes[$module][] = $route;
            }
        }

        return $routes;
    }



    /**
     * get route by methods
     *
     * @return array
    */
    public function getRoutesByMethod(): array
    {
         $routes = [];

         /** @var Route $route */
         foreach ($this->getRoutes() as $route) {
             $routes[$route->toStringMethods()][] = $route;
         }

         return $routes;
    }



    /**
     * @return array
    */
    public function getGroups(): array
    {
        return $this->groups;
    }



    /**
     * RouteCollection
     *
     * @param $methods
     * @param string $path
     * @param $callback
     * @param string|null $name
     * @return Route
     * @throws Exception\RouteException
    */
    public function map($methods, string $path, $callback, string $name = null): Route
    {
         $methods     = $this->prepareRouteMethod($methods);
         $path        = $this->prepareRoutePath($path);
         $callback    = $this->prepareRouteCallback($callback);
         $middlewares = $this->getGroupMiddlewares();
         $prefix      = $this->getPrefixValue(static::PX_NAME, '');

         $route = new Route($methods, $path, $callback, $prefix);

         if ($name) {
            $route->name($name);
         }

         $route->where($this->patterns)
               ->middleware($middlewares)
               ->addOptions($this->getDefaultOptions());

         return $this->addRoute($route);
     }



     /**
      * @param string $prefix
      * @return $this
     */
     public function prefix(string $prefix): RouteCollection
     {
        $this->addPrefixes(compact('prefix'));

        return $this;
     }




     /**
      * @param string $module
      * @return $this
     */
     public function module(string $module): RouteCollection
     {
        $this->addPrefixes(compact('module'));

        return $this;
     }



    /**
     * @param string $middleware
     * @return $this
    */
    public function middleware(string $middleware): RouteCollection
    {
        $this->addPrefixes(compact('middleware'));

        return $this;
    }




    /**
     * @param string $name
     * @return $this
    */
    public function name(string $name): RouteCollection
    {
          $this->addPrefixes(compact('name'));

          return $this;
    }





    /**
     * namespace used for controller
     *
     * @param string $namespace
     * @return $this
    */
    public function setNamespace(string $namespace): RouteCollection
    {
        $this->namespace = rtrim($namespace, '\\');

        return $this;
    }




    /**
     * @return string
     */
    public function getNamespace(): string
    {
        return $this->namespace;
    }





    /**
      * @return array
    */
    public function getRoutes(): array
    {
        return $this->routes;
    }



     /**
      * @return array
     */
     public function getNamedRoutes(): array
     {
         return Route::$collects;
     }




     /**
      * @param string $name
      * @return bool
     */
     public function hasRoute(string $name): bool
     {
         return \array_key_exists($name, Route::$collects);
     }



     /**
      * @param string $name
      * @return mixed|null
      * @throws \Exception
     */
     public function getRoute(string $name)
     {
         if (! $this->hasRoute($name)) {
              throw new \Exception('unavailable route name : ('. $name .')');
         }

         return Route::$collects[$name];
     }



     /**
      * @param $methods
      * @return array
     */
     protected function prepareRouteMethod($methods): array
     {
          if (\is_string($methods)) {
              $methods = explode('|', $methods);
          }

          return (array) $methods;
     }



     /**
      * @param string $path
      * @return string
     */
     public function prepareRoutePath(string $path): string
     {
         if ($prefix = $this->getPrefixValue(static::PX_PATH)) {
             $path = trim($prefix, '/'). '/' . ltrim($path, '/');
         }

         return $path;
     }


     /**
      * @param $callback
      * @return mixed
     */
     protected function prepareRouteCallback($callback)
     {
          $module = $this->getPrefixValue(self::PX_MODULE);

          if (\is_string($callback)) {
              if ($module) {
                  $callback = rtrim($module, '\\') . '\\'. $callback;
              }

              if ($this->namespace) {
                  $callback = $this->namespace .'\\' . $callback;
              }
          }

          return $callback;
     }



     /**
      * @return mixed
     */
     protected function getGroupMiddlewares()
     {
          return $this->getPrefixValue(static::PX_MIDDLEWARE, []);
     }



     /**
      * @return array
     */
     protected function getDefaultOptions(): array
     {
         return [
             self::PX_PATH      => $this->getPrefixValue(self::PX_PATH),
             self::PX_MODULE    => $this->getPrefixValue(self::PX_MODULE),
         ];
     }
}