<?php
namespace Jan\Component\Http\File;




/**
 * Class UploadedFile
 *
 * @package Jan\Component\Http\File
 */
class UploadedFile extends File
{

    /**
      * @param string $originalName
      * @param string $mimeType
      * @param string $tempFile
      * @param string $error
      * @param int $size
   */
    public function __construct(
        string $originalName,
        string $mimeType,
        string $tempFile,
        string $error,
        int $size
    )
    {
         parent::__construct($originalName, $mimeType, $tempFile, $error, $size);
    }



    /**
     * @param string $target
     * @param string|null $newFilename
    */
    public function move(string $target, string $newFilename = null)
    {
        dd('MOVED');
    }
}