<?php
namespace Jan\Component\Console\Input\Support;


/**
 * Class InputOption
 *
 * @package Jan\Component\Console\Input\Support
*/
class InputOption
{

    const REQUIRED = 'required';


    /**
     * @var string
     */
    private $name;


    /**
     * @var null
     */
    private $shortcut;


    /**
     * @var string
     */
    private $description;


    /**
     * @var null
     */
    private $default;


    /**
     * InputOption constructor.
     * @param string $name
     * @param string|null $shortcut
     * @param string|null $description
     * @param string|null $default
     */
    public function __construct(string $name, string $shortcut = null, string $description = null, string $default = null)
    {
        $this->name = $name;
        $this->shortcut = $shortcut;
        $this->description = $description;
        $this->default = $default;
    }


    /**
     * @return string
    */
    public function getName(): string
    {
        return $this->name;
    }


    /**
     * @return null
    */
    public function getShortcut()
    {
        return $this->shortcut;
    }



    /**
     * @return string
    */
    public function getDescription(): string
    {
        return $this->description;
    }


    /**
     * @return null
    */
    public function getDefault()
    {
        return $this->default;
    }
}