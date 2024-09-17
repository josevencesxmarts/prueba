<?php

class UsuarioModulosControlador{

    static public function ctrSetRegistrarUsuarioModulos($ids_select_elms, $id_usuario, $id_modulo_inicio){
        $registroUsuarioModulos = UsuarioModulosModelo::mdlSetRegistrarUsuarioModulos($ids_select_elms, $id_usuario, $id_modulo_inicio);
        return $registroUsuarioModulos;
    }
    static public function ctrSetUpdateUsuarioPermisosModulos($datos){
        $updatePermisosUsuarioModulos = UsuarioModulosModelo::mdlSetUpdateUsuarioPermisosModulos($datos);
        return $updatePermisosUsuarioModulos;
    }
}