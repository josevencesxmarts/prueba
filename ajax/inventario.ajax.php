<?php

require_once "../controladores/inventario.controlador.php";
require_once "../modelos/inventario.modelo.php";
require_once "../vistas/assets/plugins/fpdf186/fpdf.php";

class AjaxInventario{

    public function getAjaxListarInventarioTable(){
        $inventario = InventarioControlador::ctrGetListarInventarioTable();
        echo json_encode($inventario);
    }
    public function getAjaxListarEntradasSalidasInv($id_usuario=0, $fecha_inicio="", $fecha_fin=""){
        $data_reporte = InventarioControlador::ctrGetListarEntradasSalidasInv($id_usuario, $fecha_inicio, $fecha_fin);
        return json_encode($data_reporte);
    }
    public function getImprimirReporteCompras($pdf, $lineas, $nombre_user, $fecha_inicio, $fecha_fin){
        $pdf->AliasNbPages();
        $pdf->AddPage();
        
        // COLUMNAS
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(17, 7,utf8_decode('Usuario: '.$nombre_user),0,1,'T');
        $pdf->Cell(17, 7,'Fecha inicio: '.$fecha_inicio,0,1,'T');
        $pdf->Cell(17, 7,'Fecha final: '.$fecha_fin,0,1,'T');
        $pdf->Cell(33, 10, 'Productos', 0);
        $pdf->Cell(30, 10, 'Stock inicial', 0);
        $pdf->Cell(40, 10, 'Cant. Comprados',0,0,'R');
        $pdf->Cell(40, 10, 'Cant. Vendidos',0,0,'R');
        $pdf->Cell(40, 10, 'Stock actual',0,0,'R');
        $pdf->Ln(8);
        $pdf->Cell(0,0,'','T');
        $pdf->Ln(1);

        // PRODUCTOS
        $pdf->SetFont('Arial', '', 9);
        $stock_inicial = 0;
        $cant_compras = 0;
        $total_compras = 0;
        $cant_ventas = 0;
        $total_ventas = 0;
        $stock_actual = 0;
        foreach ($lineas as &$linea) {
            $pdf->MultiCell(30,4,utf8_decode($linea->nombre),0,'L'); 
            $pdf->Cell(50, -5, $linea->stock_inicial,0,0,'R');
            $pdf->Cell(41, -5, $linea->cant_compras_concat,0,0,'R');
            $pdf->Cell(44, -5, $linea->cant_ventas_concat,0,0,'R');
            $pdf->Cell(45, -5, $linea->stock_actual,0,0,'R');
            $stock_inicial += $linea->stock_inicial;
            $cant_compras += $linea->cant_compras;
            $total_compras += $linea->total_compras;
            $cant_ventas += $linea->cant_ventas;
            $total_ventas += $linea->total_ventas;
            $stock_actual += $linea->stock_actual;
            $pdf->Ln(3);
        }
        $pdf->Ln(12);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(51, -5, $stock_inicial,0,0,'R');
        $pdf->Cell(41, -5, $cant_compras.' ($'.number_format($total_compras,2,'.',',').')',0,0,'R');
        $pdf->Cell(44, -5, $cant_ventas.' ($'.number_format($total_ventas,2,'.',',').')',0,0,'R');
        $pdf->Cell(45, -5, $stock_actual,0,0,'R');
        $pdf->Output('reporte_entradas_salidas.pdf','I');
    }
}
$datos = json_decode(file_get_contents('php://input'),true);
if(isset($_POST['accion']) && $_POST['accion'] == 1){//Parametro para listar inventario
    $inventario = new AjaxInventario();
    $inventario->getAjaxListarInventarioTable();
}else if(isset($datos['accion']) && $datos['accion'] == 2) {//Parametro para descargar reporte de entradas y salidas por unusuario y por rango de fechas
    $id_usuario = $datos['id_usuario'];
    $nombre_user = $datos['nombre_user'];
    $fecha_inicio = $datos['fecha_inicio'];
    $fecha_fin = $datos['fecha_fin'];
    $inventario = new AjaxInventario();
    $data_reporte = json_decode($inventario->getAjaxListarEntradasSalidasInv($id_usuario, $fecha_inicio, $fecha_fin));
    class PDF extends FPDF
    {
        function Header()
        {
            $this->SetFont('Arial', 'B', 12);
            $this->Cell(0, 10, 'Reporte de Entradas y Salidas de Inventario', 0, 1, 'C');
        }
        function Footer()
        {
            $this->SetY(-15);
            $this->SetFont('Arial', 'I', 8);
            $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C');
        }
    }
    $pdf = new PDF();
    $inventario->getImprimirReporteCompras($pdf, $data_reporte, $nombre_user, $fecha_inicio, $fecha_fin);
}
