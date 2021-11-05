<?php
namespace Jan\Component\Http\Request;


use Jan\Component\Http\Encoder\UrlEncoder;


/**
 * Class Uri
 * @package Jan\Component\Http
 */
class Uri
{


    /**
     * @var
    */
    protected $link;




    /**
     * Get path
     *
     * @var string
     */
    protected $path;



    /**
     * Query string
     *
     * @var string
     */
    protected $qs;




    /**
     * Get fragment
     *
     * @var string
    */
    protected $fragment;


    /**
     * Uri constructor ( /path?query=value#fragment )
     *
     * Docs: /admin/posts?page=1&published=true;
     *
     * @param string|null $target
    */
    public function __construct(string $target = null)
    {
        if ($target) {
            $this->setLink($target);
        }

        $this->initializeParams();
    }


    /**
     * @param string|null $link
    */
    public function setLink(?string $link)
    {
         $this->link  = urldecode($link);
    }



    /**
     * @return string|null
    */
    public function link(): ?string
    {
        return $this->link;
    }


    /**
     * @param string|null $path
     * @return Uri
     */
    public function setPath(?string $path): Uri
    {
        $this->path = $path;

        return $this;
    }



    /**
     * @return string|null
    */
    public function getPath(): ?string
    {
        return $this->path;
    }



    /**
     * @param string|null $qs
     * @return $this
    */
    public function setQueryString(?string $qs): Uri
    {
         $this->qs = $qs;

         return $this;
    }




    /**
     * @return string|null
    */
    public function getQueryString(): ?string
    {
        return $this->qs;
    }



    /**
     * @param string|null $fragment
     * @return $this
    */
    public function setFragment(?string $fragment): Uri
    {
        $this->fragment = $fragment;

        return $this;
    }



    /**
     * @return string|null
    */
    public function getFragment(): ?string
    {
        return $this->fragment;
    }



    /**
     * Get parsed param by given type
     *
     * @param int $type
     * @return array|false|int|string|null
    */
    public function parse(int $type)
    {
        return parse_url($this->link, $type);
    }



    /**
     * Get parses params
     *
     * @return array|null
    */
    public function getParses(): ?array
    {
        return $this->parse(-1);
    }


    /**
     * Initialise path params
    */
    protected function initializeParams()
    {
        $this->path     = $this->parse(PHP_URL_PATH);
        $this->qs       = $this->parse(PHP_URL_QUERY);
        $this->fragment = $this->parse(PHP_URL_FRAGMENT);
    }

}