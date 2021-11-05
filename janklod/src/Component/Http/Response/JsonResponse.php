<?php
namespace Jan\Component\Http\Response;


/**
 * class JsonResponse
 * @package Jan\Component\Http\Response
*/
class JsonResponse extends Response
{

     /**
      * @param array $data
      * @param int $statusCode
      * @param array $headers
     */
     public function __construct(array $data, int $statusCode = 200, array $headers = [])
     {
         $content = \json_encode($data);

         // get last error json_encode or decode.
         $headers = array_merge(['Content-Type' => 'application/json'], $headers);

         parent::__construct($content, $statusCode, $headers);
     }
}