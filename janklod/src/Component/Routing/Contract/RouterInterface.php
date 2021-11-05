<?php
namespace Jan\Component\Routing\Contract;


/**
 * interface RouterInterface
 * @package Jan\Component\Routing\Contract
*/
interface RouterInterface extends RouteMatchedInterface
{
     /**
      * Generate route URL
      *
      * @param string $name
      * @param array $parameters
      * @return mixed
     */
     public function generate(string $name, array $parameters = []);
}