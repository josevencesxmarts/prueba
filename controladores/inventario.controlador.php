<?php

class InventarioControlador{

    static public function ctrGetListarInventarioTable(){
        $listaInventario = InventarioModelo::mdlGetListarInventarioTable();
        return $listaInventario;
    }
    static public function ctrGetListarEntradasSalidasInv($id_usuario, $fecha_inicio, $fecha_fin){
        $data_reporte = InventarioModelo::mdlGetListarEntradasSalidasInv($id_usuario, $fecha_inicio, $fecha_fin);
        return $data_reporte;
    }
}