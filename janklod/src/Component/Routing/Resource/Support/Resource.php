<?php
namespace Jan\Component\Routing\Resource\Support;



/**
 * Class Resource
 * @package Jan\Component\Routing\Resource\Support
*/
abstract class Resource
{

     /**
      * @var string
     */
     protected $path;



     /**
      * @var string
     */
     protected $controller;




     /**
      * @var string
     */
     protected $name;




     /**
      * @var array
     */
     protected $data = [];




     /**
      * @param string $path
      * @param string $controller
     */
     public function __construct(string $path, string $controller)
     {
          $this->initialize($path, $controller);
     }


    /**
     * configure resource
     * @param string $methods
     * @param string $path
     * @param string $action
     * @param array $patterns
     * @return Resource
     */
     public function add(string $methods, string $path, string $action, array $patterns = []): Resource
     {
          $this->data[$action] = [
              'methods'     => $methods,
              'path'        => sprintf('/%s', $path),
              'callback'    => sprintf('%s@%s', $this->controller, $action),
              'name'        => sprintf('%s.%s', $this->name, $action),
              'patterns'    => $patterns
          ];

          return $this;
     }



     /**
      * @return array
     */
     public function getData(): array
     {
        return $this->data;
     }


     /**
      * Configure resource items
     */
     abstract protected function configureItems(): void;



     /**
      * @param $path
      * @param $controller
      * @return void
     */
     protected function initialize($path, $controller)
     {
        $this->path = trim($path, '/');
        $this->name = str_replace('/', '.', $this->path);
        $this->controller = $controller;

        $this->configureItems();
     }



     /**
      * @return string
     */
     public function getController(): string
     {
         return $this->controller;
     }
}