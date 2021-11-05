<?php
namespace Jan\Component\FileSystem;


/**
 * Class FileReader
 *
 * @package Jan\Component\FileSystem
*/
class FileReader
{
    /**
     * @var string
     */
    protected $path;


    /**
     * @param string $path
    */
    public function __construct(string $path)
    {
         $this->path = $path;
    }


    /**
     * @param string $content
     * @return false|int
    */
    public function read(string $content)
    {
        return file_put_contents($this->path, $content);
    }
}