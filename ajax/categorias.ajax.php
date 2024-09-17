<?php

require_once "../controladores/categorias.controlador.php";
require_once "../modelos/categorias.modelo.php";

class AjaxCategorias{

    public $nombre;
    public $id_categoria_padre;
    public $tipo_negocio;
    public $aplica_peso;
    public $estado;

    public function getAjaxListarCategoriasTable(){
        $categorias = CategoriasControlador::ctrGetListarCategoriasTable();
        echo json_encode($categorias);
    }
    public function setAjaxRegistrarCategoria(){
        $respuesta = CategoriasControlador::ctrSetRegistrarCategoria($this->nombre, $this->id_categoria_padre, $this->tipo_negocio, $this->aplica_peso, $this->estado);
        echo json_encode($respuesta);
    }
    public function setAjaxActualizarCategoria($data){
        $table = 'categorias';
        $id = $_POST['id_categoria'];
        $nameId = 'id_categoria';
        $respuesta = CategoriasControlador::ctrSetActualizarCategoria($table, $data, $id, $nameId);
        echo json_encode($respuesta);
    }
    public function setAjaxEliminarCategoria(){
        $table = 'categorias';
        $id = $_POST['id_categoria'];
        $nameId = 'id_categoria';
        $respuesta = CategoriasControlador::ctrSetEliminarCategoria($table, $id, $nameId);
        echo json_encode($respuesta);
    }
    public function getAjaxListarCategorias(){
        $categorias = CategoriasControlador::ctrGetListarCategorias();
        echo json_encode($categorias, JSON_UNESCAPED_UNICODE);
    }
}
if(isset($_POST['accion']) && $_POST['accion'] == 1){//Parametro para listar categorias
    $categorias = new AjaxCategorias();
    $categorias->getAjaxListarCategoriasTable();
}else if(isset($_POST['accion']) && $_POST['accion'] == 2){//Parametro para registrar categorias
    $registrarCategoria = new AjaxCategorias();
    $registrarCategoria -> nombre = $_POST['nombre'];
    $registrarCategoria -> id_categoria_padre = $_POST['id_categoria_padre'];
    $registrarCategoria -> tipo_negocio = $_POST['tipo_negocio'];
    $registrarCategoria -> aplica_peso = $_POST['aplica_peso'];
    $registrarCategoria -> estado = $_POST['estado'];
    $registrarCategoria -> setAjaxRegistrarCategoria();
}else if(isset($_POST['accion']) && $_POST['accion'] == 3){//Parametro para actualizar categoria
    $actualizarCategoria = new AjaxCategorias();
    $data = array(
        'id_categoria' => $_POST['id_categoria'],
        'nombre' => $_POST['nombre'],
        'tipo_negocio' => $_POST['tipo_negocio'],
        'aplica_peso' => $_POST['aplica_peso'],
        'id_categoria_padre' => $_POST['id_categoria_padre'],
        'estado' => $_POST['estado'],
    );
    $actualizarCategoria -> setAjaxActualizarCategoria($data);
}else if(isset($_POST['accion']) && $_POST['accion'] == 4){//Parametro para eliminar categoria
    $eliminarCategoria = new AjaxCategorias();
    $eliminarCategoria->setAjaxEliminarCategoria();
}else if(isset($_POST['accion']) && $_POST['accion'] == 5){
    $categorias = new AjaxCategorias();
    $categorias->getAjaxListarCategorias();
}
