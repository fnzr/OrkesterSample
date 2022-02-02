<?php

namespace GraphQL\Query;

if (file_exists('./GraphQL/BaseGraphQLTest.php')) {
    require_once './GraphQL/BaseGraphQLTest.php';
}

use GraphQL\BaseGraphQLTest;
use GraphQL\Language\AST\ArgumentNode;
use Orkester\GraphQL\Operator\OrderBy;
use Orkester\MVC\MModelMaestro;
use Orkester\Persistence\Criteria\RetrieveCriteria;

class OrderByTest extends BaseGraphQLTest
{

    public function applyOrderBy(string $query, array $variables = []): RetrieveCriteria
    {
        $criteria = MModelMaestro::getCriteria();
        $root = $this->getQueryFieldNode($query);
        /** @var ArgumentNode $node */
        foreach($root->arguments->getIterator() as $node) {
            if ($node->name->value == 'order_by') {
                (new OrderBy($criteria, $node->value, $variables))->apply();
            }
        }
        return $criteria;
    }

    public function testSingle(): void
    {
        $query = <<<EOD
query {
    tag(order_by: {value: "asc"}) {
        value
    }
}
EOD;
        $criteria = $this->applyOrderBy($query);
        $this->assertEquals(['value asc'], $criteria->getOrders());
    }

    public function testMultiple(): void
    {
        $query = <<<EOD
query {
    tag(order_by: [{value: "asc"}, {id: "desc"}]) {
        value
    }
}
EOD;
        $criteria = $this->applyOrderBy($query);
        $this->assertEquals(['value asc', 'id desc'], $criteria->getOrders());
    }

    public function testVariable(): void
    {
        $query = <<<'EOD'
query {
    tag(order_by: $order) {
        value
    }
}
EOD;
        $criteria = $this->applyOrderBy($query, ['order' => ['value' => 'desc']]);
        $this->assertEquals(['value desc'], $criteria->getOrders());
    }

    public function testVariableValue(): void
    {
        $query = <<<'EOD'
query {
    tag(order_by: [{value: "asc"}, {id: $order}]) {
        value
    }
}
EOD;
        $criteria = $this->applyOrderBy($query, ['order' => 'desc']);
        $this->assertEquals(['value asc', 'id desc'], $criteria->getOrders());
    }

    public function testVariableList(): void
    {
        $query = <<<'EOD'
query {
    tag(order_by: $order) {
        value
    }
}
EOD;
        $criteria = $this->applyOrderBy($query, ['order' => ['value' => 'desc', 'id' => 'asc']]);
        $this->assertEquals(['value desc', 'id asc'], $criteria->getOrders());
    }
}
