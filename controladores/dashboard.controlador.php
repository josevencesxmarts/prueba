<?php

class DashboardControlador{

    static public function ctrGetDatosDashboard(){
        $datos = DashboardModelo::mdlGetDatosDashboard();
        return $datos;
    }
    static public function ctrGetVentasMesActual(){
        $ventasMesActual = DashboardModelo::mdlGetVentasMesActual();
        return $ventasMesActual;
    }
    static public function ctrGetProductosMasVendidos(){
        $productosMasVendidos = DashboardModelo::mdlGetProductosMasVendidos();
        return $productosMasVendidos;
    }
    static public function ctrGetProductosPocoStock(){
        $productosPocoStock = DashboardModelo::mdlGetProductosPocoStock();
        return $productosPocoStock;
    }
}