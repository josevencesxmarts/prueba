<?php

class ProductosControlador{

    static public function ctrGetListarProductosTable($domain){
        $listaProductos = ProductosModelo::mdlGetListarProductosTable($domain);
        return $listaProductos;
    }
    static public function ctrSetRegistrarProducto($table, $data){
        $registroProducto = ProductosModelo::mdlRegistrarProducto($table, $data);
        return $registroProducto;
    }
    static public function ctrSetActualizarProducto($table, $data, $id, $nameId){
        $respuesta = ProductosModelo::mdlSetActualizarInformacion($table, $data, $id, $nameId);
        return $respuesta;
    }
    static public function ctrSetEliminarProducto($table, $id, $nameId){
        $respuesta = ProductosModelo::mdlSetEliminarInformacion($table, $id, $nameId);
        return $respuesta;
    }
    static public function ctrGetListarDatasFieldsTypeSelections(){
        $datasSelections = ProductosModelo::mdlGetListarDatasFieldsTypeSelections();
        return $datasSelections;
    }
    static public function ctrGetListaProductosAutocomplete(){
        $nombreProductos = ProductosModelo::mdlGetListaProductosAutocomplete();
        return $nombreProductos;
    }
    static public function ctrGetListarProductosPdV(){
        $listaProductos = ProductosModelo::mdlGetListarProductosPdV();
        return $listaProductos;
    }
}