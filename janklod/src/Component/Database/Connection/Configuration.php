<?php
namespace Jan\Component\Database\Connection;


/**
 * Class Configuration
 *
 * @package Jan\Component\Database
 */
class Configuration implements \ArrayAccess
{

    const DRIVER    = 'driver';
    const HOST      = 'host';
    const DATABASE  = 'database';
    const PORT      = 'port';
    const CHARSET   = 'charset';
    const USERNAME  = 'username';
    const PASSWORD  = 'password';
    const COLLATION = 'collation';
    const OPTIONS   = 'options';
    const PREFIX    = 'prefix';
    const ENGINE    = 'engine';


    /**
     * @var array
    */
    protected $params = [
        self::DRIVER     => 'mysql',
        self::DATABASE   => 'default',
        self::HOST       => '127.0.0.1',
        self::PORT       => '3306',
        self::CHARSET    => 'utf8',
        self::USERNAME   => 'root',
        self::PASSWORD   => '',
        self::COLLATION  => 'utf8_unicode_ci',
        self::OPTIONS    => [],
        self::PREFIX     => '',
        self::ENGINE     => 'InnoDB', // InnoDB or MyISAM
    ];


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
     * @return mixed|null
    */
    public function getTypeConnection()
    {
        return $this->get(self::DRIVER);
    }



    /**
     * @return mixed|null
     */
    public function getHost()
    {
        return $this->get(self::HOST);
    }



    /**
     * @return mixed|null
    */
    public function getDatabase()
    {
        return $this->get(self::DATABASE);
    }


    /**
     * @return mixed|null
    */
    public function getPort()
    {
        return $this->get(self::PORT);
    }


    /**
     * @return mixed|null
    */
    public function getCharset()
    {
        return $this->get(self::CHARSET);
    }


    /**
     * @return mixed|null
    */
    public function getUsername()
    {
        return $this->get(self::USERNAME);
    }


    /**
     * @return mixed|null
     */
    public function getPassword()
    {
        return $this->get(self::PASSWORD);
    }


    /**
     * @return mixed|null
     */
    public function getOptions()
    {
        return $this->get(self::OPTIONS);
    }


    /**
     * @return mixed|null
     */
    public function getCollation()
    {
        return $this->get(self::COLLATION);
    }


    /**
     * @return mixed|null
    */
    public function getPrefix()
    {
        return $this->get(self::PREFIX);
    }




    /**
     * @return mixed|null
    */
    public function getEngine()
    {
        return $this->get(self::ENGINE);
    }

    /**
     * @param string $name
     * @return string
    */
    public function prefixTable(string $name): string
    {
        return $this->get(self::PREFIX) . $name;
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