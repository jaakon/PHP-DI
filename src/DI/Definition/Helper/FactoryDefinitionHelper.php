<?php

namespace DI\Definition\Helper;

use DI\Definition\DecoratorDefinition;
use DI\Definition\FactoryDefinition;

/**
 * Helps defining how to create an instance of a class using a factory (callable).
 *
 * @author Matthieu Napoli <matthieu@mnapoli.fr>
 */
class FactoryDefinitionHelper implements DefinitionHelper
{
    /**
     * @var callable
     */
    private $factory;

    /**
     * @var bool
     */
    private $decorate;

    /**
     * @param callable $factory
     * @param bool     $decorate Is the factory decorating a previous definition?
     */
    public function __construct($factory, $decorate = false)
    {
        $this->factory = $factory;
        $this->decorate = $decorate;
    }

    /**
     * @param string $entryName Container entry name
     * @return FactoryDefinition
     */
    public function getDefinition($entryName)
    {
        if ($this->decorate) {
            return new DecoratorDefinition($entryName, $this->factory);
        }

        return new FactoryDefinition($entryName, $this->factory);
    }
}
