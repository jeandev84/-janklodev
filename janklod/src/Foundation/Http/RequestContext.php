<?php
namespace Jan\Foundation\Http;


use Jan\Component\Http\Request\Request;


/**
 * TODO move this logic to the middleware
*/
class RequestContext
{

     /**
      * @param Request $request
      * @return Request
     */
     public function resolve(Request $request): Request
     {
         return $request = $this->resolveMethod($request);
     }




     /**
      * @param Request $request
      * @return Request
     */
     public function resolveMethod(Request $request): Request
     {
         $request->setMethod($request->server->getMethod());

         if ($request->request->has('_method')) {
             $method = $request->request->get('_method');
             if (\in_array($method, ['PUT', 'DELETE', 'PATCH'])) {
                 $request->setMethod($method);
             }
         }

         return $request;
     }




     public function resolvePath(Request $request)
     {
          // TODO resolve path
     }
}