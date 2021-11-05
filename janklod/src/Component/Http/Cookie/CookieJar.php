<?php
namespace Jan\Component\Http\Cookie;

/**
 *
*/
class CookieJar
{
    /**
     * cookie params
     *
     * @var array
     */
    protected $params;



    /**
     * @var string
     */
    protected $domain;



    /**
     * @var bool
     */
    protected $httpOnly = false;



    /**
     * @var bool
     */
    protected $secure = false;



    /**
     * @param array $params
     */
    public function __construct(array $params = [])
    {
        if (! $params) {
            $params = $_COOKIE;
        }

        $this->params = $params;
    }



    public function domain(string $domain)
    {
        $this->domain = $domain;
    }



    /**
     * @param string $name
     * @param $value
     * @param int $expires
     * @param string $path
     */
    public function set(string $name, $value, int $expires = 3600, string $path = '/')
    {
        new Cookie($name, $value, $expires, $path, $this->domain, $this->secure, $this->httpOnly);
    }



    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool
    {
        return isset($_COOKIE[$key]);
    }




    /**
     * @param string $key
     * @param null $default
     * @return mixed|null
     */
    public function get(string $key, $default = null)
    {
        return $_COOKIE[$key] ?? $default;
    }




    /**
     * @return array
    */
    public function all(): array
    {
        return $_COOKIE;
    }
}