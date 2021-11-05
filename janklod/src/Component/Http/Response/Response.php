<?php
namespace Jan\Component\Http\Response;


use Jan\Component\Http\Bag\HeaderBag;
use Jan\Component\Http\Response\Status\StatusCode;


/**
 * class Response
 * @package Jan\Component\Http\Response\Response
*/
class Response
{


   use StatusCode;



   const HTTP_OK = '200';
   const HTTP_BAD_REQUEST = '400';


   /**
    * @var string
    *
    * Example HTTP/1.0
   */
   protected $protocolVersion = 'HTTP/1.0';



   /**
    * response content
    *
    * @var string
   */
   protected $content;



   /**
    * response code status
    *
    * @var int
   */
   protected $statusCode;



   /**
    * response headers
    *
    * @var HeaderBag
   */
   public $headers;





   /**
    * Response Constructor.
    *
    * @param string|null $content
    * @param int $statusCode
    * @param array $headers
   */
   public function __construct(string $content = null, int $statusCode = 200, array $headers = [])
   {
       $this->content    = $content;
       $this->statusCode = $statusCode;
       $this->headers    = new HeaderBag($headers);

   }



    /**
     * @param array $headers
    */
    public function setHeaders(array $headers)
    {
         $this->headers = new HeaderBag($headers);
    }



    /**
     * @param $key
     * @param $value
    */
    public function setHeader($key, $value)
    {
        $this->headers->set($key, $value);
    }



    /**
     * Set protocol version
     *
     * @param string $protocolVersion
     * @return Response
    */
    public function setProtocol(string $protocolVersion): Response
    {
        $this->protocolVersion = $protocolVersion;

        return $this;
    }


    /**
     * Set content
     *
     * @param string|null $content
    */
    public function setContent(?string $content)
    {
        $this->content = $content;
    }



    /**
     * @return string
    */
    public function getContent(): string
    {
        return $this->content;
    }



    /**
     * Set status
     *
     * @param int $statusCode
    */
    public function setStatusCode(int $statusCode)
    {
        $this->statusCode = $statusCode;
    }



    /**
     * Set protocol version
     *
     * @param string $protocolVersion
     * @return $this
    */
    public function withProtocol(string $protocolVersion): Response
    {
        $this->setProtocol($protocolVersion);

        return $this;
    }


    /**
     * status code response
     *
     * @param int $statusCode
     * @return Response
    */
    public function withStatusCode(int $statusCode): Response
    {
        $this->setStatusCode($statusCode);

        return $this;
    }



    /**
     * get code status
     *
     * @return int
    */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }



    /**
     * response content
     *
     * @param $content
     * @return Response
    */
    public function withBody($content): Response
    {
        $this->setContent($content);

        return $this;
    }



    /**
     * get response body
     *
     * @return string
    */
    public function getBody(): string
    {
        return $this->content;
    }



    /**
     * response headers
     *
     * @param $headers
     * @return Response
    */
    public function withHeaders($headers): Response
    {
         $this->headers->merge($headers);

         return $this;
    }



    /**
     * @param $key
     * @param null $value
     * @return $this
    */
    public function withHeader($key, $value = null): Response
    {
        $this->headers->parse($key, $value);

        return $this;
    }



    /**
     * @return array
    */
    public function getHeaders(): array
    {
        return $this->headers->all();
    }



    /**
     * @param array $data
     * @return $this
    */
    public function toJson(array $data): Response
    {
        $this->setHeader('Content-Type', 'application/json');
        $this->setContent(\json_encode($data));

        return $this;
    }



    /**
     * send response.
     *
     * @return mixed
    */
    public function send()
    {
         if (\headers_sent()) {
             return $this;
         }

         if (\php_sapi_name() !== 'cli') {
             $this->sendStatusMessage();
             $this->sendHeaders();
         }
    }



    /**
     * send response headers
    */
    public function sendHeaders()
    {
        foreach ($this->getHeaders() as $key => $value) {
            header(\is_numeric($key) ? $value : $key .' : ' . $value);
        }
    }



    /**
     * send content to the navigator
    */
    public function sendBody()
    {
        echo $this->getBody();
    }


    /**
     * send status message of response
     *
     * @return mixed
    */
    public function sendStatusMessage()
    {
        if($message = $this->getMessage($this->statusCode)) {
            $header = sprintf('%s %s %s', $this->protocolVersion, $this->statusCode, $message);
            $this->withHeader($header);
        } else {
            $this->sendResponseCode();
        }
    }



    /**
     * @return $this
    */
    public function sendResponseCode(): Response
    {
        http_response_code($this->statusCode);
        return $this;
    }


    public function __toString()
    {
        return (string) $this->getContent();
    }
}