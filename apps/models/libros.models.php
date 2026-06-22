<?php
class librosModel {
    private $db;

    public function __construct() {
        $this->db= new PDO('mysql:host=localhost;dbname=biblioteca;charset=utf8', 'root','root');
    }

    public function getAll() {
        $query= $this->db->prepare('SELECT * FROM libro');
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    
    public function getAllAPI($sortBy,$order, $limite, $offset) {
        $sql=   "SELECT * FROM libro
                ORDER BY $sortBy $order
                LIMIT $limite OFFSET $offset"; 
        $query= $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function getLibroById($id) {
        $query=$this->db->prepare('SELECT* FROM libro WHERE id=?');
        $query->execute([$id]);
        return $query->fetch(PDO :: FETCH_OBJ);
    }

    //no confundir y pensar que el sort es un group by, los dos son formas de ordenamiento
    public function getAllByAutor($id_autor, $sortBy, $order, $limite, $offset){
        $sql= "SELECT * FROM libro
                WHERE id_autor= ?
                ORDER BY $sortBy $order
                LIMIT $limite OFFSET $offset";
        $query=$this->db->prepare($sql);
        $query->execute([$id_autor]);
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function update($id, $id_autor, $titulo, $desc, $img, $f_pub) {
        $query = $this->db->prepare('UPDATE libro 
                                     SET id_autor = ?, titulo = ?, descripcion = ?, imagen = ?, fecha_publicacion = ? 
                                     WHERE id = ?');
        $query->execute([$id_autor, $titulo, $desc, $img, $f_pub, $id]);
    }

    public function add($id_autor, $titulo, $desc, $img, $f_pub){
        $query = $this->db->prepare('INSERT INTO libro(titulo, id_autor, descripcion, imagen, fecha_publicacion) VALUES(?,?,?,?,?)');
        $query->execute([$titulo, $id_autor, $desc, $img, $f_pub]);

        return $this->db->lastInsertId();
    }
}