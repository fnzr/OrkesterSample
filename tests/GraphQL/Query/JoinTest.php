<?php

namespace GraphQL\Query;

use OrkesterSample\Models\ArticleModel;
use OrkesterSample\Models\AuthorModel;

if (file_exists('./GraphQL/Query/SelectTest.php')) {
    require_once './GraphQL/Query/SelectTest.php';
}

class JoinTest extends SelectTest
{

    public function testDepth1()
    {
        $query = <<<EOD
query {
    article {
        title
        comments(join: "LEFT") {
            message
        }
    }
}
EOD;
        $criteria = $this->applySelect($query, ArticleModel::class);
        $this->assertEquals([
            ['article', 'comment comments_1', '(article.idArticle=comments_1.idArticle)', 'LEFT']
        ], $criteria->getAssociationsJoin());
    }

    public function testDepth2()
    {
        $query = <<<EOD
query {
    author {
        name
        articles {
            title
            comments(join: "LEFT") {
                message
            }
        }
    }
}
EOD;
        $criteria = $this->applySelect($query, AuthorModel::class);
        $this->assertEquals([
            ['author', 'article articles_1', '(author.idAuthor=articles_1.idAuthor)', 'INNER'],
            ['article articles_1', 'comment comments_1', '(articles_1.idArticle=comments_1.idArticle)', 'LEFT']
        ], $criteria->getAssociationsJoin());
    }
}
