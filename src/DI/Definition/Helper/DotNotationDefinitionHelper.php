<?php
namespace DI\Definition\Helper;

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

    public function __construct($expression)
    {
        $this->expression = $expression;
    }

    /**
     * @param  string             $entryName Container entry name
     * @return StringDefinition
     */
    public function getDefinition($entryName)
    {
        return new DotNotationDefinition($entryName, $this->expression);
    }
}
