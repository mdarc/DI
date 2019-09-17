<?php

require_once '../../vendor/autoload.php';

use DI\ContainerBuilder;
use JBZoo\Profiler\Benchmark;
use Mdarc\DI\Container;

// Compare performance of functions
Benchmark::compare([
    'pimple' => function () {
        $pimple = new \Pimple\Container([]);
    },
    'php-di' => function () {
        $builder = new ContainerBuilder();
        $phpDi = $builder->build();
    },
    'mdarc/DI' => function () {
        $container = new Container();
    },
], ['count' => 100000, 'name' => 'Class Instantiation']);
