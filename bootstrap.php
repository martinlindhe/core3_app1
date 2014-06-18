<?php

require_once __DIR__.'/core3/class/Core/Bootstrap.php';

// register core3 autoloader
\Core\Bootstrap::registerAutoloader();

// register project autoloader
spl_autoload_register(function ($class) {
    $class = strtr($class, "\\", DIRECTORY_SEPARATOR);
    $fileName = (__DIR__.'/class').'/'.$class.'.php';

    if (file_exists($fileName)) {
        include $fileName;
    }
});
