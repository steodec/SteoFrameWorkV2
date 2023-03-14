<?php

namespace Steodec\SteoFrameWork\Router;

class Route
{
    /**
     * @var string
     */
    private string $_name;
    /**
     * @var callable
     */
    private mixed $_callable;
    /**
     * @var array
     */
    private array $_params = [];

    /**
     * @param string          $_name
     * @param string|callable $_callable
     * @param array           $_params
     */
    public function __construct(string $_name, string|callable $_callable, array $_params = [])
    {
        $this->_name     = $_name;
        $this->_callable = $_callable;
        $this->_params = $_params;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->_name;
    }

    /**
     * @return mixed
     */
    public function getCallable(): mixed
    {
        return $this->_callable;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->_params;
    }
}
