<?php

class ColoresControlador{

    static public function ctrGetListarColoresTable(){
        $listaColores = ColoresModelo::mdlGetListarColoresTable();
        return $listaColores;
    }
    static public function ctrSetRegistrarColor($nombre){
        $registroColor = ColoresModelo::mdlRegistrarColor($nombre);
        return $registroColor;
    }
    static public function ctrSetActualizarColor($table, $data, $id, $nameId){
        $respuesta = ColoresModelo::mdlSetActualizarInformacion($table, $data, $id, $nameId);
        return $respuesta;
    }
    static public function ctrSetEliminarColor($table, $id, $nameId){
        $respuesta = ColoresModelo::mdlSetEliminarInformacion($table, $id, $nameId);
        return $respuesta;
    }
    static public function ctrGetListarColores(){
        $listaColores = ColoresModelo::mdlGetListarColores();
        return $listaColores;
    }
}