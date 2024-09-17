<?php

require_once "../controladores/marcas.controlador.php";
require_once "../modelos/marcas.modelo.php";

class AjaxMarcas{

    public $nombre;

    public function getAjaxListarMarcasTable(){
        $marcas = MarcasControlador::ctrGetListarMarcasTable();
        echo json_encode($marcas);
    }
    public function setAjaxRegistrarMarca(){
        $respuesta = MarcasControlador::ctrSetRegistrarMarca($this->nombre);
        echo json_encode($respuesta);
    }
    public function setAjaxActualizarMarca($data){
        $table = 'marcas';
        $id = $_POST['id_marca'];
        $nameId = 'id_marca';
        $respuesta = MarcasControlador::ctrSetActualizarMarca($table, $data, $id, $nameId);
        echo json_encode($respuesta);
    }
    public function setAjaxEliminarMarca(){
        $table = 'marcas';
        $id = $_POST['id_marca'];
        $nameId = 'id_marca';
        $respuesta = MarcasControlador::ctrSetEliminarMarca($table, $id, $nameId);
        echo json_encode($respuesta);
    }
    public function getAjaxListarMarcas(){
        $marcas = MarcasControlador::ctrGetListarMarcas();
        echo json_encode($marcas, JSON_UNESCAPED_UNICODE);
    }
}
if(isset($_POST['accion']) && $_POST['accion'] == 1){//Parametro para listar marcas
    $marcas = new AjaxMarcas();
    $marcas->getAjaxListarMarcasTable();
}else if(isset($_POST['accion']) && $_POST['accion'] == 2){//Parametro para registrar marcas
    $registrarMarca = new AjaxMarcas();
    $registrarMarca -> nombre = $_POST['nombre'];
    $registrarMarca -> setAjaxRegistrarMarca();
}else if(isset($_POST['accion']) && $_POST['accion'] == 3){//Parametro para actualizar marca
    $actualizarMarca = new AjaxMarcas();
    $data = array(
        'id_marca' => $_POST['id_marca'],
        'nombre' => $_POST['nombre'],
    );
    $actualizarMarca -> setAjaxActualizarMarca($data);
}else if(isset($_POST['accion']) && $_POST['accion'] == 4){//Parametro para eliminar marca
    $eliminarMarca = new AjaxMarcas();
    $eliminarMarca->setAjaxEliminarMarca();
}else if(isset($_POST['accion']) && $_POST['accion'] == 5){
    $marcas = new AjaxMarcas();
    $marcas->getAjaxListarMarcas();
}
