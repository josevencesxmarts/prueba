<?php

class UsuariosControlador{

    public function login(){
        if(isset($_POST['loginUsuario'])){
            $usuario = $_POST['loginUsuario'];
            $password = $_POST['loginPassword'];

            $respuesta = UsuariosModelo::mdlIniciarSession($usuario, $password);
            if(count($respuesta) === 1){
                $_SESSION['usuario'] = $respuesta[0];
                echo '
                    <script>
                        window.location = "./index.php";
                    </script>
                ';
            } else if(count($respuesta) > 1){
                echo '
                    <script>
                        fncSweetAlert(
                            "error",
                            "Este usuario ya existe, consulte con su administrador",
                            "./index.php",
                        );
                    </script>
                ';
            } else {
                echo '
                    <script>
                        fncSweetAlert(
                            "error",
                            "Usuario y/o contraseña invalida",
                            "./index.php",
                        );
                    </script>
                ';
            }
        }
    }
    static function ctrGetMenuPerfil($id_perfil){
        $menuUsuario = UsuariosModelo::mdlGetMenuPerfil($id_perfil);
        return $menuUsuario;
    }
    static function ctrGetSubMenuPerfil($id_modulo, $id_perfil){
        $subMenuUsuario = UsuariosModelo::mdlGetSubMenuPerfil($id_modulo, $id_perfil);
        return $subMenuUsuario;
    }
    static public function ctrGetListarUsuariosTable(){
        $listaUsuarios = UsuariosModelo::mdlGetListarUsuariosTable();
        return $listaUsuarios;
    }
    static public function ctrSetRegistrarUsuario($nombre, $apellido, $estado, $update_precios_productos){
        $registroUsuario = UsuariosModelo::mdlRegistrarUsuario($nombre, $apellido, $estado, $update_precios_productos);
        return $registroUsuario;
    }
    static public function ctrSetActualizarUsuario($table, $data, $id, $nameId){
        $respuesta = UsuariosModelo::mdlSetActualizarInformacion($table, $data, $id, $nameId);
        return $respuesta;
    }
    static public function ctrSetEliminarUsuario($table, $id, $nameId){
        $respuesta = UsuariosModelo::mdlSetEliminarInformacion($table, $id, $nameId);
        return $respuesta;
    }
    static public function ctrGetListarUsuarios(){
        $listaUsuarios = UsuariosModelo::mdlGetListarUsuarios();
        return $listaUsuarios;
    }
}