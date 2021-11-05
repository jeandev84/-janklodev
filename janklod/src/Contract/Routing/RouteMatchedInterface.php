<?php
namespace Jan\Contract\Routing;


use Jan\Component\Http\Request\Request;
use Jan\Component\Routing\Route;



/**
 * Class RouteMatchedInterface
 *
 * @package Jan\Contract\Routing
*/
interface RouteMatchedInterface
{
    public function match(Request $request): Route;
}