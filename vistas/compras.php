<?php if(session_status() === PHP_SESSION_NONE) session_start(); ?>
<script>
    var validarUrl = window.location.toString().search('compras');
    if(validarUrl > 0) { window.location = "../index.php"; }
</script>
<?php
    $existe = false;
    if(isset($_SESSION['lista_menus']) && isset($_SESSION['usuario'])){
        if(in_array("compras.php", $_SESSION['lista_menus'])){
            $existe = true;
        }
    }
?>
<?php if($existe):?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Compras</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item active">Compras</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <!-- row Tarjetas Informativas -->
        <div class="row">
            <nav class="w-100">
                <div class="nav nav-tabs" id="compras-tab" role="tablist">
                    <a class="nav-item nav-link active" id="compras-list-tab" data-toggle="tab" href="#compras-list" role="tab" aria-controls="compras-list" aria-selected="true">Compras</a>
                    <a class="nav-item nav-link" id="det-compras-list-tab" data-toggle="tab" href="#det-compras-list" role="tab" aria-controls="det-compras-list" aria-selected="false">Detalles de Compras</a>
                </div>
            </nav>
            <div class="tab-content p-3" id="nav-tabContent">
                <div class="tab-pane fade active show" id="compras-list" role="tabpanel" aria-labelledby="compras-list-tab">
                    <!-- row para listado de compras -->
                    <div class="row">
                        <div class="col-lg-12">
                            <table id="tbl_compras" class="table table-striped w-100 shadow">
                                <thead class="bg-info">
                                    <tr style="font-size: 15px;">
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>Nro Compra</th>
                                        <th>Usuario</th>
                                        <th>Cant. Productos</th>
                                        <th>Total</th>
                                        <th>Fecha</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody class="text-small">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="det-compras-list" role="tabpanel" aria-labelledby="det-compras-list-tab">
                    <div class="row">
                        <div class="col-lg-12">
                            <table id="tbl_det_compras" class="table table-striped w-100 shadow">
                                <thead class="bg-info">
                                    <tr style="font-size: 15px;">
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>Nro Compra</th>
                                        <th>Usuario</th>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>Costo</th>
                                        <th>Subtotal</th>
                                        <th>Fecha</th>
                                    </tr>
                                </thead>
                                <tbody class="text-small">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->

<!-- Ventana modal para visualizar una compra y sus detalles -->
<div class="modal fade" id="mdlVerDetCompras" data-row-index="">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            <div class="modal-header py-1 aling-items-center">
                <h3 class="modal-title">
                    <i class="fas fa-edit"></i>
                    <h1 class="text-center">
                        NRO. COMPRA: <span class="text-danger" id="modal_titulo_de_det_compra"></span>
                    </h1>
                </h3>
                <button type="button" class="btn btn-outline-secondary border-0 fs-5" data-bs-dismiss="modal"
                    id="btnCerrarModal">
                    <i class="fas fa-times-circle"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <table id="tbl_modal_det_compra" class="table table-striped w-100 shadow">
                            <thead class="bg-info">
                                <tr style="font-size: 15px;">
                                    <th></th>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>UdM</th>
                                    <th>Costo</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="text-small">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <!-- Creacion de botones para cancelar e imprimir etiquetas de productos -->
                <button type="button" class="btn btn-secondary mt-3 mx-2" style="width: 170px" data-bs-dismiss="modal" id="btnCancelarRegistro">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Ventana modal para crear una compra -->
