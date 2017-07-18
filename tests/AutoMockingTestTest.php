<?php
declare(strict_types = 1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use Tests\Dummy\DummyTest;

class AutoMockingTestTest extends TestCase
{
    public function testTestShouldNotBeRiskyWhenItHasProphecyExpectations()
    {
        $riskyTest = new DummyTest('testWithProphecyExpectations');

        $riskyTest->runBare();

        $this->assertSame(1, $riskyTest->getNumAssertions());
    }

    public function testTestShouldBeRiskyWhenItHasNoAssertions()
    {
        $riskyTest = new DummyTest('testWithoutAssertions');

        $riskyTest->runBare();

        $this->assertSame(0, $riskyTest->getNumAssertions());
    }
}
