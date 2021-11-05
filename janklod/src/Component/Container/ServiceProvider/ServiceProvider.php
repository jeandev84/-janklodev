<?php
namespace Jan\Component\Container\ServiceProvider;



use Jan\Component\Container\ServiceProvider\Contract\ServiceProviderInterface;


/**
 * Class ServiceProvider
 * @package Jan\Component\Container\ServiceProvider
 */
abstract class ServiceProvider implements ServiceProviderInterface
{

    use ServiceProviderTrait;


    /**
     * register provider
     *
     * @return mixed
    */
    abstract public function register();
}