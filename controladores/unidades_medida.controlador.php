<?php

class UnidadesMedidaControlador{

    static public function ctrGetListarUnidadesMedidaTable(){
        $listaUnidadesMedida = UnidadesMedidaModelo::mdlGetListarUnidadesMedidaTable();
        return $listaUnidadesMedida;
    }
    static public function ctrSetRegistrarUnidadMedida($nombre, $id_udm_referencia, $ratio, $estado){
        $registroUnidadMedida = UnidadesMedidaModelo::mdlRegistrarUnidadMedida($nombre, $id_udm_referencia, $ratio, $estado);
        return $registroUnidadMedida;
    }
    static public function ctrSetActualizarUnidadMedida($table, $data, $id, $nameId){
        $respuesta = UnidadesMedidaModelo::mdlSetActualizarInformacion($table, $data, $id, $nameId);
        return $respuesta;
    }
    static public function ctrSetEliminarUnidadMedida($table, $id, $nameId){
        $respuesta = UnidadesMedidaModelo::mdlSetEliminarInformacion($table, $id, $nameId);
        return $respuesta;
    }
    static public function ctrGetListarUnidadesMedida(){
        $listaUnidadesMedida = UnidadesMedidaModelo::mdlGetListarUnidadesMedida();
        return $listaUnidadesMedida;
    }
}