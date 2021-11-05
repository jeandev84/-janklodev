<?php
namespace Jan\Component\Http\Middleware\Contract;


use Jan\Component\Http\Request\Request;


/**
 * Class MiddlewareInterface
 *
 * Middleware it's the simple logic between Request and Response >
 *
 * @package Jan\Component\Http\Middleware\Contract
*/
interface MiddlewareInterface
{
    
    /**
     * @param Request $request
     * @param callable $next
    */
    public function __invoke(Request $request, callable $next);
}