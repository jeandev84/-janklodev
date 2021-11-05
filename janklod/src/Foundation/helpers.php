<?php
use Jan\Component\Config\Config;
use Jan\Component\Container\Container;
use Jan\Component\Container\Exception\BindingResolutionException;
use Jan\Component\Http\Response;
use Jan\Component\Routing\Router;
use Jan\Component\Templating\Asset;


# application
if(! function_exists('app'))
{

    /**
     * @param string|null $abstract
     * @param array $parameters
     * @return Container
     * @throws BindingResolutionException|Exception
    */
    function app(string $abstract = null, array $parameters = []): Container
    {
        $app = Container::getInstance();

        if(is_null($abstract)) {
            return $app;
        }

        return $app->make($abstract, $parameters);
    }
}


# get base path
if(! function_exists('base_path'))
{

    /**
     * Base Path
     * @param string $path
     * @return string
     * @throws BindingResolutionException
     * @throws Exception
    */
    function base_path(string $path = ''): string
    {
        return app()->get('path') . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}


# get config
if(! function_exists('config'))
{
    /**
     * Config
     * @param string $key
     * @return mixed
     * @throws BindingResolutionException
     * @throws Exception
    */
    function config(string $key = '')
    {
        return app()->get(Config::class)->get($key);
    }
}



# get environment variables
if(! function_exists('env'))
{
    /**
     * Get item from environment or default value
     *
     * @param $key
     * @param null $default
     * @return array|string|null
    */
    function env($key, $default = null)
    {
        $value = getenv($key);

        if(! $value)
        {
            return $default;
        }

        return $value;
    }
}



# get name of application
if(! function_exists('app_name'))
{
    /**
     * Application name
     * @return string
     * @throws BindingResolutionException
    */
    function app_name(): string
    {
        return \config('app.name');
    }
}


# generate route path
if(! function_exists('route'))
{

    /**
     * @param string $name
     * @param array $params
     * @return string
     * @throws BindingResolutionException
     * @throws Exception
    */
    function route(string $name, array $params = []): string
    {
        return \app()->get(Router::class)->generate($name, $params);
    }
}



# create a response
if(! function_exists('response'))
{

    /**
     * @param string $content
     * @param int $code
     * @param array $headers
     * @return Response
    */
    function response(string $content, int $code = 200, array $headers = []): Response
    {
        return new Response($content, $code, $headers);
    }
}



# redirect response
if(! function_exists('redirect'))
{

    /**
     * @param string $path
     * @return void
    */
    function redirect(string $path)
    {
        // exit;
    }
}



# render a view
if(! function_exists('view'))
{

    /**
     * @param string $name
     * @param array $data
     * @return Response
     * @throws BindingResolutionException
    */
    function view(string $name, array $data = []): Response
    {
        $template = app()->get('view')->render($name, $data);
        return new Response($template, 200);
    }
}



# generate assets
if(! function_exists('asset'))
{

    /**
     * @param string|null $path
     * @return string
     * @throws BindingResolutionException
     * @throws Exception
    */
    function asset(string $path = null): string
    {
        $asset = app()->get(Asset::class);

        // $parts = explode('.', $path);
        // $ext = end($parts);

        $ext = pathinfo($path, PATHINFO_EXTENSION);

        switch ($ext) {
            case 'css':
                return $asset->renderOnceCss($path);
                break;
            case 'js':
                return $asset->renderOnceJs($path);
                break;
            default:
                return $asset->generateLink($path);
                break;
        }
    }
}



# render stylesheets
if(! function_exists('renderCss'))
{
    /**
     * @throws Exception
     * @return string
     */
    function renderCss(): string
    {
        return \asset()->renderCss();
    }
}



# render scripts
if(! function_exists('renderJs'))
{
    /**
     * @throws Exception
     * @return string
    */
    function renderJs(): string
    {
        return \asset()->renderJs();
    }
}