<?php

declare(strict_types=1);

namespace DI\Definition;

use DI\DependencyException;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * Definition of a string composed of other strings.
 *
 * @since 5.0
 * @author Matthieu Napoli <matthieu@mnapoli.fr>
 */
class DotNotationDefinition implements Definition, SelfResolvingDefinition
{
    /**
     * Entry name.
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $expression;

    /**
     * @param string $name Entry name
     */
    public function __construct(string $name, string $expression)
    {
        $this->name = $name;
        $this->expression = $expression;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function getExpression() : string
    {
        return $this->expression;
    }

    public function resolve(ContainerInterface $container)
    {
        $segments = explode('.', $this->expression);

        try {
            $result = $container->get(array_shift($segments));
        } catch (NotFoundExceptionInterface $e) {
            throw new DependencyException(sprintf(
                "Error while parsing dotNotation expression for entry '%s': %s",
                $this->name(),
                $e->getMessage()
            ), 0, $e);
        }

        foreach ($segments as $segment) {
            if (!is_array($result) || !array_key_exists($segment, $result)) {
                throw new \RuntimeException(sprintf('An unknown error occurred while parsing dotNotation definition: \'%s\'', $this->expression));
            }

            $result = $result[$segment];
        }

        return $result;
    }

    public function isResolvable(ContainerInterface $container) : bool
    {
        return true;
    }

    public function __toString()
    {
        return $this->expression;
    }
}
