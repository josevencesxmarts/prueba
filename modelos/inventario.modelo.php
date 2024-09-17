<?php

require_once "conexion.php";

class InventarioModelo{

    static public function mdlGetListarInventarioTable(){
        $stmt = Conexion::conectar()->prepare("SELECT '' AS detalles,
            p.id_producto,
            p.id_categoria,
            p.id_udm,
            p.id_udm_compra,
            p.id_talla,
            p.id_color,
            p.id_marca,
            p.precio,
            p.costo,
            p.nombre,
            p.codigo_barras,
            IFNULL(m.nombre,'') AS marca,
            IFNULL(t.nombre,'') AS talla,
            IFNULL(c.nombre,'') AS color,
            p.utilidad,
            p.min_stock,
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
            p.img_principal,
            p.qr_base64,
            (WITH RECURSIVE subcategorias AS (
                    SELECT id_categoria,id_categoria_padre,nombre
                    FROM categorias
                    WHERE id_categoria_padre = 0  -- Categorías principales
                UNION ALL
                    SELECT c.id_categoria,c.id_categoria_padre,CONCAT(sc.nombre, ' -> ',c.nombre)
                    FROM categorias c
                    JOIN subcategorias sc ON sc.id_categoria=c.id_categoria_padre
                )
                SELECT nombre FROM subcategorias
                WHERE id_categoria=ca.id_categoria
                LIMIT 1
            ) AS categoria,
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
            ) AS nombre_concat,
            CONCAT('$',FORMAT(p.precio,2)) AS precio_concat,
            CONCAT('$',FORMAT(p.costo,2)) AS costo_concat,
            p.stock,
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
            ) AS udm
        FROM productos p
        LEFT JOIN categorias ca ON ca.id_categoria=p.id_categoria
        LEFT JOIN unidades_medida um ON um.id_unidad_medida=p.id_udm
        LEFT JOIN unidades_medida umc ON umc.id_unidad_medida=p.id_udm_compra
        LEFT JOIN tallas t ON t.id_talla=p.id_talla
        LEFT JOIN colores c ON c.id_color=p.id_color
        LEFT JOIN marcas m ON m.id_marca=p.id_marca
        ORDER BY p.id_producto");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    static public function mdlGetListarEntradasSalidasInv($id_usuario, $fecha_inicio, $fecha_fin){
        $where = "";
        if(!empty($id_usuario) || (!empty($fecha_inicio) && !empty($fecha_fin))){
            $where = "WHERE";
            if(!empty($id_usuario)){
                $where = $where." (v.id_usuario=".$id_usuario." OR c.id_usuario=".$id_usuario.")";
            }
            if(!empty($fecha_inicio) && !empty($fecha_fin)){
                if(!empty($id_usuario)){
                    $where = $where." AND";
                }
                $where = $where." (DATE_FORMAT(v.fecha,'%Y-%m-%d') BETWEEN '".$fecha_inicio."' AND '".$fecha_fin."' OR 
                DATE_FORMAT(c.fecha,'%Y-%m-%d') BETWEEN '".$fecha_inicio."' AND '".$fecha_fin."')";
            }
        }
        $stmt = Conexion::conectar()->prepare("SELECT sub.nombre,
                (sub.stock_actual+(sub.cant_ventas-sub.cant_compras)) AS stock_inicial,
                sub.cant_compras,
                sub.cant_compras_concat,
                sub.total_compras,
                sub.total_compras_concat,
                sub.cant_ventas,
                sub.cant_ventas_concat,
                sub.total_ventas,
                sub.total_ventas_concat,
                sub.stock_actual
        FROM(
            SELECT
                p.id_producto,
                p.nombre,
                IFNULL(SUM(dc.cantidad),0) AS cant_compras,
                IFNULL(CONCAT(SUM(dc.cantidad),' ($',FORMAT(SUM(dc.subtotal),2),')'),'0 ($0.00)') AS cant_compras_concat,
                IFNULL(SUM(dc.subtotal),0) AS total_compras,
                CONCAT('$',IFNULL(FORMAT(SUM(dc.subtotal),2),FORMAT(0,2))) AS total_compras_concat,
                IFNULL(SUM(dv.cantidad),0) AS cant_ventas,
                IFNULL(CONCAT(SUM(dv.cantidad),' ($',FORMAT(SUM(dv.subtotal),2),')'),'0 ($0.00)') AS cant_ventas_concat,
                IFNULL(SUM(dv.subtotal),0) AS total_ventas,CONCAT('$',IFNULL(FORMAT(SUM(dv.subtotal),2),FORMAT(0,2))) AS total_ventas_concat,
                p.stock AS stock_actual
            FROM productos p
            LEFT JOIN det_compras dc ON dc.id_producto=p.id_producto
            LEFT JOIN det_ventas dv ON dv.id_producto=p.id_producto
            LEFT JOIN compras c ON c.id_compra=dc.id_compra
            LEFT JOIN ventas v ON v.id_venta=dv.id_venta
            ".$where."
            GROUP BY p.id_producto,p.nombre,p.stock
            ORDER BY p.id_producto,p.nombre,p.stock
        ) AS sub
        WHERE sub.cant_compras!=0 OR sub.cant_ventas!=0
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }
}