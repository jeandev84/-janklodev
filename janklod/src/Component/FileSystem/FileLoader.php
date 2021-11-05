<?php
namespace Jan\Component\FileSystem;


use Jan\Component\FileSystem\Contract\FileLoaderInterface;



/**
 * Interface FileLoader
 * @package Jan\Component\FileSystem
*/
class FileLoader extends FileLocator implements FileLoaderInterface
{


    /**
     * @param string $pattern
    */
    public function loadResources(string $pattern)
    {
        $files = $this->resources($pattern);

        foreach ($files as $file) {
            require_once $file;
        }
    }



    /**
     * @param string $path
     * @return false|mixed
    */
    public function load(string $path)
    {
         if (! $this->exists($path)) {
             return false;
         }

         return require_once $this->locate($path);
    }
}