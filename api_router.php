<?php
require_once 'libs/router/router.php';
require_once 'apps/controllers/libros.api.controller.php';

$router= new Router();

$router=addRoute('libros', 'GET', 'librosApiController', 'getLibros');
//agregar get por id
//agregar post
$router= addRoute('libros/:id', 'PUT', 'librosApiController', 'updateLibro');

//toma el metodo recurso http y la solicitud
$router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);


