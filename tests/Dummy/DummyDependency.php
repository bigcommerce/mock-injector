<?php
namespace Tests\Dummy;

/**
 * Dummy class that the Injector can easily create as a dependency
 */
class DummyDependency
{
    /**
     * @var bool
     */
    private $enabled;

    /**
     * @var DummySubDependency
     */
    private $dependency;

    /**
     * DummyDependency constructor.
     * @param DummySubDependency $dependency
     * @param bool $enabled
     */
    public function __construct(DummySubDependency $dependency, $enabled = true)
    {
        $this->enabled = $enabled;
        $this->dependency = $dependency;
    }

    /**
     * @return boolean
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * @return DummySubDependency
     */
    public function getDependency()
    {
        return $this->dependency;
    }
}
