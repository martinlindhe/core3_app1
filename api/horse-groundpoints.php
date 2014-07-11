<?php

// TODO cache to disk

$objs = ReaderCsvHagenPos::parseToObjects(__DIR__.'/../horse-data/pos4.csv');
echo \Writer\Json::encodeSlim($objs);
