<?php

require_once "conexion.php";

class UsuariosModelo{

    static public function mdlIniciarSession($usuario, $password){
        $stmt = Conexion::conectar()->prepare("SELECT
            u.id_usuario,u.nombre,u.apellido,m.vista AS vista_inicio,u.update_precios_productos,u.estado
        FROM usuarios u
        LEFT JOIN modulos m ON m.id_modulo=u.id_modulo_inicio
        WHERE u.usuario=:usuario AND u.contrasena=:password");
        $stmt->bindParam(":usuario",$usuario, PDO::PARAM_STR);
        $stmt->bindParam(":password",$password, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }
    static function mdlGetMenuPerfil($id_usuario){
        $stmt = Conexion::conectar()->prepare("SELECT
            m.id_modulo,m.modulo,m.vista,m.icon_menu,um.user_create,um.user_write,um.user_delete
        FROM modulos m
        INNER JOIN usuario_modulos um ON um.id_modulo=m.id_modulo
        WHERE (m.padre_id IS NULL OR m.padre_id=0) AND um.id_usuario=:id_usuario
        ORDER BY m.orden");
        $stmt->bindParam(":id_usuario", $id_usuario, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }
    static function mdlGetSubMenuPerfil($id_modulo, $id_usuario){
        $stmt = Conexion::conectar()->prepare("SELECT
            m.id_modulo,m.modulo,m.vista,m.icon_menu,um.user_create,um.user_write,um.user_delete
        FROM modulos m
        INNER JOIN usuario_modulos um ON um.id_modulo=m.id_modulo
        WHERE um.id_usuario=:id_usuario AND m.padre_id=:id_modulo
        ORDER BY m.orden
        ");
        $stmt->bindParam(":id_usuario", $id_usuario, PDO::PARAM_INT);
        $stmt->bindParam(":id_modulo", $id_modulo, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }
    static public function mdlGetListarUsuariosTable(){
        $stmt = Conexion::conectar()->prepare("SELECT '' AS detalles,
            u.id_usuario,
            u.nombre,
            u.apellido,
            u.usuario,
            u.contrasena,
            u.id_modulo_inicio,
            m.modulo,
            CASE WHEN u.estado=1 THEN 'ACTIVO'
            ELSE 'INACTIVO' END AS estado,
            u.update_precios_productos,
            '' AS opciones
        FROM usuarios u
        LEFT JOIN modulos m ON m.id_modulo=u.id_modulo_inicio
        ORDER BY u.id_usuario");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    static public function mdlRegistrarUsuario($nombre, $apellido, $estado, $update_precios_productos){
        $resultado = '';
        try{
            $id_max_usuario = self::mdlGetMaxUsuarioId()->max_id;
            $stmt = Conexion::conectar()->prepare("INSERT INTO  usuarios (id_usuario,
                                                                nombre,
                                                                apellido,
                                                                estado,
                                                                update_precios_productos)
                                                    VALUES (:id_usuario,
                                                            :nombre,
                                                            :apellido,
                                                            :estado,
                                                            :update_precios_productos)");
            $stmt->bindParam(':id_usuario', $id_max_usuario, PDO::PARAM_INT);
            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->bindParam(':apellido', $apellido, PDO::PARAM_STR);
            $stmt->bindParam(':estado', $estado, PDO::PARAM_INT);
            $stmt->bindParam(':update_precios_productos', $update_precios_productos, PDO::PARAM_INT);
            if($stmt->execute()){
                $resultado = 'ok';
            }else{
                $resultado = Conexion::conectar()->errorInfo();
            }
        }catch(Exception $e){
            $resultado = $e->getMessage();
        }
        $stmt = null;
        return $resultado;
    }
    static public function mdlSetActualizarInformacion($table, $data, $id, $nameId){
        try{
            $set = '';
            foreach ($data as $key => $value){
                $set.= $key.' = :'.$key.',';
            }
            $set = substr($set, 0, -1);
            $stmt = Conexion::conectar()->prepare("UPDATE $table SET $set WHERE $nameId = :$nameId");
            foreach ($data as $key => $value) {
                if($key === 'usuario'){
                    if(self::mdlGetValidUser($data[$key], $id)->count_users >= 1){
                        return 'existe';
                    }
                }
                if($data[$key] === 'null'){
                    $stmt->bindParam(':'.$key, $data[$key], PDO::PARAM_NULL);
                } else {
                    $stmt->bindParam(':'.$key, $data[$key], PDO::PARAM_STR);
                }
            }
            $stmt->bindParam(':'. $nameId, $id, PDO::PARAM_INT);
            if($stmt->execute()){
                return 'ok';
            }else{
                return Conexion::conectar()->errorInfo();
            }
        }catch(Exception $e){
            return  $e->getMessage();
        }
    }
    static public function mdlSetEliminarInformacion($table, $id, $nameId){
        try{
            $stmt = Conexion::conectar()->prepare("DELETE FROM $table WHERE $nameId = :$nameId");
            $stmt->bindParam(':'. $nameId, $id, PDO::PARAM_INT);
            if($stmt->execute()){
                return 'ok';
            }else{
                return Conexion::conectar()->errorInfo();
            }
        }catch(Exception $e){
            return  $e->getMessage();
        }
    }
    static public function mdlGetMaxUsuarioId(){
        $stmt_max = Conexion::conectar()->prepare("SELECT IFNULL(MAX(u.id_usuario),0) + 1 AS max_id
            FROM usuarios u");
        $stmt_max->execute();
        return $stmt_max->fetch(PDO::FETCH_OBJ);
    }
    static public function mdlGetListarUsuarios(){
        $stmt = Conexion::conectar()->prepare("SELECT u.id_usuario,CONCAT(u.nombre,' ',u.apellido) AS nombre_concat
        FROM usuarios u
        ORDER BY u.nombre ASC");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    static function mdlGetValidUser($usuario, $id_usuario){
        $stmt = Conexion::conectar()->prepare("SELECT COUNT(*) AS count_users
        FROM usuarios u
        WHERE u.usuario=:usuario AND u.id_usuario!=:id_usuario");
        $stmt->bindParam(":usuario", $usuario, PDO::PARAM_STR);
        $stmt->bindParam(":id_usuario", $id_usuario, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}