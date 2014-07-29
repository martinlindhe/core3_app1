<?php

// sample api that takes DELETE data
// test: curl --request DELETE --data param1=value1 --data param2=value2 http://app1.dev/api/deleter

class Deleter
{
    public function handleDelete()
    {
        $putRaw = file_get_contents('php://input');
        parse_str($putRaw, $putArr);

        var_dump($putArr);
    }
}
