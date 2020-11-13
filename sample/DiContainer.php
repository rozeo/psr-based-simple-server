<?php


namespace Sample;


use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use ReflectionClass;

class DiContainer implements ContainerInterface
{
    /**
     * @var array<mixed>
     */
    private array $bindings;

    /**
     * @var array<mixed>
     */
    private array $cachedInstances;

    public function __construct()
    {
        $this->bindings = [];
        $this->cachedInstances = [];

        $this->bind(ContainerInterface::class, $this);
    }

    public function bind(string $key, $to)
    {
        $this->bindings[$key] = $to;
    }

    /**
     * @param string $key
     * @return mixed
     * @throws \Exception
     */
    public function get($key)
    {
        if (array_key_exists($key, $this->cachedInstances)) {
            return $this->cachedInstances[$key];
        }

        if ($this->has($key)) {
            return $this->resolve($key, $this->bindings[$key]);
        }

        if (class_exists($key)) {
            return $this->resolveClass($key);
        }

        throw new \Exception("$key is not instanceable.");
    }

    public function has($key)
    {
        return array_key_exists($key, $this->bindings);
    }

    protected function resolve($key, $object)
    {
        if (is_object($object)) {
            return $this->cachedInstances[$key] = $object;
        }

        if (is_callable($object)) {
            return $this->cachedInstances[$key] = call_user_func($object, $this);
        }

        if (class_exists($object)) {
            return $this->resolveClass($object);
        }

        return $object;
    }

    protected function resolveClass(string $className)
    {
        $constructorReflection = (new ReflectionClass($className))->getConstructor();
        $parameterReflections = $constructorReflection
            ? $constructorReflection->getParameters()
            : [];

        $parameters = [];

        foreach ($parameterReflections as $parameterReflection) {
            $parameters[] = $this->get((string)$parameterReflection->getType());
        }

        return new $className(...$parameters);
    }
}