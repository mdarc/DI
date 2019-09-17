<?php

require_once '../../vendor/autoload.php';

use DI\ContainerBuilder;
use JBZoo\Profiler\Benchmark;
use Mdarc\DI\Container;
use Mdarc\DI\Test\UnitTest\TestClasses\ClassWithoutConstructor;
use Psr\Container\ContainerInterface;

Benchmark::compare([
    'php-di (development mode)' => function () {
        $builder = new ContainerBuilder();
        $builder->addDefinitions();
        $phpDi = $builder->build();
        $classWithoutConstructor = $phpDi->get(ClassWithoutConstructor::class);
    },
    'mdarc/DI' => function () {
        $container = new Container();
        $classWithoutConstructor = $container->get(ClassWithoutConstructor::class);
    },
], ['count' => 100000, 'name' => 'Autowiring - Fetch an instance of simple class without dependencies - First time']);
