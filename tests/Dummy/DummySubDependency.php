<?php
namespace Tests\Dummy;

class DummySubDependency
{
    /**
     * @var bool
     */
    private $enabled;

    /**
     * DummySubDependency constructor.
     * @param bool $enabled
     */
    public function __construct($enabled = true)
    {
        $this->enabled = $enabled;
    }

    /**
     * @return boolean
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param boolean $enabled
     * @return void
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }
}
