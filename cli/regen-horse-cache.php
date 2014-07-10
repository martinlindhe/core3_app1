<?php
/**
 * Pre-generates json files of time-segmented
 */


// TODO calc all durations
$horses = [4664, 4665];
$startTime = strtotime('20140520');
$endTime = strtotime('20140701');
$regenAllFiles = false;


$availableDurations = [3600, 3600*4, 3600*8, 3600*24];

foreach ($availableDurations as $durationSeconds) {
    for ($currentTime = $startTime; $currentTime <= $endTime; $currentTime += $durationSeconds) {
        //echo "Generating ".date('r', $currentTime).", ".($durationSeconds / 3600)." hours\n";

        foreach ($horses as $horse) {
            if (WriterHorseDataCache::generate($horse, $currentTime, $durationSeconds, $regenAllFiles)) {
                echo "Generated cache ".$horse.'-'.$currentTime.'-'.$durationSeconds."\n";
            }
        }
    }
}
