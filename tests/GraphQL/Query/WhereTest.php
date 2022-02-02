<?php

namespace GraphQL\Query;

if (file_exists('./GraphQL/BaseGraphQLTest.php')) {
    require_once './GraphQL/BaseGraphQLTest.php';
}

use GraphQL\Language\AST\ArgumentNode;
use Orkester\GraphQL\Operator\Where;
use Orkester\MVC\MModelMaestro;
use Orkester\Persistence\Criteria\RetrieveCriteria;
use OrkesterSample\Models\ArticleModel;

class WhereTest extends \GraphQL\BaseGraphQLTest
{
    public function applyWhere(string $query, string $model = MModelMaestro::class, array $variables = []): RetrieveCriteria
    {
        $criteria = (new $model())->getCriteria();
        $root = $this->getQueryFieldNode($query);
        /** @var ArgumentNode $node */
        foreach($root->arguments->getIterator() as $node) {
            if ($node->name->value == 'where') {
                (new Where($criteria, $node->value, $variables))->apply();
            }
        }
        return $criteria;
    }

    public function testAndExplicit()
    {
        $query = <<<EOD
query {
    model(where: {and: {idArticle: {eq: 5}, title: {eq: "Hello"}}}) {
        idArticle
    }
}
EOD;
        $sql = $this->applyWhere($query, ArticleModel::class)->getWhereConditionCriteria()->getSql();
        $this->assertEquals("((article.idArticle = 5) AND (article.title = 'Hello'))", $sql);
    }

    public function testAndImplicit()
    {
        $query = <<<EOD
query {
    model(where: {idArticle: {eq: 5}, title: {eq: "Hello"}}) {
        idArticle
    }
}
EOD;
        $sql = $this->applyWhere($query, ArticleModel::class)->getWhereConditionCriteria()->getSql();
        $this->assertEquals("((article.idArticle = 5) AND (article.title = 'Hello'))", $sql);
    }

    public function testOr()
    {
        $query = <<<EOD
query {
    model(where: {or: {idArticle: {eq: 5}, title: {eq: "Hello"}}}) {
        idArticle
    }
}
EOD;
        $sql = $this->applyWhere($query, ArticleModel::class)->getWhereConditionCriteria()->getSql();
        $this->assertEquals("(((article.idArticle = 5) OR (article.title = 'Hello')))", $sql);
    }

    public function testMixAndOr()
    {
        $query = <<<EOD
query {
    model(where: {idAuthor: {eq: 1}, or: {idArticle: {eq: 5}, title: {eq: "Hello"}}}) {
        idArticle
    }
}
EOD;
        $sql = $this->applyWhere($query, ArticleModel::class)->getWhereConditionCriteria()->getSql();
        $this->assertEquals("(((article.idArticle = 5) OR (article.title = 'Hello')) AND (article.idAuthor = 1))", $sql);
    }

    public function testEquals()
    {
        $query = <<<EOD
query {
    model(where: {idArticle: {eq: 5} }) {
        idArticle
    }
}
EOD;
        $sql = $this->applyWhere($query, ArticleModel::class)->getWhereConditionCriteria()->getSql();
        $this->assertEquals('((article.idArticle = 5))', $sql);
    }

    public function testNotEquals()
    {
        $query = <<<EOD
query {
    model(where: {idArticle: {neq: 5} }) {
        idArticle
    }
}
EOD;
        $sql = $this->applyWhere($query, ArticleModel::class)->getWhereConditionCriteria()->getSql();
        $this->assertEquals('((article.idArticle <> 5))', $sql);
    }

    public function testLessThan()
    {
        $query = <<<EOD
query {
    model(where: {idArticle: {lt: 5} }) {
        idArticle
    }
}
EOD;
        $sql = $this->applyWhere($query, ArticleModel::class)->getWhereConditionCriteria()->getSql();
        $this->assertEquals('((article.idArticle < 5))', $sql);
    }

    public function testLessEqualsThan()
    {
        $query = <<<EOD
query {
    model(where: {idArticle: {lte: 5} }) {
        idArticle
    }
}
EOD;
        $sql = $this->applyWhere($query, ArticleModel::class)->getWhereConditionCriteria()->getSql();
        $this->assertEquals('((article.idArticle <= 5))', $sql);
    }

    public function testGreaterThan()
    {
        $query = <<<EOD
query {
    model(where: {idArticle: {gt: 5} }) {
        idArticle
    }
}
EOD;
        $sql = $this->applyWhere($query, ArticleModel::class)->getWhereConditionCriteria()->getSql();
        $this->assertEquals('((article.idArticle > 5))', $sql);
    }

    public function testGreaterEqualsThan()
    {
        $query = <<<EOD
query {
    model(where: {idArticle: {gte: 5} }) {
        idArticle
    }
}
EOD;
        $sql = $this->applyWhere($query, ArticleModel::class)->getWhereConditionCriteria()->getSql();
        $this->assertEquals('((article.idArticle >= 5))', $sql);
    }

    public function testIn()
    {
        $query = <<<EOD
query {
    model(where: {idArticle: {in: [5, 6]} }) {
        idArticle
    }
}
EOD;
        $sql = $this->applyWhere($query, ArticleModel::class)->getWhereConditionCriteria()->getSql();
        $this->assertEquals('((article.idArticle IN (5,6)))', $sql);
    }

    public function testNotIn()
    {
        $query = <<<EOD
query {
    model(where: {idArticle: {nin: [5, 6]} }) {
        idArticle
    }
}
EOD;
        $sql = $this->applyWhere($query, ArticleModel::class)->getWhereConditionCriteria()->getSql();
        $this->assertEquals('((article.idArticle NOT IN (5,6)))', $sql);
    }
//
    public function testNull()
    {
        $query = <<<EOD
query {
    model(where: {idArticle: {is_null: true} }) {
        idArticle
    }
}
EOD;
        $sql = $this->applyWhere($query, ArticleModel::class)->getWhereConditionCriteria()->getSql();
        $this->assertEquals('((article.idArticle IS NULL ))', $sql);
    }

    public function testNotNull()
    {
        $query = <<<EOD
query {
    model(where: {idArticle: {is_null: false} }) {
        idArticle
    }
}
EOD;
        $sql = $this->applyWhere($query, ArticleModel::class)->getWhereConditionCriteria()->getSql();
        $this->assertEquals('((article.idArticle IS NOT NULL ))', $sql);
    }

    public function testVariableValue()
    {
        $query = <<<'EOD'
query {
    model(where: {idArticle: {eq: $id} }) {
        idArticle
    }
}
EOD;
        $sql = $this->applyWhere($query, ArticleModel::class, ['id' => 5])->getWhereConditionCriteria()->getSql();
        $this->assertEquals('((article.idArticle = 5))', $sql);
    }

    public function testVariableCondition()
    {
        $query = <<<'EOD'
query {
    model(where: {idArticle: $cond }) {
        idArticle
    }
}
EOD;
        $sql = $this->applyWhere($query, ArticleModel::class, ['cond' => ['eq' => 5]])->getWhereConditionCriteria()->getSql();
        $this->assertEquals('((article.idArticle = 5))', $sql);
    }

    /**
     * Currently full Where variable does not support explicit AND/OR conditions.
     */
    public function testVariableFull()
    {
        $query = <<<'EOD'
query {
    model(where: $where) {
        idArticle
    }
}
EOD;
        $sql = $this->applyWhere($query, ArticleModel::class, ['where' => ['idArticle' => ['eq' => 5]]])->getWhereConditionCriteria()->getSql();
        $this->assertEquals('((article.idArticle = 5))', $sql);
    }
}
