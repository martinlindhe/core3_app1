<?php

class HorseData
{
    public function handleGet($param)
    {
        WriterHorseDataCache::passThru($param[0]);
    }
}
