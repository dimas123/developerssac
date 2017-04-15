<?php

return [
    'settings' => [
        'displayErrorDetails' => true,
        'logger' => [
            'name' => 'slim-app',
            'path' => __DIR__ . '/../logs/app.log'
        ],
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/'
        ],
        'db' => [
            'driver' => 'mysql',
            'host' => 'localhost',
            'port' => '5432',
            'database' => 'slim_test',
            'username' => 'slim2',
            'password' => 'slim2',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
        ],
        'basePath' => __DIR__. '/../'
    ]
];