<?php


namespace OrkesterSample\Models;


use Orkester\MVC\MModelMaestro;

class AuthorModel extends MModelMaestro
{
    public static array $map = [
        'table' => 'author',
        'resource' => 'authors',
        'attributes' => [
            'idAuthor' => ['key' => 'primary'],
            'name' => ['type' => 'string'],
        ],
        'associations' => [
            'articles' => ['model' => ArticleModel::class, 'type' => 'many', 'key' => 'idAuthor'],
        ]
    ];

    public static function validate(object $entity, object|null $old): array
    {
        $errors = [];
        if (strlen($entity->name) < 3) {
            $errors['name'] = 'Author name must have at least 3 characters';
        }
        return $errors;
    }
}
