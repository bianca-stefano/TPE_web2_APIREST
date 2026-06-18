<?php
require_once 'libs/router/router.php';
require_once './libs/jwt/jwt.middleware.php';
require_once 'apps/controllers/libros.api.controller.php';
require_once './app/middlewares/guard-api.middleware.php';
require_once './app/controllers/auth.api.controller.php';

$router= new Router();

$router->addMiddleware(new JWTMiddleware());
$router->addRoute('auth/login',     'GET',     'AuthApiController',    'login');

$router->addRoute('libros', 'GET', 'librosApiController', 'getLibros');
//agregar get por id

$router->addMiddleware(new GuardMiddleware());
//agregar post
$router->addRoute('libros/:id', 'PUT', 'librosApiController', 'updateLibro');

//toma el metodo recurso http y la solicitud
$router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);


