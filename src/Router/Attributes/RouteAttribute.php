<?php

namespace Steodec\SteoFrameWork\Router\Attributes;

use Attribute;

abstract class RouteAttribute
{
    private string|bool $_path;
    /**
     * @var string|callable
     */
    private mixed $_callable;
    private string|bool $_method;
    private string|bool $_name;

    public function __construct(HTTPMethods|bool $_method = false, string|bool $_path = false, string|bool $_name = false)
    {
        $this->_path = $_path;
        $this->_method = $_method->value;
        $this->_name = $_name;
    }

    /**
     * @param bool|string $path
     *
     * @return RouteAttribute
     */
    public function setPath(bool|string $path): RouteAttribute
    {
        $this->_path = $path;
        return $this;
    }

    /**
     * @return bool|string
     */
    public function getPath(): bool|string
    {
        return $this->_path;
    }

    /**
     * @param mixed $callable
     *
     * @return RouteAttribute
     */
    public function setCallable(mixed $callable): RouteAttribute
    {
        $this->_callable = $callable;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCallable(): mixed
    {
        return $this->_callable;
    }

    /**
     * @param bool|string $method
     *
     * @return RouteAttribute
     */
    public function setMethod(bool|HTTPMethods $method): RouteAttribute
    {
        $this->_method = $method->value;
        return $this;
    }

    /**
     * @return bool|string
     */
    public function getMethod(): bool|string
    {
        return $this->_method;
    }

    /**
     * @param bool|string $name
     *
     * @return RouteAttribute
     */
    public function setName(bool|string $name): RouteAttribute
    {
        $this->_name = $name;
        return $this;
    }

    /**
     * @return bool|string
     */
    public function getName(): bool|string
    {
        return $this->_name;
    }
}
