<?php
require_once __DIR__.'/Autoloader.php';

$autoloader = \Jan\Autoload\Autoloader::load(__DIR__ .'/../../');

$autoloader->namespaces(['App\\' => 'app/', 'Jan\\' => 'src/']);

$autoloader->register();