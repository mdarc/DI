<?php

use Mdarc\DI\Container;
use Mdarc\DI\Test\UnitTest\TestClasses\OneParamConstructor;
use PHPUnit\Framework\TestCase;

class ParameterCallbackTest extends TestCase
{
    public function test_ParameterCallback()
    {
        $constructorParameters = [
            OneParamConstructor::class => [
                'pepe' => function () { return date('Y-m-d'); },
            ]
        ];
        $container = new Container([], $constructorParameters);

        /** @var OneParamConstructor $object */
        $object = $container->get(OneParamConstructor::class);
        $this->assertInstanceOf(OneParamConstructor::class, $object);
        $this->assertEquals(date('Y-m-d'), $object->getPepe());
    }
}
