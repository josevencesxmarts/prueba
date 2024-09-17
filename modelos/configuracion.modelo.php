<?php

require_once "conexion.php";

class ConfiguracionModelo{

    static public function mdlGetListarConfiguracion(){
        if(self::mdlGetValidExistRegistro() == true){
            $stmt = Conexion::conectar()->prepare("SELECT c.validar_stock,c.update_stock_productos,c.update_precios_productos FROM configuracion AS c LIMIT 1");
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        } else {
            return [];
        }
    }
    static public function mdlSetActualizarInformacion($data){
        try{
            $set = '';
            foreach ($data as $key => $value){
                $set.= $key.' = :'.$key.',';
            }
            $set = substr($set, 0, -1);
            $result = self::mdlGetValidExistRegistro();
            if($result == true) {
                $stmt = Conexion::conectar()->prepare("UPDATE configuracion SET $set WHERE id_configuracion = 1");
                foreach ($data as $key => $value) {
                    if($data[$key] === 'null'){
                        $stmt->bindParam(':'.$key, $data[$key], PDO::PARAM_NULL);
                    } else {
                        $stmt->bindParam(':'.$key, $data[$key], PDO::PARAM_STR);
                    }
                }
                if($stmt->execute()){
                    return 'ok';
                }else{
                    return Conexion::conectar()->errorInfo();
                }
            }else{
                return $result;
            }
        }catch(Exception $e){
            return  $e->getMessage();
        }
    }
    static public function mdlGetValidExistRegistro(){
        $stmt_valid = Conexion::conectar()->prepare("SELECT COUNT(*) AS qty FROM configuracion");
        $stmt_valid->execute();
        if($stmt_valid->fetch(PDO::FETCH_OBJ)->qty == 0) {
            $resultado = '';
            try{
                $stmt_valid = null;
                $stmt = Conexion::conectar()->prepare("INSERT INTO  configuracion (id_configuracion) VALUES (1)");
                if($stmt->execute()){
                    $resultado = true;
                }else{
                    $resultado = Conexion::conectar()->errorInfo();
                }
            }catch(Exception $e){
                $resultado = $e->getMessage();
            }
            $stmt = null;
            return $resultado;
        } else {
            return true;
        }
    }
}