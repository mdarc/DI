<?php

namespace Mdarc\DI\Test\UnitTest\TestClasses;

class ClassWithOneMixedParameter
{
    /** @var mixed */
    private $mixedParameter;

    /**
     * ClassWithOneUndefinedParameter constructor
     *
     * @param mixed $mixedParameter
     */
    public function __construct($mixedParameter)
    {
        $this->mixedParameter = $mixedParameter;
    }
}
