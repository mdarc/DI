<?php

use Mdarc\DI\Container;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class RequestingSelfTest extends TestCase
{
    public function test_ParametersCorrectlySetup()
    {
        $container = new Container();

        /** @var Class1 $class1 */
        $class1 = $container->get(Class1::class);
        $this->assertInstanceOf(Container::class, $class1->getContainer());
        $this->assertInstanceOf(Container::class, $class1->getContainerViaInterface());
        $this->assertSame($class1->getContainer(), $container);
        $this->assertSame($class1->getContainerViaInterface(), $container);
    }
}

class Class1 {
    /** @var Container */
    private $container;
    /** @var ContainerInterface */
    private $containerViaInterface;

    /**
     * Class1 constructor.
     *
     * @param Container                         $container
     * @param ContainerInterface $containerViaInterface
     */
    public function __construct(
        Container $container,
        ContainerInterface $containerViaInterface)
    {
        $this->container             = $container;
        $this->containerViaInterface = $containerViaInterface;
    }

    /**
     * @return Container
     */
    public function getContainer(): Container
    {
        return $this->container;
    }

    /**
     * @return ContainerInterface
     */
    public function getContainerViaInterface(): ContainerInterface
    {
        return $this->containerViaInterface;
    }
}
