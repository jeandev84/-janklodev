<?php
namespace Jan\Component\Http\Bag;


use Jan\Component\Http\Request\Body;

/**
 * Class ParameterBag
 * @package Jan\Component\Http\Bag
*/
class ParameterBag
{

     /**
      *
      * @var array
     */
     protected $params = [];


     /**
      * ParameterBag Constructor
      *
      * @param array $params
     */
     public function __construct(array $params = [])
     {
         $this->params = $params;
     }


    /**
     * Set parameter in the bag
     *
     * @param string $key
     * @param $value
     * @return ParameterBag
     */
    public function set(string $key, $value): ParameterBag
    {
        $this->params[$key] = $value;

        return $this;
    }



    /**
     * Determine if given key param exist in bag
     *
     * @param $key
     * @return bool
    */
    public function has($key): bool
    {
        return \array_key_exists($key, $this->params);
    }



    /**
     * Get value parameter from bag
     *
     * @param $key
     * @param null $default
     * @return mixed|null
    */
    public function get($key, $default = null)
    {
        return $this->params[$key] ?? $default;
    }




    /**
     * @return array
    */
    public function all(): array
    {
        return $this->params;
    }



    /**
     * @param array $params
    */
    public function merge(array $params)
    {
        $this->params = array_merge($this->params, $params);
    }



    /*
    public function reset(array $params)
    {
        foreach ($params as $key) {
            if (\array_key_exists($key, $this->params)) {
                $this->remove($key);
            }
        }
    }
    */


    /**
     * @param $key
     * @param null $value
     * @return void
    */
    public function parse($key, $value = null)
    {
        if(\is_string($key) && ! $value) {
            $key = (array) $key;
        }

        $data = \is_array($key) ? $key : [$key => $value];

        $this->merge($data);
    }



    /**
     * @param $key
     * @throws  \InvalidArgumentException
     */
    public function remove($key)
    {
        unset($this->params[$key]);
    }


    /**
     * @return void
     */
    public function clear()
    {
        $this->params = [];
    }



    /**
     * @param $key
     * @param int $default
     * @return int
     */
    public function getInt($key, int $default = 0): int
    {
        return (int) $this->get($key, $default);
    }


    /**
     * @return false|string
    */
    public function toStringify()
    {
        return ''; // \json_encode($this->params);
    }



    /**
     * @param int $type
     * @return array
    */
    public function filterParams(int $type): array
    {
        $body = [];
        foreach (array_keys($this->all()) as $key) {
            $body[$key] = filter_input($type, $key, FILTER_SANITIZE_SPECIAL_CHARS);
        }

        return $body;
    }
}