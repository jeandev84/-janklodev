<?php
namespace Jan\Component\FileSystem;

/**
 * class File
 *
 * @package Jan\Component\FileSystem
*/
class File
{

     /**
      * @var string
     */
     protected $path;



     /**
      * @var array
     */
     protected $data = [];



     /**
      * File constructor
      *
      * @param string $path
     */
     public function __construct(string $path)
     {
          $this->path  = $path;
     }



     /**
      * get file dirname
      *
      * @return string
     */
     public function getDirname(): string
     {
        return pathinfo($this->path, PATHINFO_DIRNAME);
     }




     /**
      * get base name
      *
      * @return string
     */
     public function getBasename(): string
     {
        return pathinfo($this->path, PATHINFO_BASENAME);
     }


     /**
      * get name of file
      *
      * @return string
     */
     public function getFilename(): string
     {
        return pathinfo($this->path, PATHINFO_FILENAME);
     }



     /**
      * get file extension
      *
      * @return string|null
     */
     public function getExtension(): ?string
     {
         return pathinfo($this->path, PATHINFO_EXTENSION);
     }



     /**
      * @return array
     */
     public function details(): array
     {
         return pathinfo($this->path);
     }



     /**
      * @return false|int
     */
     public function getSize()
     {
         return filesize($this->path);
     }





     /**
      * @return array|false
     */
     public function toArray()
     {
         return file($this->path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
     }



     /**
      * @return false|string
     */
     public function toJson()
     {
        return \json_encode($this->toArray());
     }



     /**
      * @return string
     */
     public function getPath(): string
     {
        return $this->path;
     }

}