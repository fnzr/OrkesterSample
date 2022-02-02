<?php


namespace OrkesterSample\Models;


use Orkester\MVC\MModelMaestro;

class CommentModel extends MModelMaestro
{
    public static array $map = [
        'table' => 'comment',
        'resource' => 'comments',
        'attributes' => [
            'idComment' => ['key' => 'primary'],
            'message' => ['type' => 'string'],
        ],
        'associations' => [
            'article' => ['model' => ArticleModel::class, 'type' => 'one', 'key' => 'idArticle'],
        ]
    ];


    public static function validateArticle(object $entity, int $id): array
    {
        return [];
    }
}
