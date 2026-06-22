<?php

class AutoresModel{
   private $db;

   public function __construct() {
        $this->db = new PDO('mysql:host=localhost;dbname=biblioteca;charset=utf8', 'root', 'root');
   }

   public function getAll() {
      // 2. prepara y ejecuta la consulta
      $query = $this->db->prepare('SELECT * FROM autor');
      $query->execute();

      // 3. obtiene los resultados
      $autores = $query->fetchAll(PDO::FETCH_OBJ);

      // var_dump($query->errorInfo());

      return $autores;
   }

   public function get($id) {
      $query = $this->db->prepare('SELECT * FROM autor WHERE id = ?');
      $query->execute([$id]);

      return $query->fetch(PDO::FETCH_ASSOC);
   }

   public function insert($nombre, $apellido, $fecha_nac, $biografia, $foto) {
      $query = $this->db->prepare('INSERT INTO autor(nombre, apellido, fecha_nac, biografia, foto) VALUES(?,?,?,?,?)');
      $query->execute([$nombre, $apellido, $fecha_nac, $biografia, $foto]);

      return $this->db->lastInsertId();
   }

   public function delete($id) {
      $query = $this->db->prepare('DELETE FROM autor WHERE id = ?');
      $query->execute([$id]);
   }

   public function update($id, $nombre, $apellido, $fecha_nac, $biografia, $foto) {
      $query = $this->db->prepare('UPDATE autor SET nombre = ?, apellido = ?, fecha_nac = ?, biografia = ?, foto = ? WHERE id = ?');
      $query->execute([$nombre, $apellido, $fecha_nac, $biografia, $foto, $id]);
  }

}