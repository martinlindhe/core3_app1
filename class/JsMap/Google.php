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
    protected $centerCoordinate;
    protected $latitude = -34.397;
    protected $longitude = 150.644;
    protected $mapType = 'ROADMAP';
    protected $divId;
    protected $markers = array();
    protected $kmlLayers = array();

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

    public function addKmlLayer($url)
    {
        $this->kmlLayers[] = $url;
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
            '//maps.googleapis.com/maps/api/js?v=3.16'.
            '&sensor='.$this->boolToString($this->sensor).
            ($this->apiKey ? '&key='.$this->apiKey : '').
            ($this->language   ? '&language='.$this->language : '').
            ($this->region ? '&region='.$this->region : '');

        $document->includeJs($apiUrl);

        $document->attachJsOnload(
            'var myOptions={'.
                'center:new google.maps.LatLng('.
                    $this->centerCoordinate->latitude.','.
                    $this->centerCoordinate->longitude.
                '),'.
                'zoom:'.$this->zoom.','.
                'mapTypeId:google.maps.MapTypeId.'.$this->mapType.
            '};'.
            'var myMap=new google.maps.Map('.
                'document.getElementById("'.$this->divId.'"),'.
                'myOptions'.
            ');'.
            $this->renderKmlLayers('myMap').
            $this->renderMarkers('myMap')
        );

        $document->attachToBody(
            '<div id="'.$this->divId.'"></div>'
        );
    }

    /**
     * requires a public url because it is included from google servers
     */
    private function renderKmlLayers($mapVar)
    {
        $res = '';
        $i = 0;

        foreach ($this->kmlLayers as $url) {
            $var = 'layer'.(++$i);
            $res .=
            'var '.$var.' = new google.maps.KmlLayer({'.
                'url: "'.$url.'"'.
            '});'.
            $var.'.setMap('.$mapVar.');';
        }
        return $res;
    }
    
    private function renderMarkers($mapVar)
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
                'map:'.$mapVar.
            '});';
        }
        return $res;
    }
}
