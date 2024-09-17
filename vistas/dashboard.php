<?php if(session_status() === PHP_SESSION_NONE) session_start(); ?>
<script>
    var validarUrl = window.location.toString().search('dashboard');
    if(validarUrl > 0) { window.location = "../index.php"; }
</script>
<?php
    $existe = false;
    if(isset($_SESSION['lista_menus']) && isset($_SESSION['usuario'])){
        if(in_array("dashboard.php", $_SESSION['lista_menus'])){
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
                <h1 class="m-0">Tablero Principal</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item active">Tablero Principal</li>
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
            <!-- TOTAL GANANCIAS -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3 id="gananciasDeHoy"></h3>
                        <p>Ganancias del Dia</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-pie"></i>
                    </div>
                    <a style="cursor: pointer;" class="small-box-footer"
                        onclick="CargarContenidoDashboard('','show_vista_modal', [])">
                        Ver mas <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <!-- TOTAL COMPRAS -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3 id="gananciasDelMes"></h3>
                        <p>Ganancias del Mes</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-cash"></i>
                    </div>
                    <a style="cursor: pointer;" class="small-box-footer"
                        onclick="CargarContenidoDashboard('','show_vista_modal', [])">
                        Ver mas <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <!-- TOTAL VENTAS DEL DIA -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-secondary">
                    <div class="inner">
                        <h3 id="ventasDeHoy"></h3>
                        <p>Ventas del Dia</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-android-calendar"></i>
                    </div>
                    <a style="cursor: pointer;" class="small-box-footer"
                        onclick="CargarContenidoDashboard('vistas/ventas.php','show_vista_modal', [])">
                        Ver mas <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <!-- TOTAL VENTAS -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3 id="ventasDelMes"></h3>
                        <p>Ventas del Mes</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-cart"></i>
                    </div>
                    <a style="cursor: pointer;" class="small-box-footer"
                        onclick="CargarContenidoDashboard('vistas/ventas.php','show_vista_modal', [])">
                        Ver mas <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <!-- TOTAL PRODUCTOS -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3 id="totalProductos"></h3>
                        <p>Productos Registrados</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-clipboard"></i>
                    </div>
                    <a style="cursor: pointer;" class="small-box-footer"
                        onclick="CargarContenidoDashboard('vistas/productos.php','show_vista_modal', [])">
                        Ver mas <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <!-- TOTAL PRODUCTOS MIN STOCK -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3 id="productosMinStock"></h3>
                        <p>Productos poco Stock</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-android-remove-circle"></i>
                    </div>
                    <a style="cursor: pointer;" class="small-box-footer"
                        onclick="CargarContenidoDashboard('vistas/productos.php','show_vista_modal',
                            [{'campo1': 'p.stock','validacion': '<=','campo2': 'p.min_stock',}]
                        )">
                        Ver mas <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>
        <!-- /.row Tarjetas Informativas -->
        <!-- row Grafico de barras -->
        <div class="row">
            <div class="col-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title" id="card_title_ventas_del_mes"></h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart">
                            <canvas id="barChart"
                                style="min-height: 250px; height: 300px; max-height: 350px; width: 100%;">
                            </canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row Grafico de barras -->
        <div class="row">
            <div class="col-lg-6">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title" id="card_title_10_produts_ms_vendids">Los 10 productos mas vendidos</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <table id="tbl_productos_mas_vendidos" class="table table-striped w-100 shadow">
                                    <thead>
                                        <tr style="font-size: 15px;">
                                            <th>Cod. producto</th>
                                            <th>Producto</th>
                                            <th>Cantidad</th>
                                            <th>Ventas</th>
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
            <div class="col-lg-6">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title" id="card_title_products_poco_stock">Listado de productos con poco stock
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <table id="tbl_productos_poco_stock" class="table table-striped w-100 shadow">
                                    <thead>
                                        <tr style="font-size: 15px;">
                                            <th>Cod. producto</th>
                                            <th>Producto</th>
                                            <th>Stock Actual</th>
                                            <th>Mín. Stock</th>
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
        </div>
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
<!-- Ventana modal para visualizar una venta y sus detalles -->
<div class="modal fade" id="mdlMostrarVistas" data-row-index="">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header py-1 aling-items-center">
                <h3 class="modal-title">
                    <i class="fas fa-edit"></i>
                </h3>
                <button type="button" class="btn btn-outline-secondary border-0 fs-5" data-bs-dismiss="modal"
                    id="btnCerrarModal">
                    <i class="fas fa-times-circle"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row" id="show_vista_modal">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary mt-3 mx-2" style="width: 170px" data-bs-dismiss="modal" id="btnCerrar">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    var tbl_productos_mas_vendidos,tbl_productos_poco_stock;
    $(document).ready(function() {
        datosDashboard();
        $.ajax({
            url: "ajax/dashboard.ajax.php",
            type: "POST",
            data: {
                'accion': 1 // parametro para obtener las ventas del mes
            },
            dataType: "json",
            success: function(respuesta) {
                let fecha_venta = [];
                let total_venta = [];
                let total_venta_mes = 0;
                for (var i = 0; i < respuesta.length; i++) {
                    fecha_venta.push(respuesta[i]['fecha_venta']);
                    total_venta.push(respuesta[i]['total_venta'].toString().replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                    total_venta_mes += parseFloat(respuesta[i]['total_venta']);
                }
                $('#card_title_ventas_del_mes').html('Ventas del Mes: $ ' + total_venta_mes.toString().replace(/\d(?=(\d{3})+\.)/g, '$&,'));

                const ctx = document.getElementById('barChart');
                var areaChartData = {
                    labels: fecha_venta,
                    datasets: [{
                        label: 'Ventas del mes',
                        backgroundColor: 'rgba(60,141,188,0.9)',
                        data: total_venta
                    }]
                }
                barCharOptions = {
                    maintainAspectRatio: false,
                    responsive: true,
                    events: false,
                    legend: {
                        display: true
                    },
                    animation: {
                        duration: 500,
                        easing: "easeOutQuart",
                        onComplete: function() {
                            var ctx = this.chart.ctx;
                            ctx.font = Chart.helpers.fontString(Chart.defaults.global
                                .defaultFontFamily, 'normal',
                                Chart.defaults.global.defaultFontFamily);
                            ctx.textAlign = 'center';
                            ctx.textBaseline = 'bottom';

                            this.data.datasets.forEach(function(dataset) {
                                for (var i = 0; i < dataset.data.length; i++) {
                                    var model = dataset._meta[Object.keys(dataset
                                            ._meta)[0]].data[i]._model,
                                        scale_max = dataset._meta[Object.keys(dataset
                                            ._meta)[0]].data[i]._yScale.maxHeight;
                                    ctx.fillStyle = '#444';
                                    var y_pos = model.y - 5;
                                    if ((scale_max - model.y) / scale_max >= 0.93)
                                        y_pos = model.y + 20;
                                    ctx.fillText(dataset.data[i], model.x, y_pos);
                                }
                            });
                        }
                    }
                }
                new Chart(ctx, {
                    type: 'bar',
                    data: areaChartData,
                    options: barCharOptions
                });
            }
        });
        /*===================================================================*/
        // INICIALIZAR LA TABLA PARA VER LOS 10 PRODUCTOS MAS VENDIDOS
        /*===================================================================*/
        tbl_productos_mas_vendidos = $('#tbl_productos_mas_vendidos').DataTable({
            searching: false,
            ajax: {
                url: "ajax/dashboard.ajax.php",
                dataSrc: '',
                type: "POST",
                data: {
                    'accion': 2 // listar los 10 productos mas vendidos
                },
                dataType: 'json',
            },
            columnDefs: [{
                    targets: 0,
                    width: '15%'
                }, {
                    targets: 1,
                    width: '65%'
                }, {
                    targets: 2,
                    width: '10%'
                }, {
                    targets: 3,
                    width: '10%'
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
        // INICIALIZAR LA TABLA PARA VER LOS PRODUCTOS CON POCO STOCK
        /*===================================================================*/
        tbl_productos_poco_stock = $('#tbl_productos_poco_stock').DataTable({
            searching: false,
            pageLength: 10,
            ajax: {
                url: "ajax/dashboard.ajax.php",
                dataSrc: '',
                type: "POST",
                data: {
                    'accion': 3 // listar los productos con poco stock
                },
                dataType: 'json',
            },
            columnDefs: [{
                    targets: 0,
                    width: '15%'
                }, {
                    targets: 1,
                    width: '65%'
                }, {
                    targets: 2,
                    width: '10%'
                }, {
                    targets: 3,
                    width: '10%'
                }
            ],
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
    });
    setInterval(() => {
        datosDashboard();
    }, 10000)

    function datosDashboard() {
        $.ajax({
            url: "ajax/dashboard.ajax.php",
            type: "POST",
            data: {
                'accion': 4 // listar informacion del tablero
            },
            dataType: "json",
            success: function(respuesta) {
                $('#totalProductos').html(respuesta[0]['totalProductos']);
                $('#gananciasDeHoy').html('$ ' + respuesta[0]['gananciasDeHoy'].toString().replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                $('#gananciasDelMes').html('$ ' + respuesta[0]['gananciasDelMes'].toString().replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                $('#ventasDeHoy').html('$ ' + respuesta[0]['ventasDeHoy'].toString().replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                $('#ventasDelMes').html('$ ' + respuesta[0]['ventasDelMes'].toString().replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                $('#productosMinStock').html(respuesta[0]['productosMinStock']);
            }
        });
    }
    function CargarContenidoDashboard(pagina_php, contenedor, domain) {
        if(pagina_php === ''){
            alert('Esta en proceso esta funcion...');
            return;
        }
        domain_productos = domain;
        $(".content-header").addClass("loader");
        $('#mdlMostrarVistas').modal('show');
        $('#' + contenedor).load(pagina_php,
            function(response, status, xhr) {
                if(status == "error") {
                    Swal.fire({
                        position: 'center',
                        icon:'error',
                        title: 'Ocurrio un error, cheque su conexion a internet!',
                    });
                }
                $(".content-header").removeClass("loader");
            }
        );
    }
</script>
<?php else:?>
    <script>
        window.location = "./index.php";
    </script>
<?php endif; ?>