<?php
declare(strict_types = 1);

namespace Tests\Dummy;

use BadMethodCallException;
use Bigcommerce\MockInjector\AutoMockingTest;
use Exception;
use Prophecy\Prophecy\ObjectProphecy;

/**
 * @group dummy
 */
class DummyTest extends AutoMockingTest
{
    /**
     * This is a dummy test which is called by AutoMockInjectorTestTest. It has one expectation configured using
     * Prophecy (see `->shouldBeCalled()`), therefore there is 1 assertion and the test shouldn't be marked as Risky.
     */
    public function testWithProphecyExpectations() : void
    {
        /** @var DummyDependency $dummyDependency */
        $dummyDependency = $this->createWithMocks(DummyDependency::class);

        /** @var DummySubDependency|ObjectProphecy $subDependency */
        $subDependency = $this->injector->getProphecy(DummySubDependency::class);
        $subDependency->setEnabled(true)->shouldBeCalled();

        $dummyDependency->getDependency()->setEnabled(true);
    }

    /**
     * This is a dummy test which doesn't have any assertions, therefore is risky.
     */
    public function testWithoutAssertions() : void
    {
    }

    public function isRisky(): bool
    {
        if (is_callable([$this, 'numberOfAssertionsPerformed'])) {
            return $this->numberOfAssertionsPerformed() === 0;
        }

        if (is_callable([$this, 'getNumAssertions'])) {
            return $this->getNumAssertions() === 0;
        }

        throw new BadMethodCallException("Could not check the number of assertions performed");
    }
}
