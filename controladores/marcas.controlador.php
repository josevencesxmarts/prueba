<?php

class MarcasControlador{

    static public function ctrGetListarMarcasTable(){
        $listaMarcas = MarcasModelo::mdlGetListarMarcasTable();
        return $listaMarcas;
    }
    static public function ctrSetRegistrarMarca($nombre){
        $registroMarca = MarcasModelo::mdlRegistrarMarca($nombre);
        return $registroMarca;
    }
    static public function ctrSetActualizarMarca($table, $data, $id, $nameId){
        $respuesta = MarcasModelo::mdlSetActualizarInformacion($table, $data, $id, $nameId);
        return $respuesta;
    }
    static public function ctrSetEliminarMarca($table, $id, $nameId){
        $respuesta = MarcasModelo::mdlSetEliminarInformacion($table, $id, $nameId);
        return $respuesta;
    }
    static public function ctrGetListarMarcas(){
        $listaMarcas = MarcasModelo::mdlGetListarMarcas();
        return $listaMarcas;
    }
}