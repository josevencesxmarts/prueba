<?php

require_once "../controladores/compras.controlador.php";
require_once "../modelos/compras.modelo.php";
require_once "../vistas/assets/plugins/fpdf186/fpdf.php";

class AjaxCompras{

    public function getAjaxListarComprasTable($id_usuario=0, $fecha_inicio="", $fecha_fin=""){
        $compras = ComprasControlador::ctrGetListarComprasTable($id_usuario, $fecha_inicio, $fecha_fin);
        return $compras;
    }
    public function getAjaxListarDetComprasTable(){
        $det_compras = ComprasControlador::ctrGetListarDetComprasTable();
        echo json_encode($det_compras);
    }
    public function setAjaxRegistrarCompra($datos){
        $respuesta = ComprasControlador::ctrSetRegistrarCompra($datos);
        echo json_encode($respuesta);
    }
    public function getImprimirReporteCompras($pdf, $compras, $nombre_user, $fecha_inicio, $fecha_fin){
        $pdf->AliasNbPages();
        $pdf->AddPage();
        
        // COLUMNAS
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(17, 7,utf8_decode('Usuario: '.$nombre_user),0,1,'T');
        $pdf->Cell(17, 7,'Fecha inicio: '.$fecha_inicio,0,1,'T');
        $pdf->Cell(17, 7,'Fecha final: '.$fecha_fin,0,1,'T');
        $pdf->Cell(33, 10, 'Nro Venta', 0);
        $pdf->Cell(55, 10, 'Cant.',0,0,'R');
        $pdf->Cell(50, 10, 'Fecha',0,0,'R');
        $pdf->Cell(50, 10, 'Subtotal',0,0,'R');
        $pdf->Ln(8);
        $pdf->Cell(0,0,'','T');
        $pdf->Ln(1);
        
        // PRODUCTOS
        $pdf->SetFont('Arial', '', 9);
        $total_compras = 0;
        foreach ($compras as &$compra) {
            $pdf->MultiCell(70,4,utf8_decode($compra['nro_ticket']),0,'L'); 
            $pdf->Cell(85, -5, $compra['cant_productos'],0,0,'R');
            $pdf->Cell(60, -5, $compra['fecha_hora_concat'],0,0,'R');
            $pdf->Cell(45, -5, $compra['total_concat'],0,0,'R');
            $pdf->Ln(3);
            $total_compras += $compra['total'];
        }

        $pdf->Ln(3);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(170, 10, 'Total:',0,0,'R');
        $pdf->Cell(20, 10, '$'.number_format($total_compras,2,'.',','),0,0,'R');
        $pdf->Output('reporte_compras.pdf','I');
    }
}
$datos = json_decode(file_get_contents('php://input'),true);
if(isset($_POST['accion']) && $_POST['accion'] == 1){//Parametro para listar compras
    $compras = new AjaxCompras();
    echo json_encode($compras->getAjaxListarComprasTable());
}else if(isset($_POST['accion']) && $_POST['accion'] == 2){//Parametro para listar detalles de compras
    $det_compras = new AjaxCompras();
    $det_compras->getAjaxListarDetComprasTable();
}else if(isset($datos['accion']) && $datos['accion'] == 3) {//Parametro para registrar compra
    session_start();
    $json = new stdClass();
    if($_SESSION['usuario']){
        $cant_productos = $datos['cant_productos'];
        $total = $datos['total'];
        $lineas = $datos['lineas'];
        if(isset($cant_productos) && isset($total) && isset($lineas)){
            $registrar = new AjaxCompras();
            date_default_timezone_set('America/Mexico_City');
            $strFechaHora = date("Y-m-d H:i:s");
            $json->id_usuario = $_SESSION['usuario']->id_usuario;
            $json->cant_productos = $cant_productos;
            $json->fecha = $strFechaHora;
            $json->total = $total;
            $json->lineas = $lineas;
            $registrar->setAjaxRegistrarCompra($json);
        } else {
            $json->estado = false;
            $json->mensaje = 'Error al hacer el registro';
            $json->error = 'Sus datos son incorrectos';
            echo json_encode($json);
        }
    } else {
        $json->estado = false;
        $json->mensaje = 'Error al hacer el registro';
        $json->error = 'Su session a caducado, volver a inicial session';
        echo json_encode($json);
    }
}else if(isset($datos['accion']) && $datos['accion'] == 4) {//Parametro para descargar reporte por rango de fechas
    $id_usuario = $datos['id_usuario'];
    $nombre_user = $datos['nombre_user'];
    $fecha_inicio = $datos['fecha_inicio'];
    $fecha_fin = $datos['fecha_fin'];
    $compra = new AjaxCompras();
    $compras = $compra->getAjaxListarComprasTable($id_usuario, $fecha_inicio, $fecha_fin);
    class PDF extends FPDF
    {
        function Header()
        {
            $this->SetFont('Arial', 'B', 12);
            $this->Cell(0, 10, 'Reporte de Compras', 0, 1, 'C');
        }
        function Footer()
        {
            $this->SetY(-15);
            $this->SetFont('Arial', 'I', 8);
            $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C');
        }
    }
    $pdf = new PDF();
    $compra->getImprimirReporteCompras($pdf, $compras, $nombre_user, $fecha_inicio, $fecha_fin);
}
