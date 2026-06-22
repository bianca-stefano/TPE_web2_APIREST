
<?php
require_once __DIR__ . '/../models/users.model.php'; 
require_once __DIR__ . '/../../libs/jwt/jwt.php';   

class AuthApiController {
    private $model;

    public function __construct () {
        $this->model = new UsersModel();
    }

    public function login($req, $res) {
        $headers = apache_request_headers();
        
        // Buscamos el original, o el alternativo si MAMP hace de las suyas
        $authorization = null;
        if (isset($headers['Authorization'])) {
            $authorization = $headers['Authorization'];
        } elseif (isset($headers['authorization'])) {
            $authorization = $headers['authorization'];
        } elseif (isset($headers['X-Authorization'])) { // Salvavidas para tu Mac
            $authorization = $headers['X-Authorization'];
        }

        if (!$authorization) {
            header("WWW-Authenticate: Basic realm='Get a token'");
            return $res->json("unathorized", 401);
        }

        $auth = explode(' ', $authorization);
        if(count($auth) != 2 || $auth[0] !== 'Basic') {
            header("WWW-Authenticate: Basic realm='Get a token'");
            return $res->json("unathorized", 401);
        }

        $auth = base64_decode($auth[1]);
        $user_pass = explode(":", $auth);
        if(count($user_pass) != 2) {
            return $res->json("unathorized", 401);
        }

        $user = $user_pass[0];
        $password = $user_pass[1];

        $userBD = $this->model->getByUser($user);

        if(!$userBD || !password_verify($password, $userBD->password)) {
            return $res->json("usuario o contraseña incorrecta", 401);
        }

        // Armamos el token
        $payload = [
            'sub' => $userBD->id_usuario, 
            'usuario' => $userBD->email,  
            'roles' => ['ADMIN', 'USER'],
            'exp' => time() + 3600 
        ];

        return $res->json(createJWT($payload));
    }
}