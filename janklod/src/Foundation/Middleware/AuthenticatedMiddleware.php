<?php
namespace Jan\Foundation\Middleware;

use Jan\Component\Http\Middleware\Contract\MiddlewareInterface;
use Jan\Component\Http\Request\Request;

class AuthenticatedMiddleware implements MiddlewareInterface
{

    public function __invoke(Request $request, callable $next)
    {
        if (! isset($_SERVER['user'])) {
            header('Location: /');
            exit;
        }

        return $next($request);
    }
}