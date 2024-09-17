<?php if(session_status() === PHP_SESSION_NONE) session_start(); ?>
<script>
    var validarUrl = window.location.toString().search('unidades_medida');
    if(validarUrl > 0) { window.location = "../index.php"; }
</script>
<?php
    $existe = false;
    if(isset($_SESSION['lista_menus']) && isset($_SESSION['usuario'])){
        if(in_array("unidades_medida.php", $_SESSION['lista_menus'])){
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
                <h1 class="m-0">Administrar Unidades De Medida</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item active">Administrar Unidades De Medida</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <!-- row para listado de unidades de medida -->
        <div class="row">
            <div class="col-lg-12">
                <table id="tbl_unidades_medida" class="table table-striped w-100 shadow">
                    <thead class="bg-info">
                        <tr style="font-size: 15px;">
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>Nombre</th>
                            <th>Unidad de Medida Referencia</th>
                            <th>Ratio</th>
                            <th>Estado</th>
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

<!-- Ventana modal para Ingresar o Modificar Unidades de Medida -->
<form id="form_unidades_medida" novalidate>
    <div class="modal fade" id="mdlGestionarUnidadesMedida" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <!-- Contenido modal -->
            <div class="modal-content">
                <!-- Cabecera del modal -->
                <div class="modal-header bg-gray py-1 aling-items-center">
                    <h5 class="modal-title" id="titulo_modal_gestionar_unidades_medida">Ingresar Unidad De Medida</h5>
                    <button type="button" class="btn btn-outline-primary text-white border-0 fs-5" data-bs-dismiss="modal"
                        id="btnCerrarModal">
                        <i class="fas fa-times-circle"></i>
                    </button>
                </div>
                <!-- Cuerpo del modal -->
                <div class="modal-body">
                    <input type="hidden" id="idUnidadMedida" />
                    <!-- Abrimos una fila -->
                    <div class="row">
                        <!-- Columna para el registro del nombre de la unidad de medida -->
                        <div class="col-lg-12">
                            <div class="form-group mb-2">
                                <label class="" for="iptNombre">
                                    <i class="fas fa-file-signature fs-6"> </i><span
                                        class="small">Nombre Unidad de Medida</span><span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" id="iptNombre"
                                    placeholder="Nombre unidad de medida" required />
                                <div class="invalid-feedback">Debe ingresar el nombre de la unidad de medida</div>
                            </div>
                        </div>
                        <!-- Columna para el registro de la unidad de medida de referencia -->
                        <div class="col-lg-12">
                            <div class="form-group mb-2">
                                <label class="" for="selUnidadMedidaReferencia">
                                    <i class="fas fa-dumpster fs-6"></i> <span class="small">Unidad de Medida de Referencia</span><span
                                        class="text-danger">*</span>
                                </label>
                                <select type="text" class="form-select form-select-sm"
                                    aria-label=".form-select-sm example" id="selUnidadMedidaReferencia">
                                </select>
                                <div class="invalid-feedback">Debe ingresar la unidad de medida de referencia</div>
                            </div>
                        </div>
                        <!-- Columna para el registro del ratio -->
                        <div class="col-lg-4">
                            <div class="form-group mb-2">
                                <label class="" for="iptRatio">
                                    <i class="fas fa-dollar-sign fs-6"></i>
                                    <span class="small">Ratio</span><span
                                        class="text-danger">*</span>
                                </label>
                                <input type="number" min="0" class="form-control" id="iptRatio"
                                    placeholder="Ratio" required />
                                <div class="invalid-feedback">Debe ingresar el ratio</div>
                            </div>
                        </div>
                        <!-- Columna para el registro del estado -->
                        <div class="col-lg-12">
                            <div class="form-group mb-2">
                                <label class="" for="selEstado">
                                    <i class="fas fa-file-signature fs-6"></i>
                                    <span class="small">Estado</span><span class="text-danger">*</span>
                                </label>
                                <select type="text" class="form-select form-select-sm"
                                    aria-label=".form-select-sm example" id="selEstado" required>
                                    <option value="1">ACTIVO</option>
                                    <option value="0">INACTIVO</option>
                                </select>
                                <div class="invalid-feedback">Debe seleccionar el estado de la unidad de medida</div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Footer del modal -->
                <div class="modal-footer">
                    <!-- Creacion de botones para cancelar y guardar la unidad -->
                    <button type="button" class="btn btn-secondary mt-3 mx-2" style="width: 170px" data-bs-dismiss="modal" id="btnCancelarRegistro">
                        Cancelar
                    </button>
                    <button type="submit" class="btn addNewRecord mt-3 mx-2" style="width: 170px" id="btnGuardarUnidadMedida">
                        Guardar Unidad
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    var accion;
    var tbl_unidades_medida;
    $(document).ready(function() {
        cargarDataInSelection();
        /*===================================================================*/
        // CARGA DEL LISTADO CON EL PLUGIN DATATABLE JS
        /*===================================================================*/
        tbl_unidades_medida = $("#tbl_unidades_medida").DataTable({
            pageLength: 10,
            dom: 'Bfrtip',
            buttons: [{
                    text: 'Agregar Unidad de Medida',
                    className: 'addNewRecord',
                    action: function(e, dt, node, config) {
                        //EVENTO PARA LEVENTAR LA VENTA MODAL
                        $('#mdlGestionarUnidadesMedida').modal('show');
                        $('#titulo_modal_gestionar_unidades_medida').html('Ingresar Unidad de Medida'); // CAMBIAR EL TITULO DE LA VENTANA MODAL
                        $('#btnGuardarUnidadMedida').html('Guardar Unidad de Medida'); // CAMBIAR EL TITULO DEL BOTON DE GUARDAR
                        accion = 2;
                    }
                },
                'pageLength'
            ],
            ajax: {
                url: "ajax/unidades_medida.ajax.php",
                dataSrc: '',
                type: "POST",
                data: {
                    'accion': 1
                }, //1: LISTAR UNIDADES DE MEDIDA
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
                    targets: 8,
                    orderable: false,
                    render: function(data, type, full, meta) {
                        return "<center>" +
                            "<span data-row-index='"+meta.row+"' id='btnEditarUnidadMedida' class='text-primary px-4' style='cursor:pointer;'>" +
                            "<i class='fas fa-pencil-alt fs-1'></i>" +
                            "</span>" +
                            "<span data-row-index='"+meta.row+"' id='btnEliminarUnidadMedida' class='text-danger px-4' style='cursor:pointer;'>" +
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

        $('#mdlGestionarUnidadesMedida').on('hidden.bs.modal', function(event) {
            limpiar_campos_form();
            actualizarDisabledUnidadMedidaReferencia();
        });

        /*===================================================================*/
        // EVENTO AL DAR CLICK EN EL BOTON DE EDITAR UNIDADES DE MEDIDA
        /*===================================================================*/
        $('#tbl_unidades_medida tbody').on('click', '#btnEditarUnidadMedida', function(){
            modalEditarUnidadMedida($(this).data('rowIndex'));
        })

        /*===================================================================*/
        // EVENTO AL DAR CLICK EN EL BOTON DE ELIMINAR UNIDAD DE MEDIDA
        /*===================================================================*/
        $('#tbl_unidades_medida tbody').on('click', '#btnEliminarUnidadMedida', function(){
            accion = 4; //Accion para Eliminar Unidades de Medida
            const data = tbl_unidades_medida.row($(this).data('rowIndex')).data();
            let id_unidad_medida = data.id_unidad_medida;
            Swal.fire({
                title: 'Está seguro de eliminar la unidad de medida?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonClass: 'btn-danger',
                confirmButtonText: 'Si, deseo eliminarlo!',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    if(!Number.isInteger(parseInt(id_unidad_medida))){
                        Swal.fire({
                            position: 'center',
                            icon:'error',
                            title: 'Error al eliminar la unidad de medida, no se pudo obtener el id del registro',
                        });
                        return;
                    }
                    var datos = new FormData();
                    datos.append("accion", accion);
                    datos.append("id_unidad_medida", id_unidad_medida);
                    $(".content-header").addClass("loader");
                    $.ajax({
                        url: 'ajax/unidades_medida.ajax.php',
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
                                    title: 'La unidad de medida se eliminó correctamente',
                                });
                                tbl_unidades_medida.ajax.reload();
                                cargarDataInSelection();
                            } else {
                                Swal.fire({
                                    position: 'center',
                                    icon:'error',
                                    title: 'Error al eliminar la unidad de medida: ' + respuesta,
                                });
                            }
                            $(".content-header").removeClass("loader");
                        },
                        error: function(respuesta) {
                            Swal.fire({
                                position: 'center',
                                icon:'error',
                                title: 'Ocurrio un error al eliminar la unidad de medida, cheque su conexion a internet!',
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
        $('#form_unidades_medida').on('submit', function(e) {
            e.preventDefault();
            const form_unidades_medida = $('#form_unidades_medida');
            let validation = Array.prototype.filter.call(form_unidades_medida, function(form) {
                if (form.checkValidity() === true) {
                    /*===================================================================*/
                    // FUNCION PARA MANDAR A REGISTRAR Y ACTUALIZAR LA UNIDAD DE MEDIDA
                    /*===================================================================*/
                    let title_msj_ajax = '';
                    let title_swal_fire = '';
                    let confirmButtonTextswalfire = '';
                    let title_msj_error_ajax = '';
                    if(accion === 2){
                        title_msj_ajax = 'La unidad de medida se registró correctamente';
                        title_swal_fire = 'Está seguro de registrar la unidad de medida?';
                        confirmButtonTextswalfire = 'Si, deseo registrarlo!';
                        title_msj_error_ajax = 'el registro';
                    }
                    if(accion === 3){
                        title_msj_ajax = 'La unidad de medida se actualizó correctamente';
                        title_swal_fire = 'Está seguro de actualizar la unidad de medida?';
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
                            let id_unidad_medida = parseInt($('#idUnidadMedida').val());
                            let nombre = $("#iptNombre").val();
                            let id_udm_referencia = $('#selUnidadMedidaReferencia').val();
                            let ratio = parseInt($('#iptRatio').val());
                            let estado = parseInt($('#selEstado').val());
                            if(accion === 3){
                                if(!Number.isInteger(id_unidad_medida)){
                                    Swal.fire({
                                        position: 'center',
                                        icon:'error',
                                        title: 'Error al actualizar la unidad de medida, no se pudo obtener el id del registro',
                                    });
                                    return;
                                }
                            }
                            var datos = new FormData();
                            datos.append("accion", accion);
                            datos.append("id_unidad_medida", id_unidad_medida);
                            datos.append("nombre", nombre);
                            datos.append("id_udm_referencia", id_udm_referencia);
                            datos.append("ratio", ratio);
                            datos.append("estado", estado);

                            $(".content-header").addClass("loader");
                            $.ajax({
                                url: 'ajax/unidades_medida.ajax.php',
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
                                        tbl_unidades_medida.ajax.reload();
                                        cargarDataInSelection();
                                        $('#mdlGestionarUnidadesMedida').modal('hide');
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
    // CARGAR LISTADO DE UNIDADES DE MEDIDA PARA REFERENCIA EN EL FORM
    /*===================================================================*/
    function cargarDataInSelection() {
        $.ajax({
            url: "ajax/unidades_medida.ajax.php",
            type: "POST",
            data: {
                'accion': 5
            },
            cache: false,
            dataType: 'json',
            success: function(respuesta) {
                var option = '<option selected value="0">Seleccione una unidad de medida</option>';
                for (var i = 0; i < respuesta.length; i++) {
                    option = option + '<option value="' + respuesta[i].id_unidad_medida + '">' + respuesta[i].nombre +
                    '</option>';
                }
                $('#selUnidadMedidaReferencia').html(option);
            },
            error: function(respuesta) {
                Swal.fire({
                    position: 'center',
                    icon:'error',
                    title: 'Ocurrio un error, cheque su conexion a internet!',
                });
            }
        });
    }
    /*===================================================================*/
    // FUNCION PARA LIMPIAR LOS CAMPOS Y REMOVER LOS ESTILOS DE LAS VALIDACIONES DE LOS INPUTS MARCADOS EN EL FORM DE UNIDADES DE MEDIDA
    /*===================================================================*/
    function limpiar_campos_form() {
        $('#idUnidadMedida').val('');
        $('#iptNombre').val('')
        $('#selUnidadMedidaReferencia').val(0)
        $('#iptRatio').val('')
        $('#selEstado').val(1)

        $('#form_unidades_medida').removeClass('was-validated');
    }
    /*===================================================================*/
    // FUNCION PARA MOSTRAR EL REGISTRO A EDITAR EN UN MODAL
    /*===================================================================*/
    function modalEditarUnidadMedida(row_index){
        accion = 3; //Accion para Editar
        $('#mdlGestionarUnidadesMedida').modal('show');

        $('#titulo_modal_gestionar_unidades_medida').html('Editar Unidad de Medida'); // CAMBIAR EL TITULO DE LA VENTANA MODAL
        $('#btnGuardarUnidadMedida').html('Actualiza Unidad de Medida'); // CAMBIAR EL TITULO DEL BOTON DE GUARDAR

        const data = tbl_unidades_medida.row(row_index).data();
        let estado = data.estado === 'ACTIVO' ? 1 : 0;

        $('#idUnidadMedida').val(data.id_unidad_medida);
        $('#iptNombre').val(data.nombre);
        $('#selUnidadMedidaReferencia').val(data.id_udm_referencia);
        $('#iptRatio').val(data.ratio);
        $('#selEstado').val(estado);

        $('#selUnidadMedidaReferencia option').prop('disabled', false);
        $('#selUnidadMedidaReferencia').find('option').each(function(){
            if (this.value == data.id_unidad_medida) {
                $(this).attr('disabled','disabled');
            }
        });
        actualizarDisabledUnidadMedidaReferencia(data.id_unidad_medida);
    }
    function actualizarDisabledUnidadMedidaReferencia(id_unidad_medida){
        $('#selUnidadMedidaReferencia option').prop('disabled', false);
        $('#selUnidadMedidaReferencia').find('option').each(function(){
            if (this.value == id_unidad_medida) {
                $(this).attr('disabled','disabled');
            }
        });
    }
</script>
<?php else:?>
    <script>
        window.location = "./index.php";
    </script>
<?php endif; ?>