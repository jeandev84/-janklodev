<?php
namespace Jan\Component\Console\Input\Support;


/**
 * Class InputBag
 *
 * @package Jan\Component\Console\Input\Support
*/
class InputBag
{

    /**
     * @var array
    */
    private $arguments = [];


    /**
     * @var array
    */
    private $options = [];




    /**
     * @param InputArgument $argument
     * @return $this
    */
    public function addArgument(InputArgument $argument): InputBag
    {
         $this->arguments[$argument->getName()] = $argument;

         return $this;
    }


    /**
     * @param string $name
     * @return mixed|null
     * @throws \Exception
    */
    public function getArgument(string $name)
    {
        if (! $this->hasArgument($name)) {
            throw new \Exception(sprintf('argument %s is not available.', $name));
        }

        return $this->arguments[$name];
    }


    /**
     * @param string $name
     * @return bool
    */
    public function hasArgument(string $name): bool
    {
        return \array_key_exists($name, $this->arguments);
    }



    /**
     * @param string $name
     * @return bool
    */
    public function isRequiredArgument(string $name): bool
    {
        if ($this->hasArgument($name)) {
            if ($this->arguments[$name]->getOption(InputArgument::REQUIRED)) {
                return true;
            }
        }

        return false;
    }



    /**
     * @param string $name
     * @return bool
    */
    public function isRequiredOption(string $name): bool
    {
        if ($this->hasOption($name)) {
            if ($this->options[$name]->getOption(InputOption::REQUIRED)) {
                return true;
            }
        }

        return false;
    }



    /**
     * @return array
    */
    public function getArguments(): array
    {
        return $this->arguments;
    }




    /**
     * @param InputOption $option
    */
    public function addOption(InputOption $option)
    {
        $this->options[$option->getName()] = $option;
    }



    /**
     * @return array
    */
    public function getOptions(): array
    {
        return $this->options;
    }


    /**
     * @param string $name
     * @return mixed|null
     * @throws \Exception
    */
    public function getOption(string $name)
    {
        if (! $this->hasOption($name)) {
            throw new \Exception(sprintf('option %s is not available.', $name));
        }

        return $this->options[$name];
    }



    /**
     * @param string|null $name
     * @return bool
    */
    public function hasOption(?string $name): bool
    {
        return \array_key_exists($name, $this->options);
    }

}