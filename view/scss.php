<?php
/**
 * Compiles scss template to css, or serves a cached version if exists
 */

/**
 * allows a-z,A-Z,0-9 and -
 */
function isValidScssFileName($name) // XXX MOVE TO CLASS
{
	if (strlen($name) <= 30 &&
		preg_match('/^[a-zA-Z0-9-]+$/', $name) == 1
	) {
		return true;
	}

	return false;
}

function sendValidationHeaders($mtime, $etag)
{
	header('Last-Modified: '.gmdate('D, j M Y H:i:s', $mtime).' GMT');
	header('Etag: '.$etag);
	header('Cache-Control: public'); // XXX useless?
}

function isModified($mtime, $etag)
{
	if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) < $mtime) {
		return true;
	}

	if (isset($_SERVER['HTTP_IF_NONE_MATCH']) && $_SERVER['HTTP_IF_NONE_MATCH'] != $etag) {
		return true;
	}

	return false;
}

if ($param[0] == 'compile') {
	// $param[1] = name of scss file

	if (!isValidScssFileName($param[1])) {
		http_response_code(400); // Bad Request
		header('Content-Type: application/json');
		echo json_encode(array('code'=>400, 'message'=>'Invalid scss name'));
		exit;
	}

	$scss = \Writer\Scss::getInstance();

	$scssPath = realpath(__DIR__.'/../scss');
	$scssFile = $scssPath.'/'.$param[1].'.scss';
	$cachedFile = $scssPath.'/'.$param[1].'.compiled.css';

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

		sendValidationHeaders($cachedMtime, $etag);

		if (isModified($cachedMtime, $etag)) {
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

		sendValidationHeaders($cachedMtime, $etag);

		$scss->setImportPaths($scssPath);
		$scss->setFormatter('scss_formatter_compressed');

		$data = $scss->compile('@import "'.basename($scssFile).'"');
		echo $data;
		file_put_contents($cachedFile, $data);
	}
}
