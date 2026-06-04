<?php
class librosModel {
    private $db;

    public function __construct() {
        $this->db= new PDO('mysql:host=localhost;dbname=biblioteca;charset=utf8', 'root','');
    }

    public function getAll() {
        $query= $this->db->prepare('SELECT * FROM libro');
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function getLibroById($id) {
        $query=$this->db->prepare('SELECT* FROM libro WHERE id=?');
        $query->execute([$id]);
        return $query->fetch(PDO :: FETCH_OBJ);
    }

    //no confundir y pensar que el sort es un group by, los dos son formas de ordenamiento
    public function getAllByAutor($id, $sort, $order){
        $query=$this->db->prepare('SELECT * FROM libro
                                    WHERE id_autor= ?
                                    ORDER BY $sort $order');
        $query->execute([$id]);
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function update($id, $id_autor, $titulo, $desc, $img, $f_pub) {
        $query=$this->db->prepare('UPDATE libro SET id=?, id_autor=?, titulo=?,
                                     descripcion=?,imagen=?, fecha_publicacion=?');
        $query->execute([$id,$id_autor, $titulo, $desc, $img, $f_pub]);
        
    }
}