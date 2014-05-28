<?php
/**
 * Compiles scss template to css, or serves a cached version if exists
 */

$viewName = $param[0]; // base name of the scss file

if (!\Writer\Scss::isValidScssFileName($viewName)) {
	http_response_code(400); // Bad Request
	header('Content-Type: application/json');
	echo json_encode(array('code'=>400, 'message'=>'Invalid scss name'));
	exit;
}

$scss = \Writer\Scss::getInstance();

$scssPath = realpath(__DIR__.'/../scss');
$scssFile = $scssPath.'/'.$viewName.'.scss';
$cachedFile = $scssPath.'/'.$viewName.'.compiled.css';

if (!file_exists($scssFile)) {
	// TODO refactor API error message
	http_response_code(400); // Bad Request
	header('Content-Type: application/json');
	echo json_encode(array('code'=>400, 'message'=>'No such scss file'));
	exit;
}

$scssMtime = filemtime($scssFile);

$cachedMtime = 0;
if (file_exists($cachedFile)) {
	$cachedMtime = filemtime($cachedFile);
}

$etag = md5($scssFile.$cachedMtime);

header('Content-Type: text/css');

if ($cachedMtime > $scssMtime) {

	\Writer\Scss::sendValidationHeaders($cachedMtime, $etag);

	if (\Writer\Scss::isModified($cachedMtime, $etag)) {
		// serve cached copy if browser didnt have it cached
		readfile($cachedFile);
	} else {
		http_response_code(304);   // Not Modified
		exit();
	}

} else {
	if (!$cachedMtime) {
		$cachedMtime = time();
	}

	\Writer\Scss::sendValidationHeaders($cachedMtime, $etag);

	$scss->setImportPaths($scssPath);
	$scss->setFormatter('scss_formatter_compressed');

	$data = $scss->compile('@import "'.basename($scssFile).'"');
	echo $data;
	file_put_contents($cachedFile, $data);
}
