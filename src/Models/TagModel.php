<?php


namespace OrkesterSample\Models;


use Orkester\MVC\MModelMaestro;

class TagModel extends MModelMaestro
{
    public static array $map = [
        'table' => 'tag',
        'resource' => 'tags',
        'attributes' => [
            'idTag' => ['key' => 'primary'],
            'value' => ['type' => 'string'],
        ],
        'associations' => [
            'articles' => ['model' => ArticleModel::class, 'type' => 'many', 'table' => 'article_tag'],
        ]
    ];
}
