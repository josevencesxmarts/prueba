<?php

require_once "conexion.php";

class MarcasModelo{

    static public function mdlGetListarMarcasTable(){
        $stmt = Conexion::conectar()->prepare("SELECT '' AS detalles,
            m.id_marca,
            m.nombre,
            '' AS opciones
        FROM marcas m
        ORDER BY m.id_marca");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    static public function mdlRegistrarMarca($nombre){
        $resultado = '';
        try{
            $id_max_marca = self::mdlGetMaxMarcaId()->max_id;
            $stmt = Conexion::conectar()->prepare("INSERT INTO  marcas (id_marca,
                                                                nombre)
                                                    VALUES (:id_marca,
                                                            :nombre)");
            $stmt->bindParam(':id_marca', $id_max_marca, PDO::PARAM_INT);
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
    static public function mdlGetMaxMarcaId(){
        $stmt_max = Conexion::conectar()->prepare("SELECT IFNULL(MAX(m.id_marca),0) + 1 AS max_id
            FROM marcas m");
        $stmt_max->execute();
        return $stmt_max->fetch(PDO::FETCH_OBJ);
    }
    static public function mdlGetListarMarcas(){
        $stmt = Conexion::conectar()->prepare("SELECT m.id_marca,m.nombre
        FROM marcas m
        ORDER BY m.nombre ASC");
        $stmt->execute();
        return $stmt->fetchAll();
    }
}