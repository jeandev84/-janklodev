<?php
namespace App\Http\Controller\Admin;


use Jan\Component\Http\Request\Request;
use Jan\Component\Http\Response\Response;
use Jan\Foundation\Routing\Controller;


/**
 * Class DocumentController
 * @package App\Http\Controller\Admin
 *
 * <Generated By JanFramework>
*/
class DocumentController extends Controller
{

     /**
      * @param Request $request
      * @return Response
     */
     public function index(Request $request): Response
     {
           return new Response('Welcome to DocumentController');
     }
}