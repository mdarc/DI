<?php

namespace Mdarc\DI\Test\UnitTest\TestClasses;

class Foo
{
    /** @var Baz */
    private $baz;

    /**
     * Foo constructor.
     *
     * @param Baz $baz
     */
    public function __construct(Baz $baz)
    {
        $this->baz = $baz;
    }

    /**
     * @return Baz
     */
    public function getBaz(): Baz
    {
        return $this->baz;
    }
}
