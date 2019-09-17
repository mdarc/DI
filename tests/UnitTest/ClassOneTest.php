<?php

use Mdarc\DI\Container;
use Mdarc\DI\Exceptions\MissingRequiredParameterException;
use Mdarc\DI\Test\UnitTest\TestClasses\ClassOne;
use PHPUnit\Framework\TestCase;

class ClassOneTest extends TestCase
{
    public function test_ParametersCorrectlySetup()
    {
        $constructorParameters = [
            ClassOne::class => [
                'param1' => 1,
                'param2' => '2',
                'param3' => [3],
            ]
        ];
        $container = new Container([], $constructorParameters);

        /** @var ClassOne $class1 */
        $class1 = $container->get(ClassOne::class);

        $this->assertInstanceOf(ClassOne::class, $class1);
        $this->assertIsInt($class1->getParam1());
        $this->assertIsString($class1->getParam2());
        $this->assertIsArray($class1->getParam3());
    }

    public function test_MissingParameterThrowException()
    {
        $this->expectException(MissingRequiredParameterException::class);
        $this->expectExceptionMessage("Constructor parameter 'string \$param2' in class '" . ClassOne::class . "' cannot be guessed and must be manually defined");

        $constructorParameters = [
            ClassOne::class => [
                'param1' => 1,
                // param2 is missing on purpose
                'param3' => [3],
            ]
        ];
        $container = new Container([], $constructorParameters);

        /** @var ClassOne $class1 */
        $container->get(ClassOne::class);
    }
}
