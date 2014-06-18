<?php
namespace JsMap;

class Coordinate
{
    var $latitude;
    var $longitude;
    
    public function __construct($latitude = 0, $longitude = 0)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }
}
