<?php
namespace Jan\Component\Config\Loaders;

use Jan\Component\Config\Contract\Loader;


/**
 * Class ArrayLoader
 *
 * @package Jan\Component\Config\Loaders
*/
class ArrayLoader implements Loader
{

    /**
     * @var array
    */
    protected $files;


    /**
     * ArrayLoader constructor.
     * @param array $files
     */
    public function __construct(array $files)
    {
        $this->files = $files;
    }


    /**
     * Parse method
     *
     * @return array
     * @throws Exception
    */
    public function parse(): array
    {
        $parsed = [];

        foreach ($this->files as $namespace => $path) {
            $parsed[$namespace] = @require $path;
        }

        return $parsed;
    }
}