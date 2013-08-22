<?php
class FilterIteratorTest extends PHPUnit_Framework_TestCase
{

    public function testFilterContainerInterface()
    {
        $a = new \CrazyCodr\Data\Filter\FilterGroup();
        $b = new \CrazyCodr\Data\Filter\FilterIterator($a);
        $this->assertInstanceOf('\CrazyCodr\Data\Filter\FilterContainerInterface', $b);
    }

    public function testDatasourceByConstructor()
    {
        $a = new \CrazyCodr\Data\Filter\FilterGroup();
        $b = array(1,2,3,4,5);
        $c = new \CrazyCodr\Data\Filter\FilterIterator($a, $b);
        $this->assertEquals($c->getDatasource(), new ArrayIterator($b));
    }

    public function testDatasourceBySetter()
    {
        $a = new \CrazyCodr\Data\Filter\FilterGroup();
        $b = array(1,2,3,4,5);
        $c = new \CrazyCodr\Data\Filter\FilterIterator($a);
        $c->setDatasource($b);
        $this->assertEquals($c->getDatasource(), new ArrayIterator($b));
    }

    /**
    * @expectedException \InvalidArgumentException
     */
    public function testInvalidDatasource()
    {
        $a = new \CrazyCodr\Data\Filter\FilterGroup();
        $b = 'hello';
        $c = new \CrazyCodr\Data\Filter\FilterIterator($a);
        $c->setDatasource($b);
    }

    public function testFilterContainer()
    {
        $a = new \CrazyCodr\Data\Filter\FilterGroup();
        $b = new \CrazyCodr\Data\Filter\FilterIterator($a);
        $this->assertEquals($b->getFilterContainer(), $a);
    }

    public function testSetFilterContainer()
    {
        $a = new \CrazyCodr\Data\Filter\FilterGroup();
        $b = new \CrazyCodr\Data\Filter\FilterGroup();
        $c = new \CrazyCodr\Data\Filter\FilterIterator($a);
        $c->setFilterContainer($b);
        $this->assertEquals($c->getFilterContainer(), $b);
    }

    public function testIteratorSupport()
    {
        $a = new \CrazyCodr\Data\Filter\FilterGroup();
        $b = array(1,2,3,4,5);
        $c = new \CrazyCodr\Data\Filter\FilterIterator($a, $b);
        $d = array();
        foreach($c as $e)
        {
            $d[] = $e;
        }
        $this->assertEquals($b, $d);
    }

}