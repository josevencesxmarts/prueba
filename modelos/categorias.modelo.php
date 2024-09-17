<?php

require_once "conexion.php";

class CategoriasModelo{

    static public function mdlGetListarCategoriasTable(){
        $stmt = Conexion::conectar()->prepare("WITH RECURSIVE subcategorias AS (
                SELECT '' AS detalles,
                        id_categoria,
                        nombre,
                        id_categoria_padre,
                        tipo_negocio,
                        nombre AS nombre_concatenado,
                    CASE WHEN aplica_peso=1 THEN 'SI'
                    ELSE 'NO' END AS aplica_peso,
                    CASE WHEN estado=1 THEN 'ACTIVO'
                    ELSE 'INACTIVO' END AS estado,
                    '' AS opciones
                FROM categorias
                WHERE id_categoria_padre = 0  -- Categorías principales
            UNION ALL
                SELECT '' AS detalles,
                        c.id_categoria,
                        c.nombre,
                        c.id_categoria_padre,
                        c.tipo_negocio,
                        CONCAT(sc.nombre_concatenado, ' -> ',c.nombre),
                    CASE WHEN c.aplica_peso=1 THEN 'SI'
                    ELSE 'NO' END AS aplica_peso,
                    CASE WHEN c.estado=1 THEN 'ACTIVO'
                    ELSE 'INACTIVO' END AS estado,
                    '' AS opciones
                FROM categorias c
                JOIN subcategorias sc ON sc.id_categoria=c.id_categoria_padre
            )
            SELECT * FROM subcategorias
            ORDER BY nombre_concatenado ASC");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    static public function mdlRegistrarCategoria($nombre, $id_categoria_padre, $tipo_negocio, $aplica_peso, $estado){
        $resultado = '';
        try{
            $id_max_categoria = self::mdlGetMaxCategoriaId()->max_id;
            $stmt = Conexion::conectar()->prepare("INSERT INTO  categorias (id_categoria,
                                                                id_categoria_padre,
                                                                nombre,
                                                                tipo_negocio,
                                                                aplica_peso,
                                                                estado)
                                                    VALUES (:id_categoria,
                                                            :id_categoria_padre,
                                                            :nombre,
                                                            :tipo_negocio,
                                                            :aplica_peso,
                                                            :estado)");
            $stmt->bindParam(':id_categoria', $id_max_categoria, PDO::PARAM_INT);
            $stmt->bindParam(':id_categoria_padre', $id_categoria_padre, PDO::PARAM_INT);
            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->bindParam(':tipo_negocio', $tipo_negocio, PDO::PARAM_INT);
            $stmt->bindParam(':aplica_peso', $aplica_peso, PDO::PARAM_INT);
            $stmt->bindParam(':estado', $estado, PDO::PARAM_STR);
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
    static public function mdlGetMaxCategoriaId(){
        $stmt_max = Conexion::conectar()->prepare("SELECT IFNULL(MAX(c.id_categoria),0) + 1 AS max_id
            FROM categorias c");
        $stmt_max->execute();
        return $stmt_max->fetch(PDO::FETCH_OBJ);
    }
    static public function mdlGetListarCategorias(){
        $stmt = Conexion::conectar()->prepare("WITH RECURSIVE subcategorias AS (
                SELECT id_categoria,id_categoria_padre,tipo_negocio,nombre,estado
                FROM categorias
                WHERE id_categoria_padre = 0  -- Categorías principales
            UNION ALL
                SELECT c.id_categoria,c.id_categoria_padre,c.tipo_negocio,CONCAT(sc.nombre, ' -> ',c.nombre),c.estado
                FROM categorias c
                JOIN subcategorias sc ON sc.id_categoria=c.id_categoria_padre
        )
        SELECT * FROM subcategorias
        ORDER BY nombre ASC");
        $stmt->execute();
        return $stmt->fetchAll();
    }
}