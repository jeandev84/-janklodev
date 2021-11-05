<?php
namespace Jan\Component\Http\Request;


use Jan\Component\Http\Bag\CookieBag;
use Jan\Component\Http\Bag\FileBag;
use Jan\Component\Http\Bag\HeaderBag;
use Jan\Component\Http\Bag\InputBag;
use Jan\Component\Http\Bag\ParameterBag;
use Jan\Component\Http\Bag\ServerBag;
use Jan\Component\Http\Session\Session;


/**
 * class Request
 * @package Jan\Component\Http\Request
*/
class Request
{

    /**
     * get query params from $_GET
     *
     * @var ParameterBag
    */
    public $queries;




    /**
     * get params from request $_POST
     *
     * @var array
    */
    public $request;




    /**
     * get request attributes
     *
     * @var array
    */
    public $attributes;



    /**
     * get data from $_COOKIE
     *
     * @var CookieBag
    */
    public $cookies;




    /**
     * @var Session
    */
    public $session;




    /**
     * get data from $_FILES
     *
     * @var FileBag
    */
    public $files;




    /**
     * get data from $_SERVER
     *
     * @var ServerBag
    */
    public $server;



    /**
     * get headers
     *
     * @var HeaderBag
    */
    public $headers;




    /**
     * request content
     *
     * @var string|null
    */
    public $content;



    /**
     * @var string
    */
    public $method;




    /**
     * @var string
    */
    public $baseUrl;




    /**
     * @var Uri
    */
    public $uri;




    /**
     * @var string
    */
    public $url;



    /**
     * Request Constructor.
     *
     * @param array $queries
     * @param array $request
     * @param array $attributes
     * @param array $cookies
     * @param array $files
     * @param array $server
     * @param string|null $content
    */
    public function __construct(
        array $queries = [],
        array $request = [],
        array $attributes = [],
        array $cookies = [],
        array $files = [],
        array $server = [],
        string $content = null
    )
    {
        $this->queries    =  new ParameterBag($queries);
        $this->request    =  new ParameterBag($request);
        $this->attributes =  new ParameterBag($attributes);
        $this->cookies    =  new CookieBag($cookies);
        $this->session    =  new Session();
        $this->files      =  new FileBag($files);
        $this->server     =  new ServerBag($server);
        $this->headers    =  new HeaderBag($this->server->getHeaders());
        $this->uri        =  new Uri($this->server->get('REQUEST_URI'));
        $this->baseUrl    =  null;
        $this->method     =  null;
        $this->url        =  null;
        $this->content    =  $content;
    }



    /**
     * Create request from factory
     *
     * @param array $queries
     * @param array $request
     * @param array $attributes
     * @param array $cookies
     * @param array $files
     * @param array $server
     * @param string|null $content
     * @return Request
    */
    public static function createFromFactory(
        array $queries = [],
        array $request = [],
        array $attributes = [],
        array $cookies = [],
        array $files = [],
        array $server = [],
        string $content = null
    ): Request
    {
        $request = new static($queries, $request, $attributes, $cookies, $files, $server, $content);

        $request->setMethod($request->server->getMethod());

        if ($request->request->has('_method')) {
            $method = $request->request->get('_method');
            if (\in_array($method, ['PUT', 'DELETE', 'PATCH'])) {
                $request->setMethod($method);
            }
        }

        $url = Url::create($request->getScheme(), $request->server->getHost(), $request->getRequestUri());
        $request->setBaseUrl($url->baseLink());
        $request->setUrl($url->link());

        return $request;
    }





    /**
     * @param $scheme
     * @param $hostName
     * @param $requestUri
     * @return Url
    */
    public static function createUrl($scheme, $hostName, $requestUri): Url
    {
        return Url::create($scheme, $hostName, $requestUri);
    }



    /**
     * @return Request
    */
    public static function createFromGlobals(): Request
    {
         $request = static::createFromFactory($_GET, $_POST, [], $_COOKIE, $_FILES, $_SERVER, 'php://input');

         if($request->hasContentTypeFormUrlEncoded() && $request->methodIn(['PUT', 'DELETE', 'PATCH'])) {
              parse_str($request->getContent(), $data);
              $request->request = new InputBag($data);
         }

         return $request;
    }



    /**
     * @param array $attributes
     * @return Request
     */
    public function setAttributes(array $attributes = []): Request
    {
        $this->attributes = $attributes;

        return $this;
    }




    /**
     * @param string $key
     * @param $value
    */
    public function setAttribute(string $key, $value)
    {
        $this->attributes[$key] = $value;
    }



