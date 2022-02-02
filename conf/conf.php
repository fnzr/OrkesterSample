<?php

return [
    'name' => 'OrkesterSample',
    'options' => [
        'app' => 'orkester_sample',
        'debug' => true,
        'charset' => 'UTF-8',
        'timezone' => "America/Sao_Paulo",
        'separatorDate' => '/',
        'csv' => ';',
        'mode' => 'DEV',
        'dispatch' => 'index.php',
        'tmpPath' => sys_get_temp_dir(),
        'locale' => array("pt_BR.utf8", "ptb"), // linux: check installed locales - "locale -a"
        'fetchStyle' => \FETCH_ASSOC,
        'language' => 'en',
        'defaultPassword' => 'default',
        'templateDefault' => 'index',
        'templatePath' => ['./src/UI'],
        'db' => 'blog',
        'allowSkipValidation' => false
    ],
    'login' => [
        'handler' => 'login',
        'class' => "Orkester\\Security\\MAuth",
        'check' => true
    ],
    'session' => [
        'handler' => "file",
        'timeout' => "30",
        'exception' => false,
        'check' => true,
        'dbsession' => false,
    ],
    'logs' => [
        'channel' => 'orkester',
        'path' => __DIR__ . '/../var/log',
        'level' => 2,
        'handler' => "socket",
        //'peer' => isset($_SERVER['REMOTE_ADDR']) ? 'host.docker.internal' : 'localhost',
        'peer' => '192.168.1.3', //192.168.0.172
        //'strict' => '127.0.0.1',
        'port' => 9999,
        'console' => 1,
        'errorCodes' => [
            E_ERROR,
            E_WARNING,
            E_PARSE,
            E_RECOVERABLE_ERROR,
            E_USER_ERROR,
            E_COMPILE_ERROR,
            E_CORE_ERROR
        ],
    ],
    'cache' => [
        'type' => "apcu", // php, java, apc, apcu, memcache
        'path' => __DIR__ . '/../var/cache',
        'memcache' => [
            'host' => "127.0.0.1",
            'port' => "11211",
            'default.ttl' => 0
        ],
        'apc' => [
            'default.ttl' => 0
        ]
    ],

];
