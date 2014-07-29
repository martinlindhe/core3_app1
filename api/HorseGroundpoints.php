<?php

// TODO cache to disk

class HorseGroundpoints
{
    public function handleGet()
    {
        $objs = ReaderCsvHagenPos::parseToObjects(__DIR__.'/../horse-data/pos4.csv');
        echo \Writer\Json::encodeSlim($objs);
    }
}
