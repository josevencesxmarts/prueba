<?php if(session_status() === PHP_SESSION_NONE) session_start(); ?>
<script>
    var validarUrl = window.location.toString().search('colores');
    if(validarUrl > 0) { window.location = "../index.php"; }
</script>
<?php
    $existe = false;
    if(isset($_SESSION['lista_menus']) && isset($_SESSION['usuario'])){
        if(in_array("colores.php", $_SESSION['lista_menus'])){
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
                <h1 class="m-0">Administrar Colores</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item active">Administrar Colores</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <!-- row para listado de colores -->
        <div class="row">
            <div class="col-lg-12">
                <table id="tbl_colores" class="table table-striped w-100 shadow">
                    <thead class="bg-info">
                        <tr style="font-size: 15px;">
                            <th></th>
                            <th></th>
                            <th>Nombre</th>
                            <th class="text-center">Opciones</th>
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

<!-- Ventana modal para Ingresar o Modificar Color -->
<form id="form_colores" novalidate>
    <div class="modal fade" id="mdlGestionarColores" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <!-- Contenido modal -->
            <div class="modal-content">
                <!-- Cabecera del modal -->
                <div class="modal-header bg-gray py-1 aling-items-center">
                    <h5 class="modal-title" id="titulo_modal_gestionar_colores">Ingresar Color</h5>
                    <button type="button" class="btn btn-outline-primary text-white border-0 fs-5" data-bs-dismiss="modal"
                        id="btnCerrarModal">
                        <i class="fas fa-times-circle"></i>
                    </button>
                </div>
                <!-- Cuerpo del modal -->
                <div class="modal-body">
                    <input type="hidden" id="idColor" />
                    <!-- Abrimos una fila -->
                    <div class="row">
                        <!-- Columna para el registro de la Descripcipón de la color -->
                        <div class="col-lg-12">
                            <div class="form-group mb-2">
                                <label class="" for="iptNombre">
                                    <i class="fas fa-file-signature fs-6"> </i><span
                                        class="small">Nombre Color</span><span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" id="iptNombre"
                                    placeholder="Descripcion" required />
                                <div class="invalid-feedback">Debe ingresar el nombre de la color</div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Footer del modal -->
                <div class="modal-footer">
                    <!-- Creacion de botones para cancelar y guardar el color -->
                    <button type="button" class="btn btn-secondary mt-3 mx-2" style="width: 170px" data-bs-dismiss="modal" id="btnCancelarRegistro">
                        Cancelar
                    </button>
                    <button type="submit" class="btn addNewRecord mt-3 mx-2" style="width: 170px" id="btnGuardarColor">
                        Guardar Color
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    var accion;
    var tbl_colores;
    $(document).ready(function() {
        /*===================================================================*/
        // CARGA DEL LISTADO CON EL PLUGIN DATATABLE JS
        /*===================================================================*/
        tbl_colores = $("#tbl_colores").DataTable({
            pageLength: 10,
            dom: 'Bfrtip',
            buttons: [{
                    text: 'Agregar Color',
                    className: 'addNewRecord',
                    action: function(e, dt, node, config) {
                        //EVENTO PARA LEVENTAR LA VENTA MODAL
                        $('#mdlGestionarColores').modal('show');
                        $('#titulo_modal_gestionar_colores').html('Ingresar Color'); // CAMBIAR EL TITULO DE LA VENTANA MODAL
                        $('#btnGuardarColor').html('Guardar Color'); // CAMBIAR EL TITULO DEL BOTON DE GUARDAR
                        accion = 2;
                    }
                },
                'pageLength'
            ],
            ajax: {
                url: "ajax/colores.ajax.php",
                dataSrc: '',
                type: "POST",
                data: {
                    'accion': 1
                }, //1: LISTAR COLORES
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
                    targets: 3,
                    orderable: false,
                    render: function(data, type, full, meta) {
                        return "<center>" +
                            "<span data-row-index='"+meta.row+"' id='btnEditarColor' class='text-primary px-4' style='cursor:pointer;'>" +
                            "<i class='fas fa-pencil-alt fs-1'></i>" +
                            "</span>" +
                            "<span data-row-index='"+meta.row+"' id='btnEliminarColor' class='text-danger px-4' style='cursor:pointer;'>" +
                            "<i class='fas fa-trash fs-1'></i>" +
                            "</span>" +
                            "</center>"
                    }
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

        $('#mdlGestionarColores').on('hidden.bs.modal', function(event) {
            limpiar_campos_form();
        });

        /*===================================================================*/
        // EVENTO AL DAR CLICK EN EL BOTON DE EDITAR COLOR
        /*===================================================================*/
        $('#tbl_colores tbody').on('click', '#btnEditarColor', function(){
            modalEditarColor($(this).data('rowIndex'));
        })

        /*===================================================================*/
        // EVENTO AL DAR CLICK EN EL BOTON DE ELIMINAR COLOR
        /*===================================================================*/
        $('#tbl_colores tbody').on('click', '#btnEliminarColor', function(){
            accion = 4; //Accion para Eliminar Color
            const data = tbl_colores.row($(this).data('rowIndex')).data();
            let id_color = data.id_color;
            Swal.fire({
                title: 'Está seguro de eliminar el color?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonClass: 'btn-danger',
                confirmButtonText: 'Si, deseo eliminarlo!',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    if(!Number.isInteger(parseInt(id_color))){
                        Swal.fire({
                            position: 'center',
                            icon:'error',
                            title: 'Error al eliminar el color, no se pudo obtener el id del registro',
                        });
                        return;
                    }
                    var datos = new FormData();
                    datos.append("accion", accion);
                    datos.append("id_color", id_color);
                    $(".content-header").addClass("loader");
                    $.ajax({
                        url: 'ajax/colores.ajax.php',
                        type: 'POST',
                        data: datos,
                        cache: false,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        success: function(respuesta) {
                            if(respuesta == 'ok'){
                                Toast.fire({
                                    icon: 'success',
                                    title: 'El color se eliminó correctamente',
                                });
                                tbl_colores.ajax.reload();
                            } else {
                                Swal.fire({
                                    position: 'center',
                                    icon:'error',
                                    title: 'Error al eliminar el color: ' + respuesta,
                                });
                            }
                            $(".content-header").removeClass("loader");
                        },
                        error: function(respuesta) {
                            Swal.fire({
                                position: 'center',
                                icon:'error',
                                title: 'Ocurrio un error al eliminar el color, cheque su conexion a internet!',
                            });
                            $(".content-header").removeClass("loader");
                        }
                    });
                }
            });
        })

        /*===================================================================*/
        // FUNCION PARA VALIDAR LOS CAMPOS REQUERIDOS EN EL FORM
        /*===================================================================*/
        $('#form_colores').on('submit', function(e) {
            e.preventDefault();
            const form_color = $('#form_colores');
            let validation = Array.prototype.filter.call(form_color, function(form) {
                if (form.checkValidity() === true) {
                    /*===================================================================*/
                    // FUNCION PARA MANDAR A REGISTRAR Y ACTUALIZAR EL COLOR
                    /*===================================================================*/
                    let title_msj_ajax = '';
                    let title_swal_fire = '';
                    let confirmButtonTextswalfire = '';
                    let title_msj_error_ajax = '';
                    if(accion === 2){
                        title_msj_ajax = 'El color se registró correctamente';
                        title_swal_fire = 'Está seguro de registrar el color?';
                        confirmButtonTextswalfire = 'Si, deseo registrarlo!';
                        title_msj_error_ajax = 'el registro';
                    }
                    if(accion === 3){
                        title_msj_ajax = 'El color se actualizó correctamente';
                        title_swal_fire = 'Está seguro de actualizar el color?';
                        confirmButtonTextswalfire = 'Si, deseo actualizarlo!';
                        title_msj_error_ajax = 'la actualizacion';
                    }
                    Swal.fire({
                        title: title_swal_fire,
                        icon: 'warning',
                        confirmButtonClass: 'addNewRecord',
                        confirmButtonText: confirmButtonTextswalfire,
                        showCancelButton: true,
                        cancelButtonText: 'Cancelar',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            let id_color = parseInt($('#idColor').val());
                            let nombre = $("#iptNombre").val();
                            if(accion === 3){
                                if(!Number.isInteger(id_color)){
                                    Swal.fire({
                                        position: 'center',
                                        icon:'error',
                                        title: 'Error al actualizar el color, no se pudo obtener el id del registro',
                                    });
                                    return;
                                }
                            }
                            var datos = new FormData();
                            datos.append("accion", accion);
                            datos.append("id_color", id_color);
                            datos.append("nombre", nombre);

                            $(".content-header").addClass("loader");
                            $.ajax({
                                url: 'ajax/colores.ajax.php',
                                type: 'POST',
                                data: datos,
                                cache: false,
                                contentType: false,
                                processData: false,
                                dataType: 'json',
                                success: function(respuesta) {
                                    if(respuesta === 'ok'){
                                        Toast.fire({
                                            icon: 'success',
                                            title: title_msj_ajax,
                                        });
                                        tbl_colores.ajax.reload();
                                        $('#mdlGestionarColores').modal('hide');
                                        limpiar_campos_form();
                                    } else {
                                        Swal.fire({
                                            position: 'center',
                                            icon:'error',
                                            title: 'Error al hacer '+title_msj_error_ajax+': ' + respuesta,
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
                } else {
                    console.log('no paso la validación');
                }
                form.classList.add('was-validated');
            });
        });
    }); // FIN DOCUMENTO READY
    /*===================================================================*/
    // FUNCION PARA LIMPIAR LOS CAMPOS Y REMOVER LOS ESTILOS DE LAS VALIDACIONES DE LOS INPUTS MARCADOS EN EL FORM DEL REGISTRO DE COLORES
    /*===================================================================*/
    function limpiar_campos_form() {
        $('#idColor').val('');
        $('#iptNombre').val('');

        $('#form_colores').removeClass('was-validated');
    }
    /*===================================================================*/
    // FUNCION PARA MOSTRAR EL REGISTRO A EDITAR EN UN MODAL
    /*===================================================================*/
    function modalEditarColor(row_index){
        accion = 3; //Accion para Editar
        $('#mdlGestionarColores').modal('show');

        $('#titulo_modal_gestionar_colores').html('Editar Color'); // CAMBIAR EL TITULO DE LA VENTANA MODAL
        $('#btnGuardarColor').html('Actualiza Color'); // CAMBIAR EL TITULO DEL BOTON DE GUARDAR

        const data = tbl_colores.row(row_index).data();

        $('#idColor').val(data.id_color);
        $('#iptNombre').val(data.nombre);
    }
</script>
<?php else:?>
    <script>
        window.location = "./index.php";
    </script>
<?php endif; ?>