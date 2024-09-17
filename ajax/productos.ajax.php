<?php

require_once "../controladores/productos.controlador.php";
require_once "../modelos/productos.modelo.php";
require_once "../vistas/assets/plugins/fpdf186/fpdf.php";

class AjaxProductos{

    public $nombre;
    public $id_categoria;
    public $id_udm;
    public $id_udm_compra;
    public $id_talla;
    public $id_color;
    public $id_marca;
    public $precio;
    public $costo;
    public $utilidad;
    public $stock;
    public $min_stock;
    public $codigo_barras;

    public function __construct(){
        session_start();
        if(isset($_SESSION['usuario']) && isset($_SESSION['lista_acceso_modulos'])){
            $array_filter_modulo = array_filter($_SESSION['lista_acceso_modulos'], function($obj){return $obj->vista == "productos.php";});
            $existe_modulo = reset($array_filter_modulo);
            $objeto = new stdClass();
            if(count($array_filter_modulo) > 0 && $existe_modulo->vista === "productos.php"){
                if($_POST['accion'] == 2 && $existe_modulo->user_create == 0){
                    $objeto->estado = false;
                    $objeto->mensaje = 'Sin permiso';
                    $objeto->error = 'No tiene acceso para registrar productos';
                    echo json_encode($objeto);
                    exit;
                } else if($_POST['accion'] == 3 && $existe_modulo->user_write == 0){
                    $objeto->estado = false;
                    $objeto->mensaje = 'Sin permiso';
                    $objeto->error = 'No tiene acceso para actualizar productos';
                    echo json_encode($objeto);
                    exit;
                } else if($_POST['accion'] == 4 && $existe_modulo->user_delete == 0){
                    $objeto->estado = false;
                    $objeto->mensaje = 'Sin permiso';
                    $objeto->error = 'No tiene acceso para eliminar productos';
                    echo json_encode($objeto);
                    exit;
                }
            } else {
                exit;
            }
        } else {
            exit;
        }
    }
    public function getAjaxListarProductosTable($domain){
        $productos = ProductosControlador::ctrGetListarProductosTable($domain);
        echo json_encode($productos);
    }
    public function setAjaxRegistrarProducto($data){
        $table = 'productos';
        $respuesta = ProductosControlador::ctrSetRegistrarProducto($table, $data);
        echo json_encode($respuesta);
    }
    public function setAjaxActualizarProducto($data){
        $table = 'productos';
        $id = $_POST['id_producto'];
        $nameId = 'id_producto';
        $respuesta = ProductosControlador::ctrSetActualizarProducto($table, $data, $id, $nameId);
        echo json_encode($respuesta);
    }
    public function setAjaxEliminarProducto(){
        $table = 'productos';
        $id = $_POST['id_producto'];
        $nameId = 'id_producto';
        $respuesta = ProductosControlador::ctrSetEliminarProducto($table, $id, $nameId);
        echo json_encode($respuesta);
    }
    public function getAjaxListarDatasFieldsTypeSelections(){
        $datasSelections = ProductosControlador::ctrGetListarDatasFieldsTypeSelections();
        echo json_encode($datasSelections);
    }
    public function getAjaxListaProductosAutocomplete(){
        $nombreProductos = ProductosControlador::ctrGetListaProductosAutocomplete();
        echo json_encode($nombreProductos);
    }
    public function getAjaxtListarProductosPdV(){
        $listaProductos = ProductosControlador::ctrGetListarProductosPdV();
        echo json_encode($listaProductos);
    }
}
if(isset($_POST['accion']) && $_POST['accion'] == 1){//Parametro para listar productos
    $productos = new AjaxProductos();
    $domain = json_decode($_POST['domain']); 
    $productos->getAjaxListarProductosTable($domain);
}else if(isset($_POST['accion']) && $_POST['accion'] == 2){//Parametro para registrar productos
    $registrarProducto = new AjaxProductos();
    $name_con_extencion = '';
    if(!empty($_FILES['img_principal'])){
        $datetime = new DateTime();
        $fechahora = $datetime->format('Y-m-d h:i:s A');
        $imagen = $_FILES['img_principal'];
        $extension = pathinfo($imagen['name'],PATHINFO_EXTENSION);
        $imagen_temporal = $imagen['tmp_name'];
        $name_con_extencion = $fechahora.'.'.$extension;
        $ruta_destino = '../vistas/assets/dist/img/'.$name_con_extencion;
        move_uploaded_file($imagen_temporal, $ruta_destino);
    }
    $data = array(
        'nombre' => "'" . $_POST['nombre'] . "'",
        'precio' => $_POST['precio'],
        'costo' => $_POST['costo'],
        'utilidad' => $_POST['utilidad'],
        'stock' => $_POST['stock'],
        'min_stock' => $_POST['min_stock'],
        'codigo_barras' => "'" . $_POST['codigo_barras'] . "'",
        'img_principal' => "'" . $name_con_extencion . "'",
    );
    if(!empty($_POST['id_categoria'])){
        $data['id_categoria'] = $_POST['id_categoria'];
    }
    if(!empty($_POST['id_udm'])){
        $data['id_udm'] = $_POST['id_udm'];
    }
    if(!empty($_POST['id_udm_compra'])){
        $data['id_udm_compra'] = $_POST['id_udm_compra'];
    }
    if(!empty($_POST['id_marca'])){
        $data['id_marca'] = $_POST['id_marca'];
    }
    if(!empty($_POST['id_talla'])){
        $data['id_talla'] = $_POST['id_talla'];
    }
    if(!empty($_POST['id_color'])){
        $data['id_color'] = $_POST['id_color'];
    }
    $registrarProducto -> setAjaxRegistrarProducto($data);
}else if(isset($_POST['accion']) && $_POST['accion'] == 3){//Parametro para actualizar producto
    $actualizarProducto = new AjaxProductos();
    $name_con_extencion = $_POST['name_img_existente'];
    if(!empty($_FILES['img_principal'])){
        $ruta_destino = '../vistas/assets/dist/img/';
        if(file_exists($ruta_destino.$name_con_extencion) && !empty($name_con_extencion)){
            unlink($ruta_destino.$name_con_extencion);
        }
        $datetime = new DateTime();
        $fechahora = $datetime->format('Y-m-d h:i:s A');
        $imagen = $_FILES['img_principal'];
        $extension = pathinfo($imagen['name'],PATHINFO_EXTENSION);
        $imagen_temporal = $imagen['tmp_name'];
        $name_con_extencion = $fechahora.'.'.$extension;
        move_uploaded_file($imagen_temporal, $ruta_destino.$name_con_extencion);
    }
    $data = array(
        'id_producto' => $_POST['id_producto'],
        'nombre' => $_POST['nombre'],
        'utilidad' => $_POST['utilidad'],
        'min_stock' => $_POST['min_stock'],
        'codigo_barras' => $_POST['codigo_barras'],
        'img_principal' => $name_con_extencion,
    );
    if($_SESSION['usuario']->update_precios_productos == 1){
        $data['precio'] = $_POST['precio'];
        $data['costo'] = $_POST['costo'];
    }
    if(!empty($_POST['id_categoria'])){
        $data['id_categoria'] = $_POST['id_categoria'];
    }
    if(!empty($_POST['id_udm'])){
        $data['id_udm'] = $_POST['id_udm'];
    }
    if(!empty($_POST['id_udm_compra'])){
        $data['id_udm_compra'] = $_POST['id_udm_compra'];
    }
    if(!empty($_POST['id_marca'])){
        $data['id_marca'] = $_POST['id_marca'];
    }
    if(!empty($_POST['id_talla'])){
        $data['id_talla'] = $_POST['id_talla'];
    }
    if(!empty($_POST['id_color'])){
        $data['id_color'] = $_POST['id_color'];
    }
    $actualizarProducto -> setAjaxActualizarProducto($data);
}else if(isset($_POST['accion']) && $_POST['accion'] == 4){//Parametro para eliminar producto
    $eliminarProducto = new AjaxProductos();
    $name_img_existente = $_POST['name_img_existente'];
    if(!empty($name_img_existente)){
        $ruta_destino = '../vistas/assets/dist/img/'.$name_img_existente;
        if(file_exists($ruta_destino)){
            unlink($ruta_destino);
        }
    }
    $eliminarProducto->setAjaxEliminarProducto();
}else if(isset($_POST['accion']) && $_POST['accion'] == 5){//Parametro desde vista de productos para cargar los campos tipo selection del form
    $datasSelections = new AjaxProductos();
    $datasSelections->getAjaxListarDatasFieldsTypeSelections();
}else if(isset($_POST['accion']) && $_POST['accion'] == 6){//Parametro desde vista de productos para imprimir etiquetas de productos
    $pdf = new FPDF();
    // Arreglo de datos para las etiquetas
    $productos = $_POST['productos'];
    // cantidad de etiquetas a imprimir por cada producto
    $cantidad = $_POST['cantidad'];
    // Configuración para los cuadritos
    $cuadritoWidth = 40;
    $cuadritoHeight = 55;
    $margin = 2;
    // Agregar página
    $pdf->AddPage();
    // Bucle for para generar las etiquetas
    $index = 0;
    $count_etiquetas = 0;
    foreach ($productos as $key => $value) {
        $product_repited = 0;
        while($product_repited < $cantidad){
            if($count_etiquetas == 25){
                // Agregar página
                $pdf->AddPage();
                $index = 0;
                $count_etiquetas = 0;
            }
            // Establecer fuente y tamaño
            $pdf->SetFont('Arial', '', 9);
            // Calcular la posición del cuadrito
            $x = ($index % 5) * ($cuadritoWidth + $margin);
            $y = floor($index / 5) * ($cuadritoHeight + $margin);
            // Dibujar el cuadrito
            $pdf->Rect($x, $y, $cuadritoWidth, $cuadritoHeight, 'D');
            // Agregar texto a la etiqueta
            $pdf->SetXY($x + 5, $y + 5);
            $pdf->MultiCell($cuadritoWidth - 10, 3, utf8_decode($value['nombre']), 0, 'L');
            // add title
            $pdf->SetXY($x + 8, $y + 15);
            $pdf->SetFont('Arial', 'B', 16);
            $pdf->MultiCell($cuadritoWidth - 10, 21, $value['precio'], 0, 'L');
            $pdf->Image($value['qr'], $x + 10, $y + 30, 19, 19, 'png');
            $product_repited++;
            $count_etiquetas++;
            $index++;
        }
    }
    // Salvar el PDF
    $pdf->Output('D', 'etiquetas.pdf');
}else if(isset($_POST['accion']) && $_POST['accion'] == 7){//Parametro desde vista de ventas para traer el listado de productos para input de autocompleatado
    $nombreProductos = new AjaxProductos();
    $nombreProductos->getAjaxListaProductosAutocomplete();
}else if(isset($_POST['accion']) && $_POST['accion'] == 8){//Parametro desde vista de ventas para obtener datos de un productos por su codigo y cargarlo en la tabla de venta
    $listaProducto = new AjaxProductos();
    $listaProducto -> getAjaxtListarProductosPdV();
}