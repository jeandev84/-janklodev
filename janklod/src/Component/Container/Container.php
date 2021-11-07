<?php
declare(strict_types=1);
namespace Jan\Component\Container;


use Closure;
use Exception;
use InvalidArgumentException;
use Jan\Component\Container\Contract\ContainerBagInterface;
use Jan\Component\Container\Contract\ContainerContract;
use Jan\Component\Container\Contract\ContainerInterface;
use Jan\Component\Container\Facade\Facade;
use Jan\Component\Container\ServiceProvider\Contract\BootableServiceProvider;
use Jan\Component\Container\ServiceProvider\Exception\InvalidServiceProvider;
use Jan\Component\Container\ServiceProvider\ServiceProvider;
use ReflectionClass;
use ReflectionException;


/**
 * Class Container
 * @package Jan\Component\Container
 */
class Container implements ContainerContract
{

    /**
     * @var Container
     */
    protected static $instance;



    /**
     * storage all bound params
     *
     * @var array
     */
    protected $bindings = [];



    /**
     * storage all instances
     *
     * @var array
     */
    protected $instances = [];


    /**
     * storage all resolved params
     *
     * @var array
     */
    protected $resolved  = [];



    /**
     * storage all aliases
     *
     * @var array
    */
    protected $aliases = [];




    /**
     * collection service providers
     *
     * @var array
    */
    protected $providers = [];





    /**
     * collection facades
     *
     * @var array
    */
    protected $facades = [];





    /**
     * Set container instance
     *
     * @param ContainerInterface|null $instance
     */
    public static function setInstance(ContainerInterface $instance = null): ?ContainerInterface
    {
        return static::$instance = $instance;
    }




    /**
     * Get container instance <Singleton>
     *
     * @return Container|static
    */
    public static function getInstance(): Container
    {
        if(is_null(static::$instance)) {
            static::$instance = new static();
        }

        return static::$instance;
    }



    /**
     * Get bindings params
     *
     * @return array
     */
    public function getBindings(): array
    {
        return $this->bindings;
    }


    /**
     * Get all instances
     *
     * @return array
     */
    public function getInstances(): array
    {
        return $this->instances;
    }


    /**
     * Get resolved params
     *
     * @return array
     */
    public function getResolved(): array
    {
        return $this->resolved;
    }



    /**
     * @return array
     */
    public function getAliases(): array
    {
        return $this->aliases;
    }


    /**
     * @param string $abstract
     * @return mixed
     */
    public function getConcreteContext(string $abstract)
    {
        if(! $this->hasConcrete($abstract)) {
            return $abstract;
        }

        return $this->bindings[$abstract]['concrete'];
    }



    /**
     * @param string $abstract
     * @param null $concrete
     * @param bool $shared
     * @return $this
     */
    public function bind(string $abstract, $concrete = null, bool $shared = false): Container
    {
        if(\is_null($concrete)) {
            $concrete = $abstract;
        }

        $this->bindings[$abstract] = compact('concrete', 'shared');

        return $this;
    }



    /**
     * Bind many params in the container
     *
     * @param array $bindings
     */
    public function binds(array $bindings)
    {
        foreach ($bindings as $bind) {
            list($abstract, $concrete, $shared) = $bind;
            $this->bind($abstract, $concrete, $shared);
        }
    }



    /**
     * Determine if the given param is bound
     *
     * @param $abstract
     * @return bool
     */
    public function bound($abstract): bool
    {
        return isset($this->bindings[$abstract]);
    }




    /**
     * @param string $abstract
     * @param $concrete
     * @return $this|Container
     */
    public function singleton(string $abstract, $concrete): Container
    {
        return $this->bind($abstract, $concrete, true);
    }


    /**
     * @param $abstract
     * @return bool
     */
    public function isShared($abstract): bool
    {
        return $this->hasInstance($abstract) || $this->onlyShared($abstract);
    }



    /**
     * Share a parameter
     *
     * @param $abstract
     * @param $concrete
     * @return mixed
     */
    public function share($abstract, $concrete)
    {
        if(! $this->hasInstance($abstract)) {
            $this->instances[$abstract] = $concrete;
        }

        return $this->instances[$abstract];
    }




    /**
     * Set instance
     *
     * @param $abstract
     * @param $concrete
     * @return Container
    */
    public function instance($abstract, $concrete): Container
    {
        $this->instances[$abstract] = $concrete;

        return $this;
    }


    /**
     * @param string $abstract
     * @return mixed
     * @throws Exception
     */
    public function factory(string $abstract)
    {
        return $this->make($abstract);
    }


    /**
     * @param string $abstract
     * @param array $parameters
     * @return mixed
     * @throws Exception
     */
    public function make(string $abstract, array $parameters = [])
    {
        return $this->resolve($abstract, $parameters);
    }


    /**
     * @param $abstract
     * @param $alias
     * @return Container
     */
    public function alias($abstract, $alias): Container
    {
        $this->aliases[$abstract] = $alias;

        return $this;
    }


