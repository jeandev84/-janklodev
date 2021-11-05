<?php
namespace Jan\Contract\Routing;


use Jan\Component\Http\Request\Request;
use Jan\Component\Http\Response\Response;



/**
 * interface RouteDispatcherInterface
 * @package Jan\Contract\Routing
*/
interface RouteDispatcherInterface
{
     /**
      * dispatch route
      * @param Request $request
      * @return mixed
     */
     public function dispatch(Request $request);
}