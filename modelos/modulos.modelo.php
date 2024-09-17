<?php

require_once "conexion.php";

class ModulosModelo{

    static public function mdlGetObtenerModulos(){
        $stmt = Conexion::conectar()->prepare("SELECT m.id_modulo AS id,
		CASE WHEN (m.padre_id IS NULL OR m.padre_id=0) THEN '#' ELSE m.padre_id END AS parent,
                m.modulo AS text,
                m.vista
        FROM modulos m
        ORDER BY m.orden");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    static public function mdlGetObtenerModulosDeUsuarios(){
        $stmt = Conexion::conectar()->prepare("SELECT um.id_modulo,m.modulo,um.id_usuario,
                CASE WHEN (m.vista IS NULL OR m.vista='') THEN 0 ELSE 1 END AS cel,
                um.user_create,um.user_write,um.user_delete
        FROM usuario_modulos um
        INNER JOIN modulos m ON m.id_modulo=um.id_modulo
        ORDER BY m.orden");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    static public function mdlGetInfModuloQAsignaModulosAUsers(){
        $stmt = Conexion::conectar()->prepare("SELECT m.id_modulo,IFNULL(m.padre_id,0) AS padre_id
        FROM modulos m
        WHERE m.vista='usuario_modulos.php'
        LIMIT 1");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}