<div class="modal fade" id="mdlRegistrarCompras" data-row-index="">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            <div class="modal-header py-1 aling-items-center">
                <h3 class="modal-title">
                    <i class="fas fa-edit"></i>
                    <h1 class="text-center">
                        CREAR COMPRA
                    </h1>
                </h3>
                <button type="button" class="btn btn-outline-secondary border-0 fs-5" data-bs-dismiss="modal"
                    id="btnCerrarModal">
                    <i class="fas fa-times-circle"></i>
                </button>
            </div>
            <div class="modal-body">
                <!-- row para listado de productos -->
                <div class="row">
                    <!-- INPUT PARA INGRESO DEL CODIGO DE BARRAS O DESCRIPCION DEL PRODUCTO -->
                    <div class="col-md-12">
                        <div class="form-group mb-4">
                            <label class="col-form-label" for="iptCodigoProducto">
                                <i class="fas fa-barcode fs-6"></i>
                                <span class="small">Productos</span>
                            </label>
                            <input type="text" class="form-control form-control-sm" id="iptProducto"
                                placeholder="Ingrese el código de barras o el nombre de producto"/>
                            <div id="sugerencias"></div>
                        </div>
                    </div>
                    <!-- LISTADO QUE CONTIENE LOS PRODUCTOS QUE SE VAN AGREGANDO PARA LA COMPRA -->
                    <div class="col-lg-12">
                        <table id="tbl_det_compra_create" class="table table-striped w-100 shadow">
                            <thead class="bg-info">
                                <tr style="font-size: 15px;">
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th>Producto</th>
                                    <th>Cant.</th>
                                    <th>UdM</th>
                                    <th>Costo</th>
                                    <th>Total</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody class="text-small">
                            </tbody>
                        </table>
                    </div>
                    <!-- BOTONE PARA VACIAR LISTADO DE LA COMPRA -->
                    <div class="col-lg-12 text-right">
                        <button class="btn btn-danger" id="btnVaciarListadoCompra">
                            <i class="fas fa-trash-alt"></i> Vaciar compra
                        </button>
                    </div>
                    <!-- ETIQUETA QUE MUESTRA LA SUMA TOTAL DE LOS PRODUCTOS AGREGADOS AL LISTADO -->
                    <div class="col-md-6">
                        <h1>Total: <span class="fw-bold text-danger" id="totalCompra">$0.00</span></h1>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <!-- Creacion de botones para cerrar ventana de ver det compras -->
                <button type="button" class="btn btn-secondary mt-3 mx-2" style="width: 170px" data-bs-dismiss="modal" id="btnCancelarRegistro">
                    Cerrar
                </button>
                <button type="submit" class="btn addNewRecord mt-3 mx-2" style="width: 170px" id="btnGuardarCompra">
                    Guardar Compra
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Ventana modal para Imprimir Reporte de Compras por Fechas -->
<form id="form_print_reporte_por_fechas" novalidate>
    <div class="modal fade" id="mdlImprimirReportePorFechas">
        <div class="modal-dialog modal-lg ">
            <div class="modal-content">
                <div class="modal-header bg-gray py-1 aling-items-center">
                    <h5 class="modal-title">Imprimir reporte de compras</h5>
                    <button type="button" class="btn btn-outline-primary text-white border-0 fs-5" data-bs-dismiss="modal"
                        id="btnCerrarModal">
                        <i class="fas fa-times-circle"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Abrimos una fila -->
                    <div class="row">
                        <!-- Columna para filtrar el reporte de compras por usuario -->
                        <div class="col-lg-12">
                            <div class="form-group mb-2">
                                <label class="" for="selUsuario">
                                    <i class="fas fa-dumpster fs-6"></i>
                                    <span class="small">Usuario</span>
                                    <span class="text-danger"></span>
                                </label>
                                <select type="text" class="form-select form-select-sm"
                                    aria-label=".form-select-sm example" id="selUsuario">
                                </select>
                                <div class="invalid-feedback">Debe seleccionar el usuario</div>
                            </div>
                        </div>
                        <!-- Columna para filtrar el rango de fechas -->
                        <div class="col-lg-6">
                            <div class="form-group mb-2">
                                <label class="" for="iptFechaInicio">
                                    <i class="fas fa-file-signature fs-6"></i>
                                    <span class="small">Fecha inicio</span>
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="date" class="form-control"
                                    id="iptFechaInicio" placeholder="Fecha inicio"/>
                                <div class="invalid-feedback">Debe ingresar la fecha de inicio</div>
                            </div>
                        </div>
                        <!-- Columna para filtrar el rango de fechas -->
                        <div class="col-lg-6">
                            <div class="form-group mb-2">
                                <label class="" for="iptFechaFin">
                                    <i class="fas fa-file-signature fs-6"></i>
                                    <span class="small">Fecha fin</span>
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="date" class="form-control"
                                    id="iptFechaFin" placeholder="Fecha final"/>
                                <div class="invalid-feedback">Debe ingresar la fecha final</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- Creacion de botones para cancelar e imprimir etiquetas de productos -->
                    <button type="button" class="btn btn-secondary mt-3 mx-2" style="width: 170px" data-bs-dismiss="modal" id="btnCancelarRegistro">
                        Cancelar
                    </button>
                    <button type="submit" class="btn addNewRecord mt-3 mx-2" style="width: 170px" id="btImprimirReporteFechas">
                        Imprimir reporte
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    var self = this;
    this.product_by_id = {}
    this.product_by_barcode = {}
    function save_productos(lista_productos){
        for(var i = 0, len = lista_productos.length; i < len; i++){
            var data = lista_productos[i];
            this.product_by_barcode[data.codigo_barras] = data
            this.product_by_id[data.id_producto] = data
        }
    }
    function get_product_by_barcode(barcode){
        return this.product_by_barcode[barcode];
    }
    function get_product_by_id(id_producto){
        return this.product_by_id[id_producto];
    }
    var accion,tbl_compras,tbl_det_compras,tbl_modal_det_compra,tbl_det_compra_create;
    var lista_compras,lista_det_compras,lista_usuarios,lista_udms;
    var lineas_agregadas = [];
    $(document).ready(function() {
        recargarTablasConDataActual();
        cargarSelectionUsers();
        cargarSelectionUdms();
        cargarProductosJS();
        getProductosAutocompleteCompra();
        /*===================================================================*/
        // CARGA DEL LISTADO DE COMPRAS CON EL PLUGIN DATATABLE JS
        /*===================================================================*/
        tbl_compras = $("#tbl_compras").DataTable({
            // order: [[1, 'asc']],
            // paging: false,
            pageLength: 10,
            dom: 'Bfrtip',
            buttons: [{
                    text: 'Crear compra',
                    className: 'addNewRecord',
                    action: function(e, dt, node, config) {
                        //EVENTO PARA LEVENTAR LA VENTANA MODAL
                        // stateBtnClickAddCompra = true;
                        accion = 2;
                        $('#mdlRegistrarCompras').modal('show');
                        setTimeout(function() {
                            tbl_det_compra_create.draw();
                        }, 175);
                    }
                },{
                    text: 'Imprimir reporte',
                    className: 'imprimirQrsRecord',
                    action: function(e, dt, node, config) {
                        $('#mdlImprimirReportePorFechas').modal('show');
                    }
                },
                'pageLength'
            ],
            ajax: {
                url: "ajax/compras.ajax.php",
                type: "POST",
                data: {
                    'accion': 1
                }, //1: LISTAR COMPRAS
                dataSrc: function(compras){
                    lista_compras = compras
                    return compras;
                },
            },
            columnDefs: [{
                    targets: 0,
                    orderable: false,
                    render: DataTable.render.select(),
                },
                {
                    targets: 1,
                    visible: false
                },
                {
                    targets: 2,
                    visible: false
                },
                {
                    targets: 3,
                    visible: false
                },
                {
                    targets: 4,
                    visible: false
                },
                {
                    targets: 5,
                    visible: false
                },
                {
                    targets: 6,
                    visible: false
                },
                {
                    targets: 12,
                    orderable: false,
                    width: '10%',
                    render: function(data, type, full, meta) {
                        return "<center>" +
                            "<span data-row-index='"+meta.row+"' id='btnVerCompra' class='text-primary px-4' style='cursor:pointer;'>" +
                            "<i class='fas fa-eye fs-1'></i>" +
                            "</span>" +
                            "</center>"
                    }
                }

            ],
            fixedColumns: {
                start: 1
            },
            scrollCollapse: true,
            scrollX: true,
            scrollY: 500,
            select: {
                style: 'multi',
                selector: 'td:first-child'
            },
            language: {
                "decimal": "",
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Entradas",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscar:",
                "zeroRecords": "Sin resultados encontrados",
                "paginate": {
                    "first": "Primero",
                    "last": "Ultimo",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            },
        });
        /*===================================================================*/
        // CARGA DEL LISTADO DET-COMPRAS CON EL PLUGIN DATATABLE JS
        /*===================================================================*/
        tbl_det_compras = $("#tbl_det_compras").DataTable({
            // order: [[1, 'asc']],
            // paging: false,
            pageLength: 10,
            dom: 'Bfrtip',
            buttons: [{
                text: 'Imprimir reporte detallado',
                className: 'imprimirQrsRecord',
                action: function(e, dt, node, config) {
                    alert('Esta en proceso esta funcion...');
                }
            }],
            ajax: {
                url: "ajax/compras.ajax.php",
                type: "POST",
                data: {
                    'accion': 2
                }, //1: LISTAR DET COMPRAS
                dataSrc: function(det_compras){
                    lista_det_compras = det_compras
                    return det_compras;
                },
            },
            columnDefs: [{
                    targets: 0,
                    orderable: false,
                    render: DataTable.render.select(),
                },
                {
                    targets: 1,
                    visible: false
                },
                {
                    targets: 2,
                    visible: false
                },
                {
                    targets: 3,
                    visible: false
                },
                {
                    targets: 4,
                    visible: false
                },
                {
                    targets: 5,
                    visible: false
                },
                {
                    targets: 6,
                    visible: false
                },
                {
                    targets: 7,
                    visible: false
                },
                {
                    targets: 8,
                    visible: false
                },
                {
                    targets: 9,
                    visible: false
                },
                {
                    targets: 10,
                    visible: false
                },
                {
                    targets: 11,
                    visible: false
                },
                {
                    targets: 12,
                    visible: false
                },
            ],
            fixedColumns: {
                start: 1
            },
            scrollCollapse: true,
            scrollX: true,
            scrollY: 500,
            select: {
                style: 'multi',
                selector: 'td:first-child'
            },
            language: {
                "decimal": "",
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Entradas",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscar:",
                "zeroRecords": "Sin resultados encontrados",
                "paginate": {
                    "first": "Primero",
                    "last": "Ultimo",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            },
        });
        /*===================================================================*/
        // INICIALIZAR LA TABLA MODAL DE VER DETALLES DE UNA COMPRA
        /*===================================================================*/
        tbl_modal_det_compra = $('#tbl_modal_det_compra').DataTable({
            // order: [[1, 'asc']],
            // paging: false,
            searching: false,
            columns: [{
                    "data": "id_det_compra"
                },
                {
                    "data": "producto"
                },
                {
                    "data": "cantidad"
                },
                {
                    "data": "udm_compra"
                },
                {
                    "data": "costo_unitario"
                },
                {
                    "data": "subtotal"
                },
            ],
            columnDefs: [{
                    targets: 0,
                    visible: false
                }, {
                    targets: 1
                }, {
                    targets: 2,
                    width: '10%'
                }, {
                    targets: 3,
                    width: '10%'
                }, {
                    targets: 4,
                    width: '10%'
                }, {
                    targets: 5,
                    width: '10%'
            }],
            scrollCollapse: true,
            scrollX: true,
            scrollY: 500,
            language: {
                "decimal": "",
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Entradas",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscar:",
                "zeroRecords": "Sin resultados encontrados",
                "paginate": {
                    "first": "Primero",
                    "last": "Ultimo",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            },
        });
        /*===================================================================*/
        // INICIALIZAR LA TABLA DE VENTAS
        /*===================================================================*/
        tbl_det_compra_create = $('#tbl_det_compra_create').DataTable({
            searching: false,
            columns: [{
                    "data": "id_producto"
                },
                {
                    "data": "cantidad"
                },
                {
                    "data": "count_udm_productos_surtir"
                },
                {
                    "data": "id_udm_compra"
                },
                {
                    "data": "costo_compra_producto"
                },
                {
                    "data": "subtotal"
                },
                {
                    "data": "descripcion_producto"
                },
                {
                    "data": "cantidad_editable"
                },
                {
                    "data": "udm_compra"
                },
                {
                    "data": "costo_venta_producto_editable",
                },
                {
                    "data": "subtotal_str"
                },
                {
                    "data": "btn_aumentar_cantidad"
                },
                {
                    "data": "btn_disminuir_cantidad"
                },
                {
                    "data": "btn_eliminar_linea"
                },
            ],
            columnDefs: [{
                    targets: 0,
                    visible: false
                }, {
                    targets: 1,
                    visible: false
                }, {
                    targets: 2,
                    visible: false
                }, {
                    targets: 3,
                    visible: false
                }, {
                    targets: 4,
                    visible: false
                }, {
                    targets: 5,
                    visible: false
                }, {
                    targets: 6,
                }, {
                    targets: 7,
                    width: '10%'
                }, {
                    targets: 8,
                    width: '10%'
                }, {
                    targets: 9,
                    width: '10%'
                }, {
                    targets: 10,
                    width: '10%'
                }, {
                    targets: 11,
                    width: '10%',
                    render: function(data, type, full, meta) {
                        return "<center>" +
                            "<span data-id-producto='"+full.id_producto+"' class='btnAumentarCantidad text-success px-2' style='cursor:pointer;' data-bs-toggle='tooltip' data-bs-placement='right'>" +
                            "<i class='fas fa-cart-plus fs-1'></i>" +
                            "</span>" +
                            "</center>"
                    }
                }, {
                    targets: 12,
                    width: '10%',
                    render: function(data, type, full, meta) {
                        return "<center>" +
                            "<span data-id-producto='"+full.id_producto+"' class='btnDisminuirCantidad text-warning px-2' style='cursor:pointer;' data-bs-toggle='tooltip' data-bs-placement='right'>" +
                            "<i class='fas fa-cart-arrow-down fs-1'></i>" +
                            "</span>" +
                            "</center>"
                    }
                }, {
                    targets: 13,
                    width: '10%',
                    render: function(data, type, full, meta) {
                        return "<center>" +
                            "<span data-id-producto='"+full.id_producto+"' class='btnEliminarProducto text-danger px-2' style='cursor:pointer;' data-bs-toggle='tooltip' data-bs-placement='right'>" +
                            "<i class='fas fa-trash fs-1'></i>" +
                            "</span>" +
                            "</center>"
                    }
                }
            ],
            paging: false,
            scrollCollapse: true,
            scrollX: true,
            scrollY: 500,
            language: {
                "decimal": "",
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Entradas",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscar:",
                "zeroRecords": "Sin resultados encontrados",
                "paginate": {
                    "first": "Primero",
                    "last": "Ultimo",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            },
        });
        /*===================================================================*/
        // EVENTO PARA AUMENTAR LA CANTIDAD DE UN PRODUCTO DEL LISTADO
        /*===================================================================*/
        $("#tbl_det_compra_create tbody").on('click', '.btnAumentarCantidad', function() {
            let linea = lineas_agregadas.find(li => li.id_producto === parseInt($(this).data('idProducto')));
            if(linea){
                let cantidad_nueva = parseFloat(linea.cantidad) + 1;
                linea.cantidad = cantidad_nueva;
                setCargarCompra();
            }
        });
        /*===================================================================*/
        // EVENTO PARA DISMINUIR LA CANTIDAD DE UN PRODUCTO DEL LISTADO
        /*===================================================================*/
        $("#tbl_det_compra_create tbody").on('click', '.btnDisminuirCantidad', function() {
            let linea = lineas_agregadas.find(li => li.id_producto === parseInt($(this).data('idProducto')));
            if(linea.cantidad && linea.cantidad >= 2){
                let cantidad_nueva = parseFloat(linea.cantidad) - 1;
                linea.cantidad = cantidad_nueva;
                setCargarCompra();
            }
        })
        /*===================================================================*/
        // EVENTO PARA AUMENTAR LA CANTIDAD DE UN PRODUCTO DEL LISTADO
        /*===================================================================*/
        $("#tbl_det_compra_create tbody").on('click', '.btnAumentCantMasiva', function() {
            let linea = lineas_agregadas.find(li => li.id_producto === parseInt($(this).data('idProducto')));
            Swal.fire({
                title: "",
                text: "Cantidad de productos a comprar",
                input: "number",
                width: 300,
                confirmButtonText: "Aceptar",
                showCancelButton: true
            }).then((result) => {
                if (result.value) {
                    if(result.value <= 0){
                        Swal.fire({
                            position: 'center',
                            icon: 'warning',
                            title: 'La cantidad del producto debe ser mayor a 0!',
                            showConfirmButton: false,
                            timer: 2000
                        });
                        return;
                    }
                    if(linea){
                        linea.cantidad = parseFloat(result.value);
                        setCargarCompra();
                    }
                }
            });
        });
        /*===================================================================*/
        // EVENTO PARA EDITAR LA UNIDAD DE MEDIDA DE COMPRA DEL PRODUCTO
        /*===================================================================*/
        $("#tbl_det_compra_create tbody").on('click', '.btnEditarUdmCompra', function() {
            var linea = lineas_agregadas.find(li => li.id_producto === parseInt($(this).data('idProducto')));
            Swal.fire({
                title: 'Seleccione una opción',
                input: 'select',
                inputOptions: lista_udms.reduce((acc, option) => {
                    acc[option.id_unidad_medida] = option.nombre;
                    return acc;
                }, {}),
                inputPlaceholder: 'Seleccione una unidad de medida',
                showCancelButton: true,
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar'
            }).then(resultado => {
                if (resultado.value) {
                    linea.id_udm_compra = parseInt(resultado.value);
                    var udm_compra = lista_udms.find(udm => udm.id_unidad_medida === parseInt(resultado.value));
                    linea.udm_compra = udm_compra ? udm_compra.nombre : '';
                    setCargarCompra();
                }
            });
        });
        /*===================================================================*/
        // EVENTO PARA EDITAR LA UNIDAD DE MEDIDA DE COMPRA DEL PRODUCTO
        /*===================================================================*/
        $("#tbl_det_compra_create tbody").on('click', '.btnEditarCostoCompra', function() {
            let linea = lineas_agregadas.find(li => li.id_producto === parseInt($(this).data('idProducto')));
            Swal.fire({
                title: "",
                text: "Costo del productos",
                input: "number",
                width: 300,
                confirmButtonText: "Agregar",
                showCancelButton: true
            }).then((result) => {
                if (result.value) {
                    if(result.value <= 0){
                        Swal.fire({
                            position: 'center',
                            icon: 'warning',
                            title: 'El costo del producto debe ser mayor a 0!',
                            showConfirmButton: false,
                            timer: 2000
                        });
                        return;
                    }
                    if(linea){
                        linea.costo_compra_producto = parseFloat(result.value);
                        setCargarCompra();
                    }
                }
            });
        });
        /*===================================================================*/
        // EVENTO QUE ELIMINARA EL PRODUCTO DEL LISTADO
        /*===================================================================*/
        $("#tbl_det_compra_create tbody").on('click', '.btnEliminarProducto', function() {
            let indice = lineas_agregadas.findIndex(li => li.id_producto === parseInt($(this).data('idProducto')));
            if(indice !== -1){
                lineas_agregadas.splice(indice,1);
                setCargarCompra();
            }
        })
        /*===================================================================*/
        // EVENTO QUE REGISTRA EL PRODUCTO EN EL LISTADO CUANDO SE INGRESE EL CODIGO DE BARRAS
        /*===================================================================*/
        $("#btnVaciarListadoCompra").on('click', function() {
            lineas_agregadas = [];
            setCargarCompra();
        })
        /*===================================================================*/
        // EVENTO QUE REGISTRA EL PRODUCTO EN EL LISTADO CUANDO SE INGRESE EL CODIGO DE BARRAS
        /*===================================================================*/
        $("#iptProducto").change(function() {
            setInsertNewProductoCompra($('#iptProducto').val());
        })
        /*===================================================================*/
        // EVENTO AL DAR CLICK EN EL MENU DE DETALLES DE COMPRA
        /*===================================================================*/
        $('#compras-list-tab, #det-compras-list-tab').on('click', function() {
            setTimeout(function() {
                tbl_compras.draw();
                tbl_det_compras.draw();
            }, 175);
        });
        /*===================================================================*/
        // EVENTO AL DETECTAR CAMBIOS DE TAMAÑO DE NAVEGADOR PARA RECARGAR DATA
        // DE LAS TABLAS Y NO SE DISTORCIONE LA INF DEL ENCABEZADO
        /*===================================================================*/
        $(window).resize(function() {
            recargarTablasConDataActual();
        });
        /*===================================================================*/
        // EVENTO AL DAR CLICK EN EL BOTON DE VER UNA COMPRA
        /*===================================================================*/
        $('#tbl_compras tbody').on('click', '#btnVerCompra', function(){
            $('#mdlVerDetCompras').data('rowIndex', $(this).data('rowIndex'));
            visualizarModalDeDetCompra($(this).data('rowIndex'));
        });
        /*===================================================================*/
        // FUNCION PARA VALIDAR LOS CAMPOS REQUERIDOS EN EL FORM
        /*===================================================================*/
        $('#form_print_reporte_por_fechas').on('submit', function(e) {
            e.preventDefault();
            const form_repor_compras = $('#form_print_reporte_por_fechas');
            let validation = Array.prototype.filter.call(form_repor_compras, function(form) {
                if (form.checkValidity() === true) {
                    let id_usuario = $('#selUsuario').val();
                    let nombre_user = ''
                    if(id_usuario.length > 0){
                        let user = lista_usuarios.find(us => us.id_usuario === parseInt(id_usuario));
                        nombre_user = user ? user.nombre_concat : '';
                    }
                    let datos = {
                        accion: 4,
                        id_usuario: id_usuario,
                        nombre_user: nombre_user,
                        fecha_inicio: $('#iptFechaInicio').val(),
                        fecha_fin: $('#iptFechaFin').val(),
                    }
                    $(".content-header").addClass("loader");
                    $.ajax({
                        url: 'ajax/compras.ajax.php',
                        type: 'POST',
                        xhrFields: {
                            responseType: 'blob'
                        },
                        data: JSON.stringify(datos),
                        contentType: 'application/json;charset=utf-8',
                        success: function(data){
                            $(".content-header").removeClass("loader");
                            if(data.type == 'application/pdf'){
                                Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: 'Ok',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                var a = document.createElement('a');
                                var url = window.URL.createObjectURL(data);
                                a.href = url;
                                a.download = 'reporte_compras.pdf';
                                a.click();
                                window.URL.revokeObjectURL(url);
                            } else {
                                Swal.fire({
                                    position: 'center',
                                    icon:'error',
                                    title: 'Error al imprimir el reporte de compras',
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            $(".content-header").removeClass("loader");
                            Swal.fire({
                                position: 'center',
                                icon:'error',
                                title: 'Ocurrio un error: '+error+'!',
                            });
                        }
                    });
                } else {
                    console.log('no paso la validación');
                }
                form.classList.add('was-validated');
            });
        });
        $('#btnGuardarCompra').on('click', function() {
            let json_lineas_compra = tbl_det_compra_create.rows().data();
            if(json_lineas_compra.length){
                Swal.fire({
                    title: 'Está seguro de registrar la compra?',
                    icon: 'warning',
                    confirmButtonClass: 'addNewRecord',
                    confirmButtonText: 'Si, deseo registrarlo!',
                    showCancelButton: true,
                    cancelButtonText: 'Cancelar',
                }).then((result) => {
                    if (result.isConfirmed) {
                        let array_values = Object.values(json_lineas_compra);
                        let update_lineas_venta = array_values.map(function(row){
                            if(row.id_producto){
                                let json = {
                                    id_producto: row.id_producto,
                                    descripcion: row.descripcion_producto,
                                    id_udm_venta: self.get_product_by_id(row.id_producto).id_udm,
                                    id_udm_compra: row.id_udm_compra,
                                    id_talla: self.get_product_by_id(row.id_producto).id_talla,
                                    id_color: self.get_product_by_id(row.id_producto).id_color,
                                    id_marca: self.get_product_by_id(row.id_producto).id_marca,
                                    cantidad: row.cantidad,
                                    count_udm_productos_surtir: row.count_udm_productos_surtir,
                                    costo_unitario: row.costo_compra_producto,
                                    subtotal: row.subtotal
                                }
                                return json;
                            } else {
                                return {};
                            }
                        }).filter(lin => lin.id_udm_venta != undefined && lin.id_udm_compra != undefined);
                        if(update_lineas_venta.length){
                            let data = {
                                accion: 3,
                                cant_productos: update_lineas_venta.map(li => (li.cantidad)).reduce((acumulado,cantidad) => acumulado + cantidad, 0),
                                total: update_lineas_venta.map(li => (li.subtotal)).reduce((acumulado,monto) => acumulado + monto, 0),
                                lineas: update_lineas_venta,
                            }
                            $(".content-header").addClass("loader");
                            $.ajax({
                                url: 'ajax/compras.ajax.php',
                                method: 'POST',
                                data: JSON.stringify(data),
                                contentType: 'application/json;charset=utf-8',
                                dataType: 'json',
                                success: function(objeto){
                                    $(".content-header").removeClass("loader");
                                    if(objeto.estado){
                                        Swal.fire({
                                            position: 'center',
                                            icon: 'success',
                                            title: objeto.mensaje+': '+objeto.datos,
                                            showConfirmButton: false,
                                            timer: 2000
                                        });
                                        tbl_compras.ajax.reload();
                                        tbl_det_compras.ajax.reload();
                                        lineas_agregadas = [];
                                        setCargarCompra();
                                        cargarProductosJS();
                                        getProductosAutocompleteCompra();
                                        $('#mdlRegistrarCompras').modal('hide');
                                    } else if(!objeto.estado) {
                                        Swal.fire({
                                            position: 'center',
                                            icon:'error',
                                            title: objeto.error,
                                        });
                                    }
                                },
                                error: function(xhr, status, error) {
                                    $(".content-header").removeClass("loader");
                                    Swal.fire({
                                        position: 'center',
                                        icon:'error',
                                        title: 'Ocurrio un error: '+error+'!',
                                    });
                                }
                            });
                        } else {
                            Swal.fire({
                                position: 'center',
                                icon:'error',
                                title: 'Error de unidades de medida!',
                            });
                        }
                    }
                });
            } else {
                Swal.fire({
                    position: 'center',
                    icon:'warning',
                    title: 'No hay productos en el listado'
                });
            }
        });
    }); // FIN DOCUMENTO READY
    /*===================================================================*/
    // FUNCION PARA MOSTRAR EL MODAL QUE VISUALIZA EL DETALLE DE UNA COMPRA
    /*===================================================================*/
    function visualizarModalDeDetCompra(row_index){
        let result = false;
        const data = tbl_compras.row(row_index).data();
        if(data && data.id_compra){
            $('#modal_titulo_de_det_compra').html(data.nro_ticket);
            $('#mdlVerDetCompras').modal('show');
            let total = 0;
            tbl_modal_det_compra.clear();
            let det_compra = lista_det_compras.filter(det => det.id_compra === data.id_compra);
            if(det_compra.length){
                det_compra.forEach(function(data){
                    tbl_modal_det_compra.row.add({
                        'id_det_compra': data.id_det_compra,
                        'producto': data.producto,
                        'cantidad': data.cantidad,
                        'udm_compra': data.udm_compra,
                        'costo_unitario': data.costo_unitario_concat,
                        'subtotal': data.subtotal_concat,
                    });
                    total = data.total;
                });
                let max_id_det_compra = Math.max(...det_compra.map(v => (v.id_det_compra)))
                tbl_modal_det_compra.row.add({
                    'id_det_compra': max_id_det_compra + 1,
                    'producto': '',
                    'cantidad': '',
                    'udm_compra': '',
                    'costo_unitario': '<strong>TOTAL:</strong>',
                    'subtotal': '<strong>'+det_compra[0].total_concat+'</strong>',
                });
                setTimeout(function() {
                    tbl_modal_det_compra.draw();
                }, 175);
                result = true;
            }
        }
        if(!result){
            Toast.fire({
                icon: 'error',
                title: 'Ocurrio un error intentelo mas tarde!',
            }); 
        }
    }
    /*===================================================================*/
    // FUNCION PARA RECARGAR TODAS LAS TABLAS DE ESTA VISTA PARA QUE RECARGUE LOS ESTILOS DE CADA TABLA
    /*===================================================================*/
    function recargarTablasConDataActual(){
        setTimeout(function() {
            tbl_compras.draw();
            tbl_det_compras.draw();
            tbl_modal_det_compra.draw();
            tbl_det_compra_create.draw();
        }, 175);
    }
    /*===================================================================*/
    // FUNCION PARA CARGAR EL CAMPO SELECTION DE LOS USUARIOS REGISTRADOS PARA PODER
    // FILTRAR LOS REPORTES DE COMPRA
    /*===================================================================*/
    function cargarSelectionUsers(){
        $.ajax({
            url: "ajax/usuarios.ajax.php",
            type: "POST",
            data: {
                'accion': 6
            },
            dataType: 'json',
            success: function(users) {
                lista_usuarios = users
                var user_option = '<option selected value="">Seleccione un usuario</option>';
                for (var i = 0; i < users.length; i++) {
                    user_option = user_option + '<option value="' + users[i].id_usuario + '">' + users[i].nombre_concat +
                    '</option>';
                }
                $('#selUsuario').html(user_option);
            }
        });
    }
    /*===================================================================*/
    // FUNCION PARA CARGAR EL LISTADO DE LAS UDMS REGISTRADOS PARA PODER
    // FILTRAR DESDE LA LISTA DE COMPRAS
    /*===================================================================*/
    function cargarSelectionUdms(){
        $.ajax({
            url: "ajax/unidades_medida.ajax.php",
            type: "POST",
            data: {
                'accion': 5
            },
            dataType: 'json',
            success: function(udms) {
                lista_udms = udms
            }
        });
    }
    /*===================================================================*/
    // FUNCION PARA LISTAR PRODUCTOS POR SU CODIGO DE BARRAS PARA FILTRAR DESDE JS CUANDO SE REALIZE BUSQUEDAS
    /*===================================================================*/
    function cargarProductosJS() {
        return $.ajax({
            'url': 'ajax/productos.ajax.php',
            'method': 'POST',
            'data': {
                'accion': 8, // FILTRAR PRODUCTOS POR SU CODIGO DE BARRAS
            },
            'dataType': 'json',
            'async': true,
            'success': function(respuesta) {
                save_productos(respuesta)
            },
            error: function (respuesta) {
                Swal.fire({
                    position: 'center',
                    icon:'error',
                    title: 'Ocurrio un error, cheque su conexion a internet!',
                });
            }
        });
    }
    /*===================================================================*/
    // TRAER LISTADO DE PRODUCTOS PARA INPUT DE AUTOCOMPLETADO
    /*===================================================================*/
    function getProductosAutocompleteCompra() {
        $.ajax({
            url: 'ajax/productos.ajax.php',
            method: 'POST',
            data: {
                'accion': 7
            },
            dataType: 'json',
            success: function(respuesta) {
                var productos_autocomplete = []; // SE USA PARA EL INPUT DE AUTOCOMPLETE
                for (let i = 0; i < respuesta.length; i++) {
                    productos_autocomplete.push({ value : respuesta[i]['id_producto'], label : respuesta[i]['descripcion_producto_compra']});
                }
                $('#iptProducto').autocomplete({
                    source: productos_autocomplete,
                    minLength: 1,
                    appendTo: '#sugerencias',
                    // autoFocus: true,
                    select: function(event, ui) {
                        setInsertNewProductoCompra(ui.item.value);
                        return false;
                    }
                });
            }
        });
    }
    function setInsertNewProductoCompra(search){
        // $('.loader').fadeIn(1000);
        let product_db = '';
        if (search != "") {
            // EVENTO CUANDO SE INGRESE EL CODIGO DE BARRAS AL PRESIONAR ENTER
            product_db = get_product_by_barcode(search);
            // EVENTO CUANDO SE SELECCIONE UNA OPCION DEL LISTADO DE BUSQUEDA
            if(product_db === undefined) {
                product_db = get_product_by_id(search);
            }
        }
        $('#iptProducto').val('');
        $('#iptProducto').focus();
        if(product_db === undefined){
            Toast.fire({
                icon: 'warning',
                title: 'No existe el producto',
            });
            var snd = new Audio("vistas/assets/sounds/error.wav");
            snd.play();
            return;
        }
        let valid_existe_product = lineas_agregadas.find(line => line.id_producto === product_db.id_producto);
        if(valid_existe_product){
            let cantidad_nueva = parseFloat(valid_existe_product.cantidad) + 1;
            valid_existe_product.cantidad = cantidad_nueva;
        } else {
            lineas_agregadas.push({
                id_producto: parseInt(product_db.id_producto),
                cantidad: 1,
                id_udm_compra: parseInt(product_db.id_udm_compra),
                udm_compra: product_db.udm_compra,
                costo_compra_producto: parseFloat(product_db.costo).toFixed(2)
            });
        }
        var snd = new Audio("vistas/assets/sounds/bell.wav");
        snd.play();
        setCargarCompra();
    }
    function setCargarCompra(){
        tbl_det_compra_create.clear();
        $('#totalCompra').html('$0.00');
        if(lineas_agregadas.length){
            let total = 0;
            lineas_agregadas.forEach(function(data){
                let product_db = get_product_by_id(data.id_producto);
                if(product_db){
                    var udm_compra = lista_udms.find(udm => udm.id_unidad_medida === parseInt(data.id_udm_compra));
                    var unidades_productos_compra = udm_compra.id_udm_referencia == 0 ? 1 : 0;
                    while(udm_compra.id_udm_referencia > 0){
                        var count_compra = unidades_productos_compra || udm_compra.ratio;
                        udm_compra = lista_udms.find(udm_ => udm_.id_unidad_medida === parseInt(udm_compra.id_udm_referencia)) || {id_udm_referencia:0};
                        if(udm_compra && udm_compra.ratio){
                            unidades_productos_compra = parseInt(count_compra) * parseInt(udm_compra.ratio);
                        }
                    }
                    var udm_venta = lista_udms.find(udm => udm.id_unidad_medida === parseInt(product_db.id_udm));
                    var unidades_productos_venta = udm_venta.id_udm_referencia == 0 ? 1 : 0;
                    while(udm_venta.id_udm_referencia > 0){
                        let count_venta = unidades_productos_venta || udm_venta.ratio;
                        udm_venta = lista_udms.find(udm_ => udm_.id_unidad_medida === parseInt(udm_venta.id_udm_referencia)) || {id_udm_referencia:0};
                        if(udm_venta && udm_venta.ratio){
                            unidades_productos_venta = parseInt(count_venta) * parseInt(udm_venta.ratio);
                        }
                    }
                    var cant_productos_surtir = 0;
                    if(unidades_productos_compra >= unidades_productos_venta){
                        cant_productos_surtir = unidades_productos_compra / unidades_productos_venta;
                    } else {
                        Swal.fire({
                            position: 'center',
                            icon:'error',
                            title: 'Error de restriccion de unidad de medida!',
                        });
                        let indice = lineas_agregadas.findIndex(li => li.id_producto === parseInt(data.id_producto));
                        if(indice !== -1){
                            lineas_agregadas.splice(indice,1);
                        }
                        return false;
                    }
                    let cantidad = parseInt(data.cantidad);
                    let count_udm_productos_surtir = cant_productos_surtir * cantidad;
                    let costo = parseFloat(data.costo_compra_producto).toFixed(2);
                    let subtotal = cantidad * costo;
                    tbl_det_compra_create.row.add({
                        'id_producto': parseInt(product_db.id_producto),
                        'cantidad': cantidad,
                        'count_udm_productos_surtir': count_udm_productos_surtir,
                        'id_udm_compra': parseInt(data.id_udm_compra),
                        'costo_compra_producto': costo,
                        'subtotal': subtotal,
                        'descripcion_producto': product_db.descripcion_producto,
                        'cantidad_editable': '<span data-id-producto="'+product_db.id_producto+'" class="btnAumentCantMasiva fw-bold text-primary px-1 fs-4" style="cursor:pointer;">'+cantidad+'</span> ',
                        'udm_compra': '<span data-id-producto="'+product_db.id_producto+'" class="btnEditarUdmCompra fw-bold text-primary px-1 fs-4" style="cursor:pointer;">'+data.udm_compra+'</span> ',
                        'costo_venta_producto_editable': '<span data-id-producto="'+product_db.id_producto+'" class="btnEditarCostoCompra fw-bold text-primary px-1 fs-4" style="cursor:pointer;">'+format_currency_amount(costo)+'</span> ',
                        'subtotal_str': format_currency_amount(subtotal),
                    });
                    total += subtotal;
                }
            });
            $('#totalCompra').html(format_currency_amount(total));
        }
        tbl_det_compra_create.draw();
    }
    /*===================================================================*/
    // FUNCION PARA DAR FORMATO DE MONEDA A UN MONTO
    /*===================================================================*/
    function format_currency_amount(amount=0){
        const options = { style: 'currency', currency: 'USD' };
        const numberFormat = new Intl.NumberFormat('en-US', options);
        return numberFormat.format(amount);
    }
</script>
<?php else:?>
    <script>
        window.location = "./index.php";
    </script>
<?php endif; ?>