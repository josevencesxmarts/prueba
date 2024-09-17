<?php if(session_status() === PHP_SESSION_NONE) session_start(); ?>
<script>
    var validarUrl = window.location.toString().search('categorias');
    if(validarUrl > 0) { window.location = "../index.php"; }
</script>
<?php
    $existe = false;
    if(isset($_SESSION['lista_menus']) && isset($_SESSION['usuario'])){
        if(in_array("categorias.php", $_SESSION['lista_menus'])){
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
                <h1 class="m-0">Administrar Categorias</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item active">Administrar Categorias</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <!-- row para listado de categorias -->
        <div class="row">
            <div class="col-lg-12">
                <table id="tbl_categorias" class="table table-striped w-100 shadow">
                    <thead class="bg-info">
                        <tr style="font-size: 15px;">
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>Categoría</th>
                            <th>Aplica Peso</th>
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

<!-- Ventana modal para Ingresar o Modificar Categoria -->
<form id="form_categorias" novalidate>
    <div class="modal fade" id="mdlGestionarCategorias" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <!-- Contenido modal -->
            <div class="modal-content">
                <!-- Cabecera del modal -->
                <div class="modal-header bg-gray py-1 aling-items-center">
                    <h5 class="modal-title" id="titulo_modal_gestionar_categorias">Ingresar Categoria</h5>
                    <button type="button" class="btn btn-outline-primary text-white border-0 fs-5" data-bs-dismiss="modal"
                        id="btnCerrarModal">
                        <i class="fas fa-times-circle"></i>
                    </button>
                </div>
                <!-- Cuerpo del modal -->
                <div class="modal-body">
                    <input type="hidden" id="idCategoria" />
                    <!-- Abrimos una fila -->
                    <div class="row">
                        <!-- Columna para el registro de la Descripcipón de la categoria -->
                        <div class="col-lg-12">
                            <div class="form-group mb-2">
                                <label class="" for="iptNombreCategReg">
                                    <i class="fas fa-file-signature fs-6"> </i><span
                                        class="small">Nombre Categoria</span><span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" id="iptNombreCategReg"
                                    placeholder="Descripcion" required />
                                <div class="invalid-feedback">Debe ingresar el nombre de la categoria</div>
                            </div>
                        </div>
                        <!-- Columna para el registro de categoria padre -->
                        <div class="col-lg-6">
                            <div class="form-group mb-2">
                                <label class="" for="selCategoriaPadre">
                                    <i class="fas fa-dumpster fs-6"></i> <span class="small">Categoria Padre</span><span
                                        class="text-danger">*</span>
                                </label>
                                <select type="text" class="form-select form-select-sm"
                                    aria-label=".form-select-sm example" id="selCategoriaPadre">
                                </select>
                                <div class="invalid-feedback">Debe seleccionar una categoria padre</div>
                            </div>
                        </div>
                        <!-- Columna para el registro de la Tipo de Negocio -->
                        <div class="col-lg-6">
                            <div class="form-group mb-2">
                                <label class="" for="selTipoNegocio">
                                    <i class="fas fa-dumpster fs-6"></i>
                                    <span class="small">Tipo de Negocio</span>
                                    <span class="text-danger">*</span>
                                </label>
                                <select type="text" class="form-select form-select-sm"
                                    aria-label=".form-select-sm example" id="selTipoNegocio" required>
                                    <option value="">Seleccione una opcion</option>
                                    <option value="1">Ropa</option>
                                    <option value="2">Abarrotes</option>
                                </select>
                                <div class="invalid-feedback">Debe seleccionar el tipo de negocio</div>
                            </div>
                        </div>
                        <!-- Columna para el registro de si aplica peso -->
                        <div class="col-lg-6">
                            <div class="form-group mb-2">
                                <label class="" for="selAplicaPesoReg">
                                    <i class="fas fa-balance-scale fs-6"></i> <span class="small">Aplica Peso</span><span
                                        class="text-danger">*</span>
                                </label>
                                <select type="text" class="form-select form-select-sm"
                                    aria-label=".form-select-sm example" id="selAplicaPesoReg" required>
                                    <option value="1">SI</option>
                                    <option selected value="0">NO</option>
                                </select>
                                <div class="invalid-feedback">Debe seleccionar una opcion</div>
                            </div>
                        </div>
                        <!-- Columna para el registro del estado -->
                        <div class="col-lg-6">
                            <div class="form-group mb-2">
                                <label class="" for="selEstadoReg">
                                    <i class="fas fa-file-signature fs-6"></i>
                                    <span class="small">Estado</span><span class="text-danger">*</span>
                                </label>
                                <select type="text" class="form-select form-select-sm"
                                    aria-label=".form-select-sm example" id="selEstadoReg" required>
                                    <option value="1">ACTIVO</option>
                                    <option value="0">INACTIVO</option>
                                </select>
                                <div class="invalid-feedback">Debe seleccionar el estado del usuario</div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Footer del modal -->
                <div class="modal-footer">
                    <!-- Creacion de botones para cancelar y guardar el categoria -->
                    <button type="button" class="btn btn-secondary mt-3 mx-2" style="width: 170px" data-bs-dismiss="modal" id="btnCancelarRegistro">
                        Cancelar
                    </button>
                    <button type="submit" class="btn addNewRecord mt-3 mx-2" style="width: 170px" id="btnGuardarCategoria">
                        Guardar Categoria
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    var accion;
    var tbl_categorias;
    $(document).ready(function() {
        /*===================================================================*/
        // CARGAR LISTADO DE CATEGORIAS PARA CAMPO SELECTION DE CATEGORIA PADRE EN EL FORM
        /*===================================================================*/
        cargaCategoriasInSelectionCategPadre();
        /*===================================================================*/
        // CARGA DEL LISTADO CON EL PLUGIN DATATABLE JS
        /*===================================================================*/
        tbl_categorias = $("#tbl_categorias").DataTable({
            pageLength: 10,
            dom: 'Bfrtip',
            buttons: [{
                    text: 'Agregar Categoria',
                    className: 'addNewRecord',
                    action: function(e, dt, node, config) {
                        //EVENTO PARA LEVENTAR LA VENTA MODAL
                        $('#mdlGestionarCategorias').modal('show');
                        $('#titulo_modal_gestionar_categorias').html('Ingresar Categoria'); // CAMBIAR EL TITULO DE LA VENTANA MODAL
                        $('#btnGuardarCategoria').html('Guardar Categoria'); // CAMBIAR EL TITULO DEL BOTON DE GUARDAR
                        accion = 2;
                    }
                },
                'pageLength'
            ],
            ajax: {
                url: "ajax/categorias.ajax.php",
                dataSrc: '',
                type: "POST",
                data: {
                    'accion': 1
                }, //1: LISTAR CATEGORIAS
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
                    targets: 8,
                    orderable: false,
                    render: function(data, type, full, meta) {
                        return "<center>" +
                            "<span data-row-index='"+meta.row+"' id='btnEditarCategoria' class='text-primary px-4' style='cursor:pointer;'>" +
                            "<i class='fas fa-pencil-alt fs-1'></i>" +
                            "</span>" +
                            "<span data-row-index='"+meta.row+"' id='btnEliminarCategoria' class='text-danger px-4' style='cursor:pointer;'>" +
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

        $('#mdlGestionarCategorias').on('hidden.bs.modal', function(event) {
            limpiar_campos_form();
            actualizarDisabledCategPadre('');
        });

        /*===================================================================*/
        // EVENTO AL DAR CLICK EN EL BOTON DE EDITAR CATEGORIA
        /*===================================================================*/
        $('#tbl_categorias tbody').on('click', '#btnEditarCategoria', function(){
            modalEditarCategoria($(this).data('rowIndex'));
        })

        /*===================================================================*/
        // EVENTO AL DAR CLICK EN EL BOTON DE ELIMINAR CATEGORIA
        /*===================================================================*/
        $('#tbl_categorias tbody').on('click', '#btnEliminarCategoria', function(){
            accion = 4; //Accion para Eliminar Categoria
            const data = tbl_categorias.row($(this).data('rowIndex')).data();
            let id_categoria = data.id_categoria;
            Swal.fire({
                title: 'Está seguro de eliminar la categoria?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonClass: 'btn-danger',
                confirmButtonText: 'Si, deseo eliminarlo!',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    if(!Number.isInteger(parseInt(id_categoria))){
                        Swal.fire({
                            position: 'center',
                            icon:'error',
                            title: 'Error al eliminar la categoria, no se pudo obtener el id del registro',
                        });
                        return;
                    }
                    var datos = new FormData();
                    datos.append("accion", accion);
                    datos.append("id_categoria", id_categoria);
                    $(".content-header").addClass("loader");
                    $.ajax({
                        url: 'ajax/categorias.ajax.php',
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
                                    title: 'La categoria se eliminó correctamente',
                                });
                                tbl_categorias.ajax.reload();
                                cargaCategoriasInSelectionCategPadre();
                            } else {
                                Swal.fire({
                                    position: 'center',
                                    icon:'error',
                                    title: 'Error al eliminar la categoria: ' + respuesta,
                                });
                            }
                            $(".content-header").removeClass("loader");
                        },
                        error: function(respuesta) {
                            Swal.fire({
                                position: 'center',
                                icon:'error',
                                title: 'Ocurrio un error al eliminar la categoria, cheque su conexion a internet!',
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
        $('#form_categorias').on('submit', function(e) {
            e.preventDefault();
            const form_categoria = $('#form_categorias');
            let validation = Array.prototype.filter.call(form_categoria, function(form) {
                if (form.checkValidity() === true) {
                    /*===================================================================*/
                    // FUNCION PARA MANDAR A REGISTRAR Y ACTUALIZAR EL CATEGORIA
                    /*===================================================================*/
                    let title_swal_fire = '';
                    let confirmButtonTextswalfire = '';
                    let title_msj_ajax = '';
                    let title_msj_error_ajax = '';
                    if(accion === 2){
                        title_swal_fire = 'Está seguro de registrar la categoria?';
                        confirmButtonTextswalfire = 'Si, deseo registrarlo!';
                        title_msj_ajax = 'La categoria se registró correctamente';
                        title_msj_error_ajax = 'el registro';
                    }
                    if(accion === 3){
                        title_swal_fire = 'Está seguro de actualizar la categoria?';
                        confirmButtonTextswalfire = 'Si, deseo actualizarlo!';
                        title_msj_ajax = 'La categoria se actualizó correctamente';
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
                            let id_categoria = parseInt($('#idCategoria').val());
                            let nombre = $("#iptNombreCategReg").val();
                            let sel_tipo_negocio = $('#selTipoNegocio').val();
                            let id_categoria_padre = $('#selCategoriaPadre').val();
                            let aplica_peso = parseInt($('#selAplicaPesoReg').val());
                            let estado = parseInt($('#selEstadoReg').val());
                            if(accion === 3){
                                if(!Number.isInteger(id_categoria)){
                                    Swal.fire({
                                        position: 'center',
                                        icon:'error',
                                        title: 'Error al actualizar la categoria, no se pudo obtener el id del registro',
                                    });
                                    return;
                                }
                            }
                            var datos = new FormData();
                            datos.append("accion", accion);
                            datos.append("id_categoria", id_categoria);
                            datos.append("nombre", nombre);
                            datos.append("tipo_negocio", sel_tipo_negocio);
                            datos.append("id_categoria_padre", id_categoria_padre);
                            datos.append("aplica_peso", aplica_peso);
                            datos.append("estado", estado);

                            $(".content-header").addClass("loader");
                            $.ajax({
                                url: 'ajax/categorias.ajax.php',
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
                                        tbl_categorias.ajax.reload();
                                        cargaCategoriasInSelectionCategPadre();
                                        $('#mdlGestionarCategorias').modal('hide');
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
    // CARGAR LISTADO DE CATEGORIAS PARA CAMPO SELECTION DE CATEGORIA PADRE EN EL FORM
    /*===================================================================*/
    function cargaCategoriasInSelectionCategPadre() {
        $.ajax({
            url: "ajax/categorias.ajax.php",
            type: "POST",
            data: {
                'accion': 5
            },
            cache: false,
            dataType: 'json',
            success: function(respuesta) {
                var option = '<option selected value="0">Seleccione una categoria</option>';
                for (var i = 0; i < respuesta.length; i++) {
                    option = option + '<option value="' + respuesta[i].id_categoria + '">' + respuesta[i].nombre +
                    '</option>';
                }
                $('#selCategoriaPadre').html(option);
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
    // FUNCION PARA LIMPIAR LOS CAMPOS Y REMOVER LOS ESTILOS DE LAS VALIDACIONES DE LOS INPUTS MARCADOS EN EL FORM DE CATEGORIA
    /*===================================================================*/
    function limpiar_campos_form() {
        $('#idCategoria').val('');
        $('#iptNombreCategReg').val('');
        $('#selTipoNegocio').val(0);
        $('#selCategoriaPadre').val(0);
        $('#selAplicaPesoReg').val(0);
        $('#selEstadoReg').val(1);

        $('#form_categorias').removeClass('was-validated');
    }
    /*===================================================================*/
    // FUNCION PARA MOSTRAR EL REGISTRO A EDITAR EN UN MODAL
    /*===================================================================*/
    function modalEditarCategoria(row_index){
        accion = 3; //Accion para Editar
        $('#mdlGestionarCategorias').modal('show');

        $('#titulo_modal_gestionar_categorias').html('Editar Categoria'); // CAMBIAR EL TITULO DE LA VENTANA MODAL
        $('#btnGuardarCategoria').html('Actualiza Categoria'); // CAMBIAR EL TITULO DEL BOTON DE GUARDAR
        $('#mdlGestionarCategorias button[type="submit"]').addClass('btn-primary');

        const data = tbl_categorias.row(row_index).data();
        let aplica_peso = data.aplica_peso === 'SI' ? 1 : 0;
        let estado = data.estado === 'ACTIVO' ? 1 : 0;

        $('#idCategoria').val(data.id_categoria);
        $('#iptNombreCategReg').val(data.nombre);
        $('#selTipoNegocio').val(data.tipo_negocio);
        $('#selCategoriaPadre').val(data.id_categoria_padre);
        $('#selAplicaPesoReg').val(aplica_peso);
        $('#selEstadoReg').val(estado);

        actualizarDisabledCategPadre(data.id_categoria);
    }
    function actualizarDisabledCategPadre(id_categoria){
        $('#selCategoriaPadre option').prop('disabled', false);
        $('#selCategoriaPadre').find('option').each(function(){
            if (this.value == id_categoria & accion == 3) {
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