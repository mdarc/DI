<?php

namespace Mdarc\DI\Test\UnitTest\TestClasses;

class Baz
{
    private $text;

    /**
     * Baz constructor
     */
    public function __construct()
    {
        $this->text = 'the lazy fox';
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }
}
