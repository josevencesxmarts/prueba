<?php

require_once "../controladores/modulos.controlador.php";
require_once "../modelos/modulos.modelo.php";

class AjaxModulos{

    public function getAjaxObtenerModulos(){
        $modulos = ModulosControlador::ctrGetObtenerModulos();
        echo json_encode($modulos);
    }
    public function getAjaxObtenerModulosDeUsuarios(){
        $modulosUsuario = ModulosControlador::ctrGetObtenerModulosDeUsuarios();
        echo json_encode($modulosUsuario);
    }
    public function getAjaxInfModuloQAsignaModulosAUsers(){
        $ifnModuloQAsignaModulosAsers = ModulosControlador::ctrGetInfModuloQAsignaModulosAUsers();
        echo json_encode($ifnModuloQAsignaModulosAsers);
    }
}
if(isset($_POST['accion']) && $_POST['accion'] == 1){//Parametro para listar modulos
    $modulos = new AjaxModulos();
    $modulos->getAjaxObtenerModulos();
} else if(isset($_POST['accion']) && $_POST['accion'] == 2){//Parametro para listar modulos de todos los usuarios
    $modulosUsuario = new AjaxModulos();
    $modulosUsuario->getAjaxObtenerModulosDeUsuarios();
} else if(isset($_POST['accion']) && $_POST['accion'] == 3){//Parametro para cargar inf del modulo q asigna modulos a users
    $ifnModuloQAsignaModulosAsers = new AjaxModulos();
    $ifnModuloQAsignaModulosAsers->getAjaxInfModuloQAsignaModulosAUsers();
}
