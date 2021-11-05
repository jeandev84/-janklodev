<?php
namespace Jan\Foundation;

use Jan\Component\Container\Container;
use Jan\Component\Container\Contract\ContainerInterface;
use Jan\Component\Container\ServiceProvider\Exception\InvalidServiceProvider;
use Jan\Component\Http\Request\Request;
use Jan\Component\Http\Response\Response;



/**
 * Class Application
 *
 * @package Jan\Foundation
*/
class Application extends Container
{


       /**
        * name of application
        *
        * @var string
       */
       protected $name = 'JanFramework';




       /**
        * version of application
        *
        * @var string
       */
       protected $version = '1.0';




       /**
        * base path of application
        *
        * @var string
       */
       protected $basePath;



       /**
        * Application constructor
        * @param string|null $basePath
        * @throws InvalidServiceProvider
       */
       public function __construct(string $basePath = null)
       {
             if ($basePath) {
                 $this->setBasePath($basePath);
             }

             $this->registers();
       }



       /**
        * Bootstrap of application
        * @throws InvalidServiceProvider
       */
       protected function registers()
       {
           $this->registerBaseBindings();
           $this->registerBaseProviders();
       }




       /**
        * Set base path of application
        *
        * @param string $basePath
        * @return $this
       */
       public function setBasePath(string $basePath): Application
       {
            $this->basePath = rtrim($basePath, '\\/');

            $this->instance('path', $this->basePath);

            return $this;
       }




       /**
        * Register base bindings
       */
       protected function registerBaseBindings()
       {
            self::setInstance($this);
            $this->instance(Container::class, $this);
            $this->instance(ContainerInterface::class, $this);
            $this->instance('app', $this);
       }




       /**
        * Register base service providers
        *
        * @return void
        * @throws InvalidServiceProvider
       */
       protected function registerBaseProviders()
       {
            $this->addProviders(self::getProviderStack());
       }



       /**
        * @param Request $request
        * @param Response $response
       */
       public function terminate(Request $request, Response $response)
       {
             $response->sendBody();

             // micro time
       }



      /**
       * @return array
      */
      protected static function getProviderStack(): array
      {
           return [
              \Jan\Foundation\Provider\AppServiceProvider::class,
              \Jan\Foundation\Provider\FileSystemServiceProvider::class,
              \Jan\Foundation\Provider\ConfigurationServiceProvider::class,
              \Jan\Foundation\Provider\DatabaseServiceProvider::class,
              \Jan\Foundation\Provider\MiddlewareServiceProvider::class,
              \Jan\Foundation\Provider\RouteServiceProvider::class,
              \Jan\Foundation\Provider\AssetServiceProvider::class,
              \Jan\Foundation\Provider\ViewServiceProvider::class,
              \Jan\Foundation\Provider\ConsoleServiceProvider::class
          ];
     }
}