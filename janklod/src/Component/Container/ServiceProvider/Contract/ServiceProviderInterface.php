<?php
namespace Jan\Component\Container\ServiceProvider\Contract;

/**
 * interface ServiceProviderInterface
 *
 * @package Jan\Component\Container\ServiceProvider\Contract
*/
interface ServiceProviderInterface
{
     /**
      * @return mixed
     */
     public function register();
}