<?php
class FilterGroupTest extends PHPUnit_Framework_TestCase
{

    public function testFilterInterface()
    {
        $a = new \CrazyCodr\Data\Filter\FilterGroup();
        $this->assertInstanceOf('\CrazyCodr\Data\Filter\FilterInterface', $a);
    }

    public function testFilterContainerInterface()
    {
        $a = new \CrazyCodr\Data\Filter\FilterGroup();
        $this->assertInstanceOf('\CrazyCodr\Data\Filter\FilterContainerInterface', $a);
    }

    public function testFilterType()
    {
        $a = new \CrazyCodr\Data\Filter\FilterGroup();
        $this->assertEquals($a->getContainerType(), \CrazyCodr\Data\Filter\FilterContainerInterface::CONTAINER_TYPE_ALL);
    }

    public function testFilterType2()
    {
        $a = new \CrazyCodr\Data\Filter\FilterGroup(\CrazyCodr\Data\Filter\FilterContainerInterface::CONTAINER_TYPE_ANY);
        $this->assertEquals($a->getContainerType(), \CrazyCodr\Data\Filter\FilterContainerInterface::CONTAINER_TYPE_ANY);
    }

    public function testGetFilters()
    {
        $a = new \CrazyCodr\Data\Filter\FilterGroup();
        $this->assertCount(0, $a->getFilters());
    }

    public function testAddFilterWithoutName()
    {
        $a = new \CrazyCodr\Data\Filter\FilterGroup();
        $a->addFilter(new \CrazyCodr\Data\Filter\ClosureFilter(function($a){ return true; }));
        $this->assertCount(1, $a->getFilters());
    }

    public function testAddFilterWithName()
    {
        $a = new \CrazyCodr\Data\Filter\FilterGroup();
        $newName = $a->addFilter(new \CrazyCodr\Data\Filter\ClosureFilter(function($a){ return true; }), 'testFilter');
        $this->assertEquals($newName, 'testFilter');
    }

    public function testAddFilters()
    {
        $a = new \CrazyCodr\Data\Filter\FilterGroup();
        $a->addFilter(new \CrazyCodr\Data\Filter\ClosureFilter(function($a){ return true; }));
        $a->addFilter(new \CrazyCodr\Data\Filter\ClosureFilter(function($a){ return true; }));
        $a->addFilter(new \CrazyCodr\Data\Filter\ClosureFilter(function($a){ return true; }));
        $a->addFilter(new \CrazyCodr\Data\Filter\ClosureFilter(function($a){ return true; }));
        $this->assertCount(4, $a->getFilters());
    }

    /**
     * @expectedException \CrazyCodr\Data\Filter\FilterNotFoundException
     */
    public function testSetInexistantFilter()
    {
        $a = new \CrazyCodr\Data\Filter\FilterGroup();
        $c = new \CrazyCodr\Data\Filter\ClosureFilter(function($a){ return true; });
        $a->setFilter($c, 'testFilter');
    }

    public function testSetExistantFilter()
    {
        $a = new \CrazyCodr\Data\Filter\FilterGroup();
        $c = new \CrazyCodr\Data\Filter\ClosureFilter(function($a){ return true; });
        $a->addFilter($c, 'testFilter');
        $this->assertEquals($a->setFilter($c, 'testFilter'), 'testFilter');
    }

    public function testHasFilter()
    {
        $a = new \CrazyCodr\Data\Filter\FilterGroup();
        $c = new \CrazyCodr\Data\Filter\ClosureFilter(function($a){ return true; });
        $a->addFilter($c, 'testFilter');
        $this->assertTrue($a->hasFilter('testFilter'));
    }

    public function testHasFilterNotFound()
    {
        $a = new \CrazyCodr\Data\Filter\FilterGroup();
        $c = new \CrazyCodr\Data\Filter\ClosureFilter(function($a){ return true; });
        $this->assertFalse($a->hasFilter('testFilter'));
    }

    public function testRemoveFilter()
    {
        $a = new \CrazyCodr\Data\Filter\FilterGroup();
        $c = new \CrazyCodr\Data\Filter\ClosureFilter(function($a){ return true; });
        $a->addFilter($c, 'testFilter');
        $a->removeFilter('testFilter');
        $this->assertFalse($a->hasFilter('testFilter'));
    }

    /**
     * @expectedException \CrazyCodr\Data\Filter\FilterNotFoundException
     */
    public function testRemoveFilterNotFound()
    {
        $a = new \CrazyCodr\Data\Filter\FilterGroup();
        $c = new \CrazyCodr\Data\Filter\ClosureFilter(function($a){ return true; });
        $a->removeFilter('testFilter');
    }

