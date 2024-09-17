<?php

class ConfiguracionControlador{

    static public function ctrGetListarConfiguracion(){
        $listaConfiguracion = ConfiguracionModelo::mdlGetListarConfiguracion();
        return $listaConfiguracion;
    }
    static public function ctrSetActualizarConfiguracion($data){
        $respuesta = ConfiguracionModelo::mdlSetActualizarInformacion($data);
        return $respuesta;
    }
}