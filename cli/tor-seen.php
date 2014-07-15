<?php
// TODO write tool that collects exit node ip:s over time, store last-seen

/**
 * stores last-seen info of tor routers
 */


 // TODO use sqlite to store data?

 $x = new ReaderTorNodes();
 $res = $x->parse();

// TODO country lookup geoip

//var_dump($res);
foreach ($res->routers as $router) {
    echo 'r: '.$router->nickname.' '.$router->identity."\n";
    // TODO log last seen
}

var_dump($res->routers[10]);

foreach ($res->dirSources as $dirSource) {
    echo 'dir-source: '.$dirSource->nickname.' '.$dirSource->identity."\n";
    // TODO log last seen
}

echo 'tor-consensus: currently '.count($res->routers).' routers, '.count($res->dirSources).' dir-sources'."\n";
