<?php
    
$doc = new \Writer\DocumentHtml5();

$map = new \JsMap\Google();
$map->setCenter(new \JsMap\Coordinate(59.742656, 17.675384));
$map->setZoom(15);
$map->setMapType('HYBRID');

$map->loadGeoJson('geojson/hagen');
//$map->loadGeoJson('geojson/stangsel');

$doc->embedCss(
    'html,body{'.
        'height:100%;'.
        'margin:0;'.
        'padding:0;'.
    '}'.
    '#'.$map->getDivId().'{'.
        //'width:1000px;'.
        //'height:600px;'.
        'width:100%;'.
        'height:100%;'.
        'border:1px solid #000;'.
    '}'.
    '.mapInfoWnd{'.
        //'color:#eeaa11;'.
        'font-size:9px;'.
        'line-height:9px;'.
    '}'
);

class CsvColumnHagenPos
{
    var $id;
    var $coordE;
    var $coordN;
    var $vegetationType;

    // trees and shrubs:
    var $species;
    var $diameter;
    var $height;
    var $deadWood;
    var $browsing;
    var $gnawing;

    // ground coverage:
    var $height2;
    var $species2;
    var $coverage;

    // pellet-group count:
    var $species3;
    var $numberOfPiles;

    var $extra;
}

$csvReader = new \Reader\Csv();
$csvReader->setStartLine(1);
$rows = $csvReader->parseFileToObjects(__DIR__.'/pos4.csv', new CsvColumnHagenPos());

foreach ($rows as $row) {
    try {
        $coord = \JsMap\CoordinateConverter::SWEREF99TM_to_WGS84($row->coordN, $row->coordE);
        $mark = new \JsMap\GoogleMapMarker($coord->latitude, $coord->longitude);
    } catch (\Exception $e) {
        continue;
    }
    $infoStr = \Helper\Object::describePropertiesWithValues($row, array('coordE', 'coordN'));
    $infoStr = str_replace("\n", '<br/>', trim($infoStr));
    $info = '<div class=\"mapInfoWnd\">'.$infoStr.'</div>';
    $mark->setInfoWindow($info);
    switch ($row->vegetationType) {
        case '633':
            // cross
            $symbol = '"M -2,-2 2,2 M 2,-2 -2,2"';
            $color = '#64b5ec';
            break;

        case '635':
            // tilted cube
            $symbol = '"M -2,0 0,-2 2,0 0,2 z"';
            $color = '#4ec73d';
            break;

        case '625':
            // tilted cube
            $symbol = '"M -2,0 0,-2 2,0 0,2 z"';
            $color = '#cf4ddd';
            break;

        case '737':
            // cross
            $symbol = '"M -2,-2 2,2 M 2,-2 -2,2"';
            $color = '#9fa250';
            break;
        case '310':
            // cross
            $symbol = '"M -2,-2 2,2 M 2,-2 -2,2"';
            $color = '#ecd959';
            break;
        default:
            $symbol = 'google.maps.SymbolPath.CIRCLE';
            $color = 'red';
    }
    $mark->setIcon(
        '{'.
            'path: '.$symbol.','.
            'scale: 2,'.
            'strokeColor: "'.$color.'"'.
        '}'
    );
    $map->addMarker($mark);
}

$map->attachToDocument($doc);


echo $doc->render();
