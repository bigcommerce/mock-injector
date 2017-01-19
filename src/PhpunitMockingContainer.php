<?php
declare(strict_types = 1);
namespace Bigcommerce\MockInjector;

use PHPUnit_Framework_MockObject_MockBuilder;
use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;

class PhpunitMockingContainer implements MockingContainerInterface
{
    /**
     * @var PHPUnit_Framework_TestCase
     */
    private $testCase;

    /**
     * Collection of mocks we've auto-created keyed by their FQCN
     * @var PHPUnit_Framework_MockObject_MockBuilder[]
     */
    private $mocks = [];

    /**
     * PhpunitMockingContainer constructor.
     * @param PHPUnit_Framework_TestCase $testCase
     */
    public function __construct(PHPUnit_Framework_TestCase $testCase)
    {
        $this->testCase = $testCase;
    }

    /**
     * Fetch an existing (or create a new mock) and pass it to the injector.
     * @param string $id
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    public function get($id)
    {
        return $this->createOrGetMock($id)->getMock();
    }

    /**
     * Is this an object we can mock create?
     * @param string $id
     * @return bool
     */
    public function has($id)
    {
        return (class_exists($id) || interface_exists($id));
    }

    /**
     * Check any expectation failures raised by the mock library.
     */
    public function checkPredictions()
    {
        return;
    }

    /**
     * Fetch one of the mocks that was auto-created by the MockInjector to construct objects used in the current test,
     * so that you can set expectations or configure mock methods.
     * @param string $mockClassName FQCN of the dependency we mocked
     * @return PHPUnit_Framework_MockObject_MockBuilder
     * @throws \InvalidArgumentException
     */
    public function getMock($mockClassName)
    {
        if (!isset($this->mocks[$mockClassName])) {
            throw new \InvalidArgumentException(
                "The MockInjector did not create a '$mockClassName' mock so it can not be retrieved."
            );
        }

        return $this->mocks[$mockClassName];
    }

    /**
     * Fetch all of the mocks that was auto-created by the MockInjector to construct objects used in the current test,
     * so that you can set expectations or configure mock methods.
     * @return PHPUnit_Framework_MockObject_MockBuilder[]
     */
    public function getAllMocks()
    {
        return $this->mocks;
    }

    /**
     * Fetch a mock that has already been created for the given class, or create a new one.
     * @param string $mockClassName
     * @return PHPUnit_Framework_MockObject_MockBuilder
     */
    private function createOrGetMock($mockClassName)
    {
        if (!isset($this->mocks[$mockClassName])) {
            $this->mocks[$mockClassName] = $this->testCase->getMockBuilder($mockClassName)
                ->disableOriginalConstructor()
                ->disableOriginalClone()
                ->disableProxyingToOriginalMethods();
        }
        return $this->mocks[$mockClassName];
    }
}
