<?php
declare(strict_types=1);

namespace Mdarc\DI;

use Psr\Container\ContainerInterface;

class Factory
{
    /** @var callable */
    private $object;

    /**
     * Factory constructor.
     *
     * @param $object
     */
    public function __construct(callable $object)
    {
        $this->object = $object;
    }

    /**
     * @param ContainerInterface|null $container
     *
     * @return mixed
     */
    public function build(?ContainerInterface $container)
    {
        $exec = $this->object;
        return $exec($container);
    }
}
