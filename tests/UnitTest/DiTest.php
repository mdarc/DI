<?php

use Mdarc\DI\Container;
use PHPUnit\Framework\TestCase;

class DiTest extends TestCase
{
    public function test_buildContainer()
    {
        $container = \Mdarc\DI\DI::buildContainer();
        $this->assertInstanceOf(Container::class, $container);
        $this->assertInstanceOf(\Psr\Container\ContainerInterface::class, $container);
    }

    public function testFactory()
    {
        $factoryClass = \Mdarc\DI\DI::factory(function () {});
        $this->assertInstanceOf(\Mdarc\DI\Factory::class, $factoryClass);
    }
}
