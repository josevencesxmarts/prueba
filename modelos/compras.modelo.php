<?php

require_once "conexion.php";
require_once "productos.modelo.php";


class ComprasModelo{

    static public function mdlGetListarComprasTable($id_usuario, $fecha_inicio, $fecha_fin){
        $where = '';
        if(!empty($id_usuario) || (!empty($fecha_inicio) && !empty($fecha_fin))){
            $where = "WHERE";
            if(!empty($id_usuario)){
                $where = $where." co.id_usuario=".$id_usuario."";
            }
            if(!empty($fecha_inicio) && !empty($fecha_fin)){
                if(!empty($id_usuario)){
                    $where = $where." AND";
                }
                $where = $where." DATE_FORMAT(co.fecha,'%Y-%m-%d') BETWEEN '".$fecha_inicio."' AND '".$fecha_fin."'";
            }
        }
        $stmt = Conexion::conectar()->prepare("SELECT '' AS detalles,
            co.id_compra,
            co.id_usuario,
            co.total,
            co.fecha,
            DATE_FORMAT(co.fecha,'%Y-%m-%d') AS fecha_concat,
            DATE_FORMAT(co.fecha,'%I:%i%p') AS hora_concat,
            co.nro_ticket,
            CONCAT_WS(' ',u.nombre,u.apellido) AS usuario,
            co.cant_productos,
            CONCAT('$',FORMAT(co.total,2)) AS total_concat,
            DATE_FORMAT(co.fecha,'%Y-%m-%d %I:%i%p') AS fecha_hora_concat,
            ''
        FROM compras co
        LEFT JOIN usuarios u ON u.id_usuario=co.id_usuario
        ".$where."
        ORDER BY co.id_compra");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    static public function mdlGetListarDetComprasTable(){
        $stmt = Conexion::conectar()->prepare("SELECT '' AS detalles,
            dc.id_det_compra,
            co.id_compra,
            u.id_usuario,
            co.cant_productos,
            co.total,
            co.fecha,
            DATE_FORMAT(co.fecha,'%Y-%m-%d') AS fecha_concat,
            DATE_FORMAT(co.fecha,'%I:%i%p') AS hora_concat,
            p.id_producto,
            CONCAT('$',FORMAT(co.total,2)) AS total_concat,
            dc.costo_unitario,
            dc.subtotal,
            co.nro_ticket,
            CONCAT_WS(' ',u.nombre,u.apellido) AS usuario,
            dc.descripcion AS producto,
            dc.cantidad,
            CONCAT(
                IF(umc.id_udm_referencia IS NOT NULL AND umc.id_udm_referencia != '',
                    CONCAT(
                        umc.nombre,
                        ' de ',
                        umc.ratio,
                        ' ',
                        (SELECT um_ref.nombre FROM unidades_medida um_ref WHERE um_ref.id_unidad_medida=umc.id_udm_referencia)
                    ),
                IFNULL(umc.nombre,''))
            ) AS udm_compra,
            CONCAT('$',FORMAT(dc.costo_unitario,2)) AS costo_unitario_concat,
            CONCAT('$',FORMAT(dc.subtotal,2)) AS subtotal_concat,
            DATE_FORMAT(co.fecha,'%Y-%m-%d %I:%i%p') AS fecha_hora_concat
        FROM det_compras dc
        LEFT JOIN compras co ON co.id_compra=dc.id_compra
        INNER JOIN productos p ON p.id_producto=dc.id_producto
        LEFT JOIN unidades_medida umc ON umc.id_unidad_medida=dc.id_udm_compra
        LEFT JOIN tallas t ON t.id_talla=p.id_talla
        LEFT JOIN colores c ON c.id_color=p.id_color
        LEFT JOIN marcas m ON m.id_marca=p.id_marca
        LEFT JOIN usuarios u ON u.id_usuario=co.id_usuario
        ORDER BY dc.id_det_compra");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    static public function mdlSetRegistrarCompra($datos){
        $objeto = new stdClass();
        $count_registros = 0;
        try{
            $stmt = Conexion::conectar()->prepare("SELECT IFNULL(LPAD(MAX(nro_ticket)+1,8,'0'),'00000001') AS secuencia,
                IFNULL(MAX(nro_ticket)+1,1) AS nro_max_compra,
                (SELECT IFNULL(MAX(dc.id_det_compra)+1,1) FROM det_compras dc) AS nro_max_detalle
            FROM compras");
            $stmt->execute();
            $max_secuencia = $stmt->fetch(PDO::FETCH_OBJ);
            $stmt = Conexion::conectar()->prepare("INSERT INTO compras(id_compra,nro_ticket,id_usuario,cant_productos,total,fecha)
                    VALUES (:id_compra,:nro_ticket,:id_usuario,:cant_productos,:total,:fecha)");
            $stmt->bindParam(':id_compra', $max_secuencia->nro_max_compra, PDO::PARAM_INT);
            $stmt->bindParam(':nro_ticket', $max_secuencia->secuencia, PDO::PARAM_STR);
            $stmt->bindParam(':id_usuario', $datos->id_usuario, PDO::PARAM_INT);
            $stmt->bindParam(':cant_productos', $datos->cant_productos, PDO::PARAM_STR);
            $stmt->bindParam(':total', $datos->total, PDO::PARAM_STR);
            $stmt->bindParam(':fecha', $datos->fecha, PDO::PARAM_STR);
            if($stmt->execute()){
                $nro_max_det = $max_secuencia->nro_max_detalle;
                foreach($datos->lineas as $dato){
                    $stmt = Conexion::conectar()->prepare("INSERT INTO det_compras(id_det_compra,id_compra,id_producto,descripcion,id_udm_venta,id_udm_compra,id_talla,id_color,id_marca,cantidad,costo_unitario,subtotal)
                            VALUES (:id_det_venta,:id_compra,:id_producto,:descripcion,:id_udm_venta,:id_udm_compra,:id_talla,:id_color,:id_marca,:cantidad,:costo_unitario,:subtotal)");
                    $stmt->bindParam(':id_det_venta', $nro_max_det, PDO::PARAM_INT);
                    $stmt->bindParam(':id_compra', $max_secuencia->nro_max_compra, PDO::PARAM_INT);
                    $stmt->bindParam(':id_producto', $dato['id_producto'], PDO::PARAM_INT);
                    $stmt->bindParam(':descripcion', $dato['descripcion'], PDO::PARAM_STR);
                    $stmt->bindParam(':id_udm_venta', $dato['id_udm_venta'], PDO::PARAM_INT);
                    $stmt->bindParam(':id_udm_compra', $dato['id_udm_compra'], PDO::PARAM_INT);
                    $stmt->bindParam(':id_talla', $dato['id_talla'], PDO::PARAM_INT);
                    $stmt->bindParam(':id_color', $dato['id_color'], PDO::PARAM_INT);
                    $stmt->bindParam(':id_marca', $dato['id_marca'], PDO::PARAM_INT);
                    $stmt->bindParam(':cantidad', $dato['cantidad'], PDO::PARAM_STR);
                    $stmt->bindParam(':costo_unitario', $dato['costo_unitario'], PDO::PARAM_STR);
                    $stmt->bindParam(':subtotal', $dato['subtotal'], PDO::PARAM_STR);
                    if($stmt->execute()){
                        $stock_actual = self::mdlGeStockProductoId($dato['id_producto'])->stock;
                        $stock_nuevo = $stock_actual + $dato['count_udm_productos_surtir'];
                        $data = array(
                            'stock' => $stock_nuevo,
                        );
                        ProductosModelo::mdlSetActualizarInformacion('productos', $data, $dato['id_producto'], 'id_producto');
                        $count_registros++;
                    }
                    $nro_max_det++;
                }
            }
            $objeto->estado = true;
            $objeto->mensaje = 'La venta se registró correctamente';
            $objeto->datos = $count_registros;
        }catch(Exception $e){
            $objeto->estado = false;
            $objeto->mensaje = 'Error al hacer el registro';
            $objeto->error = $e->getMessage();
        }
        $stmt = null;
        return $objeto;
    }
    static public function mdlGeStockProductoId($id_producto){
        $stmt = Conexion::conectar()->prepare("SELECT p.stock FROM productos AS p WHERE p.id_producto=".$id_producto." LIMIT 1");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}