<?php
namespace Bigcommerce\MockInjector;

use Bigcommerce\Injector\InjectorInterface;
use PHPUnit\Framework\TestCase;

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

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->injector = new MockInjector();
    }

    /**
     * Create an instance of $className and automatically mock all its constructor dependencies.
     * @param string $className The FQCN of the class we are creating
     * @param array $parameters Any parameters to pass to the constructor. Can be keyed by type, name or position.
     * @return object
     * @deprecated
     * @see createWithMocks()
     */
    protected function autoMock($className, $parameters = [])
    {
        return $this->injector->create($className, $parameters);
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
    protected function tearDown()
    {
        parent::tearDown();
        $this->injector->checkPredictions();
    }
}