    /**
     * @param $abstract
     * @return mixed
     */
    public function getAlias($abstract)
    {
        if($this->hasAlias($abstract)) {
            return $this->aliases[$abstract];
        }

        return $abstract;
    }



    /**
     * @param $id
     * @return bool
     */
    public function has($id): bool
    {
        return $this->bound($id) || $this->hasInstance($id) || $this->hasAlias($id);
    }



    /**
     * @param $id
     * @return bool
     */
    public function hasInstance($id): bool
    {
        return isset($this->instances[$id]);
    }



    /**
     * @param $id
     * @return bool
     */
    public function hasAlias($id): bool
    {
        return isset($this->aliases[$id]);
    }



    /**
     * @param $id
     * @return bool
     */
    public function resolved($id): bool
    {
        return isset($this->resolved[$id]);
    }



    /**
     * @param $abstract
     * @return bool
     */
    protected function hasConcrete($abstract): bool
    {
        return isset($this->bindings[$abstract]) && isset($this->bindings[$abstract]['concrete']);
    }



    /**
     * @param $id
     * @return mixed|null
     * @throws Exception
     */
    public function get($id)
    {
        try {

            return $this->resolve($id);

        } catch (Exception $e) {

            throw new Exception(sprintf('entry %s not found.', $id), $e->getCode(), $e);
        }
    }


    /**
     * @param string $abstract
     * @param array $parameters
     * @return mixed
     * @throws Exception
     */
    public function resolve(string $abstract, array $parameters = [])
    {
        // get abstract from alias
        $abstract = $this->getAlias($abstract);

        // get concrete context
        $concrete = $this->getConcreteContext($abstract);

        if($this->resolvable($concrete)) {
            $concrete = $this->resolveConcrete($concrete, $parameters);
            $this->resolved[$abstract] = true;
        }

        if($this->isShared($abstract)) {
            return $this->share($abstract, $concrete);
        }

        return $concrete;
    }



    /**
     * get function dependencies
     *
     * @param array $dependencies
     * @param array $params
     * @return array
     * @throws Exception
     */
    public function resolveDependencies(array $dependencies, array $params = []): array
    {
        $resolvedDependencies = [];

        foreach ($dependencies as $parameter) {
            $dependency = $parameter->getClass();

            if($parameter->isOptional()) { continue; }
            if($parameter->isArray()) { continue; }

            if(\is_null($dependency)) {
                if ($parameter->isDefaultValueAvailable()) {
                    $resolvedDependencies[] = $parameter->getDefaultValue();
                } else {
                    if (array_key_exists($parameter->getName(), $params)) {
                        $resolvedDependencies[] = $params[$parameter->getName()];
                    } else {
                        throw new InvalidArgumentException(
                            sprintf('can not resolve dependency (%s) ', $parameter->getName())
                        );
                    }
                }
            } else {
                $resolvedDependencies[] = $this->get($dependency->getName());
            }
        }

        return $resolvedDependencies;
    }



    /**
     * @param $concrete
     * @return bool
     */
    public function resolvable($concrete): bool
    {
        if($concrete instanceof Closure) {
            return true;
        }

        if (\is_string($concrete) && \class_exists($concrete)) {
            return true;
        }

        return false;
    }


    /**
     * @param $concrete
     * @param array $params
     * @return mixed
     * @throws Exception
     */
    public function resolveConcrete($concrete, array $params = [])
    {
        if($concrete instanceof Closure) {
            return $this->call($concrete, $params);
        }

        return $this->makeInstance($concrete, $params);
    }


    /**
     * @param string $concrete
     * @param array $params
     * @return object
     * @throws ReflectionException
     * @throws Exception
     */
    public function makeInstance(string $concrete, array $params = []): object
    {
        $reflectedClass = new ReflectionClass($concrete);

        if($reflectedClass->isInstantiable()) {

            $constructor = $reflectedClass->getConstructor();

            if(\is_null($constructor)) {
                return $reflectedClass->newInstance();
            }

            $dependencies = $this->resolveDependencies($constructor->getParameters(), $params);
            return $reflectedClass->newInstanceArgs($dependencies);
        }

        throw new ReflectionException('Cannot instantiate given argument ('. $concrete .')');
    }



    /**
     * @param $concrete
     * @param array $params
     * @param string $method
     * @return mixed
     * @throws ReflectionException
     * @throws Exception
    */
    public function call($concrete, array $params = [], string $method = '')
    {
        if (is_callable($concrete)) {
           return $this->callAnonymous($concrete);
        }

        if (\is_string($concrete) && $method) {
           return $this->callAction($concrete, $method, $params);
        }

        throw new InvalidArgumentException(sprintf('argument (%s) is not callable.', $concrete));
    }




    /**
     * @throws ReflectionException
     * @throws Exception
    */
    public function callAnonymous($concrete, array $params = [])
    {
        if (! is_callable($concrete)) {
            throw new InvalidArgumentException('cannot call given param for func().');
        }

        if ($concrete instanceof Closure) {
            $reflectedFunction  = new \ReflectionFunction($concrete);
            $functionParameters = $reflectedFunction->getParameters();

            /*
            // $dependencyParams = $this->resolveDependencies($functionParameters, $params);
            // return $concrete(...$dependencyParams);
            */

            $params = $this->resolveDependencies($functionParameters, $params);
        }

        return call_user_func($concrete, ...$params);
    }




