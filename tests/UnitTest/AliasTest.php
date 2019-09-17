<?php

use Mdarc\DI\Container;
use Mdarc\DI\Test\UnitTest\TestClasses\Foo;
use PHPUnit\Framework\TestCase;

class AliasTest extends TestCase
{
    public function test_Alias()
    {
        $definitions = [
            'pepe' => Foo::class
        ];
        $container = new Container($definitions);

        /** @var Foo $object */
        $object = $container->get('pepe');
        $this->assertInstanceOf(Foo::class, $object);
    }
}
