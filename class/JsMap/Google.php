<?php
namespace JsMap;

/**
 * Google Maps Javascript widget
 */
class Google
{
    protected $apiKey = null;
    protected $language;
    protected $region;
    protected $sensor = false;
    protected $zoom = 8;
    protected $center; ///< Coordinate
    protected $latitude = -34.397;
    protected $longitude = 150.644;
    protected $markers = array();
    protected $mapType = 'ROADMAP';
    protected $divId;

    public function __construct($apiKey = null)
    {
        $this->apiKey = $apiKey;
        $this->divId = 'gmap_'.mt_rand();
        $this->center = new Coordinate();
    }
    
    public function setLatitude($n)
    {
        $this->center->latitude = $n;
    }
    
    public function setLongitude($n)
    {
        $this->center->longitude = $n;
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
    public function setZoom($n)
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
    
    public function getDivId()
    {
        return $this->divId;
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
    
    public function setMapType($s)
    {
        $s = strtoupper($s);
        if (!in_array($s, array('ROADMAP', 'SATELLITE', 'HYBRID', 'TERRAIN'))) {
            throw new \Exception('invalid map type');
        }
        $this->mapType = $s;
    }

    public function attachToDocument(\Writer\DocumentHtml5 $document)
    {
        $apiUrl =
            '//maps.googleapis.com/maps/api/js?v=3.16'.
            '&sensor='.$this->boolToString($this->sensor).
            ($this->apiKey ? '&key='.$this->apiKey : '').
            ($this->language   ? '&language='.$this->language : '').
            ($this->region ? '&region='.$this->region : '');

        $document->includeJs($apiUrl);

        $document->attachJsOnload(
            'var myOptions={'.
                'center:new google.maps.LatLng('.$this->center->latitude.','.$this->center->longitude.'),'.
                'zoom:'.$this->zoom.','.
                'mapTypeId:google.maps.MapTypeId.'.$this->mapType.
            '};'.
            'var myMap=new google.maps.Map(document.getElementById("'.$this->divId.'"),myOptions);'.
            $this->renderMarkers()
        );

        $document->attachToBody(
            '<div id="'.$this->divId.'"></div>'
        );
    }
    
    private function renderMarkers()
    {
        $res = '';
        foreach ($this->markers as $idx => $m) {
            $res .=
            'var mk'.$idx.'=new google.maps.Marker({'.
                'position:new google.maps.LatLng('.$m->latitude.','.$m->longitude.'),'.
                ($m->getIcon() ? 'icon:"'.$m->getIcon().'",' : '').
                ($m->getTooltip() ? 'title:"'.$m->getTooltip().'",' : '').
                ($m->getZIndex() ? 'zIndex:'.$m->getZIndex().',' : '').
                ($m->isFlat() ? 'flat:true,' : '').
                'map:myMap'.
            '});';
        }
        return $res;
    }
}
