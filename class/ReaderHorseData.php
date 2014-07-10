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

class MapMarker
{
    var $id;
    var $latitude;
    var $longitude;
    var $timestamp;

    public function __construct($lat, $long)
    {
        $this->latitude = $lat;
        $this->longitude = $long;
    }
}

class ReaderHorseData
{
    /**
     * @param $filterTs timestamp to start at
     * @param $filterDuration in seconds
     * @return array of map markers
     */
    public static function parseIntoMarkers($csvFileName, $filterTs, $filterDuration)
    {
        $csvReader = new \Reader\Csv();
        $csvReader->setStartLine(2);
        $csvReader->setDelimiter("\t");
        $rows = $csvReader->parseFileToObjects($csvFileName, new CsvHorseData());

        $res = array();

        $id = 0;
        foreach ($rows as $row) {
            $id++;
            if ($row->ttf == '') {
                // these rows dont have coords
                continue;
            }
            try {
                $mark = new MapMarker($row->lat, $row->long);
                $mark->id = $id;
            } catch (\Exception $e) {
                continue;
            }

            $date = str_replace(' ', '-', $row->date);
            $mark->timestamp = strtotime($date.' '.$row->time);

            if ($mark->timestamp < $filterTs) {
                // too old
                continue;
            }

            if ($mark->timestamp > ($filterTs + $filterDuration)) {
                // too new
                continue;
            }

            $res[] = $mark;
        }

        return $res;
    }
}
