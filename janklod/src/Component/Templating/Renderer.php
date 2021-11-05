<?php
namespace Jan\Component\Templating;


use Jan\Component\Templating\Contract\RendererInterface;
use Jan\Component\Templating\Exception\ViewException;


/**
 * Class Renderer
 * @package Jan\Component\Templating
 */
class Renderer implements RendererInterface
{

    /**
     * view directory
     *
     * @var string
     */
    protected $resource;



    /**
     * file template
     *
     * @var string
    */
    protected $template;


    /**
     * layout of view
     *
     * @var string
    */
    protected $layout;




    /**
     * view data
     *
     * @var array
    */
    protected $variables = [];


    /**
     * Renderer constructor.
     *
     * @param string|null $resource
    */
    public function __construct(string $resource = null)
    {
        if($resource) {
            $this->resource($resource);
        }
    }


    /**
     * @param string $resource
     * @return $this
    */
    public function resource(string $resource): Renderer
    {
        $this->resource = rtrim($resource, '\\/');

        return $this;
    }


    /**
     * @param string $layout
     * @return $this
    */
    public function setLayout(string $layout): Renderer
    {
        $this->layout = $layout;

        return $this;
    }



    /**
     * @param array $variables
     * @return $this
    */
    public function setVariables(array $variables): Renderer
    {
        $this->variables = array_merge($this->variables, $variables);

        return $this;
    }


    /**
     * @param string $template
     * @return $this
    */
    public function setTemplate(string $template): Renderer
    {
        $this->template = $template;

        return $this;
    }




    /**
     * Render view template and optional data
     *
     * @return false|string
     * @throws ViewException
    */
    public function renderTemplate(): string
    {
        extract($this->variables, EXTR_SKIP);

        ob_start();
        require_once($this->load($this->template));
        return ob_get_clean();
    }



    /**
     * @return false|string
     * @throws ViewException
    */
    public function renderLayout()
    {
         if (! $this->exists($this->layout)) {
             return false;
         }

         ob_start();
         require_once ($this->load($this->layout));
         return ob_get_clean();
    }



    /**
     * @throws ViewException
    */
    public function renderContent($content)
    {
        if ($layout = $this->renderLayout()) {
            return str_replace("{{ content }}", $content, $layout);
        }

        return $content;
    }




    /**
     * Render html template with availables variables
     *
     * @param string $template
     * @param array $variables
     * @return false|string
     * @throws ViewException
    */
    public function render(string $template, array $variables = []): string
    {
        $content = $this->setTemplate($template)
                        ->setVariables($variables)
                        ->renderTemplate();

        return $this->renderContent($content);
    }




    /**
     * @param string $template
     * @return string
     * @throws ViewException
    */
    public function load(string $template): string
    {
        $templatePath = $this->templatePath($template);

        if(! $this->exists($template)) {
            throw new ViewException(sprintf('view file %s does not exist!', $templatePath));
        }

        return realpath($templatePath);
    }



    /**
     * @param string|null $template
     * @return bool
    */
    protected function exists(string $template): bool
    {
        $path = $this->templatePath($template);

        return \is_file($path);
    }



    /**
     * @param string $template
     * @return string
    */
    protected function templatePath(string $template): string
    {
        return $this->resource . DIRECTORY_SEPARATOR . $this->resolvePath($template);
    }




    /**
     * @param $path
     * @return string|string[]
     */
    protected function resolvePath($path)
    {
        return str_replace(['\\', '/'], DIRECTORY_SEPARATOR, ltrim($path, '\\/'));
    }
}