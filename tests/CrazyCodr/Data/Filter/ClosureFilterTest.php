<?php
class ClosureFilterTest extends PHPUnit_Framework_TestCase
{

    public function testFilterInterface()
    {
        $a = new \CrazyCodr\Data\Filter\ClosureFilter(function($data, $key){ return true; });
        $this->assertInstanceOf('\CrazyCodr\Data\Filter\FilterInterface', $a);
    }

    public function testClosureResult()
    {
        $a = new \CrazyCodr\Data\Filter\ClosureFilter(function($data, $key){ return true; });
        $this->assertTrue($a->shouldKeep('bah', 'sup'));
    }

    public function testClosureResult2()
    {
        $a = new \CrazyCodr\Data\Filter\ClosureFilter(function($data, $key){ return false; });
        $this->assertFalse($a->shouldKeep('bah', 'sup'));
    }

    public function testGetClosure()
    {
        $b = function($data, $key){ return false; };
        $c = function($data, $key){ return true; };
        $a = new \CrazyCodr\Data\Filter\ClosureFilter($b);
        $this->assertEquals($a->getClosure(), $b);
    }

    public function testSetClosure()
    {
        $b = function($data, $key){ return false; };
        $c = function($data, $key){ return true; };
        $a = new \CrazyCodr\Data\Filter\ClosureFilter($b);
        $a->setClosure($c);
        $this->assertEquals($a->getClosure(), $c);
    }

}