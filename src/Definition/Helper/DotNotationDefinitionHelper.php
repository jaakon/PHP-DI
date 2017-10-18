<?php

declare(strict_types=1);

namespace DI\Definition\Helper;

use DI\Definition\Definition;
use DI\Definition\DotNotationDefinition;

/**
 * @author Michael Seidel <mvs@albami.de>
 *
 * @since 5.1
 */
class DotNotationDefinitionHelper implements DefinitionHelper
{
    /**
     * @var string
     */
    private $expression;

    public function __construct(string $expression)
    {
        $this->expression = $expression;
    }

    /**
     * @param string $entryName Container entry name
     *
     * @return StringDefinition
     */
    public function getDefinition(string $entryName) : Definition
    {
        return new DotNotationDefinition($entryName, $this->expression);
    }
}
