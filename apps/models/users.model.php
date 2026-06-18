<?php

class UsersModel {
   private $db;

   public function __construct() {
      // 1. abre conexión con DB
      //$this->db = new PDO("mysql:host=".MYSQL_HOST.";dbname=".MYSQL_HOST.";charset=utf8", MYSQL_USER, MYSQL_PASS);
      //$this->deploy();
          $this->db = new PDO('mysql:host=localhost;dbname=biblioteca;charset=utf8', 'root', '');
   }
   

   public function getAll() {
      // 2. prepara y ejecuta la consulta
      $query = $this->db->prepare('SELECT * FROM usuario');
      $query->execute();

      // 3. obtiene los resultados
      $usuarios = $query->fetchAll(PDO::FETCH_OBJ);

      // var_dump($query->errorInfo());

      return $usuarios;
   }

   public function get($id) {
      $query = $this->db->prepare('SELECT * FROM usuario WHERE id_usuario = ?');
      $query->execute([$id]);

      return $query->fetch(PDO::FETCH_OBJ);
   }

   public function getByEmail($email) {
      $query = $this->db->prepare('SELECT * FROM usuario WHERE email = ?');
      $query->execute([$email]);

      return $query->fetch(PDO::FETCH_OBJ);
   }

   public function insert($email, $password) {
      // 1. Encriptamos la contraseña
      $hash = password_hash($password, PASSWORD_BCRYPT);
  
      // 2. Preparamos la consulta
      $query = $this->db->prepare('INSERT INTO usuario (email, password) VALUES (?, ?)');
      
      // 3. Ejecutamos pasando el mail y el HASH 
      $query->execute([$email, $hash]);
  }

  public function getByUser($user) {
        $query = $this->db->prepare('SELECT * FROM usuario WHERE usuario = ?');
        $query->execute([$user]);
        $user = $query->fetch(PDO::FETCH_OBJ);

        return $user;
    }
}