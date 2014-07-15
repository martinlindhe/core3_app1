<?php

/**
 * @group Reader
 */
class ReaderTorNodesTest extends \PHPUnit_Framework_TestCase
{
    function test1()
    {
        $x = new ReaderTorNodes();
        $res = $x->parse();

        $this->assertInstanceOf('TorConsensusResult', $res);

        $this->assertEquals(9, count($res->dirSources));

        // was 5850 at 2014-07-12
        $this->assertGreaterThan(5000, count($res->routers));

        $this->assertEquals('14C131DFC5C6F93646BE72FA1401C02A8DF2E8B4', $res->dirSources[0]->identity); // tor26
        $this->assertEquals('27B6B5996C426270A5C95488AA5BCEB6BCC86956', $res->dirSources[1]->identity); // turtles
        $this->assertEquals('49015F787433103580E3B66A1707A00E60F2D15B', $res->dirSources[2]->identity); // maatuska
        $this->assertEquals('585769C78764D58426B8B52B6651A5A71137189A', $res->dirSources[3]->identity); // dannenberg
        $this->assertEquals('80550987E1D626E3EBA5E5E75A458DE0626D088C', $res->dirSources[4]->identity); // urras
        $this->assertEquals('D586D18309DED4CD6D57C18FDB97EFA96D330566', $res->dirSources[5]->identity); // moria1
        $this->assertEquals('E8A9C45EDE6D711294FADF8E7951F4DE6CA56B58', $res->dirSources[6]->identity); // dizum
        $this->assertEquals('ED03BB616EB2F60BEC80151114BB25CEF515B226', $res->dirSources[7]->identity); // gabelmoo
        $this->assertEquals('EFCBE720AB3A82B99F9E953CD5BF50F7EEFC7B97', $res->dirSources[8]->identity); // Faravahar
    }
}
