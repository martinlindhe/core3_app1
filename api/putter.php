<?php

// sample api that takes PUT data
// test: curl --request PUT --data param1=value1 --data param2=value2 http://app1.dev/api/putter

if ($requestMethod != 'PUT') {
    throw new \Exception('api request method not allowed');
}

$putRaw = file_get_contents('php://input');
parse_str($putRaw, $putArr);

var_dump($putArr);
