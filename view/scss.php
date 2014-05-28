<?php
/**
 * Compiles scss template to css, or serves a cached version if exists
 */

$viewName = $param[0]; // base name of the scss file

// XXX untangle http response codes / api responses from Scss class
$scss = new \Writer\Scss();

$scss->setImportPath(realpath(__DIR__.'/../scss'));
$scss->handle($viewName);
