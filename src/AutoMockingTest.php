<?php
namespace Bigcommerce\TestInjector;

use Bigcommerce\Injector\InjectorInterface;

/**
 * Configured PHPUnit TestCase providing auto-mocking of dependency injection components using the
 * BigCommerce Injector.
 * Either extend it, or copy its setUp/tearDown methods to your own test cases. "TestInjector" is self contained.
 * @package Bigcommerce\TestInjector
 */
abstract class AutoMockingTest extends \PHPUnit_Framework_TestCase
{
    /** @var InjectorInterface|TestInjector */
    protected $injector;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->injector = new TestInjector();
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