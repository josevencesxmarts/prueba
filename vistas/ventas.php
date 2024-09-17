<?php if(session_status() === PHP_SESSION_NONE) session_start(); ?>
<script>
    var validarUrl = window.location.toString().search('ventas');
    if(validarUrl > 0) { window.location = "../index.php"; }
</script>
<?php
    $existe = false;
    if(isset($_SESSION['lista_menus']) && isset($_SESSION['usuario'])){
        if(in_array("ventas.php", $_SESSION['lista_menus'])){
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
                <h1 class="m-0">Ventas</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item active">Ventas</li>
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
                <div class="nav nav-tabs" id="ventas-tab" role="tablist">
                    <a class="nav-item nav-link active" id="ventas-list-tab" data-toggle="tab" href="#ventas-list" role="tab" aria-controls="ventas-list" aria-selected="true">Ventas</a>
                    <a class="nav-item nav-link" id="det-ventas-list-tab" data-toggle="tab" href="#det-ventas-list" role="tab" aria-controls="det-ventas-list" aria-selected="false">Detalles de Ventas</a>
                </div>
            </nav>
            <div class="tab-content p-3" id="nav-tabContent">
                <div class="tab-pane fade active show" id="ventas-list" role="tabpanel" aria-labelledby="ventas-list-tab">
                    <!-- row para listado de ventas -->
                    <div class="row">
                        <div class="col-lg-12">
                            <table id="tbl_ventas" class="table table-striped w-100 shadow">
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
                                        <th>Nro Ticket</th>
                                        <th>Vendedor</th>
                                        <th>Cant. Productos</th>
                                        <th>Cambio</th>
                                        <th>Total</th>
                                        <th>Fecha</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody class="text-small">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="det-ventas-list" role="tabpanel" aria-labelledby="det-ventas-list-tab">
                    <div class="row">
                        <div class="col-lg-12">
                            <table id="tbl_det_ventas" class="table table-striped w-100 shadow">
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
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>Nro Ticket</th>
                                        <th>Vendedor</th>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>Precio</th>
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

<!-- Ventana modal para visualizar una venta y sus detalles -->
<div class="modal fade" id="mdlGestionarVentas" data-row-index="">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            <div class="modal-header py-1 aling-items-center">
                <h3 class="modal-title">
                    <i class="fas fa-edit"></i>
                    <h1 class="text-center">
                        TICKET: <span class="text-danger" id="modal_titulo_de_det_venta"></span>
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
                        <table id="tbl_modal_det_venta" class="table table-striped w-100 shadow">
                            <thead class="bg-info">
                                <tr style="font-size: 15px;">
                                    <th></th>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>UdM</th>
                                    <th>Precio</th>
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
                <!-- Creacion de botones para cancelar e imprimir ticket de venta -->
                <button type="button" class="btn btn-secondary mt-3 mx-2" style="width: 170px" data-bs-dismiss="modal" id="btnCancelarRegistro">
                    Cerrar
                </button>
                <button type="submit" class="btn addNewRecord mt-3 mx-2" style="width: 170px" id="btnPrintVentaModal">
                    Imprimir
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Ventana modal para Imprimir Reporte de Ventas por Fechas -->
<form id="form_print_reporte_por_fechas" novalidate>
    <div class="modal fade" id="mdlImprimirReportePorFechas">
        <div class="modal-dialog modal-lg ">
            <div class="modal-content">
                <div class="modal-header bg-gray py-1 aling-items-center">
                    <h5 class="modal-title">Imprimir reporte de ventas</h5>
                    <button type="button" class="btn btn-outline-primary text-white border-0 fs-5" data-bs-dismiss="modal"
                        id="btnCerrarModal">
                        <i class="fas fa-times-circle"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Abrimos una fila -->
                    <div class="row">
                        <!-- Columna para filtrar el reporte de ventas por usuario -->
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
    var accion,tbl_ventas,tbl_det_ventas,tbl_modal_det_venta;
    var lista_ventas,lista_det_ventas,lista_usuarios;
    $(document).ready(function() {
        recargarTablasConDataActual();
        cargarSelectionUsers();
        /*===================================================================*/
        // CARGA DEL LISTADO DE VENTAS CON EL PLUGIN DATATABLE JS
        /*===================================================================*/
        tbl_ventas = $("#tbl_ventas").DataTable({
            // order: [[1, 'asc']],
            // paging: false,
            pageLength: 10,
            dom: 'Bfrtip',
            buttons: [{
                    text: 'Imprimir reporte',
                    className: 'imprimirQrsRecord',
                    action: function(e, dt, node, config) {
                        $('#mdlImprimirReportePorFechas').modal('show');
                    }
                },
                'pageLength'
            ],
            ajax: {
                url: "ajax/ventas.ajax.php",
                type: "POST",
                data: {
                    'accion': 1
                }, //1: LISTAR VENTAS
                dataSrc: function(ventas){
                    lista_ventas = ventas
                    return ventas;
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
                    targets: 14,
                    orderable: false,
                    width: '10%',
                    render: function(data, type, full, meta) {
                        return "<center>" +
                            "<span data-row-index='"+meta.row+"' id='btnReturnVenta' class='text-danger px-4' style='cursor:pointer;'>" +
                            "<i class='fas fa-reply fs-1'></i>" +
                            "</span>" +
                            "</center>"
                    }
                },
                {
                    targets: 15,
                    orderable: false,
                    width: '10%',
                    render: function(data, type, full, meta) {
                        return "<center>" +
                            "<span data-row-index='"+meta.row+"' id='btnVerVenta' class='text-primary px-4' style='cursor:pointer;'>" +
                            "<i class='fas fa-eye fs-1'></i>" +
                            "</span>" +
                            "</center>"
                    }
                },
                {
                    targets: 16,
                    orderable: false,
                    width: '10%',
                    render: function(data, type, full, meta) {
                        return "<center>" +
                            "<span data-row-index='"+meta.row+"' id='btnPrintVenta' class='text-info px-4' style='cursor:pointer;'>" +
                            "<i class='fas fa-print fs-1'></i>" +
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
        // CARGA DEL LISTADO DET-VENTAS CON EL PLUGIN DATATABLE JS
        /*===================================================================*/
        tbl_det_ventas = $("#tbl_det_ventas").DataTable({
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
                url: "ajax/ventas.ajax.php",
                type: "POST",
                data: {
                    'accion': 2
                }, //1: LISTAR DET VENTAS
                dataSrc: function(det_ventas){
                    lista_det_ventas = det_ventas
                    return det_ventas;
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
                {
                    targets: 13,
                    visible: false
                },
                {
                    targets: 14,
                    visible: false
                },
                {
                    targets: 15,
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
        // INICIALIZAR LA TABLA MODAL DE VER DETALLES DE UNA VENTA
        /*===================================================================*/
        tbl_modal_det_venta = $('#tbl_modal_det_venta').DataTable({
            // order: [[1, 'asc']],
            // paging: false,
            searching: false,
            columns: [{
                    "data": "id_det_venta"
                },
                {
                    "data": "producto"
                },
                {
                    "data": "cantidad"
                },
                {
                    "data": "udm"
                },
                {
                    "data": "precio_unitario"
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
        // EVENTO AL DAR CLICK EN EL MENU DE DETALLES DE VENTA
        /*===================================================================*/
        $('#ventas-list-tab, #det-ventas-list-tab').on('click', function() {
            setTimeout(function() {
                tbl_ventas.draw();
                tbl_det_ventas.draw();
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
        // EVENTO AL DAR CLICK EN EL BOTON PARA HACER UN REEMBOLSO DE DE VENTA
        /*===================================================================*/
        $('#tbl_ventas tbody').on('click', '#btnReturnVenta', function(){
            reembolsarVenta($(this).data('rowIndex'));
        });
        /*===================================================================*/
        // EVENTO AL DAR CLICK EN EL BOTON DE VER UNA VENTA
        /*===================================================================*/
        $('#tbl_ventas tbody').on('click', '#btnVerVenta', function(){
            $('#mdlGestionarVentas').data('rowIndex', $(this).data('rowIndex'));
            visualizarModalDeDetVenta($(this).data('rowIndex'));
        });
        /*===================================================================*/
        // EVENTO AL DAR CLICK EN EL BOTON PARA REIMPRIMIR TICKET DE VENTA
        /*===================================================================*/
        $('#tbl_ventas tbody').on('click', '#btnPrintVenta', function(){
            reimprimirTicketDeVenta($(this).data('rowIndex'));
        });
        /*===================================================================*/
        // EVENTO AL DAR CLICK EN EL BOTON DEL MODAL PARA REIMPRIMIR TICKET DE VENTA
        /*===================================================================*/
        $('#btnPrintVentaModal').on('click', function(){
            var row_index = $('#mdlGestionarVentas').data('rowIndex');
            reimprimirTicketDeVenta(row_index);
        });
        /*===================================================================*/
        // FUNCION PARA VALIDAR LOS CAMPOS REQUERIDOS EN EL FORM
        /*===================================================================*/
        $('#form_print_reporte_por_fechas').on('submit', function(e) {
            e.preventDefault();
            const form_repor_ventas = $('#form_print_reporte_por_fechas');
            let validation = Array.prototype.filter.call(form_repor_ventas, function(form) {
                if (form.checkValidity() === true) {
                    let id_usuario = $('#selUsuario').val();
                    let nombre_user = ''
                    if(id_usuario.length > 0){
                        let user = lista_usuarios.find(us => us.id_usuario === parseInt(id_usuario));
                        nombre_user = user ? user.nombre_concat : '';
                    }
                    let datos = {
                        accion: 5,
                        id_usuario: id_usuario,
                        nombre_user: nombre_user,
                        fecha_inicio: $('#iptFechaInicio').val(),
                        fecha_fin: $('#iptFechaFin').val(),
                    }
                    $(".content-header").addClass("loader");
                    $.ajax({
                        url: 'ajax/ventas.ajax.php',
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
                                a.download = 'reporte_ventas.pdf';
                                a.click();
                                window.URL.revokeObjectURL(url);
                            } else {
                                Swal.fire({
                                    position: 'center',
                                    icon:'error',
                                    title: 'Error al imprimir el reporte de ventas',
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
    }); // FIN DOCUMENTO READY
    /*===================================================================*/
    // FUNCION PARA HACER UN REEMBOLSO POR SI EL CLIENTE DESEA REGRESAR UN PRODUCTO
    /*===================================================================*/
    function reembolsarVenta(row_index){
        let result = false;
        const data = tbl_ventas.row(row_index).data();
        if(data && data.id_venta){
            alert('Esta en proceso la funcionalidad de reembolsar una venta...');
            result = true;
        }
        if(!result){
            Toast.fire({
                icon: 'error',
                title: 'Ocurrio un error intentelo mas tarde!',
            }); 
        }
    }
    /*===================================================================*/
    // FUNCION PARA MOSTRAR EL MODAL QUE VISUALIZA EL DETALLE DE UNA VENTA
    /*===================================================================*/
    function visualizarModalDeDetVenta(row_index){
        let result = false;
        const data = tbl_ventas.row(row_index).data();
        if(data && data.id_venta){
            $('#modal_titulo_de_det_venta').html(data.nro_ticket);
            $('#mdlGestionarVentas').modal('show');
            let total = 0;
            tbl_modal_det_venta.clear();
            let det_venta = lista_det_ventas.filter(det => det.id_venta === data.id_venta);
            if(det_venta.length){
                det_venta.forEach(function(data){
                    tbl_modal_det_venta.row.add({
                        'id_det_venta': data.id_det_venta,
                        'producto': data.producto,
                        'cantidad': data.cantidad,
                        'udm': data.udm,
                        'precio_unitario': data.precio_unitario_concat,
                        'subtotal': data.subtotal_concat,
                    });
                    total = data.total;
                });
                let max_id_det_venta = Math.max(...det_venta.map(v => (v.id_det_venta)))
                tbl_modal_det_venta.row.add({
                    'id_det_venta': max_id_det_venta + 1,
                    'producto': '',
                    'cantidad': '',
                    'udm': '',
                    'precio_unitario': '<strong>TOTAL:</strong>',
                    'subtotal': '<strong>'+det_venta[0].total_concat+'</strong>',
                });
                setTimeout(function() {
                    tbl_modal_det_venta.draw();
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
    // FUNCION PARA REIMPRIMIR UN TICKET POR SI LO DESEA EL CLIENTE O VENDEDOR
    /*===================================================================*/
    function reimprimirTicketDeVenta(row_index){
        let result = false;
        const data = tbl_ventas.row(row_index).data();
        if(data && data.id_venta){
            let venta = lista_ventas.find(vent => vent.id_venta === data.id_venta);
            let det_venta_ticket = lista_det_ventas.filter(det => det.id_venta === data.id_venta);
            if(venta.id_venta && det_venta_ticket.length){
                let datos = {
                    'accion': 4,
                    'data_ticket': {
                        'usuario': venta.usuario,
                        'nro_ticket': venta.nro_ticket,
                        'fecha_concat': venta.fecha_concat,
                        'hora_concat': venta.hora_concat,
                        'det_venta_ticket': det_venta_ticket,
                        'cant_productos': venta.cant_productos,
                        'total_concat': venta.total_concat,
                        'cambio_concat': venta.cambio_concat,
                    },
                }
                $(".content-header").addClass("loader");
                $.ajax({
                    type: 'POST',
                    url: 'ajax/ventas.ajax.php',
                    xhrFields: {
                        responseType: 'blob'
                    },
                    data: JSON.stringify(datos),
                    contentType: 'application/json;charset=utf-8',
                    success: function (json) {
                        if(json.type == 'application/pdf'){
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Ok',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            $(".content-header").removeClass("loader");
                            var a = document.createElement('a');
                            var url = window.URL.createObjectURL(json);
                            a.href = url;
                            a.download = 'ticket.pdf';
                            a.click();
                            window.URL.revokeObjectURL(url);
                        } else {
                            $(".content-header").removeClass("loader");
                            Swal.fire({
                                position: 'center',
                                icon:'error',
                                title: 'Error al imprimir el ticket',
                            });
                        }
                    },
                    error: function (respuesta) {
                        Swal.fire({
                            position: 'center',
                            icon:'error',
                            title: 'Ocurrio un error, cheque su conexion a internet!',
                        });
                        $(".content-header").removeClass("loader");
                    }
                });
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
            tbl_ventas.draw();
            tbl_det_ventas.draw();
            tbl_modal_det_venta.draw();
        }, 175);
    }
    /*===================================================================*/
    // FUNCION PARA CARGAR EL CAMPO SELECTION DE LOS USUARIOS REGISTRADOS PARA PODER
    // FILTRAR LOS REPORTES DE VENTAS
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
</script>
<?php else:?>
    <script>
        window.location = "./index.php";
    </script>
<?php endif; ?>