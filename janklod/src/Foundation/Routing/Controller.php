<?php
namespace Jan\Foundation\Routing;


use Exception;
use Jan\Component\Container\Container;
use Jan\Component\Container\Contract\ContainerBagInterface;


/**
 * Class Controller
 *
 * @package Jan\Foundation\Routing
*/
abstract class Controller implements ContainerBagInterface
{


    use ControllerTrait;


    /**
     * @var Container
    */
    protected $container;



    /**
     * @param Container $container
    */
    public function setContainer(Container $container)
    {
        $this->container = $container;
    }



    /**
     * @return Container
    */
    public function getContainer(): Container
    {
        return $this->container;
    }



    /**
     * @throws Exception
    */
    public function get($id)
    {
        return $this->container->get($id);
    }
}