<?php
namespace Jan\Component\Routing;


use Jan\Component\Routing\Exception\RouteException;


/**
 * class Route
 * @package Jan\Component\Routing
*/
class Route implements \ArrayAccess
{


      const SLASH = '/';


      /**
       * route path
       *
       * @var string
      */
      protected $path;



      /**
       * route callback
       *
       * @var mixed
      */
      protected $callback;



     /**
      * route name
      *
      * @var string
     */
     protected $name;



     /**
      * route methods
      *
      * @var array
     */
     protected $methods = [];



     /**
      * route regex params
      *
      * @var array
     */
     protected $patterns = [];



     /**
      * route matches params
      *
      * @var array
     */
     protected $matches = [];




     /**
      * route middlewares
      *
      * @var array
     */
     protected $middlewares = [];



     /**
      * route options
      *
      * @var array
     */
     protected $options = [];





     /**
      * named routes collection
      *
      * @var array
     */
     public static $collects = [];



     /**
      * @param string|null $path
      * @param mixed $callback
      * @param string|null $name
     */
     public function __construct(array $methods = [], string $path = null, $callback = null, string $name = null)
     {
           $this->methods = $methods;
           $this->path = $path;
           $this->callback = $callback;
           $this->name = $name;
     }



    /**
     * get route methods
     *
     * @return array
    */
    public function getMethods(): array
    {
        return $this->methods;
    }



    /**
     * convert array methods to string
     *
     * @param string $s (separator)
     * @return string
    */
    public function toStringMethods(string $s = '|'): string
    {
        return implode($s, $this->getMethods());
    }




    /**
     * set route methods
     *
     * @param array $methods
     * @return Route
    */
    public function methods(array $methods): Route
    {
        $this->methods = $methods;

        return $this;
    }




    /**
     * get route path
     *
     * @return string
    */
    public function getPath(): ?string
    {
        return $this->path;
    }



    /**
     * set route path
     *
     * @param string|null $path
     * @return Route
    */
    public function path(?string $path): Route
    {
        $this->path = $path;

        return $this;
    }



    /**
     * get route pattern
     *
     * @return string
    */
    public function getPattern(): string
    {
        $pattern = $this->removeTrailingSlashes($this->path);

        if ($this->patterns) {
            $pattern = $this->replacePlaceholders($pattern, $this->patterns);
        }

        return '#^'. $pattern .'$#i';
    }



    /**
     * get route callback
     *
     * @return mixed
    */
    public function getCallback()
    {
        return $this->callback;
    }




    /**
     * set route callback
     *
     * @param mixed $callback
     * @return Route
    */
    public function callback($callback): Route
    {
        $this->callback = $callback;

        return $this;
    }



    /**
     * @param array $matches
     * @return $this
    */
    public function setMatches(array $matches): Route
    {
         $this->matches = $matches;

         return $this;
    }



    /**
     * get route name
     *
     * @return string
    */
    public function getName(): ?string
    {
        return $this->name;
    }



    /**
     * set route name
     *
     * @param string|null $name
     * @return Route
     * @throws RouteException
    */
    public function name(?string $name): Route
    {
        $name = $this->name . $name;

        if (\array_key_exists($name, static::$collects)) {
            throw new RouteException(
                sprintf('This route name (%s) already taken!', $name)
            );
        }

        static::$collects[$name] = $this;

        $this->name = $name;

        return $this;
    }




    /**
     * set route middlewares
     *
     * @param $middleware
     * @return $this
    */
    public function middleware($middleware): Route
    {
        $this->middlewares = array_merge($this->middlewares, (array) $middleware);

        return $this;
    }




    /**
     * get route middlewares
     *
     * @return array
    */
    public function getMiddleware(): array
    {
        return $this->middlewares;
    }



    /**
     * @param $name
     * @return mixed|string
    */
    public function getParam($name)
    {
        return $this->patterns[$name] ?? '';
    }



    /**
     * @return array
    */
    public function getPatterns(): array
    {
        return $this->patterns;
    }




    /**
     * set route regex params
     *
     * @param $name
     * @param null $regex
     * @return Route
    */
    public function where($name, $regex = null): Route
    {
        foreach ($this->parseWhere($name, $regex) as $name => $regex) {
            $this->patterns[$name] = '(?P<'. $name .'>'. $this->resolveRegex($regex) . ')';
        }

        return $this;
    }




    /**
     * @param string $name
     * @return $this
    */
    public function whereNumeric(string $name): Route
    {
        return $this->where($name, '[0-9]+'); // (\d+)
    }




    /**
     * @param string $name
     * @return Route
    */
    public function any(string $name): Route
    {
        return $this->where($name, '.*');
    }




    /**
     * @param string $name
     * @return $this|Route
    */
    public function whereWord(string $name): Route
    {
        return $this->where($name, '\w+');
    }




    /**
     * @param string $name
     * @return $this|Route
    */
    public function whereDigital(string $name): Route
    {
        return $this->where($name, '\d+');
    }




    /**
     * @param string $name
     * @return Route
    */
    public function whereAlphaNumeric(string $name): Route
    {
        return $this->where($name, '[^a-z_\-0-9]');
    }



