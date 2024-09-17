<?php

require_once "conexion.php";

class UsuarioModulosModelo{
    static public function mdlSetRegistrarUsuarioModulos($ids_select_elms, $id_usuario, $id_modulo_inicio){
        $objeto = new stdClass();
        $total_registros = 0;
        try{
            $modulo_de_asignacion = self::mdlGetModuloIdDeAsignacion();
            $id_modulo_asignar_a_user = $modulo_de_asignacion->id_modulo;
            $id_modulo_padre = $modulo_de_asignacion->padre_id;
            if(strval($id_usuario) === '1'){
                $stmt = Conexion::conectar()->prepare("DELETE FROM usuario_modulos WHERE id_usuario=:id_usuario AND id_modulo!=$id_modulo_asignar_a_user AND id_modulo!=$id_modulo_padre");
            } else {
                $stmt = Conexion::conectar()->prepare("DELETE FROM usuario_modulos WHERE id_usuario=:id_usuario");
            }
            $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            if(!$stmt->execute()){
                $objeto->estado = false;
                $objeto->mensaje = 'Error de BD';
                $objeto->error = Conexion::conectar()->errorInfo();
                return $objeto;
            }
    
            $stmt = Conexion::conectar()->prepare("UPDATE usuarios SET id_modulo_inicio=:id_modulo_inicio WHERE id_usuario=:id_usuario");
            $stmt->bindParam(':id_modulo_inicio', $id_modulo_inicio, PDO::PARAM_INT);
            $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            if(!$stmt->execute()){
                $objeto->estado = false;
                $objeto->mensaje = 'Error de BD';
                $objeto->error = Conexion::conectar()->errorInfo();
                return $objeto;
            }
            foreach($ids_select_elms as $id_modulo){
                if(strval($id_usuario) === '1' && ($id_modulo === strval($id_modulo_asignar_a_user) || $id_modulo === strval($id_modulo_padre))){
                    $stmt = Conexion::conectar()->prepare("UPDATE usuario_modulos SET user_create=1,
                                                                                      user_write=1,
                                                                                      user_delete=1
                                                            WHERE id_usuario=:id_usuario AND id_modulo=:id_modulo");
                    $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
                    $stmt->bindParam(':id_modulo', $id_modulo, PDO::PARAM_INT);
                    if(!$stmt->execute()){
                        $objeto->estado = false;
                        $objeto->mensaje = 'Error de BD';
                        $objeto->error = Conexion::conectar()->errorInfo();
                        return $objeto;
                    }
                } else {
                    $id_max_modulo_user = self::mdlGetMaxUsuarioModulosId()->max_id;
                    $stmt = Conexion::conectar()->prepare("INSERT INTO usuario_modulos(id_usuario_modulo,
                                                                                    id_usuario,
                                                                                    id_modulo,
                                                                                    user_create,
                                                                                    user_write,
                                                                                    user_delete,
                                                                                    estado)
                                                                        VALUES(:id_usuario_modulo,
                                                                                :id_usuario,
                                                                                :id_modulo,
                                                                                0,
                                                                                0,
                                                                                0,
                                                                                1)");
                    $stmt->bindParam(':id_usuario_modulo', $id_max_modulo_user, PDO::PARAM_INT);
                    $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
                    $stmt->bindParam(':id_modulo', $id_modulo, PDO::PARAM_INT);
                    if($stmt->execute()){
                        $total_registros += 1;
                    } else {
                        $objeto->estado = false;
                        $objeto->mensaje = 'Error de BD';
                        $objeto->error = Conexion::conectar()->errorInfo();
                        return $objeto;
                    }
                }
            }
            $objeto->estado = true;
            $objeto->mensaje = 'Registros registrados correctamente';
            $objeto->datos = $total_registros;
            return $objeto;
        }catch(Exception $e){
            $objeto->estado = false;
            $objeto->mensaje = 'Error de BD';
            $objeto->error = $e->getMessage();
            return $objeto;
        }
        $stmt = null;
        return $objeto;
    }
    static public function mdlGetModuloIdDeAsignacion(){
        $stmt_max = Conexion::conectar()->prepare("SELECT m.id_modulo,m.padre_id
        FROM modulos m
        WHERE m.vista='usuario_modulos.php'
        LIMIT 1");
        $stmt_max->execute();
        return $stmt_max->fetch(PDO::FETCH_OBJ);
    }
    static public function mdlSetUpdateUsuarioPermisosModulos($datos){
        $objeto = new stdClass();
        $total_registros = 0;
        try{
            foreach($datos as $dato){
                $stmt = Conexion::conectar()->prepare("UPDATE usuario_modulos SET user_create=:user_create,
                                                                        user_write=:user_write,
                                                                        user_delete=:user_delete
                                                    WHERE id_modulo=:id_modulo AND id_usuario=:id_usuario");
                $stmt->bindParam(':user_create', $dato['user_create'], PDO::PARAM_INT);
                $stmt->bindParam(':user_write', $dato['user_write'], PDO::PARAM_INT);
                $stmt->bindParam(':user_delete', $dato['user_delete'], PDO::PARAM_INT);
                $stmt->bindParam(':id_modulo', $dato['id_modulo'], PDO::PARAM_INT);
                $stmt->bindParam(':id_usuario', $dato['id_usuario'], PDO::PARAM_INT);
                $stmt->execute();
                if($stmt->execute()){
                    $total_registros += 1;
                } else {
                    $objeto->estado = false;
                    $objeto->mensaje = 'Error de BD';
                    $objeto->error = Conexion::conectar()->errorInfo();
                    return $objeto;
                }
            }
            $objeto->estado = true;
            $objeto->mensaje = 'Registros actualizados correctamente';
            $objeto->datos = $total_registros;
            return $objeto;
        }catch(Exception $e){
            $objeto->estado = false;
            $objeto->mensaje = 'Error de BD';
            $objeto->error = $e->getMessage();
            return $objeto;
        }
        $stmt = null;
        return $objeto;
    }
    static public function mdlGetMaxUsuarioModulosId(){
        $stmt_max = Conexion::conectar()->prepare("SELECT IFNULL(MAX(um.id_usuario_modulo),0) + 1 AS max_id
            FROM usuario_modulos um");
        $stmt_max->execute();
        return $stmt_max->fetch(PDO::FETCH_OBJ);
    }
}