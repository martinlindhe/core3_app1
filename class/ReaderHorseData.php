<?php

class CsvHorseData
{
    //Date	Time	TTF	Lat	Long		2D3D	Alt	DOP	SVs	FOM	X	Y	Temp	Bat	Status	SCap	GPS	GSM
    var $empty; // leading tab...
    var $date;
    var $time;
    var $ttf;  // ??
    var $lat;
    var $long;
    var $two2threed; //? .. 2D3D
    var $alt;
    var $dop;
    var $svs;
    var $fom;
    var $x;
    var $y;
    var $temp;
    var $bat;
    var $status;
    var $scap;
    var $gps;
    var $gsm;
}

class ReaderHorseData
{
    // returns array of map markers
    public static function addMarkersToMap(\JsMap\Google $map, $csvFileName)
    {
        $csvReader = new \Reader\Csv();
        $csvReader->setStartLine(2);
        $csvReader->setDelimiter("\t"); // FIXME unit test tab delim
        $rows = $csvReader->parseFileToObjects($csvFileName, new CsvHorseData());

        foreach ($rows as $row) {
            if ($row->ttf == '') {
                // these rows dont have coords
                continue;
            }
            try {
                $coord = new \JsMap\Coordinate($row->lat, $row->long);
                $mark = new \JsMap\GoogleMapMarker($coord->latitude, $coord->longitude);
            } catch (\Exception $e) {
                continue;
            }
            $info = $row->date.', '.$row->time;
            //$mark->setTooltip($info);
            $map->addMarker($mark);
        }
    }
}
