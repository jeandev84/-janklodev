<?php
/*
|----------------------------------------------------------------------
|                       JanFramework
|
|   Author      :   Yao Kouassi Jean-Claude
|   Email       :   jeanyao@ymail.com
|   Occupation  :   Developer PHP
|   GITLAB      :   https://github.com/jeandev84/janklodev
|
|----------------------------------------------------------------------
*/



/*
|----------------------------------------------------------------------
|   Autoloader classes and dependencies of application
|----------------------------------------------------------------------
*/

require_once __DIR__.'/../vendor/autoload.php';


/*
|-------------------------------------------------------
|    Require bootstrap of Application
|-------------------------------------------------------
*/

$app = require_once __DIR__.'/../bootstrap/app.php';



/*
|-------------------------------------------------------
|    Check instance of Kernel
|-------------------------------------------------------
*/


$kernel = $app->get(\Jan\Contract\Http\Kernel::class);


/*
|-------------------------------------------------------
|    Get Response
|-------------------------------------------------------
*/


$response = $kernel->handle(
    $request = \Jan\Component\Http\Request\Request::createFromGlobals()
);



/*
|-------------------------------------------------------
|    Send all headers to navigator
|-------------------------------------------------------
*/

$response->send();



/*
|-------------------------------------------------------
|    Terminate application
|-------------------------------------------------------
*/

$kernel->terminate($request, $response);