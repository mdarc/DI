<?php

use Mdarc\DI\Container;
use Mdarc\DI\Test\UnitTest\TestClasses\ClassWithOneMixedParameter;
use PHPUnit\Framework\TestCase;

class ClassWithOneMixedParameterTest extends TestCase
{
    public function test_ParametersCorrectlySetup()
    {
        $container = new Container([], [
            ClassWithOneMixedParameter::class => [
                'mixedParameter' => 'pepe'
            ]
        ]);

        $classWithOneMixedParameter = $container->get(ClassWithOneMixedParameter::class);
        $this->assertInstanceOf(ClassWithOneMixedParameter::class, $classWithOneMixedParameter);
    }
}
