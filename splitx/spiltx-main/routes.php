<?php
$router->get('/', 'DashboardController@show');

// Authentication Routes
$router->get('/login', 'LoginController@show');
$router->post('/login', 'LoginController@verify');
$router->get('/logout', 'LogoutController@logout');

$router->get('/register', 'RegisterController@show');
$router->post('/register', 'RegisterController@register');

$router->get('/dashboard', 'DashboardController@show');

// Group Management
$router->get('/groups', 'GroupController@index');
$router->get('/groups/create', 'GroupController@create');
$router->post('/groups', 'GroupController@store');
$router->get('/groups/edit', 'GroupController@edit');
$router->post('/groups/edit', 'GroupController@update');
$router->post('/groups/delete', 'GroupController@delete');
$router->get('/groups/search-user', 'GroupController@searchUser');

// Event Management
$router->get('/events', 'EventController@index');
$router->get('/events/create', 'EventController@create');
$router->post('/events', 'EventController@store');
$router->get('/events/edit', 'EventController@edit');
$router->post('/events/edit', 'EventController@update');
$router->post('/events/delete', 'EventController@delete');
