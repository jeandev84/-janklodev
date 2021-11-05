<?php
namespace Jan\Foundation\Routing;

use Exception;
use Jan\Component\Database\Capsule;
use Jan\Component\Http\Response\JsonResponse;
use Jan\Component\Http\Response\Response;
use Jan\Component\Templating\Renderer;


/**
 * Trait ControllerTrait
 * @package Jan\Foundation\Routing
*/
trait ControllerTrait
{


    protected $layout = 'layouts/default';


    /**
     * @param string $template
     * @param array $data
     * @param Response|null $response
     * @return Response
     * @throws Exception
    */
    public function render(string $template, array $data = [], Response $response = null): Response
    {
        /** @var Renderer $renderer */
        $renderer =  $this->container->get('view');
        $renderer->setLayout(sprintf('%s.php', $this->layout));
        $output = $this->container->get('view')->render($template, $data);

        if (! $response) {
            $response = new Response();
        }

        $response->setContent($output);

        return $response;
    }


    /**
     * @param $template
     * @param array $data
     * @return mixed
     * @throws Exception
    */
    public function renderHtml($template, array $data = [])
    {
        return $this->container->get('view')->render($template, $data);
    }



    /**
     * @param array $data
     * @param int $code
     * @param array $headers
     * @return JsonResponse
     */
    public function json(array $data, int $code = 200, array $headers = []): JsonResponse
    {
        return new JsonResponse($data, $code, $headers);
    }


    /**
     * @throws Exception
    */
    public function getCapsule(): Capsule
    {
        return $this->get('capsule');
    }
}