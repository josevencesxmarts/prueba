<?php

require_once "../controladores/ventas.controlador.php";
require_once "../modelos/ventas.modelo.php";
require_once "../vistas/assets/plugins/fpdf186/fpdf.php";

class AjaxVentas{

    public function getAjaxListarVentasTable($id_usuario=0, $fecha_inicio="", $fecha_fin=""){
        $ventas = VentasControlador::ctrGetListarVentasTable($id_usuario, $fecha_inicio, $fecha_fin);
        return json_encode($ventas);
    }
    public function getAjaxListarDetVentasTable(){
        $det_ventas = VentasControlador::ctrGetListarDetVentasTable();
        echo json_encode($det_ventas);
    }
    public function setAjaxRegistrarVenta($datos, $cant_productos, $total_venta, $cambio, $strFechaHora, $id_usuario){
        $respuesta = VentasControlador::ctrSetRegistrarVenta($datos, $cant_productos, $total_venta, $cambio, $strFechaHora, $id_usuario);
        return $respuesta;
    }
    public function getImprimirTicketVenta($data_ticket){
        define('EURO',chr(128)); // Constante con el símbolo Euro.
        $pdf = new FPDF('P','mm',array(80,150)); // Tamaño tickt 80mm x 150 mm (largo aprox)
        $pdf->AddPage();
        // CABECERA
        $pdf->SetFont('Helvetica','',12);
        $pdf->Cell(60,4,'LORET JUVENIL',0,1,'C');
        $pdf->SetFont('Helvetica','',8);
        $pdf->Cell(60,4,utf8_decode('C.P.: 51500 Av. Benito Juárez #95'),0,1,'C');
        $pdf->Cell(60,4,utf8_decode('Abajo de la primaria México 68.'),0,1,'C');
        $pdf->Cell(60,4,utf8_decode('Col. México 68. Tejupilco de Hidalgo.'),0,1,'C');
        $pdf->Cell(60,4,'Tel: 7224457634',0,1,'C');
        $pdf->Cell(60,4,'Correo: loret_juvenil@hotmail.com',0,1,'C');
        $pdf->Cell(60,4,utf8_decode('Cajer@: '.$data_ticket->usuario),0,1,'C');
        $pdf->Cell(60,4,utf8_decode('Cliente: Público en general'),0,1,'C');

        // DATOS FACTURA        
        $pdf->Ln(5);
        $pdf->Cell(60,4,'No. Ticket: '.$data_ticket->nro_ticket,0,1,'');
        $pdf->Cell(60,4,'Fecha: '.$data_ticket->fecha_concat,0,1,'');
        $pdf->Cell(60,4,'Hora: '.$data_ticket->hora_concat,0,1,'');
        $pdf->Cell(60,4,utf8_decode('Método de pago: Efectivo'),0,1,'');
        
        // COLUMNAS
        $pdf->SetFont('Helvetica', 'B', 7);
        $pdf->Cell(30, 10, 'Articulo', 0);
        $pdf->Cell(5, 10, 'Cant.',0,0,'R');
        $pdf->Cell(10, 10, 'Precio',0,0,'R');
        $pdf->Cell(15, 10, 'Subtotal',0,0,'R');
        $pdf->Ln(8);
        $pdf->Cell(60,0,'','T');
        $pdf->Ln(0);
        
        // PRODUCTOS
        $pdf->SetFont('Helvetica', '', 7);
        foreach ($data_ticket->det_venta_ticket as &$linea) {
            $pdf->MultiCell(30,4,utf8_decode($linea['producto']),0,'L'); 
            $pdf->Cell(33, -5, $linea['cantidad'],0,0,'R');
            $pdf->Cell(14, -5, $linea['precio_unitario_concat'],0,0,'R');
            $pdf->Cell(14, -5, $linea['subtotal_concat'],0,0,'R');
            $pdf->Ln(3);
        }
        
        // SUMATORIO DE LOS PRODUCTOS Y CANTIDAD PRODUCTOS Y CAMBIO
        $pdf->Ln(6);
        $pdf->Cell(60,0,'','T');
        $pdf->Ln(2);    
        $pdf->Cell(25, 10, 'CANT. PRODUCTOS', 0);    
        $pdf->Cell(20, 10, '', 0);
        $pdf->Cell(15, 10, $data_ticket->cant_productos,0,0,'R');
        $pdf->Ln(3);    
        $pdf->Cell(25, 10, 'TOTAL', 0);    
        $pdf->Cell(20, 10, '', 0);
        $pdf->Cell(15, 10, $data_ticket->total_concat,0,0,'R');
        $pdf->Ln(3);    
        $pdf->Cell(25, 10, 'CAMBIO', 0);    
        $pdf->Cell(20, 10, '', 0);
        $pdf->Cell(15, 10, $data_ticket->cambio_concat,0,0,'R');
        
        // PIE DE PAGINA
        $pdf->Ln(10);
        $pdf->Cell(60,0,'GRASIAS POR SU COMPRA',0,1,'C');
        $pdf->Ln(3);
        $pdf->Cell(60,0,utf8_decode('¡DIOS LO BENDIGA!'),0,1,'C');
        
        $pdf->Output('ticket.pdf','i');
    }
    public function getImprimirReporteVentas($pdf, $ventas, $nombre_user, $fecha_inicio, $fecha_fin){
        $pdf->AliasNbPages();
        $pdf->AddPage();
        
        // COLUMNAS
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(17, 7,utf8_decode('Usuario: '.$nombre_user),0,1,'T');
        $pdf->Cell(17, 7,'Fecha inicio: '.$fecha_inicio,0,1,'T');
        $pdf->Cell(17, 7,'Fecha final: '.$fecha_fin,0,1,'T');
        $pdf->Cell(33, 10, 'Ticket', 0);
        $pdf->Cell(55, 10, 'Cant.',0,0,'R');
        $pdf->Cell(50, 10, 'Fecha',0,0,'R');
        $pdf->Cell(50, 10, 'Subtotal',0,0,'R');
        $pdf->Ln(8);
        $pdf->Cell(0,0,'','T');
        $pdf->Ln(1);
        
        // PRODUCTOS
        $pdf->SetFont('Arial', '', 9);
        $total_ventas = 0;
        foreach ($ventas as &$venta) {
            $pdf->MultiCell(70,4,utf8_decode($venta->nro_ticket),0,'L'); 
            $pdf->Cell(85, -5, $venta->cant_productos,0,0,'R');
            $pdf->Cell(60, -5, $venta->fecha_hora_concat,0,0,'R');
            $pdf->Cell(45, -5, $venta->total_concat,0,0,'R');
            $pdf->Ln(3);
            $total_ventas += $venta->total;
        }

        $pdf->Ln(3);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(170, 10, 'Total:',0,0,'R');
        $pdf->Cell(20, 10, '$'.number_format($total_ventas,2,'.',','),0,0,'R');
        $pdf->Output('reporte_ventas.pdf','I');
    }
}
$datos = json_decode(file_get_contents('php://input'),true);
if(isset($_POST['accion']) && $_POST['accion'] == 1){//Parametro para listar ventas
    $ventas = new AjaxVentas();
    echo $ventas->getAjaxListarVentasTable();
}else if(isset($_POST['accion']) && $_POST['accion'] == 2){//Parametro para listar detalles de ventas
    $det_ventas = new AjaxVentas();
    $det_ventas->getAjaxListarDetVentasTable();
}else if(isset($_POST['accion']) && $_POST['accion'] == 3) {//Parametro para registrar venta
    date_default_timezone_set('America/Mexico_City');
    $strFechaHora = date("Y-m-d H:i:s");
    $fecha = date('Y-m-d');
    $hora = date('h:iA');
    $registrar = new AjaxVentas();
    $result = $registrar->setAjaxRegistrarVenta($_POST['arr'], $_POST['cant_productos'], $_POST['total_venta'], $_POST['cambio'], $strFechaHora, $_POST['id_usuario']);
    if(isset($result->nro_ticket)){
        $data_ticket = new stdClass();
        $data_ticket->usuario = $_POST['usuario'];
        $data_ticket->nro_ticket = $result->nro_ticket;
        $data_ticket->fecha_concat = $fecha;
        $data_ticket->hora_concat = $hora;
        $data_ticket->det_venta_ticket = $_POST['det_venta_ticket'];
        $data_ticket->cant_productos = $_POST['cant_productos'];
        $data_ticket->total_concat = $_POST['total_concat'];
        $data_ticket->cambio_concat = $_POST['cambio_concat'];
        $registrar->getImprimirTicketVenta($data_ticket);
    }
}else if(isset($datos['accion']) && $datos['accion'] == 4) {//Parametro para reeimprimir un ticket de venta
    $data_ticket = $datos['data_ticket'];
    if(isset($data_ticket)){
        $venta = new AjaxVentas();
        $data_ticket_ = new stdClass();
        $data_ticket_->usuario = $data_ticket['usuario'];
        $data_ticket_->nro_ticket = $data_ticket['nro_ticket'];
        $data_ticket_->fecha_concat = $data_ticket['fecha_concat'];
        $data_ticket_->hora_concat = $data_ticket['hora_concat'];
        $data_ticket_->det_venta_ticket = $data_ticket['det_venta_ticket'];
        $data_ticket_->cant_productos = $data_ticket['cant_productos'];
        $data_ticket_->total_concat = $data_ticket['total_concat'];
        $data_ticket_->cambio_concat = $data_ticket['cambio_concat'];
        $venta->getImprimirTicketVenta($data_ticket_);
    }
}else if(isset($datos['accion']) && $datos['accion'] == 5) {//Parametro para descargar reporte por rango de fechas
    $id_usuario = $datos['id_usuario'];
    $nombre_user = $datos['nombre_user'];
    $fecha_inicio = $datos['fecha_inicio'];
    $fecha_fin = $datos['fecha_fin'];
    $venta = new AjaxVentas();
    $ventas = json_decode($venta->getAjaxListarVentasTable($id_usuario, $fecha_inicio, $fecha_fin));
    class PDF extends FPDF
    {
        function Header()
        {
            $this->SetFont('Arial', 'B', 12);
            $this->Cell(0, 10, 'Reporte de Ventas', 0, 1, 'C');
        }
        function Footer()
        {
            $this->SetY(-15);
            $this->SetFont('Arial', 'I', 8);
            $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C');
        }
    }
    $pdf = new PDF();
    $venta->getImprimirReporteVentas($pdf, $ventas, $nombre_user, $fecha_inicio, $fecha_fin);
}