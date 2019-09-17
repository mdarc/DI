<?php

require_once '../../vendor/autoload.php';

use DI\ContainerBuilder;
use JBZoo\Profiler\Benchmark;
use Mdarc\DI\Container;
use Mdarc\DI\Test\UnitTest\TestClasses\ClassWithoutConstructor;
use Psr\Container\ContainerInterface;

Benchmark::compare([
    'mdarc/DI (class defined in constructor)' => function () {
        $DiContainer = new Container([
            ClassWithoutConstructor::class => function (ContainerInterface $c) {
                return new ClassWithoutConstructor();
            }
        ]);
        $classWithoutConstructor = $DiContainer->get(ClassWithoutConstructor::class);
    },
    'mdarc/DI (autowiring - aka Reflection)' => function () {
        $DiContainer = new Container();
        $classWithoutConstructor = $DiContainer->get(ClassWithoutConstructor::class);
    },
], ['count' => 100000, 'name' => 'Defined class vs. Autowiring']);
