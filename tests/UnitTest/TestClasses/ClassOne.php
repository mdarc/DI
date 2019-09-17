<?php
declare(strict_types=1);

namespace Mdarc\DI\Test\UnitTest\TestClasses;

class ClassOne
{
    /** @var int */
    private $param1;
    /** @var string */
    private $param2;
    /** @var array */
    private $param3;

    /**
     * ClassOne constructor.
     *
     * @param int    $param1
     * @param string $param2
     * @param array  $param3
     */
    public function __construct(int $param1, string $param2, array $param3)
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
     * @return string
     */
    public function getParam2(): string
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
