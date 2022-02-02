<?php

namespace GraphQL\Query;

if (file_exists('./GraphQL/BaseGraphQLTest.php')) {
    require_once './GraphQL/BaseGraphQLTest.php';
}

use Orkester\GraphQL\Operator\Select;
use Orkester\MVC\MModelMaestro;
use Orkester\Persistence\Criteria\RetrieveCriteria;

class SelectTest extends \GraphQL\BaseGraphQLTest
{
    public function applySelect(string $query, string $model = MModelMaestro::class, array $variables = []): RetrieveCriteria
    {
        $criteria = (new $model())->getCriteria();
        $root = $this->getQueryFieldNode($query);
        return (new Select($criteria, $root->selectionSet, $variables))->apply();
    }

    public function testSimple()
    {
        $query = <<<EOD
query {
    model {
        value
        id
    }
}
EOD;
        $criteria = $this->applySelect($query);
        $this->assertEquals(['value', 'id'], $criteria->getColumns());

    }

    public function testAssociation()
    {
        $query = <<<EOD
query {
    article {
        title
        comments {
            message
        }
    }
}
EOD;
        $criteria = $this->applySelect($query);
        $this->assertEquals(['title', 'comments.message'], $criteria->getColumns());
    }

    public function testAssociationDepth2()
    {
        $query = <<<EOD
query {
    author {
        name
        articles {
            title
            comments {
                message
            }
        }
    }
}
EOD;
        $criteria = $this->applySelect($query);
        $this->assertEquals(['name', 'articles.title', 'articles.comments.message'], $criteria->getColumns());
    }

    public function testAlias()
    {
        $query = <<<EOD
query {
    model {
        myAlias (field: "name")    
    }
}
EOD;
        $criteria = $this->applySelect($query);
        $this->assertEquals(['name as myAlias'], $criteria->getColumns());
    }

    public function testExpression()
    {
        $query = <<<EOD
query {
    model {
        fullName (expr: "concat(firstName, ' ', lastName)")    
    }
}
EOD;
        $criteria = $this->applySelect($query);
        $this->assertEquals(["concat(firstName, ' ', lastName) as fullName"], $criteria->getColumns());
    }
}
