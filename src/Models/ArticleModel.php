<?php


namespace OrkesterSample\Models;


use Orkester\MVC\MModelMaestro;

class ArticleModel extends MModelMaestro
{
    public static array $map = [
        'table' => 'article',
        'resource' => 'articles',
        'attributes' => [
            'idArticle' => ['key' => 'primary'],
            'title' => ['type' => 'string'],
            'content' => ['type' => 'string'],
            'idAuthor' => ['type' => 'integer', 'nullable' => 'true']
        ],
        'associations' => [
            'author' => ['model' => AuthorModel::class, 'type' => 'one', 'key' => 'idAuthor'],
            'tags' => ['model' => TagModel::class, 'type' => 'many', 'table' => 'article_tag'],
            'comments' => ['model' => CommentModel::class, 'type' => 'many', 'key' => 'idArticle']
        ]
    ];
}
