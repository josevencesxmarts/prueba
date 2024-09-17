<?php

class TallasControlador{

    static public function ctrGetListarTallasTable(){
        $listaTallas = TallasModelo::mdlGetListarTallasTable();
        return $listaTallas;
    }
    static public function ctrSetRegistrarTalla($nombre){
        $registroTalla = TallasModelo::mdlRegistrarTalla($nombre);
        return $registroTalla;
    }
    static public function ctrSetActualizarTalla($table, $data, $id, $nameId){
        $respuesta = TallasModelo::mdlSetActualizarInformacion($table, $data, $id, $nameId);
        return $respuesta;
    }
    static public function ctrSetEliminarTalla($table, $id, $nameId){
        $respuesta = TallasModelo::mdlSetEliminarInformacion($table, $id, $nameId);
        return $respuesta;
    }
    static public function ctrGetListarTallas(){
        $listaTallas = TallasModelo::mdlGetListarTallas();
        return $listaTallas;
    }
}