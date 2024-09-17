<?php if(session_status() === PHP_SESSION_NONE) session_start(); ?>
<script>
    var validarUrl = window.location.toString().search('configuracion');
    if(validarUrl > 0) { window.location = "../index.php"; }
</script>
<?php
    $existe = false;
    if(isset($_SESSION['lista_menus']) && isset($_SESSION['usuario'])){
        if(in_array("configuracion.php", $_SESSION['lista_menus'])){
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
                <h1 class="m-0">Configuración del Sistema</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item active">Configuración del Sistema</li>
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
                <div class="nav nav-tabs" id="product-tab" role="tablist">
                    <a class="nav-item nav-link active" id="content-config-ventas-tab" data-toggle="pill" href="#content-config-ventas" role="tab" aria-controls="content-config-ventas" aria-selected="true">Ventas</a>
                    <a class="nav-item nav-link" id="content-config-productos-tab" data-toggle="tab" href="#content-config-productos" role="tab" aria-controls="content-config-productos" aria-selected="false">Productos</a>
                </div>
            </nav>
            <div class="tab-content p-3" id="nav-tab-content-config">
                <div class="tab-pane fade active show" id="content-config-ventas" role="tabpanel" aria-labelledby="content-config-ventas-tab">
                    <!-- row para listado de productos -->
                    <div class="row">
                        <!--FORMULARIO PARA CONFIGURAR VENTAS -->
                        <div class="col-md-12">
                            <div class="card card-info card-outline shadow">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="fas fa-edit"></i> Configuracion Ventas</h3>
                                </div>
                                <div class="card-body">
                                    <form class="needs-validation-registro-config-ventas" novalidate id="frm_registro_config_ventas">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group mb-2">
                                                    <label class="col-form-label" for="iptValidarStock">
                                                        <i class="fas fa-plus-circle fs-6"></i>
                                                        <span class="small">Stock</span>
                                                    </label>
                                                    <select class="form-select form-select-sm" aria-label=".form-select-sm example"
                                                        id="selValidarStock">
                                                        <option value="">Seleccione una opcion</option>
                                                        <option value="1">Validar stock</option>
                                                        <option value="0">No validar stock</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group m-0 mt-2">
                                                    <button type="submit" class="btn addNewRecord w-100" id="btnRegistrarConfigVentas">Guardar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="content-config-productos" role="tabpanel" aria-labelledby="content-config-productos-tab">
                    <div class="row">
                        <!--FORMULARIO PARA CONFIGURAR PRODUCTOS -->
                        <div class="col-md-12">
                            <div class="card card-info card-outline shadow">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="fas fa-edit"></i> Configuracion Productos</h3>
                                </div>
                                <div class="card-body">
                                    <form class="needs-validation-registro-config-productos" novalidate id="frm_registro_config_productos">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group mb-2">
                                                    <label class="col-form-label" for="iptValidarStock">
                                                        <i class="fas fa-plus-circle fs-6"></i>
                                                        <span class="small">Poder modificar stock</span>
                                                    </label>
                                                    <select class="form-select form-select-sm" aria-label=".form-select-sm example"
                                                        id="selUpdateStockProductos">
                                                        <option value="">Seleccione una opcion</option>
                                                        <option value="1">Si</option>
                                                        <option value="0">No</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group mb-2">
                                                    <label class="col-form-label" for="iptValidarStock">
                                                        <i class="fas fa-plus-circle fs-6"></i>
                                                        <span class="small">Poder modificar precios</span>
                                                    </label>
                                                    <select class="form-select form-select-sm" aria-label=".form-select-sm example"
                                                        id="selUpdatePreciosProductos">
                                                        <option value="">Seleccione una opcion</option>
                                                        <option value="1">Si</option>
                                                        <option value="0">No</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group m-0 mt-2">
                                                    <button type="submit" class="btn addNewRecord w-100" id="btnRegistrarConfigVentas">Guardar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
<script>
    $(document).ready(function() {
        /*===================================================================*/
        // FUNCION PARA LLENAR EL FORM
        /*===================================================================*/
        $.ajax({
            url: "ajax/configuracion.ajax.php",
            type: "POST",
            data: {
                'accion': 1 // listar informacion de configuracion
            },
            dataType: "json",
            success: function(res) {
                if(res.validar_stock){
                    $("#selValidarStock option").each(function(){
                        if ($(this).val() == res.validar_stock)
                            $(this).attr("selected","selected");
                    });
                }
                if(res.update_stock_productos){
                    $("#selUpdateStockProductos option").each(function(){
                        if ($(this).val() == res.update_stock_productos)
                            $(this).attr("selected","selected");
                    });
                }
                if(res.update_precios_productos){
                    $("#selUpdatePreciosProductos option").each(function(){
                        if ($(this).val() == res.update_precios_productos)
                            $(this).attr("selected","selected");
                    });
                }
            }
        });
        /*===================================================================*/
        // FUNCION PARA VALIDAR LOS CAMPOS REQUERIDOS EN EL FORM DE VENTAS
        /*===================================================================*/
        $('#frm_registro_config_ventas').on('submit', function(e) {
            e.preventDefault();
            let datos = {
                accion: 2,
                modulo: 'ventas',
                validar_stock: $('#selValidarStock').val(),
            }
            actualizarConfiguracion(datos);
        });
        /*===================================================================*/
        // FUNCION PARA VALIDAR LOS CAMPOS REQUERIDOS EN EL FORM DE PRODUCTOS
        /*===================================================================*/
        $('#frm_registro_config_productos').on('submit', function(e) {
            e.preventDefault();
            let datos = {
                accion: 2,
                modulo: 'productos',
                update_stock_productos: $('#selUpdateStockProductos').val(),
                update_precios_productos: $('#selUpdatePreciosProductos').val(),
            }
            actualizarConfiguracion(datos);
        });
    });
    function actualizarConfiguracion(datos) {
        Swal.fire({
            title: 'Está seguro de actualizar la configuracion?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonClass: 'addNewRecord',
            confirmButtonText: 'Si, deseo actualizarlo!',
            cancelButtonText: 'Cancelar',
        }).then((result) => {
            if (result.isConfirmed) {
                $(".content-header").addClass("loader");
                $.ajax({
                    url: 'ajax/configuracion.ajax.php',
                    type: 'POST',
                    data: datos,
                    cache: false,
                    dataType: 'json',
                    success: function(respuesta) {
                        if(respuesta === 'ok'){
                            Toast.fire({
                                icon: 'success',
                                title: 'La configuracion se actualizó correctamente',
                            });
                        } else {
                            Swal.fire({
                                position: 'center',
                                icon:'error',
                                title: 'Error al hacer la actualizacion: ' + respuesta,
                            });
                        }
                        $(".content-header").removeClass("loader");
                    },
                    error: function(respuesta) {
                        Swal.fire({
                            position: 'center',
                            icon:'error',
                            title: 'Ocurrio un error, cheque su conexion a internet!',
                        });
                        $(".content-header").removeClass("loader");
                    }
                });
            }
        });
    }
</script>
<?php else:?>
    <script>
        window.location = "./index.php";
    </script>
<?php endif; ?>