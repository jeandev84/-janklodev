<?php
namespace Jan\Component\Http\Response\Contract;


/**
 * interface ResponseInterface
 * @package Jan\Component\Http\Response\Contract
*/
interface ResponseInterface
{

     /**
      * status code response
      *
      * @param $code
      * @return mixed
     */
     public function withStatus($code);


     /**
      * response content
      *
      * @param $content
      * @return mixed
     */
     public function withBody($content);



     /**
      * response headers
      *
      * @param $headers
      * @return mixed
     */
     public function withHeaders($headers);



     /**
      * send response.
      *
      * @return mixed
     */
     public function send();
}