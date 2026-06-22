<?php
require_once __DIR__ . '/libs/router/router.php';
require_once __DIR__ . '/libs/jwt/jwt.middleware.php'; 
require_once __DIR__ . '/apps/controllers/libros.api.controller.php';
require_once __DIR__ . '/middleware/guard-api.middleware.php';
require_once __DIR__ . '/apps/controllers/auth.api.controller.php';

$router= new Router();

// Se ejecuta SIEMPRE. Si hay un token en la petición, lo lee y lo guarda en $req->user.
// Si no hay token, deja continuar la petición pero sin usuario logueado
$router->addMiddleware(new JWTMiddleware());

// Ruta para obtener el token por primera vez (Login)
$router->addRoute('auth/login',     'POST',     'AuthApiController',    'login');

//publico
$router->addRoute('libros',     'GET', 'librosApiController', 'getLibros');
$router->addRoute('libros/:id', 'GET', 'librosApiController', 'getLibroById');


$router->addMiddleware(new GuardMiddleware());

// Cualquier petición que intente ir a las rutas de abajo SÍ O SÍ debe tener un 
// usuario válido inyectado en la request con el rol 'ADMIN'. Si no, acá se frena todo
$router->addRoute('libros', 'POST', 'librosApiController', 'agregarLibro');
$router->addRoute('libros/:id', 'PUT', 'librosApiController', 'update');

//el resource indica el recurso/destino a donde ir. Ejemplo: libros/5       
//el request_method representa el metodo http que se cargo. Ejemplo: GET
$router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);


/*
    1- El cliente envía una petición (Request): Dispara una solicitud HTTP (por ejemplo, desde Postman) 
    hacia una URL con un método específico (GET, POST, etc.).

    2- Entrada a la aplicación (api_router.php): La petición es capturada por el enrutador principal de la API.

    3- Coincidencia de rutas (Matching): El Router recorre su tabla de ruteo interna y compara la URL y el método 
    HTTP de la petición con los endpoints que habías registrado previamente.

    4- Despacho al Controlador (Dispatch): Una vez que encuentra la ruta correspondiente, el Router instancia el 
    Controlador e invoca la función (método) asociada a ese endpoint, inyectándole los objetos $request y $res.

    5- Consulta al Modelo: El Controlador (que maneja la lógica de negocio) le pide al Modelo que interactúe con la 
    Base de Datos mediante consultas SQL.

    6- Procesamiento de la respuesta: El Controlador recibe los datos crudos del Modelo, realiza las validaciones 
    necesarias y los empaqueta llamando al método $res->json($datos, $codigo_estado).

    7- Serialización y envío (Response): La clase Response se encarga de transformar esos datos nativos de PHP a formato 
    JSON (json_encode), configurar las cabeceras HTTP (Headers) y enviarle la respuesta final al cliente
*/

