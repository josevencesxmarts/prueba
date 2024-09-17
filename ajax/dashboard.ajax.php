<?php

require_once "../controladores/dashboard.controlador.php";
require_once "../modelos/dashboard.modelo.php";

class AjaxDashboard{

    public function getDatosDashboard(){
        $datos = DashboardControlador::ctrGetDatosDashboard();
        echo json_encode($datos);
    }
    public function getVentasMesActual(){
        $ventasMesActual = DashboardControlador::ctrGetVentasMesActual();
        echo json_encode($ventasMesActual);
    }
    public function getProductosMasVendidos(){
        $productosMasVendidos = DashboardControlador::ctrGetProductosMasVendidos();
        echo json_encode($productosMasVendidos);
    }
    public function getProductosPocoStock(){
        $productosPocoStock = DashboardControlador::ctrGetProductosPocoStock();
        echo json_encode($productosPocoStock);
    }
}
if(isset($_POST['accion']) && $_POST['accion'] == 1){ // Ejecutar function de ventas del mes (Grafico de barras)
    $ventasMesActual = new AjaxDashboard();
    $ventasMesActual->getVentasMesActual();
}else if(isset($_POST['accion']) && $_POST['accion'] == 2){ // Ejecutar function de los 10 productos mas vendidos
    $productosMasVendidos = new AjaxDashboard();
    $productosMasVendidos->getProductosMasVendidos();
}else if(isset($_POST['accion']) && $_POST['accion'] == 3){ // Ejecutar function de los productos con poco stock
    $productosPocoStock = new AjaxDashboard();
    $productosPocoStock->getProductosPocoStock();
}else if(isset($_POST['accion']) && $_POST['accion'] == 4){
    $datos = new AjaxDashboard();
    $datos->getDatosDashboard();
}
?>