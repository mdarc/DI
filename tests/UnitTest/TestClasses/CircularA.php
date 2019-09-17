<?php

namespace Mdarc\DI\Test\UnitTest\TestClasses;

class CircularA
{
    /** @var CircularB */
    private $circularB;

    /**
     * CircularA constructor.
     *
     * @param CircularB $circularB
     */
    public function __construct(CircularB $circularB)
    {
        $this->circularB = $circularB;
    }
}
