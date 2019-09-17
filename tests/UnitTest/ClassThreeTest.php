<?php

use Mdarc\DI\Container;
use Mdarc\DI\Test\UnitTest\TestClasses\ClassThree;
use Mdarc\DI\Test\UnitTest\TestClasses\Foo;
use Mdarc\DI\Test\UnitTest\TestClasses\Bar;
use Mdarc\DI\Test\UnitTest\TestClasses\Baz;
use PHPUnit\Framework\TestCase;

class ClassThreeTest extends TestCase
{
    public function test_ParametersCorrectlySetup()
    {
        $container = new Container();

        /** @var ClassThree $class3 */
        $class3 = $container->get(ClassThree::class);
        $this->assertInstanceOf(ClassThree::class, $class3);
        $this->assertInstanceOf(Foo::class, $class3->getFoo());
        $this->assertInstanceOf(Bar::class, $class3->getBar());
        $this->assertInstanceOf(Baz::class, $class3->getFoo()->getBaz());
        $this->assertEquals('the lazy fox', $class3->getFoo()->getBaz()->getText());
    }
}
