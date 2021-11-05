<?php
namespace Jan\Component\Console\Input\Support;

/**
 * Class InputArgument
 *
 * @package Jan\Component\Console\Input\Support
*/
class InputArgument
{

    const REQUIRED = 'required';


    /**
     * @var string
    */
    private $name;


    /**
     * @var string
     */
    private $description;


    /**
     * @var string
    */
    private $default;




    /**
     * @var array
    */
    private $options;



    /**
     * InputArgument constructor.
     * @param string $name
     * @param string|null $description
     * @param string|null $default
     * @param array $options
    */
    public function __construct(string $name, string $description = null, string $default = null, array $options = [])
    {
        $this->name = $name;
        $this->description = $description;
        $this->default = $default;
        $this->options = $options;
    }


    /**
     * @param string $key
     * @return bool
     */
    public function getOption(string $key): bool
    {
         return isset($this->options[$key]);
    }


    /**
     * @return string
    */
    public function getName(): string
    {
        return $this->name;
    }


    /**
     * @return string
    */
    public function getDescription(): string
    {
        return $this->description;
    }


    /**
     * @return string|null
    */
    public function getDefault(): ?string
    {
        return $this->default;
    }


    /**
     * @param string|null $default
    */
    public function setDefault(?string $default = null)
    {
        $this->default = $default;
    }
}