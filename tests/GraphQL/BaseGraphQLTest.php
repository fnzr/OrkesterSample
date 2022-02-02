<?php

namespace GraphQL;

use GraphQL\Language\AST\FieldNode;
use GraphQL\Language\Parser;
use Orkester\Manager;

class BaseGraphQLTest extends \PHPUnit\Framework\TestCase
{
    protected static bool $initialized = FALSE;

    public function setUp(): void
    {
        parent::setUp();

        if (!self::$initialized) {
            Manager::init();
            self::$initialized = TRUE;
        }
    }

    public function getQueryFieldNode(string $query, int $index = 0): FieldNode
    {
        $doc = Parser::parse($query);
        return $doc->definitions->offsetGet($index)->selectionSet->selections->offsetGet(0);
    }
}
