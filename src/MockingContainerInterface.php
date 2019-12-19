<?php
declare(strict_types = 1);
namespace Bigcommerce\MockInjector;

use Prophecy\Prophecy\ObjectProphecy;
use Psr\Container\ContainerInterface;

interface MockingContainerInterface extends ContainerInterface
{
    /**
     * Check any expectation failures raised by the mock library.
     */
    public function checkPredictions();

    /**
     * Fetch one of the mocks that was auto-created by the MockInjector to construct objects used in the current test,
     * so that you can set expectations or configure mock methods.
     * @param string $mockClassName FQCN of the dependency we mocked
     * @return ObjectProphecy
     */
    public function getMock($mockClassName);

    /**
     * Fetch all of the mocks that was auto-created by the MockInjector to construct objects used in the current test,
     * so that you can set expectations or configure mock methods.
     * @return ObjectProphecy[]
     */
    public function getAllMocks();

    /**
     * Set a prophecy to be used by the injector rather than creating on demand.
     * @param string $mockClassName
     * @param ObjectProphecy $mock
     * @return void
     */
    public function setMock(string $mockClassName, ObjectProphecy $mock);
}
