<?php
/**
 * Pre-generates json files of time-segmented
 */
 // 2014-07-10: 4min to generate from ~40 days

$horses = [4664, 4665];
$startTime = strtotime('20140520');
$endTime = strtotime('20140701');
$regenAllFiles = false;

$availableDurations = [ 3600, 3600*4, 3600*8, 3600*24, 3600*24*7, 3600*24*14, 3600*24*30];

foreach ($availableDurations as $durationSeconds) {

    if ($durationSeconds <= 3600*24) {
        $increaseSeconds = $durationSeconds;
    } else {
        $increaseSeconds = 3600*24;
    }

    echo "Duration ".($durationSeconds / 3600)." hours, ".($increaseSeconds / 3600)." h increases:\n";

    for ($currentTime = $startTime; $currentTime <= $endTime; $currentTime += $increaseSeconds) {
        foreach ($horses as $horse) {
            if (WriterHorseDataCache::generate($horse, $currentTime, $durationSeconds, $regenAllFiles)) {
                $outFileName = str_replace(
                    getcwd().'/',
                    '',
                    WriterHorseDataCache::getCacheFileName($horse, $currentTime, $durationSeconds)
                );
                echo "    Generated horse ".$horse." ".date('Ymd H:i:s', $currentTime).": ".
                    $outFileName."\n";
            }
        }
    }
}
