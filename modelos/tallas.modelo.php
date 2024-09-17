<?php

require_once "conexion.php";

class TallasModelo{

    static public function mdlGetListarTallasTable(){
        $stmt = Conexion::conectar()->prepare("SELECT '' AS detalles,
            t.id_talla,
            t.nombre,
            '' AS opciones
        FROM tallas t
        ORDER BY t.id_talla");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    static public function mdlRegistrarTalla($nombre){
        $resultado = '';
        try{
            $id_max_talla = self::mdlGetMaxTallaId()->max_id;
            $stmt = Conexion::conectar()->prepare("INSERT INTO  tallas (id_talla,
                                                                nombre)
                                                    VALUES (:id_talla,
                                                            :nombre)");
            $stmt->bindParam(':id_talla', $id_max_talla, PDO::PARAM_INT);
            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
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
    static public function mdlGetMaxTallaId(){
        $stmt_max = Conexion::conectar()->prepare("SELECT IFNULL(MAX(t.id_talla),0) + 1 AS max_id
            FROM tallas t");
        $stmt_max->execute();
        return $stmt_max->fetch(PDO::FETCH_OBJ);
    }
    static public function mdlGetListarTallas(){
        $stmt = Conexion::conectar()->prepare("SELECT t.id_talla,t.nombre
        FROM tallas t
        ORDER BY t.nombre ASC");
        $stmt->execute();
        return $stmt->fetchAll();
    }
}