<?php
namespace Jan\Foundation\Routing;


use Jan\Component\Http\Response\Response;
use Jan\Component\Templating\Exception\ViewException;
use Jan\Component\Templating\Renderer;

/**
 * Class DefaultController
 *
 * @package Jan\Foundation\Routing
*/
class DefaultController
{



    /**
     * DefaultController constructor
    */
    public function __construct()
    {
        $view = new Renderer(__DIR__.'/Resources/views');
        $view->setLayout(false);
        $this->view = $view;
    }




    /**
     * @return Response
     * @throws ViewException
    */
    public function index(): Response
    {
        $response = new Response();
        $output = $this->view->render('welcome.php');
        $response->setContent($output);
        return $response;
    }
}