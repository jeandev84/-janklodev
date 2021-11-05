<?php
namespace Jan\Express;


use Jan\Component\Container\Container;
use Jan\Component\Http\Request\Request;
use Jan\Component\Http\Response\Response;
use Jan\Component\Routing\Exception\RouteException;
use Jan\Component\Routing\Router;



/**
 * Class App
 *
 * @package Jan\Express
*/
class App extends Container
{

     /**
      * @var array
     */
     protected $definitions = [];


     /**
      * @var Router
     */
     protected $router;


     /**
      * @param array $definitions
     */
     public function __construct(array $definitions)
     {
          $this->bootstrap($definitions);
     }




     protected function bootstrap(array $definitions)
     {
         $this->definitions = $this->bindDefinitions($definitions);

         $this->instance('router', new Router());
     }



     public function getRouter()
     {
          return $this->get('router');
     }



     /**
     */
     public function map(string $methods, string $path, \Closure $handle)
     {
          $this->getRouter()->map($methods, $path, $handle);
     }




     /**
      * @param Request $request
      * @return \Closure
     */
     protected function handle(Request $request): \Closure
     {
          $route = $this->router->match($request->getMethod(), $request->getRequestUri());

          if (! $route) {
              dd('Route not found');
          }

         $this->instance(Request::class, $request);

         // run middlewares

         return $route->getCallback();
     }



    /**
     * @throws \ReflectionException
     */
     public function run()
     {
          $request  = Request::createFromGlobals();
          $callback = $this->handle($request);

          if($output = $this->call($callback, [$request, new Response()])) {
              echo $output;
          }
     }




     /**
      * @param array $definitions
      * @return array
     */
     public function bindDefinitions(array $definitions): array
     {
          return $definitions;
     }
}