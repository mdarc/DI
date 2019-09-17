<?php
declare(strict_types=1);

namespace Mdarc\DI;

final class DI
{
    /**
     * @param array $definitions
     * @param array $constructorParameters
     *
     * @return Container
     */
    public static function buildContainer(array $definitions = [], array $constructorParameters = []): Container
    {
        return new Container($definitions, $constructorParameters);
    }

    /**
     * @param callable $object
     *
     * @return Factory
     */
    public static function factory(callable $object): Factory
    {
        return new Factory($object);
    }
}
