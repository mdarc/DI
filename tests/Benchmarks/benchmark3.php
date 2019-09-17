<?php

require_once '../../vendor/autoload.php';

use DI\ContainerBuilder;
use JBZoo\Profiler\Benchmark;
use Mdarc\DI\Container;
use Mdarc\DI\Test\UnitTest\TestClasses\ClassWithoutConstructor;
use Psr\Container\ContainerInterface;

$pimple = new \Pimple\Container([
    ClassWithoutConstructor::class => function ($c) {
        return new ClassWithoutConstructor();
    }
]);
$classWithoutConstructor = $pimple[ClassWithoutConstructor::class];
//
$builder = new ContainerBuilder();
$builder->addDefinitions([
    ClassWithoutConstructor::class => function (ContainerInterface $c) {
        return new ClassWithoutConstructor();
    }
]);
$phpDi = $builder->build();
$classWithoutConstructor = $phpDi->get(ClassWithoutConstructor::class);
//
if (file_exists(__DIR__ . '/tmp/CompiledContainer.php')) {
    @unlink(__DIR__ . '/tmp/CompiledContainer.php');
    @rmdir(__DIR__ . '/tmp');
}
$builder = new ContainerBuilder();
$builder->addDefinitions([
    ClassWithoutConstructor::class => function (ContainerInterface $c) {
        return new ClassWithoutConstructor();
    }
]);
$builder->enableCompilation(__DIR__ . '/tmp');
$phpDiCompiled = $builder->build();
$classWithoutConstructor = $phpDiCompiled->get(ClassWithoutConstructor::class);
//
$container = new Container([
    ClassWithoutConstructor::class => function (ContainerInterface $c) {
        return new ClassWithoutConstructor();
    }
]);
$classWithoutConstructor = $container->get(ClassWithoutConstructor::class);

Benchmark::compare([
    'pimple' => function () use ($pimple) {
        $classWithoutConstructor = $pimple[ClassWithoutConstructor::class];
    },
    'php-di' => function () use ($phpDi) {
        $classWithoutConstructor = $phpDi->get(ClassWithoutConstructor::class);
    },
    'php-di (compilation enabled)' => function () use ($phpDiCompiled) {
        $classWithoutConstructor = $phpDiCompiled->get(ClassWithoutConstructor::class);
    },
    'mdarc/DI' => function () use ($container) {
        $classWithoutConstructor = $container->get(ClassWithoutConstructor::class);
    },
], ['count' => 1000000, 'name' => 'Fetch an instance of simple class without dependencies - Second time']);
