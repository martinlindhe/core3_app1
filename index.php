<?php
/**
 * This is the application router
 */

require_once 'core3/class/Core/Bootstrapper.php';
spl_autoload_register('Core_Bootstrapper::autoload');

$request = '';
if (isset($_SERVER['REDIRECT_URL'])) {
    $request = $_SERVER['REDIRECT_URL'];
} else if (isset($_SERVER['REQUEST_URI'])) { 
    $request = $_SERVER['REQUEST_URI'];
}

$router = new Web_RequestRouter();
$router->setApplicationDirectoryRoot(__DIR__);
$router->setApplicationWebRoot('/app1');  // XXX TODO FIXME how should we set this up properly? it is only needed when app is not in root vhost
$router->route($request);
