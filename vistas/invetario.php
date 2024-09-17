<?php if(session_status() === PHP_SESSION_NONE) session_start(); ?>
<script>
    var validarUrl = window.location.toString().search('invetario');
    if(validarUrl > 0) { window.location = "../index.php"; }
</script>
<?php
    $existe = false;
    if(isset($_SESSION['lista_menus']) && isset($_SESSION['usuario'])){
        if(in_array("invetario.php", $_SESSION['lista_menus'])){
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
                <h1 class="m-0">Inventario</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item active">Inventario</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <!-- row para listado de inventario -->
        <div class="row">
            <div class="col-lg-12">
                <table id="tbl_inventario" class="table table-striped w-100 shadow">
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
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>Nombre producto</th>
                            <th>Precio venta</th>
                            <th>Costo</th>
                            <th>Stock</th>
                            <th>Unida de medida</th>
                        </tr>
                    </thead>
                    <tbody class="text-small">
                    </tbody>
                </table>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->

<!-- Ventana modal para Imprimir Reporte de Entradas Y Salidas por Fechas -->
<form id="form_reporte_ent_sali_por_fecha" novalidate>
    <div class="modal fade" id="mdReporteEntradaSalidaPorFechas">
        <div class="modal-dialog modal-lg ">
            <div class="modal-content">
                <div class="modal-header bg-gray py-1 aling-items-center">
                    <h5 class="modal-title">Imprimir reporte de entradas y salidas</h5>
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
    var accion;
    var tbl_inventario,lista_usuarios;
    $(document).ready(function() {
        cargarSelectionUsers();
        /*===================================================================*/
        // CARGA DEL LISTADO CON EL PLUGIN DATATABLE JS
        /*===================================================================*/
        tbl_inventario = $("#tbl_inventario").DataTable({
            pageLength: 10,
            dom: 'Bfrtip',
            buttons: [{
                    text: 'Reporte inventario',
                    className: 'imprimirQrsRecord',
                    action: function(e, dt, node, config) {
                        $('#mdReporteInventario').modal('show');
                    }
                },{
                    text: 'Reporte entradas y salidas',
                    className: 'imprimirQrsRecord',
                    action: function(e, dt, node, config) {
                        $('#mdReporteEntradaSalidaPorFechas').modal('show');
                    }
                },
                'pageLength'
            ],
            ajax: {
                url: "ajax/inventario.ajax.php",
                dataSrc: '',
                type: "POST",
                data: {
                    'accion': 1
                }, //1: LISTAR INVENTARIO
            },
            responsive: {
                details: {
                    type: 'column'
                }
            },
            columnDefs: [{
                    targets: 0,
                    orderable: false,
                    className: 'control'
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
                {
                    targets: 16,
                    visible: false
                },
                {
                    targets: 17,
                    visible: false
                },
                {
                    targets: 18,
                    visible: false
                },
                {
                    targets: 19,
                    visible: false
                },
                {
                    targets: 20,
                    visible: false
                }
            ],
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
        // FUNCION PARA VALIDAR LOS CAMPOS REQUERIDOS EN EL FORM
        /*===================================================================*/
        $('#form_reporte_ent_sali_por_fecha').on('submit', function(e) {
            e.preventDefault();
            const form_repor_ent_sali = $('#form_reporte_ent_sali_por_fecha');
            let validation = Array.prototype.filter.call(form_repor_ent_sali, function(form) {
                if (form.checkValidity() === true) {
                    let id_usuario = $('#selUsuario').val();
                    let nombre_user = ''
                    if(id_usuario.length > 0){
                        let user = lista_usuarios.find(us => us.id_usuario === parseInt(id_usuario));
                        nombre_user = user ? user.nombre_concat : '';
                    }
                    let datos = {
                        accion: 2,
                        id_usuario: id_usuario,
                        nombre_user: nombre_user,
                        fecha_inicio: $('#iptFechaInicio').val(),
                        fecha_fin: $('#iptFechaFin').val(),
                    }
                    $(".content-header").addClass("loader");
                    $.ajax({
                        url: 'ajax/inventario.ajax.php',
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
                                a.download = 'reporte_entradas_salidas.pdf';
                                a.click();
                                window.URL.revokeObjectURL(url);
                            } else {
                                Swal.fire({
                                    position: 'center',
                                    icon:'error',
                                    title: 'Error al imprimir el reporte',
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