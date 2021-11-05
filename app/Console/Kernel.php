<?php
namespace App\Console;


use App\Command\ChangePasswordCommand;
use App\Command\ConsoleStyleCommand;
use App\Command\SayHelloCommand;
use Jan\Foundation\Console\Kernel as ConsoleKernel;


/**
 * Class Kernel
 * @package App\Console
*/
class Kernel extends ConsoleKernel
{

    /**
     * @var string[]
    */
    protected $commands = [
        SayHelloCommand::class,
        ChangePasswordCommand::class,
        ConsoleStyleCommand::class
    ];
}