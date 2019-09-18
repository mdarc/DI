<?php

use Mdarc\DI\Container;
use Mdarc\DI\Exceptions\NotFoundException;
use Mdarc\DI\DI;
use Mdarc\DI\Test\UnitTest\TestClasses\Baz;
use Mdarc\DI\Test\UnitTest\TestClasses\Foo;
use PHPUnit\Framework\TestCase;

class InstantiationTest extends TestCase
{
    public function test_SameInstanceAlways()
    {
        $container = new Container();

        /** @var Foo $foo */
        $foo = $container->get(Foo::class);
        /** @var Foo $fooAnotherInstance */
        $fooAnotherInstance = $container->get(Foo::class);

        $this->assertInstanceOf(Foo::class, $foo);
        $this->assertInstanceOf(Foo::class, $fooAnotherInstance);
        $this->assertSame($foo, $fooAnotherInstance);
    }

    public function test_Factory()
    {
        $container = new Container([
            Baz::class => DI::factory(function() {
                return new Baz();
            })
        ]);

        $baz = $container->get(Baz::class);
        $anotherBar = $container->get(Baz::class);
        $this->assertInstanceOf(Baz::class, $baz);
        $this->assertInstanceOf(Baz::class, $anotherBar);
        $this->assertNotSame($baz, $anotherBar);
    }

    public function test_NonExistingClassThrowsException()
    {
        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage("Exception building 'pepe': Class pepe does not exist");

        $container = new Container();
        $container->get('pepe');
    }

    public function test_InstantiateWithoutWiring()
    {
        $container = new Container([
            'a_baz' => function() {
                return new Baz();
            },
        ]);

        $baz = $container->get('a_baz');
        $this->assertInstanceOf(Baz::class, $baz);
    }

    public function test_ArrayConfig()
    {
        $container = new Container([
            'a_pepe' => ['pepe'],
        ]);

        $pepe = $container->get('a_pepe');
        $this->assertIsArray($pepe);
    }

    public function test_Has()
    {
        $container = new Container();
        $this->assertTrue($container->has("something"));
    }

    public function test_Set()
    {
        $container = new Container();
        $container->set(Baz::class, new Baz());

        $baz = $container->get(Baz::class);
        $this->assertInstanceOf(Baz::class, $baz);
    }
}
