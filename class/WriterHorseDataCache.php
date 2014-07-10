<?php

class WriterHorseDataCache
{
    /**
     * Generates cached file if it does not already exist
     *
     * @param $force unconditionally create new disk cache
     */
    public static function generate($horseId, $startTime, $durationSeconds, $force = false)
    {
        $dirName = __DIR__.'/../horse-data/cache';
        if (!is_dir($dirName)) {
            mkdir($dirName);
        }

        $cacheFileName = $dirName.'/'.$horseId.'-'.$startTime.'-'.$durationSeconds;
        if ($force || !file_exists($cacheFileName)) {
            $markers = \ReaderHorseData::parseIntoMarkers($horseId, $startTime, $durationSeconds);

            $data = \Writer\Json::encode($markers);
            file_put_contents($cacheFileName, $data);
            return true;
        }

        return false;
    }
}
