<?php
namespace Jan\Foundation\Middleware;

use Jan\Component\Http\Middleware\Contract\MiddlewareInterface;
use Jan\Component\Http\Request\Request;

class SessionStartMiddleware implements MiddlewareInterface
{

    public function __invoke(Request $request, callable $next)
    {
         // session_start();

         // echo "SESSION STARTED<br>";
         return $next($request);
    }
}