    /**
     * @param string $name
     * @return Route
    */
    public function whereSlug(string $name): Route
    {
        return $this->where($name, '[a-z\-0-9]+');
    }




    /**
     * Convert path parameters
     *
     * @param array $params
     * @return string
    */
    public function generatePath(array $params): string
    {
         $path = $this->getPath();
         $path = $this->removeTrailingSlashes($path);

         foreach ($params as $k => $v) {
             $path = preg_replace(["#{{$k}}#", "#{{$k}.?}#"], $v, $path);
         }

         return sprintf('%s%s', self::SLASH, $path);
    }




    /**
     * @param $name
     * @param array $params
     * @return void|null
    */
    public static function generate($name, array $params = [])
    {
         if (! isset(self::$collects[$name])) {
              return null;
         }

         self::$collects[$name]->replaceParams($params);
    }


    /**
     * @param string|null $requestMethod
     * @return bool
    */
    public function matchMethod(?string $requestMethod): bool
    {
         if (\in_array($requestMethod, $this->methods)) {
             $this->addOptions(compact('requestMethod'));
             return true;
         }

         return false;
    }


    /**
     * @param string|null $requestUri
     * @return false
    */
    public function matchPath(?string $requestUri): bool
    {
        if (preg_match($pattern = $this->getPattern(), $this->resolveURL($requestUri), $matches)) {

            $this->matches = $this->filterMatchedParams($matches);

            $this->addOptions(compact('pattern', 'requestUri'));

            return true;
        }

        return false;
    }


    /**
     * @return array
    */
    public function getMatches(): array
    {
        return $this->matches;
    }


    /**
     * @param string|null $requestMethod
     * @param string|null $requestUri
     * @return bool
    */
    public function match(?string $requestMethod, ?string $requestUri): bool
    {
         return $this->matchMethod($requestMethod) && $this->matchPath($requestUri);
    }




    /**
     * @return array
    */
    public function getOptions(): array
    {
        return $this->options;
    }



    /**
     * @param array $options
     * @return Route
    */
    public function addOptions(array $options): Route
    {
        $this->options = array_merge($this->options, $options);

        return $this;
    }



    /**
     * @param $key
     * @param $value
     * @return $this
    */
    public function setOption($key, $value): Route
    {
         $this->options[$key] = $value;

         return $this;
    }


    /**
     * @param $key
     * @param null $default
     * @return mixed|null
    */
    public function getOption($key, $default = null)
    {
        return $this->options[$key] ?? $default;
    }


    /**
     * get path of given URL
     *
     * @param string|null $path
     * @return string
     */
    public function resolveURL(?string $path): string
    {
        if(stripos($path, '?') !== false) {
            $path = explode('?', $path, 2)[0];
        }

        return $this->removeTrailingSlashes($path);
    }


    /**
     * @param string $path
     * @return string
    */
    public function resolvePath(string $path): string
    {
        $position = strpos($path, '?');

        if ($position !== false) {
            $path = substr($path, 0, $position);
        }

        return $this->removeTrailingSlashes($path);
    }



    /**
     * just
     * @param string $path
     * @return false|string
    */
    public function resolvePathOtherLogic(string $path)
    {
        $position = strpos($path, '?');

        if ($position === false) {
            return $path;
        }

        return substr($path, 0, $position);
    }



    /**
     * @param array $matches
     * @return array
    */
    protected function filterMatchedParams(array $matches): array
    {
        return array_filter($matches, function ($key) {

            return ! is_numeric($key);

        }, ARRAY_FILTER_USE_KEY);
    }



    /**
     * Determine parses
     *
     * @param $name
     * @param $regex
     * @return array
    */
    protected function parseWhere($name, $regex): array
    {
        return \is_array($name) ? $name : [$name => $regex];
    }



    /**
     * @param $regex
     * @return string|string[]
    */
    protected function resolveRegex($regex)
    {
        return str_replace('(', '(?:', $regex);
    }


    /**
     * @param string $pattern
     * @param array $patterns
     * @return string
    */
    protected function replacePlaceholders(string $pattern, array $patterns): string
    {
        foreach ($patterns as $k => $v) {
            $pattern = preg_replace(["#{{$k}}#", "#{{$k}.?}#"], [$v, '?'. $v .'?'], $pattern);
        }

        return $pattern;
    }


    /**
     * @param string|null $path
     * @return string
     */
    protected function removeTrailingSlashes(?string $path): string
    {
        return trim($path, '\\/');
    }


    /**
     * @param mixed $offset
     * @return bool|void
     */
    public function offsetExists($offset)
    {
        return property_exists($this, $offset);
    }


    /**
     * @param mixed $offset
     * @return mixed|void
     */
    public function offsetGet($offset)
    {
        if(property_exists($this, $offset)) {
            return $this->{$offset};
        }

        return null;
    }


    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        if(property_exists($this, $offset)) {
            $this->{$offset} = $value;
        }
    }


    /**
     * @param mixed $offset
    */
    public function offsetUnset($offset)
    {
        if(property_exists($this, $offset)) {
            unset($this->{$offset});
        }
    }
}