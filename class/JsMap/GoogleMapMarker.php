<?php
namespace JsMap;

class GoogleMapMarker
{
    var $latitude;
    var $longitude;
    protected $tooltip;
    protected $icon;
    protected $zIndex;
    protected $flat = false;
    
    public function __construct($lat, $long)
    {
        $this->latitude = $lat;
        $this->longitude = $long;
    }
    
    public function setTooltip($s)
    {
        $this->tooltip = $s;
    }
    
    public function getTooltip()
    {
        return $this->tooltip;
    }
    
    public function getIcon()
    {
        return $this->icon;
    }
    
    public function getZIndex()
    {
        return $this->zIndex;
    }
    
    /**
     * @return bool
     */
    public function isFlat()
    {
        return $this->flat;
    }
}
