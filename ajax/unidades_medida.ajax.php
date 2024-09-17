<?php

require_once "../controladores/unidades_medida.controlador.php";
require_once "../modelos/unidades_medida.modelo.php";

class AjaxUnidadesMedida{

    public $nombre;
    public $id_udm_referencia;
    public $ratio;
    public $estado;

    public function getAjaxListarUnidadesMedidaTable(){
        $unidades_medida = UnidadesMedidaControlador::ctrGetListarUnidadesMedidaTable();
        echo json_encode($unidades_medida);
    }
    public function setAjaxRegistrarUnidadMedida(){
        $respuesta = UnidadesMedidaControlador::ctrSetRegistrarUnidadMedida($this->nombre, $this->id_udm_referencia, $this->ratio, $this->estado);
        echo json_encode($respuesta);
    }
    public function setAjaxActualizarUnidadMedida($data){
        $table = 'unidades_medida';
        $id = $_POST['id_unidad_medida'];
        $nameId = 'id_unidad_medida';
        $respuesta = UnidadesMedidaControlador::ctrSetActualizarUnidadMedida($table, $data, $id, $nameId);
        echo json_encode($respuesta);
    }
    public function setAjaxEliminarUnidadMedida(){
        $table = 'unidades_medida';
        $id = $_POST['id_unidad_medida'];
        $nameId = 'id_unidad_medida';
        $respuesta = UnidadesMedidaControlador::ctrSetEliminarUnidadMedida($table, $id, $nameId);
        echo json_encode($respuesta);
    }
    public function getAjaxListarUnidadesMedida(){
        $unidades_medida = UnidadesMedidaControlador::ctrGetListarUnidadesMedida();
        echo json_encode($unidades_medida, JSON_UNESCAPED_UNICODE);
    }
}
if(isset($_POST['accion']) && $_POST['accion'] == 1){//Parametro para listar unidades de medida
    $unidades_medida = new AjaxUnidadesMedida();
    $unidades_medida->getAjaxListarUnidadesMedidaTable();
}else if(isset($_POST['accion']) && $_POST['accion'] == 2){//Parametro para registrar unidades de medida
    $registrarUnidadMedida = new AjaxUnidadesMedida();
    $registrarUnidadMedida -> nombre = $_POST['nombre'];
    $registrarUnidadMedida -> id_udm_referencia = $_POST['id_udm_referencia'];
    $registrarUnidadMedida -> ratio = $_POST['ratio'];
    $registrarUnidadMedida -> estado = $_POST['estado'];
    $registrarUnidadMedida -> setAjaxRegistrarUnidadMedida();
}else if(isset($_POST['accion']) && $_POST['accion'] == 3){//Parametro para actualizar unidad de medida
    $actualizarUnidadMedida = new AjaxUnidadesMedida();
    $data = array(
        'id_unidad_medida' => $_POST['id_unidad_medida'],
        'nombre' => $_POST['nombre'],
        'id_udm_referencia' => $_POST['id_udm_referencia'],
        'ratio' => $_POST['ratio'],
        'estado' => $_POST['estado'],
    );
    $actualizarUnidadMedida -> setAjaxActualizarUnidadMedida($data);
}else if(isset($_POST['accion']) && $_POST['accion'] == 4){//Parametro para eliminar unidad de medida
    $eliminarUnidadMedida = new AjaxUnidadesMedida();
    $eliminarUnidadMedida->setAjaxEliminarUnidadMedida();
}else if(isset($_POST['accion']) && $_POST['accion'] == 5){
    $unidades_medida = new AjaxUnidadesMedida();
    $unidades_medida->getAjaxListarUnidadesMedida();
}
