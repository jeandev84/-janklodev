<?php
namespace Jan\Contract\Http;

use Jan\Component\Http\Request\Request;
use Jan\Component\Http\Response\Response;


/**
 * Interface Kernel
 *
 * @package Jan\Contract\Http
*/
interface Kernel
{

    /**
     * @param Request $request
     * @return Response
     */
    public function handle(Request $request): Response;


    /**
     * @param Request $request
     * @param Response $response
     * @return mixed
     */
    public function terminate(Request $request, Response $response);
}