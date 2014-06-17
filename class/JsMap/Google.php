<?php
/**
 * Google Maps Javascript API V3
 *
 * Currently based on version "V3" of the API, which is
 * the latest release version as of 2012/02
 *
 * Tutorial:
 * https://developers.google.com/maps/documentation/javascript/tutorial
 */

namespace JsMap;

class Google
{
    protected $apiKey = null;
    protected $language;
    protected $region;

    protected $sensor = false;

    protected $width  = 500;
    protected $height = 300;
    protected $zoom = 8;

    protected $latitude = -34.397;
    protected $longitude = 150.644;
 
    protected $markers = array();

    public function __construct($apiKey = null)
    {
        $this->apiKey = $apiKey;
    }
    
    /**
     * @param string $s 2-letter language code, eg "en"
     */
    public function setLanguage($s)
    {
        $this->language = $s;
    }
    
    /**
     * @param string $s in order to force regional settings, eg "US", "SE"
     */
    public function setRegion($s)
    {
        $this->region = $s;
    }

    /**
     * $param bool $b try to detect user location? instead of specifying coordinates
     */
    public function useSensor($b)
    {
        $this->sensor = $b;
    }

    /**
     * $param int $n 1=whole world to 18=max zoom
     */
    public function setZoomLevel($n)
    {
        $this->zoom = $n;
    }

    public function setWidth($n)
    {
        $this->width = $n;
    }

    public function setHeight($n)
    {
        $this->height = $n;
    }
    
    public function addMarker(GoogleMapMarker $mark)
    {
        $this->markers[] = $mark;
    }

    public function addMarkers($arr)
    {
        if (!is_array($arr)) {
            throw new \Exception('not array');
        }

        foreach ($arr as $o) {
            $this->addMarker($o);
        }
    }

    private function boolToString($b)
    {
        return $b ? 'true' : 'false';
    }

    public function renderToDocument(\Writer\DocumentXhtml $document)
    {
        $apiUrl =
            '//maps.googleapis.com/maps/api/js'.
            '?sensor='.$this->boolToString($this->sensor).
            ($this->apiKey ? '&key='.$this->apiKey : '').
            ($this->language   ? '&language='.$this->language : '').
            ($this->region ? '&region='.$this->region : '');

        $document->includeJs($apiUrl);

        $divId = 'gmap_'.mt_rand();

        $res =
        'var myOptions={'.
            'center:new google.maps.LatLng('.$this->latitude.','.$this->longitude.'),'.
            'zoom:'.$this->zoom.','.
            'mapTypeId:google.maps.MapTypeId.ROADMAP'.
        '};'.
        'var myMap=new google.maps.Map(document.getElementById("'.$divId.'"),myOptions);'.
        $this->renderMarkers();

        $document->attachJsOnload($res);

        $css =
            'width:'.$this->width.'px;'.
            'height:'.$this->height.'px;';
        $document->attachToBody(
            '<div id="'.$divId.'" style="'.$css.'"></div>'
        );
    }
    
    private function renderMarkers()
    {
        $res = '';
        foreach ($this->markers as $idx => $m) {
            $res .=
            'var mk'.$idx.'=new google.maps.Marker({'.
                'position:new google.maps.LatLng('.$m->latitude.','.$m->longitude.'),'.
                ($m->icon ? 'icon:"'.$m->icon.'",' : '').
                ($m->tooltip ? 'title:"'.$m->tooltip.'",' : '').
                ($m->zIndex ? 'zIndex:'.$m->zIndex.',' : '').
                ($m->flat ? 'flat:true,' : '').
                'map:myMap'.
            '});';
        }
        return $res;
    }
}
