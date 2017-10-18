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
        return self::resolveExpression($this->name, $this->expression, $container);
    }

    public function isResolvable(ContainerInterface $container) : bool
    {
        return true;
    }

    public function __toString()
    {
        return $this->expression;
    }

    /**
     * Resolve a string expression.
     */
    public static function resolveExpression(
        string $entryName,
        string $expression,
        ContainerInterface $container
    ) {
        $segments = explode('.', $expression);

        try {
            $result = $container->get(array_shift($segments));
        } catch (NotFoundExceptionInterface $e) {
            throw new DependencyException(sprintf(
                "Error while parsing dotNotation expression for entry '%s': %s",
                $entryName,
                $e->getMessage()
            ), 0, $e);
        }

        foreach ($segments as $segment) {
            if (!is_array($result) || !array_key_exists($segment, $result)) {
                throw new \RuntimeException(sprintf('An unknown error occurred while parsing dotNotation definition: \'%s\'', $expression));
            }

            $result = $result[$segment];
        }

        return $result;
    }
}
