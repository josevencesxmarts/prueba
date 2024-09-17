<?php

require_once "../controladores/colores.controlador.php";
require_once "../modelos/colores.modelo.php";

class AjaxColores{

    public $nombre;

    public function getAjaxListarColoresTable(){
        $colores = ColoresControlador::ctrGetListarColoresTable();
        echo json_encode($colores);
    }
    public function setAjaxRegistrarColor(){
        $respuesta = ColoresControlador::ctrSetRegistrarColor($this->nombre);
        echo json_encode($respuesta);
    }
    public function setAjaxActualizarColor($data){
        $table = 'colores';
        $id = $_POST['id_color'];
        $nameId = 'id_color';
        $respuesta = ColoresControlador::ctrSetActualizarColor($table, $data, $id, $nameId);
        echo json_encode($respuesta);
    }
    public function setAjaxEliminarColor(){
        $table = 'colores';
        $id = $_POST['id_color'];
        $nameId = 'id_color';
        $respuesta = ColoresControlador::ctrSetEliminarColor($table, $id, $nameId);
        echo json_encode($respuesta);
    }
    public function getAjaxListarColores(){
        $colores = ColoresControlador::ctrGetListarColores();
        echo json_encode($colores, JSON_UNESCAPED_UNICODE);
    }
}
if(isset($_POST['accion']) && $_POST['accion'] == 1){//Parametro para listar colores
    $colores = new AjaxColores();
    $colores->getAjaxListarColoresTable();
}else if(isset($_POST['accion']) && $_POST['accion'] == 2){//Parametro para registrar colores
    $registrarColor = new AjaxColores();
    $registrarColor -> nombre = $_POST['nombre'];
    $registrarColor -> setAjaxRegistrarColor();
}else if(isset($_POST['accion']) && $_POST['accion'] == 3){//Parametro para actualizar color
    $actualizarColor = new AjaxColores();
    $data = array(
        'id_color' => $_POST['id_color'],
        'nombre' => $_POST['nombre'],
    );
    $actualizarColor -> setAjaxActualizarColor($data);
}else if(isset($_POST['accion']) && $_POST['accion'] == 4){//Parametro para eliminar color
    $eliminarColor = new AjaxColores();
    $eliminarColor->setAjaxEliminarColor();
}else if(isset($_POST['accion']) && $_POST['accion'] == 5){
    $colores = new AjaxColores();
    $colores->getAjaxListarColores();
}
