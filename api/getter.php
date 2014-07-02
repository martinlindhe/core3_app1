<?php

// sample api that takes GET data
// test: curl --request GET "http://app1.dev/api/getter?param1=hej&param2=hela"

if ($requestMethod != 'GET') {
    throw new \Exception('api request method not allowed');
}

var_dump($_GET);
