<?php

namespace Steodec\SteoFrameWork\Router\Attributes;

use Attribute;

abstract class RouteAttribute
{
    private string|bool $path;
    /**
     * @var string|callable
     */
    private mixed $callable;
    private string|bool $method;
    private string|bool $name;

    public function __construct(
        HTTPMethods|bool $_method = false,
        string|bool $_path = false,
        string|bool $_name = false
    ) {
        $this->path = $_path;
        $this->method = $_method->value;
        $this->name = $_name;
    }

    /**
     * @param bool|string $path
     *
     * @return RouteAttribute
     */
    public function setPath(bool|string $path): RouteAttribute
    {
        $this->path = $path;
        return $this;
    }

    /**
     * @return bool|string
     */
    public function getPath(): bool|string
    {
        return $this->path;
    }

    /**
     * @param mixed $callable
     *
     * @return RouteAttribute
     */
    public function setCallable(mixed $callable): RouteAttribute
    {
        $this->callable = $callable;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCallable(): mixed
    {
        return $this->callable;
    }

    /**
     * @param bool|string $method
     *
     * @return RouteAttribute
     */
    public function setMethod(bool|HTTPMethods $method): RouteAttribute
    {
        $this->method = $method->value;
        return $this;
    }

    /**
     * @return bool|string
     */
    public function getMethod(): bool|string
    {
        return $this->method;
    }

    /**
     * @param bool|string $name
     *
     * @return RouteAttribute
     */
    public function setName(bool|string $name): RouteAttribute
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return bool|string
     */
    public function getName(): bool|string
    {
        return $this->name;
    }
}
