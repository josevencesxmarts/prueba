<?php

require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";

class AjaxUsuarios{

    public $nombre;
    public $apellido;
    public $usuario;
    public $contrasena;
    public $vista_inicio;
    public $update_precios_productos;
    public $estado;

    public function getAjaxListarUsuariosTable(){
        $usuarios = UsuariosControlador::ctrGetListarUsuariosTable();
        echo json_encode($usuarios);
    }
    public function setAjaxRegistrarUsuario(){
        $respuesta = UsuariosControlador::ctrSetRegistrarUsuario($this->nombre, $this->apellido, $this->estado, $this->update_precios_productos);
        echo json_encode($respuesta);
    }
    public function setAjaxActualizarUsuario($data){
        $table = 'usuarios';
        $id = $_POST['id_usuario'];
        $nameId = 'id_usuario';
        $respuesta = UsuariosControlador::ctrSetActualizarUsuario($table, $data, $id, $nameId);
        echo json_encode($respuesta);
    }
    public function setAjaxEliminarUsuario(){
        $table = 'usuarios';
        $id = $_POST['id_usuario'];
        $nameId = 'id_usuario';
        $respuesta = UsuariosControlador::ctrSetEliminarUsuario($table, $id, $nameId);
        echo json_encode($respuesta);
    }
    public function getAjaxListarUsuarios(){
        $usuarios = UsuariosControlador::ctrGetListarUsuarios();
        echo json_encode($usuarios, JSON_UNESCAPED_UNICODE);
    }
}
if(isset($_POST['accion']) && $_POST['accion'] == 1){//Parametro para listar usuarios
    $usuarios = new AjaxUsuarios();
    $usuarios->getAjaxListarUsuariosTable();
}else if(isset($_POST['accion']) && $_POST['accion'] == 2){//Parametro para registrar usuarios
    $registrarUsuario = new AjaxUsuarios();
    $registrarUsuario -> nombre = $_POST['nombre'];
    $registrarUsuario -> apellido = $_POST['apellido'];
    $registrarUsuario -> update_precios_productos = $_POST['update_precios_productos'];
    $registrarUsuario -> estado = $_POST['estado'];
    $registrarUsuario -> setAjaxRegistrarUsuario();
}else if(isset($_POST['accion']) && $_POST['accion'] == 3){//Parametro para actualizar usuario
    $actualizarUsuario = new AjaxUsuarios();
    $data = array(
        'nombre' => $_POST['nombre'],
        'apellido' => $_POST['apellido'],
        'update_precios_productos' => $_POST['update_precios_productos'],
        'estado' => $_POST['estado'],
    );
    $actualizarUsuario -> setAjaxActualizarUsuario($data);
}else if(isset($_POST['accion']) && $_POST['accion'] == 4){//Parametro para eliminar usuario
    $eliminarUsuario = new AjaxUsuarios();
    $eliminarUsuario->setAjaxEliminarUsuario();
}else if(isset($_POST['accion']) && $_POST['accion'] == 5){//Parametro para actualizar session de usuario
    $actualizarUsuario = new AjaxUsuarios();
    $data = array(
        'usuario' => $_POST['usuario'],
        'contrasena' => $_POST['contrasena'],
    );
    $actualizarUsuario -> setAjaxActualizarUsuario($data);
}else if(isset($_POST['accion']) && $_POST['accion'] == 6){
    $usuarios = new AjaxUsuarios();
    $usuarios->getAjaxListarUsuarios();
}