<?php

require_once "../controladores/tallas.controlador.php";
require_once "../modelos/tallas.modelo.php";

class AjaxTallas{

    public $nombre;

    public function getAjaxListarTallasTable(){
        $tallas = TallasControlador::ctrGetListarTallasTable();
        echo json_encode($tallas);
    }
    public function setAjaxRegistrarTalla(){
        $respuesta = TallasControlador::ctrSetRegistrarTalla($this->nombre);
        echo json_encode($respuesta);
    }
    public function setAjaxActualizarTalla($data){
        $table = 'tallas';
        $id = $_POST['id_talla'];
        $nameId = 'id_talla';
        $respuesta = TallasControlador::ctrSetActualizarTalla($table, $data, $id, $nameId);
        echo json_encode($respuesta);
    }
    public function setAjaxEliminarTalla(){
        $table = 'tallas';
        $id = $_POST['id_talla'];
        $nameId = 'id_talla';
        $respuesta = TallasControlador::ctrSetEliminarTalla($table, $id, $nameId);
        echo json_encode($respuesta);
    }
    public function getAjaxListarTallas(){
        $tallas = TallasControlador::ctrGetListarTallas();
        echo json_encode($tallas, JSON_UNESCAPED_UNICODE);
    }
}
if(isset($_POST['accion']) && $_POST['accion'] == 1){//Parametro para listar tallas
    $tallas = new AjaxTallas();
    $tallas->getAjaxListarTallasTable();
}else if(isset($_POST['accion']) && $_POST['accion'] == 2){//Parametro para registrar tallas
    $registrarTalla = new AjaxTallas();
    $registrarTalla -> nombre = $_POST['nombre'];
    $registrarTalla -> setAjaxRegistrarTalla();
}else if(isset($_POST['accion']) && $_POST['accion'] == 3){//Parametro para actualizar talla
    $actualizarTalla = new AjaxTallas();
    $data = array(
        'id_talla' => $_POST['id_talla'],
        'nombre' => $_POST['nombre'],
    );
    $actualizarTalla -> setAjaxActualizarTalla($data);
}else if(isset($_POST['accion']) && $_POST['accion'] == 4){//Parametro para eliminar talla
    $eliminarTalla = new AjaxTallas();
    $eliminarTalla->setAjaxEliminarTalla();
}else if(isset($_POST['accion']) && $_POST['accion'] == 5){
    $tallas = new AjaxTallas();
    $tallas->getAjaxListarTallas();
}
