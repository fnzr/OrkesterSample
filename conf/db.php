<?php
return [
    'db' => [
        'blog' => [
            'db' => 'mysql',
            'driver' => 'pdo_mysql',
            'host' => 'localhost:33365',
            'dbname' => 'blog_db',
            'user' => 'user',
            'password' => 'user',
            'formatDate' => '%d/%m/%Y',
            'formatDatePHP' => 'd/m/Y',
            'formatDateWhere' => '%Y/%m/%d',
            'formatTime' => '%H:%i',
            'formatTimePHP' => 'H:i',
            'formatTimeWhere' => '%H:%i',
            'charset' => 'utf8',
            'collate' => 'utf8_bin',
            'sequence' => [
                'table' => 'Sequence',
                'name' => 'Name',
                'value' => 'Value'
            ],
            'configurationClass' => 'Doctrine\DBAL\Configuration',
        ],
    ],
];
