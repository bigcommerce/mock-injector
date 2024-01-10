<?php
namespace Tests;

use Bigcommerce\Injector\InjectorInterface;
use Bigcommerce\MockInjector\AutoMockingTest;
use Bigcommerce\MockInjector\MockInjector;
use Bigcommerce\MockInjector\ProphecyMockingContainer;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;
use Tests\Dummy\DummyDependency;
use Tests\Dummy\DummySubDependency;

/**
 * @coversDefaultClass \Bigcommerce\MockInjector\MockInjector
 */
class MockInjectorTest extends AutoMockingTest
{
    /** @var  ObjectProphecy|ProphecyMockingContainer */
    private $mockContainer;
    /** @var  ObjectProphecy|InjectorInterface */
    private $mockInjector;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mockContainer = $this->prophesize(ProphecyMockingContainer::class);
        $this->mockInjector = $this->prophesize(InjectorInterface::class);
    }

    /**
     * @covers ::create
     */
    public function testCreate() : void
    {
        $this->mockInjector->create("abc123", [1 => "hello"])->willReturn("cat")->shouldBeCalledTimes(1);
        $i = new MockInjector($this->mockContainer->reveal(), $this->mockInjector->reveal());
        $this->assertEquals("cat", $i->create("abc123", [1 => "hello"]));
    }

    /**
     * @covers ::invoke
     */
    public function testInvoke() : void
    {
        $obj = new \stdClass();
        $this->mockInjector->invoke($obj, "method1", [1 => "hello"])->willReturn("fish")->shouldBeCalledTimes(1);
        $i = new MockInjector($this->mockContainer->reveal(), $this->mockInjector->reveal());
        $this->assertEquals("fish", $i->invoke($obj, "method1", [1 => "hello"]));
    }

    /**
     * @covers ::checkPredictions
     */
    public function testCheckPredictions() : void
    {
        $this->mockContainer->checkPredictions()->shouldBeCalledTimes(1);
        $i = new MockInjector($this->mockContainer->reveal(), $this->mockInjector->reveal());
        $i->checkPredictions();
    }

    /**
     * @covers ::getAllMocks
     */
    public function testGetAllMocks() : void
    {
        $this->mockContainer->getAllMocks()->willReturn([1, 2, 6])->shouldBeCalledTimes(1);
        $i = new MockInjector($this->mockContainer->reveal(), $this->mockInjector->reveal());
        $this->assertEquals([1, 2, 6], $i->getAllMocks());
    }

    /**
     * @covers ::getMock
     */
    public function testGetMock() : void
    {
        $dummy = new \stdClass();
        $this->mockContainer->getMock("blah")->willReturn($dummy)->shouldBeCalledTimes(1);
        $i = new MockInjector($this->mockContainer->reveal(), $this->mockInjector->reveal());
        $this->assertEquals($dummy, $i->getMock("blah"));
    }

    /**
     * This is a live integration test. We wont provide any dependencies (so use poor mans DI)
     * and will instantiate an object with an auto-mocked dependency.
     * @covers ::__construct
     */
    public function testWithoutDependencies() : void
    {
        $i = new MockInjector();
        /** @var DummyDependency $obj */
        $obj = $i->create(DummyDependency::class);
        $this->assertInstanceOf(DummySubDependency::class, $obj->getDependency());
        // Whilst we are an instance of DummySubDependency, we should be a mock.
        $this->assertNotEquals(DummySubDependency::class, get_class($obj->getDependency()));
        $this->assertEquals($i->getMock(DummySubDependency::class)->reveal(), $obj->getDependency());
    }
}
