<?php

class BitcoindJsonRpcClientTest extends \PHPUnit_Framework_TestCase
{
    function test1()
    {
        $cli = new \Bitcoind\JsonRpcClient();
        $cli->setPort(8332);
        $cli->setHost('battle');
        $cli->setUsername('mimikry');
        $cli->setPassword('dfg8ds89fgysd98fgy2kjh3k2h3k1hgk2ga0al0a10ls1k1dkrutxmz');

        // uses __call()
        $res = $cli->getInfo();

        $this->assertGreaterThanOrEqual(200, $res->httpCode);

        $this->assertGreaterThanOrEqual(90201, $res->result->version);
        $this->assertGreaterThanOrEqual(70002, $res->result->protocolversion);
        $this->assertGreaterThanOrEqual(60000, $res->result->walletversion);
    }
/*
    function test2()
    {
        $cli = new \Bitcoind\JsonRpcClient();
        $cli->setPort(8332);
        $cli->setHost('battle');
        $cli->setUsername('mimikry');
        $cli->setPassword('dfg8ds89fgysd98fgy2kjh3k2h3k1hgk2ga0al0a10ls1k1dkrutxmz');

//thepiratebay.org bitcoin address:
        $res = $cli->getaccount(array('1KeBs4HBQzkdHC2ou3gpyGHqcL7aKzwTve'));

        var_dump($res);
    }*/
}
