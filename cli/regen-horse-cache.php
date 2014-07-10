<?php
/**
 * Pre-generates json files of time-segmented
 */


// TODO calc all durations
$horses = [4664, 4665];
$startTime = strtotime('20140520');
$regenAllFiles = true;



$durationSeconds = 60 * 60 * 24; // 24h


for ($currentTime = $startTime; $currentTime < ($startTime + ($durationSeconds * 10) ); $currentTime += $durationSeconds) {
    echo "Generating for date ".date('r', $currentTime).", ".($durationSeconds / 3600)." hours\n";

    foreach ($horses as $horse) {
        if (WriterHorseDataCache::generate($horse, $currentTime, $durationSeconds, $regenAllFiles)) {
            echo "Generated cache ".$horse.'-'.$currentTime.'-'.$durationSeconds."\n";
        }
    }
}
