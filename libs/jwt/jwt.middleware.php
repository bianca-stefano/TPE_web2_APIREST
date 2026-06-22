<?php

require_once __DIR__ . '/jwt.php';

//es para validar el token, si no, no sirve para lo demas
//controla si el token te da pase a diferentes funcionalidades

class JWTMiddleware extends Middleware {
    public function run($request, $response) {
        // Buscamos el token en los headers estándar o en el alternativo para tu Mac
        $headers = apache_request_headers();
        $auth_header = null;

        if (isset($headers['Authorization'])) {
            $auth_header = $headers['Authorization'];
        } elseif (isset($headers['authorization'])) {
            $auth_header = $headers['authorization'];
        } elseif (isset($headers['X-Authorization'])) { // Salvavidas para MAMP en Mac
            $auth_header = $headers['X-Authorization'];
        }

        if (!$auth_header) {
            return; // Si no hay token, continúa (el Guard se encargará de frenarlo si es privada)
        }

        $auth_header = explode(' ', $auth_header); // ["Bearer", "un.token.firma"]
        
        if(count($auth_header) != 2) {
            return;
        }
        
        if($auth_header[0] != 'Bearer' && $auth_header[0] != 'Basic') { 
            // Permitimos pasar si es Bearer (o Basic si el login se procesara acá)
            return;
        }
        
        // Si el header era el de Basic Auth del login, no queremos que intente validarlo como JWT
        if ($auth_header[0] === 'Basic') {
            return;
        }

        $jwt = $auth_header[1];
        $request->user = validateJWT($jwt);
    }
}