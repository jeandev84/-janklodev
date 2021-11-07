<?php
namespace Jan\Component\Database\Connection;


/**
 * Class Configuration
 *
 * @package Jan\Component\Database
 */
abstract class Configuration implements \ArrayAccess
{


    /**
     * @var array
    */
    protected $params = [];


    /**
     * Configuration constructor
     *
     * @param array $params
     * @throws \Exception
     */
    public function __construct(array $params = [])
    {
        if ($params) {
            $this->parse($params);
        }
    }


    /**
     * @return mixed|null
     */
    abstract public function getTypeConnection();




    /**
     * @return mixed|null
    */
    abstract public function getHost();



    /**
     * @return mixed|null
    */
    abstract public function getDatabase();



    /**
     * @return mixed|null
    */
    abstract public function getPort();




    /**
     * @return mixed|null
    */
    abstract public function getCharset();



    /**
     * @return mixed|null
    */
    abstract public function getUsername();




    /**
     * @return mixed|null
    */
    abstract public function getPassword();



    /**
     * @return mixed|null
    */
    abstract public function getCollation();



    /**
     * @return mixed|null
    */
    abstract public function getTablePrefix();




    /**
     * @return mixed|null
    */
    abstract public function getEngine();





    /**
     * @param array $params
     * @return Configuration
     * @throws \Exception
     */
    public function parse(array $params): Configuration
    {
        foreach ($params as $key => $value) {
            if ($this->has($key)) {
                $this->params[$key] = $value;
            }
        }

        return $this;
    }



    /**
     * @param $key
     * @param $value
     */
    public function set($key, $value)
    {
        $this->params[$key] = $value;
    }




    /**
     * @param $key
     * @return bool
     */
    public function has($key): bool
    {
        return \array_key_exists($key, $this->params);
    }




    /**
     * @param $name
     * @param null $default
     * @return mixed|null
     */
    public function get($name, $default = null)
    {
        return $this->params[$name] ?? $default;
    }




    /**
     * Get all config params
     *
     * @return array
    */
    public function getParams(): array
    {
        return $this->params;
    }




    /**
     * @param string $name
     * @return string
    */
    public function getTableRealName(string $name): string
    {
        return $this->getTablePrefix(). $name;
    }



    /**
     * Remove config param
     *
     * @param string $name
     */
    public function remove(string $name)
    {
        unset($this->params[$name]);
    }





    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset): bool
    {
        return $this->has($offset);
    }


    /**
     * @param mixed $offset
     * @return mixed|null
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }


    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $this->set($offset, $value);
    }


    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        $this->remove($offset);
    }
}