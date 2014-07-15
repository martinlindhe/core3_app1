<?php

class TorDirSource
{
    var $nickname;
    var $identity;
    var $address;
    var $ip;
    var $dirPort;
    var $orPort;
}

class TorRouter
{
    var $nickname;
    var $identity;
    var $digest;
    var $publication;
    var $ip;
    var $orPort;
    var $dirPort;
}

class TorConsensusResult
{
    var $routers = array();
    var $dirSources = array();
}

class ReaderTorNodes
{
    // aktuell url till consensus finns här: https://www.torproject.org/docs/tor-doc-relay.html.en#check
    private $consensusUrl = 'http://194.109.206.212/tor/status-vote/current/consensus';

    private $cacheFileName = '/tmp/torConsensus';
    private $cacheRawFileName = '/tmp/torConsensus.raw';

    private function get()
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->consensusUrl,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_USERAGENT => 'Codular Sample cURL Request'
        ));

        $res = curl_exec($curl);
        curl_close($curl);
        return $res;
    }

    private function updateCache($data)
    {
        file_put_contents($this->cacheFileName, serialize($data));
    }

    private function getCache()
    {
        return unserialize(file_get_contents($this->cacheFileName));
    }

    private function updateRawCache($data)
    {
        file_put_contents($this->cacheRawFileName, $data);
    }

    private function getRawCache()
    {
        return file_get_contents($this->cacheRawFileName);
    }

    private function isCacheOlderThan($sec)
    {
        if (filemtime($this->cacheFileName) < (time() - $sec)) {
            return true;
        }
        return false;
    }

    private function isCacheExpired()
    {
        if (!file_exists($this->cacheFileName)) {
            return true;
        }
        if ($this->isCacheOlderThan(3600 * 4)) {
            return true;
        }
        return false;
    }

    private function parseRouter($row)
    {
        //  "r" SP nickname SP identity SP digest SP publication SP IP SP ORPort SP DirPort NL
        $x = explode(" ", $row);
        $r = new TorRouter();
        $r->nickname = $x[1];
        $r->identity = $x[2];
        $r->digest = $x[3];
        $r->publication = $x[4].' '.$x[5];
        $r->ip = $x[6];
        $r->orPort = $x[7];
        $r->dirPort = $x[8];
        return $r;
    }

    public function parseDirSource($row)
    {
        // "dir-source" SP nickname SP identity SP address SP IP SP dirport SP orport NL
        $x = explode(" ", $row);
        $dir = new TorDirSource();
        $dir->nickname = $x[1];
        $dir->identity = $x[2];
        $dir->address = $x[3];
        $dir->ip = $x[4];
        $dir->dirPort = $x[5];
        $dir->orPort = $x[6];
        return $dir;
    }

    public function parse()
    {
        if (!$this->isCacheExpired()) {
            return $this->getCache();
        }

        $data = $this->get();

        $routers = array();
        $dirSources = array();

        foreach (explode("\n", $data) as $row) {
            if (substr($row, 0, 2) == 'r ') {
                // normal user node
                $routers[] = $this->parseRouter($row);
            } else if (substr($row, 0, 11) == 'dir-source ') {
                // top node (9 currently exist, 2014)
                $dirSources[] = $this->parseDirSource($row);
            }
        }

        $res = new TorConsensusResult();
        $res->routers = $routers;
        $res->dirSources = $dirSources;

        $this->updateCache($res);
        $this->updateRawCache($res);

        return $res;
    }
}
