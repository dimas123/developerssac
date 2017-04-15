<?php

$container = $app->getContainer();

$container['logger'] = function($c){
    $settings = $c->get('settings')['logger'];

    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], Monolog\Logger::DEBUG));

    return $logger;
};

$container['view'] = function($c){
    $settings = $c->get('settings')['renderer'];

    return new \Slim\Views\PhpRenderer($settings['template_path']);
};

// Service factory for the ORM
$container['db'] = function ($c) {
    $capsule = new \Illuminate\Database\Capsule\Manager;
    $capsule->addConnection($c['settings']['db']);

    $capsule->setAsGlobal();
    $capsule->bootEloquent();

    return $capsule;
};

$container['basePath'] = function($c){
    return $c->get('settings')['basePath'];
};

$container['EmployeeController'] = function($c){
    return new \App\Controllers\EmployeeController($c);
};

