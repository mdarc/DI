<?php
declare(strict_types=1);

namespace Mdarc\DI\Test\UnitTest\TestClasses;

class ClassTwo
{
    /** @var int */
    private $param1;
    /** @var mixed */
    private $param2;
    /** @var array */
    private $param3;

    /**
     * ClassOne constructor.
     *
     * @param int      $param1
     * @param mixed    $param2
     * @param array    $param3
     * @param int|null $param4
     */
    public function __construct(int $param1, $param2, array $param3 = ['default'], ?int $param4 = null)
    {
        $this->param1 = $param1;
        $this->param2 = $param2;
        $this->param3 = $param3;
    }

    /**
     * @return int
     */
    public function getParam1(): int
    {
        return $this->param1;
    }

    /**
     * @return mixed
     */
    public function getParam2()
    {
        return $this->param2;
    }

    /**
     * @return array
     */
    public function getParam3(): array
    {
        return $this->param3;
    }

}
