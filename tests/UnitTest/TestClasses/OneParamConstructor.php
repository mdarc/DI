<?php

namespace Mdarc\DI\Test\UnitTest\TestClasses;

class OneParamConstructor
{
    /** @var string */
    private $pepe = '';

    /**
     * OneParamConstructor constructor.
     *
     * @param string $pepe
     */
    public function __construct(string $pepe = '')
    {
        $this->pepe = $pepe;
    }

    public function getPepe(): string
    {
        return $this->pepe;
    }
}
