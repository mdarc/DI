<?php

namespace Mdarc\DI\Test\UnitTest\TestClasses;

class CircularB
{
    /** @var CircularA */
    private $circularA;

    /**
     * CircularB constructor.
     *
     * @param CircularA $circularA
     */
    public function __construct(CircularA $circularA)
    {
        $this->circularA = $circularA;
    }
}
