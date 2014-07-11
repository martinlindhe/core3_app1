<?php

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


class ReaderCsvHagenPos
{
    /**
     * @return array of CsvColumnHagenPos
     */
    public static function parseToObjects($csvFileName)
    {
        // TODO parse to own object type and clean data some, see commented  out code below
        $csvReader = new \Reader\Csv();
        $csvReader->setStartLine(1);
        $rows = $csvReader->parseFileToObjects($csvFileName, new CsvColumnHagenPos());

        foreach ($rows as $row) {
            try {
                // convert coordinates
                $coord = \JsMap\CoordinateConverter::SWEREF99TM_to_WGS84($row->coordN, $row->coordE);
                $row->latitude = $coord->latitude;
                $row->longitude = $coord->longitude;

            } catch (\Exception $e) {
                continue;
            }
        }

        return $rows;

            /*
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
            */

    }
}
