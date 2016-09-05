<?php
namespace DI\Definition;

use DI\DependencyException;
use DI\Scope;
use Interop\Container\ContainerInterface;
use Interop\Container\Exception\NotFoundException;

class DotNotationDefinition implements Definition, SelfResolvingDefinition
{
    /**
     * @var string
     */
    private $expression;

    /**
     * Entry name.
     * @var string
     */
    private $name;

    /**
     * @param string $name         Entry name
     * @param string $expression
     */
    public function __construct($name, $expression)
    {
        $this->name       = $name;
        $this->expression = $expression;
    }

    public function __toString()
    {
        return $this->expression;
    }

    /**
     * @return string
     */
    public function getExpression()
    {
        return $this->expression;
    }

    /**
     * @return string Entry name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function getScope()
    {
        return Scope::SINGLETON;
    }

    public function isResolvable(ContainerInterface $container)
    {
        return true;
    }

    public function resolve(ContainerInterface $container)
    {
        $expression = $this->expression;

        $result = preg_replace_callback('#\{([^\{\}]+)\}#', function (array $matches) use ($container) {
            try {
                return $container->get($matches[1]);
            } catch (NotFoundException $e) {
                throw new DependencyException(sprintf(
                    "Error while parsing string expression for entry '%s': %s",
                    $this->getName(),
                    $e->getMessage()
                ), 0, $e);
            }
        }, $expression);

        if ($result === null) {
            throw new \RuntimeException(sprintf('An unknown error occurred while parsing the string definition: \'%s\'', $expression));
        }

        return $result;
    }
}
