<?php
namespace Jan\Foundation\Generator;


use Jan\Component\Http\Request\Request;
use Jan\Component\Routing\Router;

/**
 * class UrlGenerator
 *
 * @package Jan\Foundation\Generator
*/
class UrlGenerator
{

    /**
     * @var Request
    */
    protected $request;



    /**
     * @var Router
    */
    protected $router;




    /**
     * @var string
    */
    protected $baseURL;




    /**
     * @param Request $request
     * @param Router $router
    */
    public function __construct(Request $request, Router $router)
    {
        $this->request = $request;
        $this->router  = $router;
    }


    /**
     * @param $name
     * @param array $parameters
     * @param int $depth
     * @return string
     * @throws \Exception
    */
    public function generate($name, array $parameters = [], int $depth = 1): string
    {
         return $this->baseURL . '/'. $this->router->generate($name, $parameters);
    }
}