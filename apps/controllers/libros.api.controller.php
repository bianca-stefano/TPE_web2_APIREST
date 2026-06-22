<?php
require_once __DIR__ . '/../models/libros.models.php';

class librosApiController {
    private $model;

    public function __construct() {
        $this->model= new librosModel();
    }

    public function getLibros($req,$res){
        //ORDENAMIENTO

        //si no pide ninguna forma de orden en especial, por defecto (??) va por id
        $sortBy=$req->query->sort ?? 'id';
        //orden default ascendente
        $order= $req->query->order ?? 'ASC';
        //opcional= ordenar por autor
        $id_autor=$req->query->autor ?? null;

        //PAGINADO
        
        //se obliga que sea un entero 
        $pag= (int) ($req->query->page ?? 1);
        //limite de libors a mostrar en cada pagina
        $limite= (int) ($req->query->limit ?? 10);
        //cuantos libros saltearse, segun la pagina que pidio el usuario
        //(1-1)*10= 0 , no se saltea nada
        //(2-1)*10 se saltea 10
        $offset=($pag-1)*$limite;

        if($id_autor){
            //modificado el libromodel
            $libros= $this->model->getAllByAutor($id_autor, $sortBy, $order, $limite, $offset);
        } else {
            $libros= $this->model->getAllAPI($sortBy,$order, $limite, $offset);
        }
        return $res->json($libros, 200);

    }

    public function getLibroById($req, $res){
        $id_libro = $req->params->id;

        $libro=$this->model->getLibroById($id_libro);

        if(!$libro) {
            return $res->json("Libro id=$id_libro no existe", 404);
        } else{
            return $res->json($libro, 200);
        }
    }

    public function agregarLibro($req, $res){

        $id_autor= $req->body->id_autor ?? null;
        $titulo=$req->body->titulo ?? null;
        $desc=$req->body->descripcion ?? null;
        $f_pub=$req->body->fecha_publicacion ?? null;
        $img=$req->body->imagen ?? null;

        if (empty($id_autor) || empty($titulo) || empty($desc) || empty($f_pub)) {
            return $res->json('Falta completar datos obligatorios', 400);
        }

        $libro = $this->model->add($id_autor, $titulo, $desc, $img, $f_pub);

        if(!$libro){
            return $res->json('no se pudo insertar', 500);
        }

        return $res->json($libro, 201);
    }

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