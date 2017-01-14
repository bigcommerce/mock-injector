<?php
namespace Tests;

use Bigcommerce\Injector\InjectorInterface;
use Bigcommerce\TestInjector\MockingContainer;
use Bigcommerce\TestInjector\TestInjector;
use Prophecy\Prophecy\ObjectProphecy;
use Tests\Dummy\DummyDependency;
use Tests\Dummy\DummySubDependency;

/**
 *
 * @coversDefaultClass \Bigcommerce\TestInjector\TestInjector
 */
class TestInjectorTest extends \PHPUnit_Framework_TestCase
{
    /** @var  ObjectProphecy|MockingContainer */
    private $mockContainer;
    /** @var  ObjectProphecy|InjectorInterface */
    private $injector;

    protected function setUp()
    {
        parent::setUp();
        $this->mockContainer = $this->prophesize(MockingContainer::class);
        $this->injector = $this->prophesize(InjectorInterface::class);
    }

    /**
     * @covers ::create
     */
    public function testCreate()
    {
        $this->injector->create("abc123", [1 => "hello"])->willReturn("cat")->shouldBeCalledTimes(1);
        $i = new TestInjector($this->mockContainer->reveal(), $this->injector->reveal());
        $this->assertEquals("cat", $i->create("abc123", [1 => "hello"]));
    }

    /**
     * @covers ::invoke
     */
    public function testInvoke()
    {
        $obj = new \stdClass();
        $this->injector->invoke($obj, "method1", [1 => "hello"])->willReturn("fish")->shouldBeCalledTimes(1);
        $i = new TestInjector($this->mockContainer->reveal(), $this->injector->reveal());
        $this->assertEquals("fish", $i->invoke($obj, "method1", [1 => "hello"]));
    }

    /**
     * @covers ::checkPredictions
     */
    public function testCheckPredictions()
    {
        $this->mockContainer->checkPredictions()->shouldBeCalledTimes(1);
        $i = new TestInjector($this->mockContainer->reveal(), $this->injector->reveal());
        $i->checkPredictions();
    }

    /**
     * @covers ::getAllMocks
     */
    public function testGetAllMocks()
    {
        $this->mockContainer->getAllMocks()->willReturn([1, 2, 6])->shouldBeCalledTimes(1);
        $i = new TestInjector($this->mockContainer->reveal(), $this->injector->reveal());
        $this->assertEquals([1, 2, 6], $i->getAllMocks());
    }

    /**
     * @covers ::getMock
     */
    public function testGetMock()
    {
        $dummy = new \stdClass();
        $this->mockContainer->getMock("blah")->willReturn($dummy)->shouldBeCalledTimes(1);
        $i = new TestInjector($this->mockContainer->reveal(), $this->injector->reveal());
        $this->assertEquals($dummy, $i->getMock("blah"));
    }

    /**
     * This is a live integration test. We wont provide any dependencies (so use poor mans DI)
     * and will instantiate an object with an auto-mocked dependency.
     * @covers ::__construct
     */
    public function testWithoutDependencies()
    {
        $i = new TestInjector();
        /** @var DummyDependency $obj */
        $obj = $i->create(DummyDependency::class);
        $this->assertInstanceOf(DummySubDependency::class, $obj->getDependency());
        // Whilst we are an instance of DummySubDependency, we should be a mock.
        $this->assertNotEquals(DummySubDependency::class, get_class($obj->getDependency()));
        $this->assertEquals($i->getMock(DummySubDependency::class)->reveal(), $obj->getDependency());
    }
}
