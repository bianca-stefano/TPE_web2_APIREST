<?php
/*
    Este archivo tiene la función validateJWT, que se encarga de revisar matemáticamente que el token sea legítimo 
    (que su firma sea real).
    Además, mira el reloj para comprobar que no se haya pasado de la hora de vencimiento.
    Tambien crea el token.
    Este archivo funciona como una caja de herramientas para el token.
*/

    function createJWT($payload) {
        // Header
        $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
        // Payload
        $payload = json_encode($payload);

        // Base64Url
        $header = base64_encode($header);
        $header = str_replace(['+', '/', '='], ['-', '_', ''], $header);
        $payload = base64_encode($payload);
        $payload = str_replace(['+', '/', '='], ['-', '_', ''], $payload);

        // Firma
        $signature = hash_hmac('sha256', $header . "." . $payload, 'promocionanosProfe', true);
        $signature = base64_encode($signature);
        $signature = str_replace(['+', '/', '='], ['-', '_', ''], $signature);

        // JWT
        $jwt = $header . "." . $payload . "." . $signature;
        return $jwt;
    }

    function validateJWT($jwt) {
        $jwt = explode('.', $jwt);
        if(count($jwt) != 3) {
            return null;
        }
        $header = $jwt[0];
        $payload = $jwt[1];
        $signature = $jwt[2];

        $valid_signature = hash_hmac('sha256', $header . "." . $payload, 'promocionanosProfe', true);
        $valid_signature = base64_encode($valid_signature);
        $valid_signature = str_replace(['+', '/', '='], ['-', '_', ''], $valid_signature);

        if($signature != $valid_signature) {
            return null;
        }

        $payload = base64_decode($payload);
        $payload = json_decode($payload);

        if($payload->exp < time()) {
            return null;
        }

        return $payload;
    }