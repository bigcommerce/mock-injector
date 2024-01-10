<?php

namespace Tests\Dummy;

/**
 * Dummy class that the Injector can easily create as a dependency
 */
class DummyDependency
{

    public function __construct(
        private readonly DummySubDependency $dependency
    )
    {
    }

    public function getDependency(): DummySubDependency
    {
        return $this->dependency;
    }
}
