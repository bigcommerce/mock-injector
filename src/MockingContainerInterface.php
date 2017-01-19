<?php
declare(strict_types = 1);
namespace Bigcommerce\MockInjector;

use Interop\Container\ContainerInterface;
use PHPUnit_Framework_MockObject_MockObject;
use Prophecy\Prophecy\ObjectProphecy;

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
     * @return ObjectProphecy|PHPUnit_Framework_MockObject_MockObject
     */
    public function getMock($mockClassName);

    /**
     * Fetch all of the mocks that was auto-created by the MockInjector to construct objects used in the current test,
     * so that you can set expectations or configure mock methods.
     * @return ObjectProphecy[]|PHPUnit_Framework_MockObject_MockObject[]
     */
    public function getAllMocks();
}
