<?php
namespace Jan\Component\Http\Response;


/**
 * class RedirectResponse
 *
 *@package Jan\Component\Http\Response
*/
class RedirectResponse extends Response
{


     /**
      * @var string
     */
     protected $path;



     /**
      * @param string $path
      * @param int $status
      * @param array $headers
     */
     public function __construct(string $path, int $status = 301, array $headers = [])
     {
          parent::__construct(null, $status, $headers);
     }




     /**
      * @param string $path
      * @return $this
     */
     public function path(string $path): RedirectResponse
     {
         $this->path = $path;

         return $this;
     }



     /**
      * Send headers redirect
      * @return bool
     */
     public function send()
     {
         // TODO realise method send for redirect
         header('Location : '. $this->path);
         // return true; show content here.
     }
}