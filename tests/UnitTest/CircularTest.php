<?php

use Mdarc\DI\Exceptions\CircularReferenceException;
use Mdarc\DI\Container;
use Mdarc\DI\DI;
use Mdarc\DI\Test\UnitTest\TestClasses\Baz;
use Mdarc\DI\Test\UnitTest\TestClasses\CircularA;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class CircularTest extends TestCase
{
    public function test_CircularReferencesThrowException()
    {
        $this->expectException(CircularReferenceException::class);
        $this->expectExceptionMessage("Parameter 'Mdarc\DI\Test\UnitTest\TestClasses\CircularA \$circularA' in class Mdarc\DI\Test\UnitTest\TestClasses\CircularB has a circular reference with class Mdarc\DI\Test\UnitTest\TestClasses\CircularA");

        $container = new Container();
        $container->get(CircularA::class);
    }

    public function test_CircularReferencesInFactoryThrowException()
    {
        $this->expectException(CircularReferenceException::class);
        $this->expectExceptionMessage("Factory for object 'Mdarc\DI\Test\UnitTest\TestClasses\Baz' has a circular reference with itself");

        $container = new Container([
            Baz::class => DI::factory(function(ContainerInterface $container) {
                $baz = $container->get(Baz::class);
                // Not doing anything with $baz. Just for the test.
                return new Baz();
            })
        ]);

        $container->get(Baz::class);
    }
}
