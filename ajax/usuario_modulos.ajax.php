<?php

require_once "../controladores/usuario_modulos.controlador.php";
require_once "../modelos/usuario_modulos.modelo.php";

class AjaxUsuarioModulos{

    public function __construct(){
        session_start();
        $datos = json_decode(file_get_contents('php://input'),true);
        if(isset($_SESSION['usuario']) && isset($_SESSION['lista_acceso_modulos'])){
            $array_filter_modulo = array_filter($_SESSION['lista_acceso_modulos'], function($obj){return $obj->vista == "usuario_modulos.php";});
            $existe_modulo = reset($array_filter_modulo);
            $objeto = new stdClass();
            if(count($array_filter_modulo) > 0 && $existe_modulo->vista === "usuario_modulos.php"){
                if($datos['accion'] == 1 && $existe_modulo->user_create == 0){
                    $objeto->estado = false;
                    $objeto->mensaje = 'Sin permiso';
                    $objeto->error = 'No tiene acceso para asignar modulos a usuarios';
                    echo json_encode($objeto);
                    exit;
                } else if($datos['accion'] == 2 && $existe_modulo->user_write == 0){
                    $objeto->estado = false;
                    $objeto->mensaje = 'Sin permiso';
                    $objeto->error = 'No tiene acceso para actualizar permisos de modulos a usuarios';
                    echo json_encode($objeto);
                    exit;
                }
            } else {
                exit;
            }
        } else {
            exit;
        }
    }
    public function setAjaxRegistrarUsuarioModulos($ids_select_elms, $id_usuario, $id_modulo_inicio){
        $registroPerfilModulos = UsuarioModulosControlador::ctrSetRegistrarUsuarioModulos($ids_select_elms, $id_usuario, $id_modulo_inicio);
        echo json_encode($registroPerfilModulos);
    }
    public function setAjaxUpdateUsuarioPermisosModulos($datos){
        $updatePermisosUsuarioModulos = UsuarioModulosControlador::ctrSetUpdateUsuarioPermisosModulos($datos);
        echo json_encode($updatePermisosUsuarioModulos);
    }
}
$datos = json_decode(file_get_contents('php://input'),true);
if(isset($datos['accion']) && $datos['accion'] == 1){//Parametro para guardar los modulos de usuario
    $registroPerfilModulos = new AjaxUsuarioModulos();
    $registroPerfilModulos->setAjaxRegistrarUsuarioModulos($datos['ids_select_elms'], $datos['id_usuario'], $datos['id_modulo_inicio']);
} else if(isset($datos['accion']) && $datos['accion'] == 2){//Parametro para actualizar los modulos con los permisos a usuario
    $updatePermisosUsuarioModulos = new AjaxUsuarioModulos();
    $updatePermisosUsuarioModulos->setAjaxUpdateUsuarioPermisosModulos($datos['datos']);
}
