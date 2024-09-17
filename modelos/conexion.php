<?php

class Conexion{
    
    static public function conectar(){
        try {
            // $con = new PDO('mysql:host=localhost;dbname=sistema_de_ropa', 'root', 'admin');
            $con = new PDO('mysql:host=localhost;dbname=u442818963_bd_boutiquelor', 'u442818963_jose', '8bA$*/=N');
            return $con;
        } catch (PDOException $e) {
            echo "Fallo la conexion: " . $e->getMessage();
        }
    }
}