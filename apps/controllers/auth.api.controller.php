<?php
require_once 'app/models/users.model.php';
require_once 'libs/jwt.php';

class AunthApiController {
    private $model;

    public function __construct () {
        $this->model = new UsersModel();
    }

    public function login($req, $res) {
        //leer encabezado
        $authorization= $req->authorization;

        $auth= explode( '', $authorization);
        if(count($auth)!= 2 || $auth[0] !== 'Basic') {
            header("WWW-Authenticate: Basic realm= 'Get a token'");
            return $res->json("unathorized", 401);
        }

        $auth= base64_decode($auth[1]);
        $user_pass= explode(":", $auth);
        if(count($user_pass)!= 2) {
            return $res->json("unathorized", 401);
        }

        $user= $user_pass[0];
        $password= $user_pass[1];

        $userBD= $this->model->getByUser($user);

        if(!$userBD || password_verify($password, $userBD->password)) {
            return $res->json("usuario o contraseña incorrecta", 401);
        }

        //return el token
        $payload= [
            'sub'=> $userBD->id,
            'usuario'=> $userBD->usuario,
            'roles' => ['ADMIN', 'USER', 'BANANA'],
            'exp' => time() + 3600 // Expira en 1 hora
        ];

        return $res->json(createJWT($payload));

    }
}