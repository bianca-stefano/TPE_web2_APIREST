<?php

// Aseguramos que herede de la clase Middleware del sistema
class GuardMiddleware extends Middleware {
    
    // El router va a llamar a esta función 'run' de forma nativa
    public function run($request, $response) {
        
        // 1. Si el JWTMiddleware no inyectó ningún usuario, rebotamos
        if (!isset($request->user) || $request->user === null) {
            return $response->json("unathorized", 401);
        }

        // 2. Comprobamos si el usuario tiene el rol ADMIN adentro de sus roles
        // Como en tu payload pusimos 'roles' => ['ADMIN', 'USER'], es un arreglo
        if (!isset($request->user->roles) || !in_array('ADMIN', $request->user->roles)) {
            return $response->json("Forbidden: No tenés permisos de administrador", 403);
        }

        // Si pasó las dos pruebas, no hacemos nada (el router sigue viaje hacia el controlador)
    }
}