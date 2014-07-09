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
    /**
     * @param $filterDate string YYYYMMDD if set, only include measures from this date
     * @return array of map markers
     */
    public static function parseIntoMarkers($csvFileName, $filterDate = '')
    {
        $csvReader = new \Reader\Csv();
        $csvReader->setStartLine(2);
        $csvReader->setDelimiter("\t");
        $rows = $csvReader->parseFileToObjects($csvFileName, new CsvHorseData());

        $filterTs = strtotime($filterDate);
        $res = array();

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

            $date = str_replace(' ', '-', $row->date);
            $ts = strtotime($date.' '.$row->time);

            $dateTs = strtotime($date);
            if ($filterDate && $dateTs != $filterTs) {
                continue;
            }

            $info = date('r', $ts);
            $mark->setTooltip($info);
            $res[] = $mark;
        }

        return $res;
    }
}
