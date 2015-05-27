<?php

namespace Gos\Component\RatchetStack;

use Ratchet\ComponentInterface;

class Builder
{
    /**
     * @var \SplStack
     */
    protected $components;

    public function __construct()
    {
        $this->components = new \SplStack();
    }

    /**
     * @return $this
     */
    public function unshift(/*$kernelClass, $args...*/)
    {
        if (func_num_args() === 0) {
            throw new \InvalidArgumentException('Missing argument(s) when calling unshift');
        }

        $msgApp = func_get_args();
        $this->components->unshift($msgApp);

        return $this;
    }

    /**
     * @return $this
     */
    public function push(/*$kernelClass, $args...*/)
    {
        if (func_num_args() === 0) {
            throw new \InvalidArgumentException('Missing argument(s) when calling push');
        }

        $msgApp = func_get_args();
        $this->components->push($msgApp);

        return $this;
    }

    /**
     * @param ComponentInterface $component
     *
     * @return ServerStack
     */
    public function resolve(ComponentInterface $component)
    {
        $middlewares = array($component);

        foreach ($this->components as $comp) {
            $args = $comp;
            $firstArg = array_shift($args);

            if (is_callable($firstArg)) {
                $component = $firstArg($component);
            } else {
                $class = $firstArg;
                array_unshift($args, $component);
                $reflection = new \ReflectionClass($class);
                $component = $reflection->newInstanceArgs($args);
            }

            array_unshift($middlewares, $component);
        }

        return new ServerStack($component);
    }
}
