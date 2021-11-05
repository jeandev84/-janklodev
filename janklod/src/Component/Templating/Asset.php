<?php
namespace Jan\Component\Templating;


use Jan\Component\Templating\Contract\AssetInterface;

/**
 * Class Asset ( Asset manager. )
 * @package Jan\Component\Templating
 */
class Asset implements AssetInterface
{

    const CSS_BLANK = '<link href="%s" rel="stylesheet">';
    const JS_BLANK  = '<script src="%s" type="application/javascript"></script>';


    /**
     * @var array
     */
    private $css = [];



    /**
     * @var array
     */
    private $js = [];



    /**
     * @var string
     */
    private $baseUrl;



    /**
     * Asset constructor.
     * @param string $baseUrl
     */
    public function __construct(string $baseUrl = '')
    {
        if($baseUrl) {
            $this->setBaseUrl($baseUrl);
        }
    }



    /**
     * @param $baseUrl
     */
    public function setBaseUrl($baseUrl)
    {
        $this->baseUrl = rtrim($baseUrl, '\\/');
    }


    /**
     * Add css link
     *
     * @param string $link
     */
    public function css(string $link)
    {
        $this->css[] = $link;
    }


    /**
     * @param array $styles
     */
    public function addStylesheets(array $styles)
    {
        $this->css = array_merge($this->css, $styles);
    }


    /**
     * @param array $scripts
     */
    public function addScripts(array $scripts)
    {
        $this->js = array_merge($this->js, $scripts);
    }


    /**
     * Get css data
     *
     * @return array
     */
    public function getStyleSheets(): array
    {
        return $this->css;
    }


    /**
     * Add js link
     *
     * @param string $js
     */
    public function js(string $js)
    {
        $this->js[] = $js;
    }


    /**
     * Get css data
     *
     * @return array
     */
    public function getScripts(): array
    {
        return $this->js;
    }


    /**
     * Render css format html
     *
     * @return string
     */
    public function renderCss(): string
    {
        return $this->buildHtml($this->css, self::CSS_BLANK);
    }


    /**
     * @param $link
     * @return string
     */
    public function renderOnceCss($link): string
    {
        return sprintf(self::CSS_BLANK."\n", $this->generateLink($link));
    }


    /**
     * @param $script
     * @return string
     */
    public function renderOnceJs($script): string
    {
        return sprintf(self::JS_BLANK."\n", $this->generateLink($script));
    }



    /**
     * Render js format html
     *
     * @return string
     */
    public function renderJs(): string
    {
        return $this->buildHtml($this->js, self::JS_BLANK);
    }


    /**
     * @param $filename
     * @return string
    */
    public function generateLink($filename): string
    {
        return $this->baseUrl . '/'. trim($filename, '\/');
    }




    /**
     * @return string
     */
    public function __toString(): string
    {
        return '';
    }



    /**
     * Print html format
     *
     * @param array $files
     * @param string $blank
     * @return string
    */
    protected function buildHtml(array $files, string $blank): string
    {
        $html = [];

        foreach ($files as $filename) {
            $html[] = sprintf($blank, $this->generateLink($filename));
        }

        return join("\n", $html);
    }
}