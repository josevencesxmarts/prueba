<?php

require_once "conexion.php";

class UnidadesMedidaModelo{

    static public function mdlGetListarUnidadesMedidaTable(){
        $stmt = Conexion::conectar()->prepare("SELECT '' AS detalles,
            um.id_unidad_medida,
            um.id_udm_referencia,
            um.nombre,
            CONCAT(
                IF(um.id_udm_referencia IS NOT NULL AND um.id_udm_referencia != '',
                    CONCAT(
                        um.nombre,
                        ' de ',
                        um.ratio,
                        ' ',
                        um_ref.nombre
                    ),
                um.nombre)
            ) AS nombre_concat,
            IFNULL((
                SELECT u_m.nombre
                FROM unidades_medida u_m
                WHERE u_m.id_unidad_medida=um.id_udm_referencia
            ),'') AS udm_referencia,
            um.ratio,
            CASE WHEN um.estado=1 THEN 'ACTIVO'
                ELSE 'INACTIVO' END AS estado,
            '' AS opciones
        FROM unidades_medida um
        LEFT JOIN unidades_medida um_ref ON um_ref.id_unidad_medida=um.id_udm_referencia
        ORDER BY um.id_unidad_medida");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    static public function mdlRegistrarUnidadMedida($nombre, $id_udm_referencia, $ratio, $estado){
        $resultado = '';
        try{
            $id_max_unidad_medida = self::mdlGetMaxUnidadMedidaId()->max_id;
            $stmt = Conexion::conectar()->prepare("INSERT INTO  unidades_medida (id_unidad_medida,
                                                                nombre,
                                                                id_udm_referencia,
                                                                ratio,
                                                                estado)
                                                    VALUES (:id_unidad_medida,
                                                            :nombre,
                                                            :id_udm_referencia,
                                                            :ratio,
                                                            :estado)");
            $stmt->bindParam(':id_unidad_medida', $id_max_unidad_medida, PDO::PARAM_INT);
            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->bindParam(':id_udm_referencia', $id_udm_referencia, PDO::PARAM_INT);
            $stmt->bindParam(':ratio', $ratio, PDO::PARAM_INT);
            $stmt->bindParam(':estado', $estado, PDO::PARAM_INT);
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
    static public function mdlGetMaxUnidadMedidaId(){
        $stmt_max = Conexion::conectar()->prepare("SELECT IFNULL(MAX(um.id_unidad_medida),0) + 1 AS max_id
            FROM unidades_medida um");
        $stmt_max->execute();
        return $stmt_max->fetch(PDO::FETCH_OBJ);
    }
    static public function mdlGetListarUnidadesMedida(){
        $stmt = Conexion::conectar()->prepare("SELECT um.id_unidad_medida,
            CONCAT(
                IF(um.id_udm_referencia IS NOT NULL AND um.id_udm_referencia != '',
                    CONCAT(
                        um.nombre,
                        ' de ',
                        um.ratio,
                        ' ',
                        um_ref.nombre
                    ),
                um.nombre)
            ) AS nombre,
            um.id_udm_referencia,um.ratio
        FROM unidades_medida um
        LEFT JOIN unidades_medida um_ref ON um_ref.id_unidad_medida=um.id_udm_referencia
        ORDER BY um.nombre DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }
}