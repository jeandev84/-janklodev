<?php
namespace Jan\Component\Http\Request;



/**
 * Class Url
 * @package Jan\Component\Http
*/
class Url extends Uri
{


    /**
     * Get scheme
     *
     * @var string
    */
    protected $scheme;




    /**
     * Get username
     *
     * @var string
    */
    protected $username;




    /**
     * Get password
     *
     * @var string
    */
    protected $password;




    /**
     * Get host
     *
     * @var string
     */
    protected $host;




    /**
     * Get port
     *
     * @var string
    */
    protected $port;



    /**
     * Url constructor ( scheme://user:pass@host:port/path?query=value#fragment )
     *
     * Docs: http://postgres:123456@127.0.0.1:5402/database_name?charset=utf8#anchor;
     *
     * @param string $link
    */
     public function __construct(string $link)
     {
          parent::__construct($link);
     }


     /**
      * @param string $scheme
      * @param string $host
      * @param string $path
      * @return Url
     */
     public static function create(string $scheme, string $host, string $path): Url
     {
         $URL = new static($path);
         $URL->setScheme($scheme);
         $URL->setHost($host);

         return $URL;
     }




     /**
      * @param string $scheme
      * @return Url
     */
     public function setScheme(string $scheme): Url
     {
         $this->scheme = $scheme;

         return $this;
     }




    /**
     * @return string
    */
    public function getScheme(): string
    {
        return $this->scheme;
    }



    /**
     * @param string $username
     * @return Url
    */
    public function setUser(string $username): Url
    {
        $this->username = $username;

        return $this;
    }



    /**
     * @return string
    */
    public function getUser(): string
    {
        return $this->username;
    }






    /**
     * @param string $password
     * @return Url
    */
    public function setPassword(string $password): Url
    {
        $this->password = $password;

        return $this;
    }



    /**
     * @return string
    */
    public function getPassword(): string
    {
        return $this->password;
    }


    /**
     * @param string|null $host
     * @return Url
    */
    public function setHost(?string $host): Url
    {
         $this->host = $host;

         return $this;
     }




     /**
      * @return string
     */
     public function getHost(): string
     {
         return $this->host;
     }



     /**
      * @param string|null $port
      * @return Url
     */
     public function setPort(?string $port): Url
     {
         $this->port = $port;

         return $this;
     }



     /**
      * @return string|null
     */
     public function getPort(): ?string
     {
        return $this->port;
     }



     /**
      * Initialise path params
     */
     protected function initializeParams()
     {
        $this->scheme   = $this->parse(PHP_URL_SCHEME);
        $this->username = $this->parse(PHP_URL_USER);
        $this->password = $this->parse(PHP_URL_PASS);
        $this->host     = $this->parse(PHP_URL_HOST);
        $this->port     = $this->parse(PHP_URL_PORT);
        parent::initializeParams();
     }



     /**
      * @return string
     */
     public function baseLink(): string
     {
         return urldecode(sprintf('%s://%s', $this->getScheme(), $this->getHost()));
     }



     /**
      * @return string
     */
     public function link(): string
     {
         return urldecode(sprintf('%s%s', $this->baseLink(), $this->link));
     }
}