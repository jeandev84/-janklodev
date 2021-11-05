<?php
namespace Jan\Component\FileSystem;


use Jan\Component\FileSystem\Contract\FileLocatorInterface;


/**
 * class FileLocator
 *
 * @package Jan\Component\FileSystem
*/
class FileLocator implements FileLocatorInterface
{

    /**
     *
     * @var string
    */
    protected $resource;



    /**
     * FileLocator constructor.
     *
     * @param string|null $resource
    */
    public function __construct(string $resource = null)
    {
         if ($resource) {
             $this->resource($resource);
         }
    }




    /**
     * Load base path
     *
     * Example: resource('/path/to.txt')
     *
     * @param string $path
    */
    public function resource(string $path)
    {
        $this->resource = rtrim(realpath($path), '\\/');
    }





    /**
     * searches for all the path names matching pattern
     *
     * Example : resources('/config/*.php')
     *
     * @param string $pattern
     * @param int $flags
     * @return array|false
    */
    public function resources(string $pattern, int $flags = 0)
    {
          return glob($this->locate($pattern), $flags);
    }



    /**
     * @param string $pattern
     * @return array|false
    */
    public function scan(string $pattern)
    {
        return scandir($this->locate($pattern));
    }



    /**
     * Generate full path of given file.
     *
     * Example: locate('/path/to.ext')
     *
     * @param string $path
     * @return string
    */
    public function locate(string $path): string
    {
        return implode(DIRECTORY_SEPARATOR, [$this->resource, $this->resolvePath($path)]);
    }



    /**
     * @param string $path
     * @return bool
    */
    public function exists(string $path): bool
    {
         return file_exists($this->locate($path));
    }


    /**
     * @param string $path
     * @return bool
    */
    public function has(string $path): bool
    {
         return \is_file($this->locate($path));
    }




    /**
     * @param string $path
     * @return false|string
    */
    public function realpath(string $path)
    {
        return realpath($this->locate($path));
    }




    /**
     * @param string $path
     * @return string
    */
    public function resolvePath(string $path): string
    {
        return str_replace(['\\', '/'], DIRECTORY_SEPARATOR, trim($path, '\\/'));
    }



    /**
     * @return string
    */
    public function getResourcePath(): string
    {
        return $this->resource;
    }
}