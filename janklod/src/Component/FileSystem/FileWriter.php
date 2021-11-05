<?php
namespace Jan\Component\FileSystem;


/**
 * Class FileWriter
 *
 * @package Jan\Component\FileSystem
*/
class FileWriter
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
    public function write(string $content)
    {
        return file_put_contents($this->path, $content);
    }
}