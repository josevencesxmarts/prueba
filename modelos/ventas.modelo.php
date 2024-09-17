<?php

require_once "conexion.php";
require_once "configuracion.modelo.php";
require_once "productos.modelo.php";


class VentasModelo{

    static public function mdlGetListarVentasTable($id_usuario, $fecha_inicio, $fecha_fin){
        $where = '';
        if(!empty($id_usuario) || (!empty($fecha_inicio) && !empty($fecha_fin))){
            $where = "WHERE";
            if(!empty($id_usuario)){
                $where = $where." v.id_usuario=".$id_usuario."";
            }
            if(!empty($fecha_inicio) && !empty($fecha_fin)){
                if(!empty($id_usuario)){
                    $where = $where." AND";
                }
                $where = $where." DATE_FORMAT(v.fecha,'%Y-%m-%d') BETWEEN '".$fecha_inicio."' AND '".$fecha_fin."'";
            }
        }
        $stmt = Conexion::conectar()->prepare("SELECT '' AS detalles,
            v.id_venta,
            v.id_usuario,
            v.cambio,
            v.total,
            v.fecha,
            DATE_FORMAT(v.fecha,'%Y-%m-%d') AS fecha_concat,
            DATE_FORMAT(v.fecha,'%I:%i%p') AS hora_concat,
            v.nro_ticket,
            CONCAT_WS(' ',u.nombre,u.apellido) AS usuario,
            v.cant_productos,
            CONCAT('$',FORMAT(v.cambio,2)) AS cambio_concat,
            CONCAT('$',FORMAT(v.total,2)) AS total_concat,
            DATE_FORMAT(v.fecha,'%Y-%m-%d %I:%i%p') AS fecha_hora_concat,
            '',
            '',
            ''
            FROM ventas v
            LEFT JOIN usuarios u ON u.id_usuario=v.id_usuario
            ".$where."
            ORDER BY v.id_venta");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    static public function mdlGetListarDetVentasTable(){
        $stmt = Conexion::conectar()->prepare("SELECT '' AS detalles,
            dv.id_det_venta,
            v.id_venta,
            u.id_usuario,
            v.cant_productos,
            v.cambio,
            v.total,
            v.fecha,
            DATE_FORMAT(v.fecha,'%Y-%m-%d') AS fecha_concat,
            DATE_FORMAT(v.fecha,'%I:%i%p') AS hora_concat,
            p.id_producto,
            CONCAT('$',FORMAT(v.cambio,2)) AS cambio_concat,
            CONCAT('$',FORMAT(v.total,2)) AS total_concat,
            dv.precio_unitario,
            dv.utilidad,
            dv.subtotal,
            v.nro_ticket,
            CONCAT_WS(' ',u.nombre,u.apellido) AS usuario,
            CONCAT(
                IF(p.nombre IS NOT NULL AND p.nombre != '',
                    CONCAT(p.nombre,
                        IF((m.nombre IS NOT NULL AND m.nombre != '') OR
                            (t.nombre IS NOT NULL AND t.nombre != '') OR
                            (c.nombre IS NOT NULL AND c.nombre != ''),
                            '(',
                        ''),
                        IF(m.nombre IS NOT NULL AND m.nombre != '',
                            CONCAT(m.nombre,
                                IF((t.nombre IS NOT NULL AND t.nombre != '') OR
                                    (c.nombre IS NOT NULL AND c.nombre != ''),
                                    ',',
                                '')
                            ),
                        ''),
                        IF(t.nombre IS NOT NULL AND t.nombre != '',
                            CONCAT(t.nombre,
                                IF((c.nombre IS NOT NULL AND c.nombre != ''),
                                    ',',
                                '')
                            ),
                        ''),
                        IF(c.nombre IS NOT NULL AND c.nombre != '',
                            c.nombre,
                        ''),
                        IF((m.nombre IS NOT NULL AND m.nombre != '') OR
                            (t.nombre IS NOT NULL AND t.nombre != '') OR
                            (c.nombre IS NOT NULL AND c.nombre != ''),
                            ')',
                        '')
                    ),
                '')
            ) AS producto,
            dv.cantidad,
            CONCAT(
                IF(um.id_udm_referencia IS NOT NULL AND um.id_udm_referencia != '',
                    CONCAT(
                        um.nombre,
                        ' de ',
                        um.ratio,
                        ' ',
                        (SELECT um_ref.nombre FROM unidades_medida um_ref WHERE um_ref.id_unidad_medida=um.id_udm_referencia)
                    ),
                IFNULL(um.nombre,''))
            ) AS udm,
            CONCAT('$',FORMAT(dv.precio_unitario,2)) AS precio_unitario_concat,
            CONCAT('$',FORMAT(dv.subtotal,2)) AS subtotal_concat,
            DATE_FORMAT(v.fecha,'%Y-%m-%d %I:%i%p') AS fecha_hora_concat
            FROM det_ventas dv
            LEFT JOIN ventas v ON v.id_venta=dv.id_venta
            INNER JOIN productos p ON p.id_producto=dv.id_producto
            LEFT JOIN unidades_medida um ON um.id_unidad_medida=p.id_udm
            LEFT JOIN tallas t ON t.id_talla=p.id_talla
            LEFT JOIN colores c ON c.id_color=p.id_color
            LEFT JOIN marcas m ON m.id_marca=p.id_marca
            LEFT JOIN usuarios u ON u.id_usuario=v.id_usuario
            ORDER BY dv.id_det_venta");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    static public function mdlSetRegistrarVenta($datos, $cant_productos, $total_venta, $cambio, $strFechaHora, $id_usuario){
        $objeto = new stdClass();
        try{
            $config = ConfiguracionModelo::mdlGetListarConfiguracion();
            $stmt = Conexion::conectar()->prepare("SELECT IFNULL(LPAD(MAX(nro_ticket)+1,8,'0'),'00000001') AS secuencia,
                IFNULL(MAX(nro_ticket)+1,1) AS nro_max_venta,
                (SELECT IFNULL(MAX(dv.id_det_venta)+1,1) FROM det_ventas dv) AS nro_max_detalle
            FROM ventas");
            $stmt->execute();
            $max_secuencia = $stmt->fetch(PDO::FETCH_OBJ);
            $stmt = null;
            $stmt = Conexion::conectar()->prepare("INSERT INTO ventas(id_venta,nro_ticket,id_usuario,cant_productos,total,cambio,fecha)
                    VALUES (:id_venta,:nro_ticket,:id_usuario,:cant_productos,:total,:cambio,:fecha)");
            $stmt->bindParam(':id_venta', $max_secuencia->nro_max_venta, PDO::PARAM_INT);
            $stmt->bindParam(':nro_ticket', $max_secuencia->secuencia, PDO::PARAM_STR);
            $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $stmt->bindParam(':cant_productos', $cant_productos, PDO::PARAM_STR);
            $stmt->bindParam(':total', $total_venta, PDO::PARAM_STR);
            $stmt->bindParam(':cambio', $cambio, PDO::PARAM_STR);
            $stmt->bindParam(':fecha', $strFechaHora, PDO::PARAM_STR);
            if($stmt->execute()){
                $stmt = null;
                $listaProductos = [];
                $nro_max_det = $max_secuencia->nro_max_detalle;
                for ($i=0; $i < count($datos); $i++) {
                    $listaProductos = explode(",", $datos[$i]);
                    $stmt = Conexion::conectar()->prepare("INSERT INTO det_ventas(id_det_venta,id_venta,id_producto,cantidad,precio_unitario,utilidad,subtotal)
                            VALUES (:id_det_venta,:id_venta,:id_producto,:cantidad,:precio_unitario,:utilidad,:subtotal)");
                    $stmt->bindParam(':id_det_venta', $nro_max_det, PDO::PARAM_INT);
                    $stmt->bindParam(':id_venta', $max_secuencia->nro_max_venta, PDO::PARAM_INT);
                    $stmt->bindParam(':id_producto', $listaProductos[0], PDO::PARAM_INT);
                    $stmt->bindParam(':cantidad', $listaProductos[1], PDO::PARAM_STR);
                    $stmt->bindParam(':precio_unitario', $listaProductos[2], PDO::PARAM_STR);
                    $stmt->bindParam(':utilidad', $listaProductos[3], PDO::PARAM_STR);
                    $stmt->bindParam(':subtotal', $listaProductos[4], PDO::PARAM_STR);
                    if($stmt->execute()){
                        if($config != [] and $config->validar_stock == "1"){
                            $data = array(
                                'stock' => $listaProductos[5],
                            );
                            ProductosModelo::mdlSetActualizarInformacion('productos', $data, $listaProductos[0], 'id_producto');
                        }
                    } else {
                        $objeto->error = Conexion::conectar()->errorInfo();
                        return $objeto;
                    }
                    $nro_max_det++;
                }
            }else{
                $objeto->error = Conexion::conectar()->errorInfo();
                return $objeto;
            }
            $objeto->nro_ticket = $max_secuencia->secuencia;
        }catch(Exception $e){
            $objeto->error = $e->getMessage();
            return $objeto;
        }
        $stmt = null;
        return $objeto;
    }
}