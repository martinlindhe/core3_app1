<?php

class WriterHorseDataCache
{
    /**
     * Allow 0-9 and - in key name
     */
    public static function isValidCacheKey($key)
    {
        if (preg_match('/^[0-9-]+$/', $key) != 1) {
            return false;
        }
        return true;
    }

    /**
     * Quickly pass thru cache file from disk to client
     * SIDE EFFECT: exits application
     */
    public static function passThru($cacheKey)
    {
        if (!self::isValidCacheKey($cacheKey)) {
            throw new \Exception('bad input');
        }

        $cacheFileName = realpath(__DIR__.'/../horse-data/cache').'/'.$cacheKey;
        if (!file_exists($cacheFileName)) {
            throw new \Exception('no such file');
        }

        // NOTE cannot detect x-sendfile will work for given path
        //header('X-Sendfile: '.$cacheFileName);

        readfile($cacheFileName);
        exit;
    }
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

        $cacheFileName = self::getCacheFileName($horseId, $startTime, $durationSeconds);
        if ($force || !file_exists($cacheFileName)) {
            $markers = \ReaderHorseData::parseIntoMarkers($horseId, $startTime, $durationSeconds);

            $data = \Writer\Json::encode($markers);
            file_put_contents($cacheFileName, $data);
            return true;
        }

        return false;
    }

    public static function getCacheFileName($horseId, $startTime, $durationSeconds)
    {
        $dirName = realpath(__DIR__.'/../horse-data/cache');
        return $dirName.'/'.$horseId.'-'.date('YmdHis', $startTime).'-'.$durationSeconds;
    }
}
