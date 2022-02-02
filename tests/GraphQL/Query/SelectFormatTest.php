<?php

namespace GraphQL\Query;

use Orkester\GraphQL\Operator\Select;
use OrkesterSample\Models\ArticleModel;
use OrkesterSample\Models\AuthorModel;

if (file_exists('./GraphQL/Query/SelectTest.php')) {
    require_once './GraphQL/Query/SelectTest.php';
}

class SelectFormatTest extends SelectTest
{

    public function testDepth2()
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
        $root = $this->getQueryFieldNode($query);
        $select = new Select(AuthorModel::getCriteria(), $root->selectionSet, []);
        $criteria = $select->apply();
        $result1 = $criteria->asResult();
//        mdump($result1);
//        $result = $select->formatResult($result1);
        $select->b($result1);
//        mdump($result);
        $this->fail();
    }
}
