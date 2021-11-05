<?php
namespace Jan\Component\FileSystem\Contract;


/**
 * Interface FileLoaderInterface
 * @package Jan\Component\FileSystem\Contract
*/
interface FileLoaderInterface
{
    /**
     * Load file
     *
     * @param string $path
     * @return mixed
    */
    public function load(string $path);
}