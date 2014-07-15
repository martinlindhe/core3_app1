<?php
/**
 * generates a ip-blocklist of all ip's from the tor consensus file
 */

 $reader = new ReaderTorNodes();
 $nodes = $reader->parse();


$ips = array();
foreach ($nodes->routers as $router) {
    if (!in_array($router->ip, $ips)) {
        $ips[] = $router->ip;
    }
}

foreach ($nodes->dirSources as $dirSource) {
    if (!in_array($dirSource->ip, $ips)) {
        $ips[] = $dirSource->ip;
    }
}

echo '# tor-consensus: extracted '.count($ips).' IPs out of '.count($nodes->routers).' routers, '.count($nodes->dirSources).' dir-sources'."\n";
echo '# generated '.date('r')."\n\n";

// TODO which are dupes?
foreach ($ips as $ip) {
    echo "iptables -A INPUT -s ".$ip." -j DROP\n";
}
