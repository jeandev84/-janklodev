<?php
namespace Jan\Component\Console\Input\Support;


use Jan\Component\Console\Command\Exception\CommandException;
use Jan\Component\Console\Input\Contract\InputInterface;
use Jan\Component\Console\Input\Exception\InvalidArgumentCommand;
use Jan\Component\Console\Input\Exception\InvalidOptionCommand;


/**
 * Class InputArgv
 *
 * @package Jan\Component\Console\Input\Support
*/
abstract class InputArgv implements InputInterface
{


    /**
     * argument arg0
     *
     * @var string
    */
    protected $defaultArgument;



    /**
     * @var string
    */
    protected $firstArgument;



    /**
     * token arguments
     *
     * @var array
    */
    protected $tokens = [];



    /**
     * parses arguments
     *
     * @var array
    */
    protected $arguments = [];



    /**
     * parses options
     *
     * @var array
    */
    protected $options = [];




    /**
     * @var array
     */
    protected $argumentFlags = [];




    /**
     * @var array
    */
    protected $optionFlags   = [];




    /**
     * @var InputBag
    */
    protected $inputBag;




    /**
     * @param array $tokens
    */
    public function __construct(array $tokens)
    {
        $this->tokens = $this->takeTokens($tokens);
    }



    /**
     * @param InputBag $inputBag
     * @return mixed
    */
    public function parses(InputBag $inputBag)
    {
        $this->inputBag = $inputBag;
    }



    /**
     * @param array $tokens
    */
    public function setTokens(array $tokens)
    {
        $this->tokens = $tokens;
    }




    /**
     * @return array
    */
    public function getTokens(): array
    {
        return $this->tokens;
    }




    /**
     * @param $defaultArgument
     * @return $this
     */
    public function setDefaultArgument($defaultArgument): InputArgv
    {
        $this->defaultArgument = $defaultArgument;

        return $this;
    }


    /**
     * @param array $arguments
     * @return $this
     * @throws InvalidArgumentCommand
    */
    public function setArguments(array $arguments): InputArgv
    {
        foreach ($arguments as $name => $value) {
              $this->setArgument($name, $value);
        }

        return $this;
    }


    /**
     * @param array $argumentFlags
     * @return $this
     */
    public function setArgumentFlags(array $argumentFlags): InputArgv
    {
        $this->argumentFlags = array_merge($this->argumentFlags, $argumentFlags);

        return $this;
    }


    /**
     * @param $index
     * @param $value
     * @return $this
     */
    public function setArgumentFlag($index, $value): InputArgv
    {
        $this->argumentFlags[$index] = $value;

        return $this;
    }




    /**
     * @return array
     */
    public function getArgumentFlags(): array
    {
        return $this->argumentFlags;
    }




    /**
     * @return array
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }


    /**
     * @param array $options
     * @return $this
     * @throws InvalidOptionCommand
     * @throws InvalidArgumentCommand
   */
    public function setOptions(array $options): InputArgv
    {
        foreach ($options as $name => $value) {
            $this->setOption($name, $value);
        }

        return $this;
    }


    /**
     * @param array $optionFlags
     * @return $this
     */
    public function setOptionFlags(array $optionFlags): InputArgv
    {
        $this->optionFlags = array_merge($this->optionFlags, $optionFlags);

        return $this;
    }



    /**
     * @param $index
     * @param $value
     * @return $this
     */
    public function setOptionFlag($index, $value): InputArgv
    {
        $this->optionFlags[$index] = $value;

        return $this;
    }


    /**
     * @return array
    */
    public function getOptionFlags(): array
    {
        return $this->optionFlags;
    }


    /**
     * @param $name
     * @param $value
     * @return $this
     * @throws InvalidArgumentCommand
     */
    public function setOption($name, $value): InputArgv
    {
        if (! $this->inputBag->getOptions()) {
            throw new InvalidArgumentCommand(sprintf('option (%s) is not defined.', $name));
        } else {
            if (! $this->inputBag->hasOption($name)) {
                throw new InvalidArgumentCommand(sprintf('option (%s) is not available.', $name));
            }

            if ($this->inputBag->isRequiredOption($name)) {
                throw new InvalidArgumentCommand(sprintf('option (%s) is required.', $name));
            }
        }



        $this->options[$name] = $value;

        return $this;
    }



    /**
     * @return array
    */
    public function getOptions(): array
    {
        return $this->options;
    }


    /**
     * @param $name
     * @param $value
     * @return $this
     * @throws InvalidArgumentCommand
    */
    public function setArgument($name, $value): InputArgv
    {
        if (! $this->inputBag->getArguments()) {
            throw new InvalidArgumentCommand(sprintf('argument (%s) is not defined.', $name));
        } else {
            if (! $this->inputBag->hasArgument($name)) {
                throw new InvalidArgumentCommand(sprintf('argument (%s) is not available.', $name));
            }

            if ($this->inputBag->isRequiredArgument($name)) {
                throw new InvalidArgumentCommand(sprintf('argument (%s) is required.', $name));
            }
        }

        $this->arguments[$name] = $value;

        return $this;
    }


    /**
     * @param string|null $name
     * @return mixed|string
     * @throws InvalidArgumentCommand
    */
    public function getArgument(string $name = null)
    {
        if (! $name) {
            if (! $this->defaultArgument) {
                throw new InvalidArgumentCommand('undefined default argument of command.');
            }

            return $this->defaultArgument;
        }

        if (isset($this->arguments[$name])) {
            return $this->arguments[$name];
        }

        throw new InvalidArgumentCommand('Invalid command argument.');
    }



    /**
     * @return mixed
     */
    public function getFirstArgument()
    {
        return $this->firstArgument;
    }


    /**
     * @param $fistArgument
     * @return InputArgv
    */
    public function setFirstArgument($fistArgument): InputArgv
    {
        $this->firstArgument = $fistArgument;

        return $this;
    }


    /**
     * @param array $tokens
     * @return array|false
    */
    private function takeTokens(array $tokens)
    {
        array_shift($tokens);

        if (! isset($tokens[0])) {
            return [];
        }

        $this->setFirstArgument($tokens[0]);

        if (isset($tokens[1])) {
            $this->setDefaultArgument($tokens[1]);
        }

        array_shift($tokens);

        return $tokens;
    }
}