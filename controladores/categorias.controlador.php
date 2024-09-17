<?php

class CategoriasControlador{

    static public function ctrGetListarCategoriasTable(){
        $listaCategorias = CategoriasModelo::mdlGetListarCategoriasTable();
        return $listaCategorias;
    }
    static public function ctrSetRegistrarCategoria($nombre, $id_categoria_padre, $tipo_negocio, $aplica_peso, $estado){
        $registroCategoria = CategoriasModelo::mdlRegistrarCategoria($nombre, $id_categoria_padre, $tipo_negocio, $aplica_peso, $estado);
        return $registroCategoria;
    }
    static public function ctrSetActualizarCategoria($table, $data, $id, $nameId){
        $respuesta = CategoriasModelo::mdlSetActualizarInformacion($table, $data, $id, $nameId);
        return $respuesta;
    }
    static public function ctrSetEliminarCategoria($table, $id, $nameId){
        $respuesta = CategoriasModelo::mdlSetEliminarInformacion($table, $id, $nameId);
        return $respuesta;
    }
    static public function ctrGetListarCategorias(){
        $listaCategorias = CategoriasModelo::mdlGetListarCategorias();
        return $listaCategorias;
    }
}