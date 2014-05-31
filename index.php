<?php
/**
 * This is the application router
 */

require_once 'bootstrap.php';

$request = '';
if (isset($_SERVER['REDIRECT_URL'])) {
    $request = $_SERVER['REDIRECT_URL'];
} else if (isset($_SERVER['REQUEST_URI'])) {
    $request = $_SERVER['REQUEST_URI'];
}

$router = new \Web\RequestRouter();
$router->setApplicationDirectoryRoot(__DIR__);
$router->setApplicationWebRoot('/app1');  // XXX TODO FIXME how should we set this up properly? it is only needed when app is not in root vhost


/**
 * Compiles scss template to css, or serves a cached version if exists
 */
$router->registerRoute('scss', function($params) // XXX maybe param should be "/app1/scss" for clarity
{
    $viewName = $params[0]; // base name of the scss file

    // XXX untangle http response codes / api responses from Scss class
    $scss = new \Writer\Scss();

    $scss->setImportPath(realpath(__DIR__.'/scss'));
    return $scss->handle($viewName);
});


echo $router->route($request);


// TODO: internally handle /api = API calls
