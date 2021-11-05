<?php
namespace Jan\Component\Container\Contract;

use Jan\Component\Container\Container;

/**
 * Interface ContainerBagInterface
 *
 * @package Jan\Component\Container\Contract
*/
interface ContainerBagInterface
{

    /**
     * @param Container $container
    */
    public function setContainer(Container $container);


    /**
     * @return Container
    */
    public function getContainer(): Container;
}