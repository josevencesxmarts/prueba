<?php

class ComprasControlador{

    static public function ctrGetListarComprasTable($id_usuario, $fecha_inicio, $fecha_fin){
        $listaCompras = ComprasModelo::mdlGetListarComprasTable($id_usuario, $fecha_inicio, $fecha_fin);
        return $listaCompras;
    }
    static public function ctrGetListarDetComprasTable(){
        $listaDetCompras = ComprasModelo::mdlGetListarDetComprasTable();
        return $listaDetCompras;
    }
    static public function ctrSetRegistrarCompra($datos){
        $respuesta = ComprasModelo::mdlSetRegistrarCompra($datos);
        return $respuesta;
    }
}