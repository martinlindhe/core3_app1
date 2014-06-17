<?php
namespace JsMap;

class GoogleMapMarker
{
    var $latitude;
    var $longitude;
    var $tooltip;
    var $icon;
    var $zIndex;
    var $flat = false;
    
    public function __construct($lat, $long)
    {
        $this->latitude = $lat;
        $this->longitude = $long;
    }
}
