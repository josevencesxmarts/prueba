<?php

require_once "../controladores/configuracion.controlador.php";
require_once "../modelos/configuracion.modelo.php";

class AjaxConfiguracion{

    public function getAjaxListarConfiguracion(){
        $lista_configuracion = ConfiguracionControlador::ctrGetListarConfiguracion();
        echo json_encode($lista_configuracion);
    }
    public function setAjaxActualizarConfiguracion($data){
        $respuesta = ConfiguracionControlador::ctrSetActualizarConfiguracion($data);
        echo json_encode($respuesta);
    }
}
if(isset($_POST['accion']) && $_POST['accion'] == 1){//Parametro para listar configuracion{
    $configuracion = new AjaxConfiguracion();
    $configuracion->getAjaxListarConfiguracion();
} else if(isset($_POST['accion']) && $_POST['accion'] == 2){//Parametro para actualizar configuracion
    $actualizarConfiguracion = new AjaxConfiguracion();
    $data = array();
    if(!empty($_POST['modulo']) && $_POST['modulo'] === 'ventas' &&
        (!empty($_POST['validar_stock']) || isset($_POST['validar_stock']))){
        $data['validar_stock'] = $_POST['validar_stock'];
    } else if(!empty($_POST['modulo']) && $_POST['modulo'] === 'productos'){
        if((!empty($_POST['update_stock_productos']) || isset($_POST['update_stock_productos']))){
            $data['update_stock_productos'] = $_POST['update_stock_productos'];
        }
        if((!empty($_POST['update_precios_productos']) || isset($_POST['update_precios_productos']))){
            $data['update_precios_productos'] = $_POST['update_precios_productos'];
        }
    }
    $actualizarConfiguracion -> setAjaxActualizarConfiguracion($data);
}
