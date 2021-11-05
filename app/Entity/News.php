<?php
namespace App\Entity;

/**
 * Class News
*/
class News
{

     /**
      * @var int
     */
     protected $id;


     /**
      * @var string
     */
     protected $title;


     /**
      * @var string
     */
     protected $content;


     /**
      * @var File
     */
     // protected $brochure = null;



     /**
      * @var \DateTime
     */
     protected $published_at;


    /**
     * @return int
    */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return News
     */
    public function setTitle(string $title): News
    {
        $this->title = $title;


        return $this;
    }



    /**
     * @return string
    */
    public function getContent(): string
    {
        return $this->content;
    }




    /**
     * @param string $content
     * @return News
    */
    public function setContent(string $content): News
    {
        $this->content = $content;

        return $this;
    }



    /**
     * @return File
    */
    public function getBrochure(): File
    {
        // return $this->brochure;
    }



    /**
     * @param File $brochure
     * @return News
    */
    public function setBrochure(File $brochure): News
    {
        // $this->brochure = $brochure;

        return $this;
    }


    /**
     * @return \DateTime
     * @throws \Exception
     */
    public function getPublishedAt(): \DateTime
    {
        return new \DateTime($this->published_at);
    }


    /**
     * @param \DateTime $publishedAt
     * @return News
    */
    public function setPublishedAt(\DateTime $publishedAt): News
    {
        $this->published_at = $publishedAt->format('Y-m-d');

        return $this;
    }

}