<?php

namespace DI\Definition;

/**
 * Definition of a value or class with a factory.
 *
 * @author Matthieu Napoli <matthieu@mnapoli.fr>
 */
class FactoryDefinition implements Definition
{
    /**
     * Entry name.
     * @var string
     */
    private $name;

    /**
     * Callable that returns the value.
     * @var callable
     */
    private $factory;

    /**
     * @param string      $name    Entry name
     * @param callable    $factory Callable that returns the value associated to the entry name.
     */
    public function __construct($name, $factory)
    {
        $this->name = $name;
        $this->factory = $factory;
    }

    /**
     * @return string Entry name.
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return callable Callable that returns the value associated to the entry name.
     */
    public function getCallable()
    {
        return $this->factory;
    }

    public function __toString()
    {
        return 'Factory';
    }
}
