<?php
declare(strict_types=1);

namespace Mdarc\DI\Test\UnitTest\TestClasses;

class ClassThree
{
    /** @var Foo */
    private $foo;
    /** @var Bar */
    private $bar;

    /**
     * ClassThree constructor.
     *
     * @param Foo $foo
     * @param Bar $bar
     */
    public function __construct(Foo $foo, Bar $bar)
    {
        $this->foo = $foo;
        $this->bar = $bar;
    }

    /**
     * @return Foo
     */
    public function getFoo(): Foo
    {
        return $this->foo;
    }

    /**
     * @return Bar
     */
    public function getBar(): Bar
    {
        return $this->bar;
    }
}
