<?php

// sample api that takes POST data
// test: curl --data param1=value1 --data param2=value2 http://app1.dev/api/poster

class Poster
{
    public function handlePost()
    {
        var_dump($_POST);
    }
}
