<?php 
require_once "controladores/plantilla.controlador.php";

require_once "controladores/usuarios.controlador.php";
require_once "modelos/usuarios.modelo.php";

$plantilla = new PlantillaControlador();
$plantilla -> CargarPlantilla();
// require_once "vistas/assets/plugins/fpdf186/fpdf.php";


// class PDF extends FPDF
// {
//     function Header()
//     {
//         $this->SetFont('Arial', 'B', 12);
//         $this->Cell(0, 10, 'Reporte de Entradas y Salidas de Inventario', 0, 1, 'C');
//     }
//     function Footer()
//     {
//         $this->SetY(-15);
//         $this->SetFont('Arial', 'I', 8);
//         $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C');
//     }
// }
// $pdf = new PDF();

// $pdf->AliasNbPages();
// $pdf->AddPage();

// // COLUMNAS
// $pdf->SetFont('Arial', 'B', 10);
// $pdf->Cell(17, 7,utf8_decode('Usuario: '),0,1,'T');
// $pdf->Cell(17, 7,'Fecha inicio: ',0,1,'T');
// $pdf->Cell(17, 7,'Fecha final: ',0,1,'T');
// $pdf->Cell(33, 10, 'Productos', 0);
// $pdf->Cell(30, 10, 'Stock inicial', 0);
// $pdf->Cell(40, 10, 'Cant. Comprados',0,0,'R');
// $pdf->Cell(40, 10, 'Cant. Vendidos',0,0,'R');
// $pdf->Cell(40, 10, 'Stock actual',0,0,'R');
// $pdf->Ln(8);
// $pdf->Cell(0,0,'','T');
// $pdf->Ln(1);

// // PRODUCTOS
// $pdf->SetFont('Arial', '', 9);
// $total_ventas = 0;
// // foreach ($lineas as &$linea) {
//     $pdf->MultiCell(30,4,utf8_decode('jose'),0,'L'); 
//     $pdf->Cell(50, -5, '1,666.00',0,0,'R');
//     $pdf->Cell(41, -5, '1,666.00',0,0,'R');
//     $pdf->Cell(44, -5, '1,666.00',0,0,'R');
//     $pdf->Cell(45, -5, '1,666.00',0,0,'R');
//     $pdf->Ln(3);
// // }
// $pdf->Ln(12);
// $pdf->SetFont('Arial', 'B', 10);
// $pdf->Cell(51, -5, '1,666.00',0,0,'R');
// $pdf->Cell(41, -5, '1,666.00',0,0,'R');
// $pdf->Cell(44, -5, '1,666.00',0,0,'R');
// $pdf->Cell(45, -5, '1,666.00',0,0,'R');
// $pdf->Output('reporte_entradas_salidas.pdf','I');