    /**
     * @param string $concrete
     * @param string $method
     * @param array $params
     * @return false|mixed
     * @throws ReflectionException
     * @throws Exception
    */
    public function callAction(string $concrete, string $method, array $params = [])
    {
        $reflectedMethod = new \ReflectionMethod($concrete, $method);
        $arguments = $this->resolveDependencies($reflectedMethod->getParameters(), $params);

        $object = $this->get($concrete);

        $implements = class_implements($object);

        if (isset($implements[ContainerBagInterface::class])) {
            $object->setContainer($this);
        }

        return call_user_func_array([$object, $method], $arguments);
    }




    /**
     * @param $object
     * @param $method
     * @param array $params
     * @return false|mixed
    */
    public function callback($object, $method, array $params = [])
    {
        return call_user_func_array([$object, $method], $params);
    }



    /**
     * F'lush the container of all bindings and resolved instances.
     *
     * @return void
     */
    public function flush()
    {
        $this->aliases = [];
        $this->resolved = [];
        $this->bindings = [];
        $this->instances = [];
    }


    /**
     * @param $abstract
     * @return bool
     */
    protected function onlyShared($abstract): bool
    {
        return isset($this->bindings[$abstract]['shared'])
               && $this->bindings[$abstract]['shared'] === true;
    }


    /**
     * add service providers
     *
     * @param array $providers
     * @return Container
     * @throws InvalidServiceProvider
    */
    public function addProviders(array $providers): Container
    {
        foreach ($providers as $provider) {
            $this->addProvider($provider);
        }

        return $this;
    }




    /**
     * add service provider
     *
     * @param ServiceProvider|string $provider
     * @return $this
     * @throws InvalidServiceProvider
     * @throws Exception
    */
    public function addProvider($provider): Container
    {
        $provider = $this->resolveProvider($provider);

        return $this->providerProcess($provider);
    }



    /**
     * @param $provider
     * @return ServiceProvider
     * @throws InvalidServiceProvider
     * @throws Exception
    */
    protected function resolveProvider($provider): ServiceProvider
    {
        if (\is_string($provider)) {
            $provider = $this->get($provider);
        }

        if (! $provider instanceof ServiceProvider) {
            throw new InvalidServiceProvider('cannot resolve this service provider.');
        }

        return $provider;
    }




    /**
     * @return array
    */
    public function getProviders(): array
    {
        return $this->providers;
    }




    /**
     * @param ServiceProvider $provider
     * @return Container
    */
    protected function providerProcess(ServiceProvider $provider): Container
    {
          $provider->setContainer($this);

          if (! \in_array($provider, $this->providers)) {

              $implements = class_implements($provider);

              if (isset($implements[BootableServiceProvider::class])) {
                  if (method_exists($provider, 'boot')) {
                      $provider->boot();
                  }
              }

              $provider->register();

              $this->providers[] = $provider;
          }

          return $this;
    }


    /**
     * @param Facade|string $facade
     * @return $this
     * @throws Exception
    */
    public function addFacade($facade): Container
    {
         $facade = $this->resolveFacade($facade);

         if (! \in_array($facade, $this->facades)) {

             $facade->setContainer($this);

             $this->facades[] = $facade;

         }


         return $this;
    }


    /**
     * @param $facade
     * @return Facade
     * @throws Exception
    */
    protected function resolveFacade($facade): Facade
    {
        if (\is_string($facade)) {
            $facade = $this->get($facade);
        }

        if (! $facade instanceof Facade) {
            throw new InvalidArgumentException('cannot resolve given argument for adding facade.');
        }

        return $facade;
    }

    /**
     * @param array $facades
     * @throws Exception
    */
    public function addFacades(array $facades)
    {
         foreach ($facades as $facade) {
             $this->addFacade($this->get($facade));
         }
    }



    /**
     * @return array
    */
    public function getFacades(): array
    {
        return $this->facades;
    }





    /**
     * @param mixed $id
     * @return bool
    */
    public function offsetExists($id): bool
    {
        return $this->has($id);
    }


    /**
     * @param mixed $id
     * @return mixed
     * @throws Exception
     */
    public function offsetGet($id)
    {
        return $this->get($id);
    }


    /**
     * @param mixed $id
     * @param mixed $value
     */
    public function offsetSet($id, $value)
    {
        $this->bind($id, $value);
    }


    /**
     * @param mixed $id
     */
    public function offsetUnset($id)
    {
        unset(
            $this->bindings[$id],
            $this->instances[$id],
            $this->resolved[$id]
        );
    }


    /**
     * @param $name
     * @return array|bool|mixed|object|string|null
     */
    public function __get($name)
    {
        return $this[$name];
    }




    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $this[$name] = $value;
    }
}