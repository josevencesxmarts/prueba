<?php if(session_status() === PHP_SESSION_NONE) session_start(); ?>
<script>
    var validarUrl = window.location.toString().search('usuarios');
    if(validarUrl > 0) { window.location = "../index.php"; }
</script>
<?php
    $existe = false;
    if(isset($_SESSION['lista_menus']) && isset($_SESSION['usuario'])){
        if(in_array("usuarios.php", $_SESSION['lista_menus'])){
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
                <h1 class="m-0">Administrar Usuarios</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item active">Administrar Usuarios</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <!-- row para listado de usuarios -->
        <div class="row">
            <div class="col-lg-12">
                <table id="tbl_usuarios" class="table table-striped w-100 shadow">
                    <thead class="bg-info">
                        <tr style="font-size: 15px;">
                            <th></th>
                            <th></th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>Estado</th>
                            <th></th>
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

<!-- Ventana modal para Ingresar o Modificar Usuarios -->
<form id="form_usuarios" novalidate>
    <div class="modal fade" id="mdlGestionarUsuarios" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <!-- Contenido modal -->
            <div class="modal-content">
                <!-- Cabecera del modal -->
                <div class="modal-header bg-gray py-1 aling-items-center">
                    <h5 class="modal-title" id="titulo_modal_gestionar_usuarios">Ingresar Usuario</h5>
                    <button type="button" class="btn btn-outline-primary text-white border-0 fs-5" data-bs-dismiss="modal"
                        id="btnCerrarModal">
                        <i class="fas fa-times-circle"></i>
                    </button>
                </div>
                <!-- Cuerpo del modal -->
                <div class="modal-body">
                    <input type="hidden" id="idUsuario" />
                    <!-- Abrimos una fila -->
                    <div class="row">
                        <!-- Columna para el registro del nombre del usuario -->
                        <div class="col-lg-12">
                            <div class="form-group mb-2">
                                <label class="" for="iptNombre">
                                    <i class="fas fa-file-signature fs-6"></i>
                                    <span class="small">Nombre</span><span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" id="iptNombre"
                                    name="iptNombre" placeholder="Nombre del usuario" required />
                                <div class="invalid-feedback">Debe ingresar el nombre del usuario</div>
                            </div>
                        </div>
                        <!-- Columna para el registro del apellido -->
                        <div class="col-lg-12">
                            <div class="form-group mb-2">
                                <label class="" for="iptApellido">
                                    <i class="fas fa-file-signature fs-6"></i>
                                    <span class="small">Apellido</span><span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" id="iptApellido"
                                    name="iptApellido" placeholder="Apellido del usuario" required />
                                <div class="invalid-feedback">Debe ingresar el apellido del usuario</div>
                            </div>
                        </div>
                        <!-- Columna para el registro del estado -->
                        <div class="col-lg-12">
                            <div class="form-group mb-2">
                                <label class="" for="selEstado">
                                    <i class="fas fa-file-signature fs-6"></i>
                                    <span class="small">Estado</span><span class="text-danger">*</span>
                                </label>
                                <select class="form-select form-select-sm"
                                    aria-label=".form-select-sm example" id="selEstado" required>
                                    <option value="1">ACTIVO</option>
                                    <option value="0">INACTIVO</option>
                                </select>
                                <div class="invalid-feedback">Debe seleccionar el estado del usuario</div>
                            </div>
                        </div>
                        <!-- Columna para el registro de quien puede modificar los precios de productos -->
                        <div class="col-lg-12">
                            <div class="form-group mb-2">
                                <label class="" for="selEstado">
                                    <i class="fas fa-dollar-sign fs-6"></i>
                                    <span class="small">Poder modificar precios en productos</span>
                                </label>
                                <select class="form-select form-select-sm" aria-label=".form-select-sm example"
                                    id="selUpdatePreciosProductos" required>
                                    <option value="1">Si</option>
                                    <option value="0">No</option>
                                </select>
                                <div class="invalid-feedback">Debe seleccionar una opcion</div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Footer del modal -->
                <div class="modal-footer">
                    <!-- Creacion de botones para cancelar y guardar el usuario -->
                    <button type="button" class="btn btn-secondary mt-3 mx-2" style="width: 170px" data-bs-dismiss="modal" id="btnCancelarRegistro">
                        Cancelar
                    </button>
                    <button type="submit" class="btn addNewRecord mt-3 mx-2" style="width: 170px" id="btnGuardarUsuario">
                        Guardar Usuario
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Ventana modal para Actualizar Session De Usuarios-->
<div class="modal fade" id="mdlGestionarSessionUsuario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <!-- Contenido modal -->
        <div class="modal-content">
            <!-- Cabecera del modal -->
            <div class="modal-header bg-gray py-1 aling-items-center">
                <h5 class="modal-title">Actualizar Session De Usuario</h5>
                <button type="button" class="btn btn-outline-primary text-white border-0 fs-5" data-bs-dismiss="modal"
                    id="btnCerrarModal">
                    <i class="fas fa-times-circle"></i>
                </button>
            </div>
            <!-- Cuerpo del modal -->
            <div class="modal-body">
                <!-- FORM PARA ACTUALIZAR DATOS DE SESSION DEL USUARIO-->
                <form id="form_session_usuario" class="needs-validation-login" novalidate>
                    <input type="hidden" id="iptIdUsuarioSession" />
                    <!-- USUARIO DEL SISTEMA -->
                    <div class="input-group mb-3">
                        <input class="form-control" type="text" placeholder="Usuario" id="iptUsuario" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                        <div class="invalid-feedback">Debe ingresar un usuario</div>
                    </div>
                    <!-- CONTRASEÑA DEL USUARIO -->
                    <div class="input-group mb-3">
                        <input class="form-control" type="password" placeholder="Contraseña" id="iptPassword" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        <div class="invalid-feedback">Debe ingresar una contraseña</div>
                    </div>
                    <!-- REPETIR CONTRASEÑA DEL USUARIO -->
                    <div class="input-group mb-3">
                        <input class="form-control" type="password" placeholder="Repetir Contraseña" id="iptRepetirPassword" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        <div class="invalid-feedback">Debe repetir la contraseña</div>
                    </div>
                    <!-- BOTON PARA ACTUALIZAR DATOS DE SESION DE USUARIO -->
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn addNewRecord" id="btnActualizarSessionUsuario">Actualizar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    var accion;
    var tbl_usuarios;
    $(document).ready(function() {
        limpiar_campos_form();
        /*===================================================================*/
        // CARGA DEL LISTADO DE USUARIOS CON EL PLUGIN DATATABLE JS
        /*===================================================================*/
        tbl_usuarios = $("#tbl_usuarios").DataTable({
            pageLength: 10,
            dom: 'Bfrtip',
            buttons: [{
                    text: 'Agregar Usuario',
                    className: 'addNewRecord',
                    action: function(e, dt, node, config) {
                        //EVENTO PARA LEVENTAR LA VENTA MODAL
                        modalRegistrarUsuario();
                    }
                },
                'pageLength'
            ],
            ajax: {
                url: "ajax/usuarios.ajax.php",
                dataSrc: '',
                type: "POST",
                data: {
                    'accion': 1
                }, //1: LISTAR USUARIOS
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
                    targets: 9,
                    visible: false
                },
                {
                    targets: 10,
                    orderable: false,
                    render: function(data, type, full, meta) {
                        return "<center>" +
                            "<span data-row-index='"+meta.row+"' id='btnEditarUsuario' class='text-primary px-4' style='cursor:pointer;'>" +
                            "<i class='fas fa-pencil-alt fs-1'></i>" +
                            "</span>" +
                            "<span data-row-index='"+meta.row+"' id='btnEditarSessionUsuario' class='text-info px-4' style='cursor:pointer;'>" +
                            "<i class='fas fa-user fs-1'></i>" +
                            "</span>" +
                            "<span data-row-index='"+meta.row+"' id='btnEliminarUsuario' class='text-danger px-4' style='cursor:pointer;'>" +
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

        $('#mdlGestionarUsuarios').on('hidden.bs.modal', function(event) {
            limpiar_campos_form();
        });

        /*===================================================================*/
        // EVENTO AL DAR CLICK EN EL BOTON DE EDITAR USUARIO
        /*===================================================================*/
        $('#tbl_usuarios tbody').on('click', '#btnEditarUsuario', function(){
            modalEditarUsuario($(this).data('rowIndex'));
        })

        /*===================================================================*/
        // EVENTO AL DAR CLICK EN EL BOTON DE EDITAR SESSION DE USUARIO
        /*===================================================================*/
        $('#tbl_usuarios tbody').on('click', '#btnEditarSessionUsuario', function(){
            $('#mdlGestionarSessionUsuario').modal('show');
            const data = tbl_usuarios.row($(this).data('rowIndex')).data();
            $('#iptIdUsuarioSession').val(data.id_usuario);
            $('#iptUsuario').val(data.usuario);
            $('#iptPassword').val(data.contrasena);
            $('#iptRepetirPassword').val(data.contrasena);
        })

        /*===================================================================*/
        // EVENTO AL DAR CLICK EN EL BOTON DE ELIMINAR USUARIO
        /*===================================================================*/
        $('#tbl_usuarios tbody').on('click', '#btnEliminarUsuario', function(){
            accion = 4; //Accion para Eliminar Usuario
            const data = tbl_usuarios.row($(this).data('rowIndex')).data();
            let id_usuario = data.id_usuario;
            Swal.fire({
                title: 'Está seguro de eliminar la usuario?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonClass: 'btn-danger',
                confirmButtonText: 'Si, deseo eliminarlo!',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    if(!Number.isInteger(parseInt(id_usuario))){
                        Swal.fire({
                            position: 'center',
                            icon:'error',
                            title: 'Error al eliminar el usuario, no se pudo obtener el id del registro',
                        });
                        return;
                    }
                    var datos = new FormData();
                    datos.append("accion", accion);
                    datos.append("id_usuario", id_usuario);
                    $(".content-header").addClass("loader");
                    $.ajax({
                        url: 'ajax/usuarios.ajax.php',
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
                                    title: 'El usuario se eliminó correctamente',
                                });
                                tbl_usuarios.ajax.reload();
                            } else {
                                Swal.fire({
                                    position: 'center',
                                    icon:'error',
                                    title: 'Error al eliminar el usuario: ' + respuesta,
                                });
                            }
                            $(".content-header").removeClass("loader");
                        },
                        error: function(respuesta) {
                            Swal.fire({
                                position: 'center',
                                icon:'error',
                                title: 'Ocurrio un error al eliminar el usuario, cheque su conexion a internet!',
                            });
                            $(".content-header").removeClass("loader");
                        }
                    });
                }
            });
        })

        /*===================================================================*/
        // FUNCION PARA VALIDAR LOS CAMPOS REQUERIDOS DE SESSION DE USUARIO
        /*===================================================================*/
        $('#form_usuarios').on('submit', function(e) {
            e.preventDefault();
            const form_usuario = $('#form_usuarios');
            let validation = Array.prototype.filter.call(form_usuario, function(form) {
                if (form.checkValidity() === true) {
                    /*===================================================================*/
                    // FUNCION PARA MANDAR A REGISTRAR Y ACTUALIZAR EL USUARIO
                    /*===================================================================*/
                    let title_msj_ajax = '';
                    let title_swal_fire = '';
                    let confirmButtonTextswalfire = '';
                    let title_msj_error_ajax = '';
                    if(accion === 2){
                        title_msj_ajax = 'El usuario se registró correctamente';
                        title_swal_fire = 'Está seguro de registrar el usuario?';
                        confirmButtonTextswalfire = 'Si, deseo registrarlo!';
                        title_msj_error_ajax = 'el registro';
                    }
                    if(accion === 3){
                        title_msj_ajax = 'El usuario se actualizó correctamente';
                        title_swal_fire = 'Está seguro de actualizar el usuario?';
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
                            let id_usuario = parseInt($('#idUsuario').val());
                            let nombre = $("#iptNombre").val();
                            let apellido = $("#iptApellido").val();
                            let estado = parseInt($('#selEstado').val());
                            let update_precios_productos = $('#selUpdatePreciosProductos').val();
                            if(accion === 3){
                                if(!Number.isInteger(id_usuario)){
                                    Swal.fire({
                                        position: 'center',
                                        icon:'error',
                                        title: 'Error al actualizar el usuario, no se pudo obtener el id del registro',
                                    });
                                    return;
                                }
                            }
                            var datos = new FormData();
                            datos.append("accion", accion);
                            datos.append("id_usuario", id_usuario);
                            datos.append("nombre", nombre);
                            datos.append("apellido", apellido);
                            datos.append("estado", estado);
                            datos.append("update_precios_productos", update_precios_productos);

                            $(".content-header").addClass("loader");
                            $.ajax({
                                url: 'ajax/usuarios.ajax.php',
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
                                        tbl_usuarios.ajax.reload();
                                        $('#mdlGestionarUsuarios').modal('hide');
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
        /*===================================================================*/
        // FUNCION PARA VALIDAR LOS CAMPOS REQUERIDOS EN EL FORM
        /*===================================================================*/
        $('#form_session_usuario').on('submit', function(e) {
            e.preventDefault();
            const form_session_usuario = $('#form_session_usuario');
            let validation = Array.prototype.filter.call(form_session_usuario, function(form) {
                if (form.checkValidity() === true) {
                    let id_usuario = parseInt($('#iptIdUsuarioSession').val());
                    let usuario = $("#iptUsuario").val();
                    let contrasena = $("#iptPassword").val();
                    let repetir_contrasena = $("#iptRepetirPassword").val();
                    if(contrasena != repetir_contrasena){
                        Swal.fire({
                            position: 'center',
                            icon:'error',
                            title: 'Las contraseñas no coinciden',
                        });
                        return;
                    }
                    if(!Number.isInteger(id_usuario)){
                        Swal.fire({
                            position: 'center',
                            icon:'error',
                            title: 'Error al actualizar el usuario, no se pudo obtener el id del registro',
                        });
                        return;
                    }
                    /*===================================================================*/
                    // FUNCION PARA MANDAR A ACTUALIZAR DATOS DE SESSION DE USUARIO
                    /*===================================================================*/
                    Swal.fire({
                        title: 'Está seguro de actualizar el usuario?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonClass: 'addNewRecord',
                        confirmButtonText: 'Si, deseo actualizarlo!',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            var datos = new FormData();
                            datos.append("accion", 5);
                            datos.append("id_usuario", id_usuario);
                            datos.append("usuario", usuario);
                            datos.append("contrasena", contrasena);

                            $(".content-header").addClass("loader");
                            $.ajax({
                                url: 'ajax/usuarios.ajax.php',
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
                                            title: 'El usuario se actualizó correctamente',
                                        });
                                        tbl_usuarios.ajax.reload();
                                        $('#mdlGestionarSessionUsuario').modal('hide');
                                    } else if(respuesta === 'existe'){
                                        Swal.fire({
                                            position: 'center',
                                            icon:'error',
                                            title: 'Ya exite un usuario con ese nombre',
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
                } else {
                    console.log('no paso la validación');
                }
                form.classList.add('was-validated');
            });
        });
    }); // FIN DOCUMENTO READY
    /*===================================================================*/
    // FUNCION PARA LIMPIAR LOS CAMPOS Y REMOVER LOS ESTILOS DE LAS VALIDACIONES DE LOS INPUTS MARCADOS EN EL FORM DEL USUARIO
    /*===================================================================*/
    function limpiar_campos_form() {
        $('#idUsuario').val('');
        $('#iptNombre').val('')
        $('#iptApellido').val('')
        $('#selEstado').val('')
        $('#selUpdatePreciosProductos').val('')

        $('#form_usuarios').removeClass('was-validated');
    }
    /*===================================================================*/
    // FUNCION PARA MOSTRAR EL REGISTRO A EDITAR EN UN MODAL
    /*===================================================================*/
    function modalEditarUsuario(row_index){
        accion = 3; //Accion para Editar
        $('#mdlGestionarUsuarios').modal('show');

        $('#titulo_modal_gestionar_usuarios').html('Editar Usuario'); // CAMBIAR EL TITULO DE LA VENTANA MODAL
        $('#btnGuardarUsuario').html('Actualiza Usuario'); // CAMBIAR EL TITULO DEL BOTON DE GUARDAR

        const data = tbl_usuarios.row(row_index).data();
        let estado = data.estado === 'ACTIVO' ? 1 : 0;

        $('#idUsuario').val(data.id_usuario);
        $('#iptNombre').val(data.nombre);
        $('#selUpdatePreciosProductos').val(data.update_precios_productos);
        $('#iptApellido').val(data.apellido);
        $('#selEstado').val(estado);
    }
    /*===================================================================*/
    // FUNCION PARA MOSTRAR EL MODAL PARA REGISTRAR USUARIOS
    /*===================================================================*/
    function modalRegistrarUsuario(row_index){
        accion = 2; //Accion para registrar
        $('#mdlGestionarUsuarios').modal('show');

        $('#titulo_modal_gestionar_usuarios').html('Ingresar Usuario'); // CAMBIAR EL TITULO DE LA VENTANA MODAL
        $('#btnGuardarUsuario').html('Guardar Usuario'); // CAMBIAR EL TITULO DEL BOTON DE GUARDAR
    }
</script>

<?php else:?>
    <script>
        window.location = "./index.php";
    </script>
<?php endif; ?>