<?php

use Mdarc\DI\Container;
use Mdarc\DI\Test\UnitTest\TestClasses\Bar;
use Mdarc\DI\Test\UnitTest\TestClasses\ClassWithoutConstructor;
use PHPUnit\Framework\TestCase;

class NoConstructorTest extends TestCase
{
    public function test_NoConstructor()
    {
        $container = new Container();

        /** @var Bar $object */
        $object = $container->get(Bar::class);
        $this->assertInstanceOf(Bar::class, $object);
    }

    public function test_ClassWithoutConstructor()
    {
        $container = new Container();

        /** @var ClassWithoutConstructor $object */
        $object = $container->get(ClassWithoutConstructor::class);
        $this->assertInstanceOf(ClassWithoutConstructor::class, $object);
    }
}
