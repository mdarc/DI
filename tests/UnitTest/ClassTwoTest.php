<?php

use Mdarc\DI\Container;
use Mdarc\DI\Exceptions\MissingRequiredParameterException;
use Mdarc\DI\Test\UnitTest\TestClasses\ClassOne;
use Mdarc\DI\Test\UnitTest\TestClasses\ClassTwo;
use PHPUnit\Framework\TestCase;

class ClassTwoTest extends TestCase
{
    public function test_ParametersCorrectlySetup()
    {
        $constructorParameters = [
            ClassTwo::class => [
                'param1' => 1,
                'param2' => new \StdClass,
                // param3 should be optional so is not defined
            ]
        ];
        $container = new Container([], $constructorParameters);

        /** @var ClassTwo $class2 */
        $class2 = $container->get(ClassTwo::class);

        $this->assertInstanceOf(ClassTwo::class, $class2);
        $this->assertIsInt($class2->getParam1());
        $this->assertIsObject($class2->getParam2());
        $this->assertIsArray($class2->getParam3());
        $this->assertEquals(['default'], $class2->getParam3());
    }

    public function test_MissingParameterThrowException()
    {
        $this->expectException(MissingRequiredParameterException::class);
        $this->expectExceptionMessage("Constructor parameter without type '\$param2' in class '" . ClassTwo::class . "' cannot be guessed and must be manually defined");

        $constructorParameters = [
            ClassTwo::class => [
                'param1' => 1,
                // param2 is missing on purpose
                'param3' => ['something'],
            ]
        ];
        $container = new Container([], $constructorParameters);

        /** @var ClassOne $class1 */
        $container->get(ClassTwo::class);
    }
}
