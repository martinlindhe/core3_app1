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

require 'settings/settings.php';

$router->setApplicationWebRoot(dirname($_SERVER['SCRIPT_NAME']));


/**
 * Compiles SCSS to CSS stylesheets on demand
 */
$router->registerRoute('scss', function($params) // XXX param should be full path, /scss
{
    $viewName = $params[0]; ///< base name of the scss file

    $scss = new \Writer\Scss();

    $scss->setImportPath(realpath(__DIR__.'/scss'));

    header('Content-Type: text/css');

    try {
        return $scss->handle($viewName);
    } catch (\CachedInClientException $ex) {
        http_response_code(304); // Not Modified
        return;
    } catch (\Exception $ex) {
        
        // TODO set different http response code depending on the exception type

        http_response_code(400); // Bad Request
        header('Content-Type: application/json');
        return \Api\ResponseError::exceptionToJson($ex);
    }
});

\Writer\HttpHeader::sendContentType('text/html; charset=utf-8');

echo $router->route($request);


// TODO: route /api
