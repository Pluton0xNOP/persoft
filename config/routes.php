<?php
// config/routes.php
// Rutas de autenticación
$router->get('/auth/login', 'AuthController@showLoginForm');
$router->get('/auth/register', 'AuthController@showRegisterForm');
$router->post('/auth/login', 'AuthController@login');
$router->post('/auth/register', 'AuthController@register');
$router->post('/semaforizacion/actualizarSemaforizacion', 'SemaforizacionController@actualizarSemaforizacion');
?>