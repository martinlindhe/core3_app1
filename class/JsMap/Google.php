<?php
namespace JsMap;

// TODO rewrite: insert js array with markers, and a js loop that creates them, rather than a php loop
// see example: http://stackoverflow.com/questions/3059044/google-maps-js-api-v3-simple-multiple-marker-example

class GeoJsonReference
{
    var $url;
}

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
    protected $centerCoordinate;
    protected $latitude = -34.397;
    protected $longitude = 150.644;
    protected $mapType = 'ROADMAP';
    protected $divId;
    protected $markers = array();
    protected $geoJsonReferences  = array();

    public function __construct($apiKey = null)
    {
        $this->apiKey = $apiKey;
        $this->divId = 'gmap_'.mt_rand();
    }

    public function setCenter(Coordinate $c)
    {
        $this->centerCoordinate = $c;
    }

    /*
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

    public function loadGeoJson($url)
    {
        $x = new GeoJsonReference();
        $x->url = $url;
        $this->geoJsonReferences[] = $x;
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
        if (!$this->centerCoordinate) {
            throw new \Exception('requires centerCoordinate');
        }
        $apiUrl =
            '//maps.googleapis.com/maps/api/js?v=3.16'.  // v=3.16, v=exp
            '&sensor='.$this->boolToString($this->sensor).
            ($this->apiKey ? '&key='.$this->apiKey : '').
            ($this->language ? '&language='.$this->language : '').
            ($this->region ? '&region='.$this->region : '');

        $document->includeJs($apiUrl);

        $document->embedJs(
            'google.maps.event.addDomListener(window, "load", function(){'.
                'var map=new google.maps.Map('.
                    'document.getElementById("'.$this->divId.'"),'.
                    '{'.
                        'center:new google.maps.LatLng('.
                            $this->centerCoordinate->latitude.','.
                            $this->centerCoordinate->longitude.
                        '),'.
                        'zoom:'.$this->zoom.','.
                        'mapTypeId:google.maps.MapTypeId.'.$this->mapType.
                    '}'.
                ');'.
                $this->renderLoadGeoJson().
                $this->renderMarkers().
            '});'
        );

        $document->attachToBody(
            '<div id="'.$this->divId.'"></div>'
        );
    }

    /**
     * requires a public url because it is included from google servers
     */
    private function renderLoadGeoJson()
    {
        $res = '';
        foreach ($this->geoJsonReferences as $ref) {
            $res .=
            'map.data.loadGeoJson("'.$ref->url.'");';
        }
        return $res;
    }

    private function renderMarkers()
    {
        $res = 'var infoWindow = new google.maps.InfoWindow();';
        foreach ($this->markers as $idx => $m) {
            $res .=
            'var k'.$idx.'=new google.maps.Marker({'.
                'position:new google.maps.LatLng('.$m->latitude.','.$m->longitude.'),'.
                ($m->getIcon() ? 'icon:'.$m->getIcon().',' : '').
                ($m->getTooltip() ? 'title:"'.$m->getTooltip().'",' : '').
                ($m->getZIndex() ? 'zIndex:'.$m->getZIndex().',' : '').
                ($m->isFlat() ? 'flat:true,' : '').
                'map:map'.
            '});'.
            ($m->getInfoWindow() ?
            'google.maps.event.addListener(k'.$idx.',"mouseover",function()'.
            '{'.
                'infoWindow.setContent("'.$m->getInfoWindow().'");'.
                'infoWindow.open(map,this);'.
            '});' : '');
        }
        return $res;
    }
}
