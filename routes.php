<?php

$router->get('login', 'app/views/CRUDtw/login.php');
$router->post('login', 'app/views/CRUDtw/login.php');
$router->get('logout', 'app/views/CRUDtw/logout.php');

$router->group(['middleware' => ['auth']], function ($router) {
    $router->get('user-dashboard', 'app/views/CRUDtw/user-dashboard.php');
});

$router->group(['middleware' => ['auth', 'admin']], function ($router) {
    $router->get('users', 'app/views/CRUDtw/index.php');
    $router->get('add-user', 'app/views/CRUDtw/ADD.php');
    $router->post('add-user', 'app/views/CRUDtw/ADD.php');
    $router->get('edit-user', 'app/views/CRUDtw/edit.php');
    $router->post('edit-user', 'app/views/CRUDtw/edit.php');
    $router->post('delete-user', 'app/views/CRUDtw/delete.php');
});

$router->get('aboutus', 'app/views/aboutus.php');
$router->get('gmail', 'app/views/gmail.php');
$router->get('lastname', 'app/views/lastname.php');
