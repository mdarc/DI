<?php

require_once '../../vendor/autoload.php';

use DI\ContainerBuilder;
use JBZoo\Profiler\Benchmark;
use Mdarc\DI\Container;
use Mdarc\DI\Test\UnitTest\TestClasses\ClassWithoutConstructor;
use Psr\Container\ContainerInterface;

if (file_exists(__DIR__ . '/tmp/CompiledContainer.php')) {
    @unlink(__DIR__ . '/tmp/CompiledContainer.php');
    @rmdir(__DIR__ . '/tmp');
}

Benchmark::compare([
    'pimple' => function () {
        $pimple = new \Pimple\Container([
            ClassWithoutConstructor::class => function ($c) {
                return new ClassWithoutConstructor();
            }
        ]);
        $classWithoutConstructor = $pimple[ClassWithoutConstructor::class];
    },
    'php-di' => function () {
        $builder = new ContainerBuilder();
        $builder->addDefinitions([
            ClassWithoutConstructor::class => function (ContainerInterface $c) {
                return new ClassWithoutConstructor();
            }
        ]);
        $phpDi = $builder->build();
        $classWithoutConstructor = $phpDi->get(ClassWithoutConstructor::class);
    },
    'php-di (compilation enabled)' => function () {
        $builder = new ContainerBuilder();
        $builder->addDefinitions([
            ClassWithoutConstructor::class => function (ContainerInterface $c) {
                return new ClassWithoutConstructor();
            }
        ]);
        $builder->enableCompilation(__DIR__ . '/tmp');
        $phpDi = $builder->build();
        $classWithoutConstructor = $phpDi->get(ClassWithoutConstructor::class);
    },
    'mdarc/DI' => function () {
        $container = new Container([
            ClassWithoutConstructor::class => function (ContainerInterface $c) {
                return new ClassWithoutConstructor();
            }
        ]);
        $classWithoutConstructor = $container->get(ClassWithoutConstructor::class);
    },
], ['count' => 100000, 'name' => 'Fetch an instance of simple class without dependencies - First time']);
