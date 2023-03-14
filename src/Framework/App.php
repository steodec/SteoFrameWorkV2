<?php

namespace Steodec\SteoFrameWork\Framework;

use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Whoops\Handler\HandlerInterface;
use Whoops\Run;

class App
{
    /**
     * List of modules
     *
     * @var string[]
     */
    private array $modules = [];
    /**
     * @var string
     */
    private string $definition;

    /**
     * @var ?ContainerInterface
     */
    private ?ContainerInterface $container = null;

    /**
     * @var string[]
     */
    private array $middlewares = [];

    /**
     * @var int
     */
    private int $index = 0;

    public function __construct(string $definition)
    {
        $this->definition = $definition;
    }

    /**
     * Add module to App
     *
     * @param string $module
     *
     * @return App
     */
    public function addModule(string $module): self
    {
        $this->modules[] = $module;
        return $this;
    }

    /**
     * Add middleware
     *
     * @param string $middleware
     *
     * @return App
     */
    public function pipe(string $middleware): self
    {
        $this->middlewares[] = $middleware;
        return $this;
    }

    public function process(ServerRequestInterface $request): ResponseInterface
    {
        $middleware = $this->getMiddleware();
        if (is_null($middleware)) {
            throw new \Exception('No middleware');
        } else {
            return call_user_func_array($middleware, [$request, [$this, 'process']]);
        }
    }

    public function run(ServerRequestInterface $request): ResponseInterface
    {
        foreach ($this->modules as $module) {
            $this->getContainer()->get($module);
        }
        return $this->process($request);
    }

    /**
     * @return ContainerInterface
     * @throws \Exception
     */
    private function getContainer(): ContainerInterface
    {
        if ($this->container === null) {
            $builder = new ContainerBuilder();
            $builder->addDefinitions($this->definition);
            foreach ($this->modules as $module) {
                if ($module::DEFINITIONS) {
                    $builder->addDefinitions($module::DEFINITIONS);
                }
            }
            $this->container = $builder->build();
        }
        return $this->container;
    }

    /**
     * @return object|null
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    private function getMiddleware(): ?object
    {
        if (array_key_exists($this->index, $this->middlewares)) {
            $middleware = $this->container->get($this->middlewares[$this->index]);
            $this->index++;
            return $middleware;
        }
        return null;
    }
}
