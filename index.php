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
 * Compiles SCSS to CSS stylesheets on demand
 */
$router->registerRoute('scss', function($params) // XXX maybe param should be "/app1/scss" for clarity
{
    $viewName = $params[0]; // base name of the scss file

    $scss = new \Writer\Scss();

    $scss->setImportPath(realpath(__DIR__.'/scss'));

    header('Content-Type: text/css');

    try {
        return $scss->handle($viewName);
    } catch (\CachedInClientException $ex) {
        http_response_code(304); // Not Modified
        return;
    } catch (\Exception $ex) {
        http_response_code(400); // Bad Request
        
        // TODO set different http response code depending on the exception type
        // TODO make this generic handling for api calls & resonse generation

        $arr = array(
            'status'    => 'exception',
            'exception' => get_class($ex),
            'message'   => htmlentities($ex->getMessage()),
            'file'      => htmlentities($ex->getFile()),
            'line'      => $ex->getLine(),
        );

        header('Content-Type: application/json');
        return json_encode($arr, JSON_UNESCAPED_SLASHES);
    }
});


echo $router->route($request);


// TODO: internally handle /api = API calls