    public function testClearFilters()
    {
        $a = new \CrazyCodr\Data\Filter\FilterGroup();
        $a->addFilter(new \CrazyCodr\Data\Filter\ClosureFilter(function($a){ return true; }));
        $a->addFilter(new \CrazyCodr\Data\Filter\ClosureFilter(function($a){ return true; }));
        $a->addFilter(new \CrazyCodr\Data\Filter\ClosureFilter(function($a){ return true; }));
        $a->addFilter(new \CrazyCodr\Data\Filter\ClosureFilter(function($a){ return true; }));
        $a->clearFilters();
        $this->assertCount(0, $a->getFilters());
    }

    public function testGetFilter()
    {
        $a = new \CrazyCodr\Data\Filter\FilterGroup();
        $newname = $a->addFilter($c = new \CrazyCodr\Data\Filter\ClosureFilter(function($a){ return true; }));
        $this->assertEquals($a->getFilter($newname), $c);
    }

    public function testGetNamedFilter()
    {
        $a = new \CrazyCodr\Data\Filter\FilterGroup();
        $a->addFilter($c = new \CrazyCodr\Data\Filter\ClosureFilter(function($a){ return true; }), 'testFilter');
        $this->assertEquals($a->getFilter('testFilter'), $c);
    }

    public function testANYAggregation()
    {
        $a = new \CrazyCodr\Data\Filter\FilterGroup(\CrazyCodr\Data\Filter\FilterContainerInterface::CONTAINER_TYPE_ANY);
        $b = new \CrazyCodr\Data\Filter\ClosureFilter(function($a){ return true; });
        $c = new \CrazyCodr\Data\Filter\ClosureFilter(function($a){ return false; });
        $a->addFilter($b);
        $a->addFilter($c);
        $this->assertTrue($a->shouldKeep('data', 'key'));
    }

    public function testANYAggregation2()
    {
        $a = new \CrazyCodr\Data\Filter\FilterGroup(\CrazyCodr\Data\Filter\FilterContainerInterface::CONTAINER_TYPE_ANY);
        $b = new \CrazyCodr\Data\Filter\ClosureFilter(function($a){ return false; });
        $c = new \CrazyCodr\Data\Filter\ClosureFilter(function($a){ return true; });
        $a->addFilter($b);
        $a->addFilter($c);
        $this->assertTrue($a->shouldKeep('data', 'key'));
    }

    public function testANYAggregation3()
    {
        $a = new \CrazyCodr\Data\Filter\FilterGroup(\CrazyCodr\Data\Filter\FilterContainerInterface::CONTAINER_TYPE_ANY);
        $b = new \CrazyCodr\Data\Filter\ClosureFilter(function($a){ return false; });
        $c = new \CrazyCodr\Data\Filter\ClosureFilter(function($a){ return false; });
        $a->addFilter($b);
        $a->addFilter($c);
        $this->assertFalse($a->shouldKeep('data', 'key'));
    }

    public function testANYAggregation4()
    {
        $a = new \CrazyCodr\Data\Filter\FilterGroup(\CrazyCodr\Data\Filter\FilterContainerInterface::CONTAINER_TYPE_ANY);
        $b = new \CrazyCodr\Data\Filter\ClosureFilter(function($a){ return true; });
        $c = new \CrazyCodr\Data\Filter\ClosureFilter(function($a){ return true; });
        $a->addFilter($b);
        $a->addFilter($c);
        $this->assertTrue($a->shouldKeep('data', 'key'));
    }

    public function testALLAggregation()
    {
        $a = new \CrazyCodr\Data\Filter\FilterGroup();
        $b = new \CrazyCodr\Data\Filter\ClosureFilter(function($a){ return true; });
        $c = new \CrazyCodr\Data\Filter\ClosureFilter(function($a){ return false; });
        $a->addFilter($b);
        $a->addFilter($c);
        $this->assertFalse($a->shouldKeep('data', 'key'));
    }

    public function testALLAggregation2()
    {
        $a = new \CrazyCodr\Data\Filter\FilterGroup();
        $b = new \CrazyCodr\Data\Filter\ClosureFilter(function($a){ return false; });
        $c = new \CrazyCodr\Data\Filter\ClosureFilter(function($a){ return true; });
        $a->addFilter($b);
        $a->addFilter($c);
        $this->assertFalse($a->shouldKeep('data', 'key'));
    }

    public function testALLAggregation3()
    {
        $a = new \CrazyCodr\Data\Filter\FilterGroup();
        $b = new \CrazyCodr\Data\Filter\ClosureFilter(function($a){ return true; });
        $c = new \CrazyCodr\Data\Filter\ClosureFilter(function($a){ return true; });
        $a->addFilter($b);
        $a->addFilter($c);
        $this->assertTrue($a->shouldKeep('data', 'key'));
    }

    public function testALLAggregation4()
    {
        $a = new \CrazyCodr\Data\Filter\FilterGroup();
        $b = new \CrazyCodr\Data\Filter\ClosureFilter(function($a){ return false; });
        $c = new \CrazyCodr\Data\Filter\ClosureFilter(function($a){ return false; });
        $a->addFilter($b);
        $a->addFilter($c);
        $this->assertFalse($a->shouldKeep('data', 'key'));
    }

}