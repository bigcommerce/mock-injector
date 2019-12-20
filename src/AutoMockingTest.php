<?php
namespace Bigcommerce\MockInjector;

use Bigcommerce\Injector\InjectorInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\MethodProphecy;
use Prophecy\Prophet;

/**
 * Configured PHPUnit TestCase providing auto-mocking of dependency injection components using the
 * BigCommerce Injector.
 * Either extend it, or copy its setUp/tearDown methods to your own test cases. "MockInjector" is self contained.
 * @package Bigcommerce\MockInjector
 */
abstract class AutoMockingTest extends TestCase
{
    /** @var InjectorInterface|MockInjector */
    protected $injector;

    /** @var Prophet */
    private $mockingContainerProphet;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->mockingContainerProphet = new Prophet();
        $this->injector = new MockInjector(new ProphecyMockingContainer($this->mockingContainerProphet));
    }

    /**
     * Create an instance of $className and automatically mock all its constructor dependencies.
     * @param string $className The FQCN of the class we are creating
     * @param array $parameters Any parameters to pass to the constructor. Can be keyed by type, name or position.
     * @return object
     */
    protected function createWithMocks($className, $parameters = [])
    {
        return $this->injector->create($className, $parameters);
    }

    /**
     * Tears down the fixture, for example, close a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown(): void
    {
        parent::tearDown();
        $this->injector->checkPredictions();

        foreach ($this->mockingContainerProphet->getProphecies() as $objectProphecy) {
            foreach ($objectProphecy->getMethodProphecies() as $methodProphecies) {
                /** @var MethodProphecy[] $methodProphecies */
                foreach ($methodProphecies as $methodProphecy) {
                    $this->addToAssertionCount(count($methodProphecy->getCheckedPredictions()));
                }
            }
        }
    }
}
