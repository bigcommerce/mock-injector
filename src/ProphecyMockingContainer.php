<?php

namespace Bigcommerce\MockInjector;

use Prophecy\Exception\Prediction\AggregateException;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;
use Prophecy\Prophet;

class ProphecyMockingContainer implements MockingContainerInterface
{
    use ProphecyTrait;

    /**
     * @var Prophet
     */
    private $prophet;

    /**
     * Collection of mocks we've auto-created keyed by their FQCN
     * @var ObjectProphecy[]
     */
    private $mocks = [];

    /**
     * MockingContainer constructor.
     * @param Prophet $prophet
     */
    public function __construct(Prophet $prophet)
    {
        $this->prophet = $prophet;
    }

    /**
     * Checks all predictions defined by prophecies of this Prophet.
     *
     * @throws AggregateException If any prediction fails
     */
    public function checkPredictions()
    {
        $this->prophet->checkPredictions();
    }

    /**
     * Fetch an existing (or create a new mock) and pass it to the injector.
     * @param string $id
     * @return mixed
     */
    public function get($id)
    {
        return $this->createOrGetMock($id)->reveal();
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
     * Fetch one of the mocks that was auto-created by the MockInjector to construct objects used in the current test,
     * so that you can set expectations or configure mock methods.
     * Alternatively, will create and return a mock which the injector will use (useful for setting expectations
     * on constructor behaviours prior to calling injector create)
     * @param string $mockClassName FQCN of the dependency we mocked
     * @return ObjectProphecy
     */
    public function getMock($mockClassName)
    {
        return $this->createOrGetMock($mockClassName);
    }

    /**
     * Set a prophecy to be used by the injector rather than creating on demand.
     * @param string $mockClassName
     * @param ObjectProphecy $mock
     * @return void
     */
    public function setMock(string $mockClassName, ObjectProphecy $mock)
    {
        $this->mocks[$mockClassName] = $mock;
    }

    /**
     * Fetch all of the mocks that was auto-created by the MockInjector to construct objects used in the current test,
     * so that you can set expectations or configure mock methods.
     * @return ObjectProphecy[]
     */
    public function getAllMocks()
    {
        return $this->mocks;
    }

    /**
     * Fetch a mock that has already been created for the given class, or create a new one.
     * @param string $mockClassName
     * @return ObjectProphecy
     */
    private function createOrGetMock($mockClassName)
    {
        if (!isset($this->mocks[$mockClassName])) {
            $this->mocks[$mockClassName] = $this->prophet->prophesize($mockClassName);
        }
        return $this->mocks[$mockClassName];
    }
}
