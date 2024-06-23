<?php

declare(strict_types = 1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use Tests\Dummy\DummyTest;

class AutoMockingTestTest extends TestCase
{
    public function testTestShouldNotBeRiskyWhenItHasProphecyExpectations(): void
    {
        $riskyTest = new DummyTest('testWithProphecyExpectations');

        $riskyTest->runBare();

        $this->assertFalse($riskyTest->isRisky());

    }

    public function testTestShouldBeRiskyWhenItHasNoAssertions(): void
    {
        $riskyTest = new DummyTest('testWithoutAssertions');

        $riskyTest->runBare();

        $this->assertTrue($riskyTest->isRisky());
    }
}
