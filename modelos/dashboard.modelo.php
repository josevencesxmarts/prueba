<?php

require_once "conexion.php";

class DashboardModelo{

    static public function mdlGetDatosDashboard(){
        // $stmt = Conexion::conectar()->prepare("CALL prc_ObtenerDatosDashboard()");
        $stmt = Conexion::conectar()->prepare("SELECT IFNULL((SELECT COUNT(*) FROM productos p),0) AS totalProductos,
        IFNULL(FORMAT((SELECT ROUND(SUM(dv.utilidad),2) FROM det_ventas dv INNER JOIN ventas v ON v.id_venta=dv.id_venta WHERE DATE(v.fecha) = CURDATE()),2),0.00) AS gananciasDeHoy,
        IFNULL(FORMAT((SELECT ROUND(SUM(dv.utilidad),2) FROM det_ventas dv INNER JOIN ventas v ON v.id_venta=dv.id_venta WHERE DATE(v.fecha) >= DATE(LAST_DAY(NOW()-INTERVAL + 1 MONTH) + INTERVAL 1 DAY) AND DATE(v.fecha) <= LAST_DAY(DATE(CURRENT_DATE))),2),0.00) AS gananciasDelMes,
        IFNULL(FORMAT((SELECT ROUND(SUM(v.total),2) FROM ventas v WHERE DATE(v.fecha) = CURDATE()),2),0.00) AS ventasDeHoy,
		IFNULL(FORMAT((SELECT ROUND(SUM(v.total),2) FROM ventas v WHERE DATE(v.fecha) >= DATE(LAST_DAY(NOW()-INTERVAL + 1 MONTH) + INTERVAL 1 DAY) AND DATE(v.fecha) <= LAST_DAY(DATE(CURRENT_DATE))),2),0.00) AS ventasDelMes,
        IFNULL((SELECT COUNT(1) FROM productos p WHERE p.stock <= p.min_stock),0) AS productosMinStock;");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    static public function mdlGetVentasMesActual(){
        // $stmt = Conexion::conectar()->prepare("CALL prc_ObtenerVentasMesActual()");
        $stmt = Conexion::conectar()->prepare("SELECT
            DATE(v.fecha) AS fecha_venta,
            ROUND(SUM(v.total),2) AS total_venta
        FROM ventas v
        WHERE DATE(v.fecha) >= DATE(LAST_DAY(NOW()-INTERVAL + 1 MONTH) + INTERVAL 1 DAY) 
        AND DATE(v.fecha) <= LAST_DAY(DATE(CURRENT_DATE))
        GROUP BY DATE(v.fecha)");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    static public function mdlGetProductosMasVendidos(){
        // $stmt = Conexion::conectar()->prepare("CALL prc_ListarProductosMasVendidos()");
        $stmt = Conexion::conectar()->prepare("SELECT IFNULL(p.codigo_barras,'') AS codigo_producto,
            p.nombre AS descripcion_producto,
            SUM(dv.cantidad) AS cantidad,
            CONCAT('$',FORMAT(SUM(dv.subtotal),2)) AS total_venta
        FROM det_ventas dv
        INNER JOIN productos p ON p.id_producto=dv.id_producto
        GROUP BY p.codigo_barras,p.nombre
        ORDER BY SUM(dv.cantidad) DESC
        LIMIT 10;");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    static public function mdlGetProductosPocoStock(){
        // $stmt = Conexion::conectar()->prepare("CALL prc_ListarProductosPocoStock()");
        $stmt = Conexion::conectar()->prepare("SELECT p.codigo_barras AS codigo_producto,
            p.nombre AS descripcion_producto,
            p.stock AS stock_actual,
            p.min_stock AS minimo_stock
        FROM productos p
        WHERE p.stock <= p.min_stock
        ORDER BY p.stock ASC;");
        $stmt->execute();
        return $stmt->fetchAll();
    }
}