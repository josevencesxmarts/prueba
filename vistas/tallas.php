<?php if(session_status() === PHP_SESSION_NONE) session_start(); ?>
<script>
    var validarUrl = window.location.toString().search('tallas');
    if(validarUrl > 0) { window.location = "../index.php"; }
</script>
<?php
    $existe = false;
    if(isset($_SESSION['lista_menus']) && isset($_SESSION['usuario'])){
        if(in_array("tallas.php", $_SESSION['lista_menus'])){
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
                <h1 class="m-0">Administrar Tallas</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item active">Administrar Tallas</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <!-- row para listado de tallas -->
        <div class="row">
            <div class="col-lg-12">
                <table id="tbl_tallas" class="table table-striped w-100 shadow">
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

<!-- Ventana modal para Ingresar o Modificar Talla -->
<form id="form_tallas" novalidate>
    <div class="modal fade" id="mdlGestionarTallas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <!-- Contenido modal -->
            <div class="modal-content">
                <!-- Cabecera del modal -->
                <div class="modal-header bg-gray py-1 aling-items-center">
                    <h5 class="modal-title" id="titulo_modal_gestionar_tallas">Ingresar Talla</h5>
                    <button type="button" class="btn btn-outline-primary text-white border-0 fs-5" data-bs-dismiss="modal"
                        id="btnCerrarModal">
                        <i class="fas fa-times-circle"></i>
                    </button>
                </div>
                <!-- Cuerpo del modal -->
                <div class="modal-body">
                    <input type="hidden" id="idTalla" />
                    <!-- Abrimos una fila -->
                    <div class="row">
                        <!-- Columna para el registro de la Descripcipón de la talla -->
                        <div class="col-lg-12">
                            <div class="form-group mb-2">
                                <label class="" for="iptNombre">
                                    <i class="fas fa-file-signature fs-6"> </i><span
                                        class="small">Nombre Talla</span><span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" id="iptNombre"
                                    placeholder="Descripcion" required />
                                <div class="invalid-feedback">Debe ingresar el nombre de la talla</div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Footer del modal -->
                <div class="modal-footer">
                    <!-- Creacion de botones para cancelar y guardar la talla -->
                    <button type="button" class="btn btn-secondary mt-3 mx-2" style="width: 170px" data-bs-dismiss="modal" id="btnCancelarRegistro">
                        Cancelar
                    </button>
                    <button type="submit" class="btn addNewRecord mt-3 mx-2" style="width: 170px" id="btnGuardarTalla">
                        Guardar Talla
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    var accion;
    var tbl_tallas;
    $(document).ready(function() {
        /*===================================================================*/
        // CARGA DEL LISTADO CON EL PLUGIN DATATABLE JS
        /*===================================================================*/
        tbl_tallas = $("#tbl_tallas").DataTable({
            pageLength: 10,
            dom: 'Bfrtip',
            buttons: [{
                    text: 'Agregar Talla',
                    className: 'addNewRecord',
                    action: function(e, dt, node, config) {
                        //EVENTO PARA LEVENTAR LA VENTA MODAL
                        $('#mdlGestionarTallas').modal('show');
                        $('#titulo_modal_gestionar_tallas').html('Ingresar Talla'); // CAMBIAR EL TITULO DE LA VENTANA MODAL
                        $('#btnGuardarTalla').html('Guardar Talla'); // CAMBIAR EL TITULO DEL BOTON DE GUARDAR
                        accion = 2;
                    }
                },
                'pageLength'
            ],
            ajax: {
                url: "ajax/tallas.ajax.php",
                dataSrc: '',
                type: "POST",
                data: {
                    'accion': 1
                }, //1: LISTAR TALLAS
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
                            "<span data-row-index='"+meta.row+"' id='btnEditarTalla' class='text-primary px-4' style='cursor:pointer;'>" +
                            "<i class='fas fa-pencil-alt fs-1'></i>" +
                            "</span>" +
                            "<span data-row-index='"+meta.row+"' id='btnEliminarTalla' class='text-danger px-4' style='cursor:pointer;'>" +
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

        $('#mdlGestionarTallas').on('hidden.bs.modal', function(event) {
            limpiar_campos_form();
        });

        /*===================================================================*/
        // EVENTO AL DAR CLICK EN EL BOTON DE EDITAR TALLA
        /*===================================================================*/
        $('#tbl_tallas tbody').on('click', '#btnEditarTalla', function(){
            modalEditarTalla($(this).data('rowIndex'));
        })

        /*===================================================================*/
        // EVENTO AL DAR CLICK EN EL BOTON DE ELIMINAR TALLA
        /*===================================================================*/
        $('#tbl_tallas tbody').on('click', '#btnEliminarTalla', function(){
            accion = 4; //Accion para Eliminar Talla
            const data = tbl_tallas.row($(this).data('rowIndex')).data();
            let id_talla = data.id_talla;
            Swal.fire({
                title: 'Está seguro de eliminar la talla?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonClass: 'btn-danger',
                confirmButtonText: 'Si, deseo eliminarlo!',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    if(!Number.isInteger(parseInt(id_talla))){
                        Swal.fire({
                            position: 'center',
                            icon:'error',
                            title: 'Error al eliminar la talla, no se pudo obtener el id del registro',
                        });
                        return;
                    }
                    var datos = new FormData();
                    datos.append("accion", accion);
                    datos.append("id_talla", id_talla);
                    $(".content-header").addClass("loader");
                    $.ajax({
                        url: 'ajax/tallas.ajax.php',
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
                                    title: 'La talla se eliminó correctamente',
                                });
                                tbl_tallas.ajax.reload();
                            } else {
                                Swal.fire({
                                    position: 'center',
                                    icon:'error',
                                    title: 'Error al eliminar la talla: ' + respuesta,
                                });
                            }
                            $(".content-header").removeClass("loader");
                        },
                        error: function(respuesta) {
                            Swal.fire({
                                position: 'center',
                                icon:'error',
                                title: 'Ocurrio un error al eliminar la talla, cheque su conexion a internet!',
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
        $('#form_tallas').on('submit', function(e) {
            e.preventDefault();
            const form_talla = $('#form_tallas');
            let validation = Array.prototype.filter.call(form_talla, function(form) {
                if (form.checkValidity() === true) {
                    /*===================================================================*/
                    // FUNCION PARA MANDAR A REGISTRAR Y ACTUALIZAR LA TALLA
                    /*===================================================================*/
                    let title_msj_ajax = '';
                    let title_swal_fire = '';
                    let confirmButtonTextswalfire = '';
                    let title_msj_error_ajax = '';
                    if(accion === 2){
                        title_msj_ajax = 'La talla se registró correctamente';
                        title_swal_fire = 'Está seguro de registrar la talla?';
                        confirmButtonTextswalfire = 'Si, deseo registrarlo!';
                        title_msj_error_ajax = 'el registro';
                    }
                    if(accion === 3){
                        title_msj_ajax = 'La talla se actualizó correctamente';
                        title_swal_fire = 'Está seguro de actualizar la talla?';
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
                            let id_talla = parseInt($('#idTalla').val());
                            let nombre = $("#iptNombre").val();
                            if(accion === 3){
                                if(!Number.isInteger(id_talla)){
                                    Swal.fire({
                                        position: 'center',
                                        icon:'error',
                                        title: 'Error al actualizar la talla, no se pudo obtener el id del registro',
                                    });
                                    return;
                                }
                            }
                            var datos = new FormData();
                            datos.append("accion", accion);
                            datos.append("id_talla", id_talla);
                            datos.append("nombre", nombre);

                            $(".content-header").addClass("loader");
                            $.ajax({
                                url: 'ajax/tallas.ajax.php',
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
                                        tbl_tallas.ajax.reload();
                                        $('#mdlGestionarTallas').modal('hide');
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
    // FUNCION PARA LIMPIAR LOS CAMPOS Y REMOVER LOS ESTILOS DE LAS VALIDACIONES DE LOS INPUTS MARCADOS EN EL FORM DEL REGISTRO DE TALLAS
    /*===================================================================*/
    function limpiar_campos_form() {
        $('#idTalla').val('');
        $('#iptNombre').val('');

        $('#form_tallas').removeClass('was-validated');
    }
    /*===================================================================*/
    // FUNCION PARA MOSTRAR EL REGISTRO A EDITAR EN UN MODAL
    /*===================================================================*/
    function modalEditarTalla(row_index){
        accion = 3; //Accion para Editar
        $('#mdlGestionarTallas').modal('show');

        $('#titulo_modal_gestionar_tallas').html('Editar Talla'); // CAMBIAR EL TITULO DE LA VENTANA MODAL
        $('#btnGuardarTalla').html('Actualiza Talla'); // CAMBIAR EL TITULO DEL BOTON DE GUARDAR

        const data = tbl_tallas.row(row_index).data();

        $('#idTalla').val(data.id_talla);
        $('#iptNombre').val(data.nombre);
    }
</script>
<?php else:?>
    <script>
        window.location = "./index.php";
    </script>
<?php endif; ?>