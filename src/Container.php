<?php
declare(strict_types=1);

namespace Mdarc\DI;

use Mdarc\DI\Exceptions\NotFoundException;
use Mdarc\DI\Exceptions\CircularReferenceException;
use Mdarc\DI\Exceptions\MissingRequiredParameterException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use ReflectionClass;
use ReflectionException;

class Container implements ContainerInterface
{
    /** @var object[] */
    private $instances = [];

    /** @var int[] */
    private $circularReferenceMap = [];

    /** @var object[] */
    private $definitions = [];

    /** @var string[] */
    private $constructorParameters = [];

    /**
     * Container constructor
     *
     * @param array $definitions
     * @param array $constructorParameters
     */
    public function __construct(array $definitions = [], array $constructorParameters = [])
    {
        $this->definitions = $definitions;
        $this->constructorParameters = $constructorParameters;
    }

    /**
     * Find an entry of the container by its identifier and return it.
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @return mixed Entry.
     *
     * @throws NotFoundExceptionInterface  No entry was found for **this** identifier.
     * @throws ContainerExceptionInterface Error while retrieving the entry.
     */
    public function get($id)
    {
        // Was already built?
        if (isset($this->instances[$id])) {
            return $this->instances[$id];
        }

        // Let's build it
        try {
            $instance = $this->build($id);
        } catch (ReflectionException $e) {
            throw new NotFoundException("Exception building '{$id}': " . $e->getMessage(), 0, $e);
        }

        if ($instance instanceof Factory) {
            $newInstance = $instance->build($this);
            // Decrement the circular reference counter
            $this->circularReferenceMap[$id] -= 1;

            return $newInstance;
        }

        $this->instances[$id] = $instance;

        return $instance;
    }

    /**
     * @param string $id
     *
     * @return mixed
     *
     * @throws CircularReferenceException
     * @throws MissingRequiredParameterException
     * @throws ReflectionException
     */
    private function build(string $id)
    {
        // is it in the definitions?
        if (isset($this->definitions[$id])) {

            // is it an alias of another class?
            if (is_string($this->definitions[$id])) {
                return $this->get($this->definitions[$id]);
            }

            // is it an array with configurations?
            if (is_array($this->definitions[$id])) {
                return $this->definitions[$id];
            }

            // is this a factory? then it should return a new object always
            if ($this->definitions[$id] instanceof Factory) {
                if (!isset($this->circularReferenceMap[$id])) {
                    $this->circularReferenceMap[$id] = 0;
                }
                if ($this->circularReferenceMap[$id] >= 1) {
                    throw new CircularReferenceException(
                        "Factory for object '{$id}' has a circular reference with itself", 0, '', $id
                    );
                }
                // Increment the circular reference counter
                $this->circularReferenceMap[$id] += 1;
                return $this->definitions[$id];
            }

            // build it
            return $this->definitions[$id]($this);
        }

        // let's build it using reflection
        $reflectionClass = new ReflectionClass($id);
        $constructor = $reflectionClass->getConstructor();
        if ($constructor === null) {
            return $reflectionClass->newInstance();
        }

        $params = $constructor->getParameters();
        if (empty($params)) {
            return $reflectionClass->newInstance();
        }

        // Parameters validation
        foreach ($params as $parameter) {
            if ($parameter->isOptional()) {
                continue;
            }
            $pname = $parameter->getName();
            if (isset($this->constructorParameters[$id][$pname])) {
                continue;
            }

            $ptype = $parameter->getType();
            if ($ptype === null) { // no defined type
                throw new MissingRequiredParameterException(
                    "Constructor parameter without type '\${$pname}' in class '{$id}' cannot be guessed and must be manually defined",
                    0,
                    $pname,
                    $id
                );
            }

            if ($this->isInternalType($ptype->getName())) {
                throw new MissingRequiredParameterException(
                    sprintf(
                        "Constructor parameter '%s \$%s' in class '%s' cannot be guessed and must be manually defined", $ptype->getName(), $pname, $id
                    ),
                    0,
                    $pname,
                    $id
                );
            }
        }

        $args = [];
        foreach ($params as $parameter) {
            $pname = $parameter->getName();
            if ($parameter->isOptional()) {
                if (!isset($this->constructorParameters[$id][$pname])) {
                    $args[] = $parameter->getDefaultValue();
                    continue;
                }
            }
            $ptype = $parameter->getType();
            if ($ptype === null || $this->isInternalType($ptype->getName())) {
                $val = $this->constructorParameters[$id][$pname];
                if (is_callable($val)) {
                    $val = $val($this);
                }
                $args[] = $val;
                continue;
            }

            $dependencyClassName = $parameter->getType()->getName();

            // Circular reference check
            if (isset($this->circularReferenceMap[$dependencyClassName][$id])) {
                throw new CircularReferenceException(
            "Parameter '" . $ptype->getName() . " \${$pname}' in class {$id} has a circular reference with class {$dependencyClassName}", 0, $pname, $id
                );
            }
            $this->circularReferenceMap[$id][$dependencyClassName] = 1;

            // Getting the reference
            $args[] = $this->get($dependencyClassName);
        }

        return $reflectionClass->newInstanceArgs($args);
    }

    /**
     * @param string $typeName
     *
     * @return bool
     */
    private function isInternalType(string $typeName): bool
    {
        return in_array($typeName, ['array', 'int', 'string', 'float']);
    }

    /**
     * Returns true if the container can return an entry for the given identifier.
     * Returns false otherwise.
     *
     * `has($id)` returning true does not mean that `get($id)` will not throw an exception.
     * It does however mean that `get($id)` will not throw a `NotFoundExceptionInterface`.
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @return bool
     */
    public function has($id)
    {
        // We do our best.
        return true;
    }

    /**
     * @param string $id
     * @param mixed  $definition
     */
    public function set(string $id, $definition)
    {
        $this->instances[$id] = $definition;
    }
}
