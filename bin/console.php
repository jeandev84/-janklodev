#!/usr/bin/env php
<?php

/*
|------------------------------------------------------------------
|   Framework console
|   Ex: $ php bin/console.php
|   Ex: $ php bin/console.php list
|   Ex: $ php bin/console.php --help/-h
|   Ex: $ php bin/console.php make:controller -controller=SiteController -action=index,about,news,contact
|   Ex: $ php bin/console.php make:command app:user:change-password
|   Ex: $ php bin/console.php make:model User
|   Ex: $ php bin/console.php make:addition -a=1 -b=2
|   Ex: $ php bin/console.php make:resource -entity=Product
|   Ex: $ php bin/console.php server:run (run internal server php)
|------------------------------------------------------------------
*/

require(__DIR__ . '/../vendor/autoload.php');
$app = require(__DIR__ . '/../bootstrap/app.php');


$kernel = $app->get(Jan\Contract\Console\Kernel::class);

$status = $kernel->handle(
 $input = new \Jan\Component\Console\Input\ConsoleInputArg(),
 new \Jan\Component\Console\Output\ConsoleOutput()
);


$kernel->terminate($input, $status);
exit($status);