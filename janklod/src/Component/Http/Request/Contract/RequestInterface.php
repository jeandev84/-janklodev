<?php
namespace Jan\Component\Http\Request\Contract;


/**
 * Interface RequestInterface
 * @package Jan\Component\Http\Request\Contract
*/
interface RequestInterface
{
     /**
      * get request method
      *
      * @return string
     */
     public function getMethod(): string;



     /**
      * get request uri
      *
      * @return string
     */
     public function getUri(): string;




     /**
      * get request path
      *
      * @return array
     */
     public function getBody(): array;




     /**
      * get request headers
      *
      * @return array
     */
     public function getHeaders(): array;
}