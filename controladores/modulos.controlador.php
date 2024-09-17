<?php

class ModulosControlador{

    static public function ctrGetObtenerModulos(){
        $listaModulos = ModulosModelo::mdlGetObtenerModulos();
        return $listaModulos;
    }
    static public function ctrGetObtenerModulosDeUsuarios(){
        $modulosUsuario = ModulosModelo::mdlGetObtenerModulosDeUsuarios();
        return $modulosUsuario;
    }
    static public function ctrGetInfModuloQAsignaModulosAUsers(){
        $listaModulos = ModulosModelo::mdlGetInfModuloQAsignaModulosAUsers();
        return $listaModulos;
    }
}