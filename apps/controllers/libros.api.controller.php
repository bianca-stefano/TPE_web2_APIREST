<?php
require_once __DIR__ . '/../models/libros.models.php';

class librosApiController {
    private $model;

    public function __construct() {
        $this->model= new librosModel();
    }

    public function getLibros($req,$res){
        //si no pide ninguna forma de orden en especial, por defecto (??) va por id
        $sortBy=$req->query->sort ?? 'id';
        //orden default ascendente
        $order= $req->query->order ?? 'ASC';
        
        //opcional= ordenar por autor
        $id_autor=$req->query->autor ?? null;
        if($id_autor){
            $libros= $this->model->getAllByAutor($id_autor, $sortBy, $order);
        } else {
            $libros= $this->model->getAll($sortBy,$order);
        }
        return $res->json($libros, 200);

    }

    //hacer insert para el post

    public function update($req,$res){
        $id_libro=$req->params->id;

        $libro=$this->model->getLibroById($id_libro);
        if(!$libro) {
            return $res->json("Libro id=$id_libro no existe", 404);
        }

        $id_autor= $req->body->id_autor ?? null;
        $titulo=$req->body->titulo ?? null;
        $desc=$req->body->descripcion ?? null;
        $f_pub=$req->body->fecha_publicacion ?? null;
        $img=$req->body->imagen ?? null;

        if (empty($id_autor) || empty($titulo) || empty($desc) || empty($f_pub)) {
            return $res->json('Falta completar datos obligatorios', 400);
        }

        $this->model->update($id_libro,$id_autor,$titulo, $desc, $img, $f_pub);
        //pide el libro a la base para mostrarlo actualizado
        $libroAct=$this->model->getLibroById($id_libro);
        return $res->json($libroAct, 200);
    }
    
}