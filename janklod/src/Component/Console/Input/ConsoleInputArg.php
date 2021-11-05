<?php
namespace Jan\Component\Console\Input;


use Jan\Component\Console\Input\Contract\InputInterface;
use Jan\Component\Console\Input\Support\InputArgv;
use Jan\Component\Console\Input\Support\InputBag;


/**
 * Class ConsoleInputArg
 * @package Jan\Component\Console\Input
*/
class ConsoleInputArg extends InputArgv
{

    /**
     * @param array $tokens
    */
    public function __construct(array $tokens = [])
    {
        if (! $tokens) {
            $tokens = $_SERVER['argv'];
        }

        parent::__construct($tokens);
    }



    /**
     * @throws Exception\InvalidArgumentCommand
     * @throws Exception\InvalidOptionCommand
    */
    public function parses(InputBag $inputBag)
    {
         parent::parses($inputBag);

         $tokens = $this->getTokens();

         foreach ($tokens as $token) {
            $this->processParseToken($token);
         }
    }


    /**
     * @param string $token
     * @throws Exception\InvalidArgumentCommand
     * @throws Exception\InvalidOptionCommand
    */
    protected function processParseToken(string $token)
    {
        if (preg_match("/^(.*)=(.*)$/i", $token)) {

            list($tokenName,$tokenValue) = explode('=', $token);

            if(preg_match('/^-(\w+)$/', $tokenName, $matches)) {
                $this->setArgument($matches[1], $tokenValue);
            }elseif(preg_match('/^--(\w+)$/', $tokenName, $matches)) {
                $this->setOption($matches[1], $tokenValue);
            }else{
                $this->setArgument($tokenName, $tokenValue);
            }

        } else {

            if(preg_match('/^-(\w+)$/', $token, $matches)) {
                $this->setArgumentFlag($matches[0], true);
            }elseif(preg_match('/^--(\w+)$/', $token, $matches)) {
                $this->setOptionFlag($matches[0], true);
            }
        }
    }

    /**
     * @return array
    */
    public function log(): array
    {
        return [
           'name' => $this->getFirstArgument(),
           'arg0' => $this->getArgument(),
           '-arg=value' => $this->getArguments(),
           '--option=value' => $this->getOptions(),
           '-arg:flag' => $this->getArgumentFlags(),
           '--option:flag' => $this->getOptionFlags(),
        ];
    }
}