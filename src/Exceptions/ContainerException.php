<?php
namespace Mdarc\DI\Exceptions;

use Psr\Container\ContainerExceptionInterface;
use Throwable;

abstract class ContainerException extends \Exception implements ContainerExceptionInterface
{
    /** @var string */
    private $parameter;
    /** @var string */
    private $class;

    /**
     * ContainerException constructor.
     *
     * @param string         $message
     * @param int            $code
     * @param string         $parameter
     * @param string         $class
     * @param Throwable|null $previous
     */
    public function __construct($message = "", $code = 0, string $parameter = "", string $class = "", Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->parameter = $parameter;
        $this->class = $class;
    }

    /**
     * @return string
     */
    public function getParameter(): string
    {
        return $this->parameter;
    }

    /**
     * @return string
     */
    public function getClass(): string
    {
        return $this->class;
    }
}
