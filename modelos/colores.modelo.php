<?php

require_once "conexion.php";

class ColoresModelo{

    static public function mdlGetListarColoresTable(){
        $stmt = Conexion::conectar()->prepare("SELECT '' AS detalles,
            c.id_color,
            c.nombre,
            '' AS opciones
        FROM colores c
        ORDER BY c.id_color");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    static public function mdlRegistrarColor($nombre){
        $resultado = '';
        try{
            $id_max_color = self::mdlGetMaxColorId()->max_id;
            $stmt = Conexion::conectar()->prepare("INSERT INTO colores (id_color,
                                                                nombre)
                                                    VALUES (:id_color,
                                                            :nombre)");
            $stmt->bindParam(':id_color', $id_max_color, PDO::PARAM_INT);
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
    static public function mdlGetMaxColorId(){
        $stmt_max = Conexion::conectar()->prepare("SELECT IFNULL(MAX(c.id_color),0) + 1 AS max_id
            FROM colores c");
        $stmt_max->execute();
        return $stmt_max->fetch(PDO::FETCH_OBJ);
    }
    static public function mdlGetListarColores(){
        $stmt = Conexion::conectar()->prepare("SELECT c.id_color,c.nombre
        FROM colores c
        ORDER BY c.nombre ASC");
        $stmt->execute();
        return $stmt->fetchAll();
    }
}