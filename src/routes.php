<?php

$app->get('/', function($request, $response, $args){
    return $response->withRedirect('/employee');
});

$app->get('/employee', 'EmployeeController:index');
$app->get('/employee/show[/{id}]', 'EmployeeController:show');
$app->post('/employee/store', 'EmployeeController:store');

#web services
$app->get('/app/employee', 'EmployeeController:getApp');


