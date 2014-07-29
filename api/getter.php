<?php

// sample api that takes GET data
// test: curl --request GET "http://app1.dev/api/getter?param1=hej&param2=hela"

class Getter
{
    public function handleGet()
    {
        var_dump($_GET);
    }
}
