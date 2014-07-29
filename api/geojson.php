<?php

class Geojson
{
    public function handleGet($param)
    {
        $viewName = $param[0];
        if (!self::isValidViewName($viewName)) {
            throw new \Exception('bad input');
        }

        $jsonFile = __DIR__.'/../geojson/'.$viewName.'.geojson';

        if (!file_exists($jsonFile)) {
            http_response_code(404);
            return;
        }

        include $jsonFile;
    }

    private function isValidViewName($key)
    {
        if (preg_match('/^[a-zA-Z0-9-]+$/', $key) != 1) {
            return false;
        }
        return true;
    }
}
