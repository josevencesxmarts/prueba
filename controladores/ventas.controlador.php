<?php

class VentasControlador{

    static public function ctrGetListarVentasTable($id_usuario, $fecha_inicio, $fecha_fin){
        $listaVentas = VentasModelo::mdlGetListarVentasTable($id_usuario, $fecha_inicio, $fecha_fin);
        return $listaVentas;
    }
    static public function ctrGetListarDetVentasTable(){
        $listaDetVentas = VentasModelo::mdlGetListarDetVentasTable();
        return $listaDetVentas;
    }
    static public function ctrSetRegistrarVenta($datos, $cant_productos, $total_venta, $cambio, $strFechaHora, $id_usuario){
        $respuesta = VentasModelo::mdlSetRegistrarVenta($datos, $cant_productos, $total_venta, $cambio, $strFechaHora, $id_usuario);
        return $respuesta;
    }
}