    /**
     * @return array
    */
    public function getAttributes(): array
    {
        return $this->attributes;
    }



    /**
     * get request method
     *
     * @return string
    */
    public function getMethod(): string
    {
        if (! \is_null($this->method)) {
            return $this->method;
        }

        return $this->method = $this->server->get('REQUEST_METHOD', 'GET');
    }




    /**
     * Set request method
     *
     * @param string $method
     * @return $this
    */
    public function setMethod(string $method): Request
    {
        $this->method = $method;

        $this->server->set('REQUEST_METHOD', $method);

        return $this;
    }




    /**
     * @return Uri
    */
    public function getUri(): Uri
    {
        return $this->uri;
    }



    /**
     * @return string
    */
    public function getRequestUri(): string
    {
        return $this->uri->link();
    }



    /**
     * @return mixed|null
    */
    public function getHttpProtocol()
    {
       return $this->server->getProtocol();
    }


    /**
     * @return string
    */
    public function getPath(): string
    {
        return $this->uri->getPath();
    }



    /**
     * @return array|false|string|string[]
    */
    public function resolvedPath(string $path = null)
    {
        if (! $path) {
            $path = $this->getRequestUri();
        }

        if ($this->server->has('SCRIPT_NAME')) {
            $path = str_replace($this->server->get('SCRIPT_NAME'), '', $path);
        }

        $position = strpos($path, '?');

        if ($position !== false) {
            $path = substr($path, 0, $position);
        }


        $scheme     = $this->getScheme();
        $host       = $this->server->getHost();
        $requestUri = $this->getRequestUri();

        $url = Url::create($scheme, $host, $requestUri);
        $this->setBaseUrl($url->baseLink());
        $this->setUrl($url->link());

        return $path;
    }




    /**
     * @param string $baseUrl
    */
    public function setBaseUrl(string $baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }



    /**
     * @return string|null
     */
    public function getBaseUrl(): ?string
    {
        return $this->baseUrl;
    }




    /**
     * @param string $url
    */
    public function setUrl(string $url)
    {
        $this->url = $url;
    }




    /**
     * @return string|null
     */
    public function url(): ?string
    {
        return $this->url;
    }




    /**
     * get request path
     *
     * @return Body
    */
    public function getBody(): Body
    {
        $method = $this->getMethod();

        $params = [];

        switch ($method) {
            case 'GET':
                $params = $this->queries->filterParams(INPUT_GET);
                break;
            case 'POST':
                $params = $this->request->filterParams(INPUT_POST);
            break;
        }

        return new Body($params);
    }



    public function getBodyContent()
    {
        /*
                $content = file_get_contents('php://input');
                parse_str(urldecode($content), $data);
                $p = new ParameterBag($data);
                $p->remove('_method');
                $params = $p->all();
        */

        /*
        $content = file_get_contents('php://input');
        parse_str(urldecode($content), $output);

        return $output;
        */
    }



    /**
     * get request headers
     *
     * @return array
    */
    public function getHeaders(): array
    {
        return $this->headers->all();
    }



    /**
     * @return string
    */
    public function getContent(): string
    {
         return file_get_contents($this->content);
    }



    /**
     * Determine if the protocol is secure
     *
     * @return bool
    */
    public function isSecure(): bool
    {
        $https = $this->server->get('HTTPS');
        $port  = $this->server->get('SERVER_PORT');


        return $https == 'on' && $port == 443;
    }




    /**
     * @return string
    */
    public function getScheme(): string
    {
        return $this->isSecure() ? 'https' : 'http';
    }



    /**
     * @return bool
    */
    public function isXhr(): bool
    {
        return $this->server->get('HTTP_X_REQUESTED_WITH') === 'XMLHttpRequest';
    }



    /**
     * @param string $host
     * @return bool
    */
    public function isValidHost(string $host): bool
    {
        return $this->server->getHost() === $host;
    }


    /**
     * @return bool
     */
    protected function hasContentTypeFormUrlEncoded(): bool
    {
        return stripos($this->getContentType(), 'application/x-www-form-urlencoded') === 0;
    }




    /**
     * @return mixed|null
     */
    protected function getContentType()
    {
        return $this->headers->get('CONTENT_TYPE', '');
    }




    /**
     * @param array $methods
     * @return bool
    */
    protected function methodIn(array $methods): bool
    {
        return \in_array($this->toUpperMethod(), $methods);
    }




    /**
     * @return string
    */
    protected function toUpperMethod(): string
    {
        return strtoupper($this->getMethod());
    }
}