<?php if(session_status() === PHP_SESSION_NONE) session_start(); ?>
<script>
    var validarUrl = window.location.toString().search('usuario_modulos');
    if(validarUrl > 0) { window.location = "../index.php"; }
</script>
<?php
    $existe = false;
    if(isset($_SESSION['lista_menus']) && isset($_SESSION['usuario'])){
        if(in_array("usuario_modulos.php", $_SESSION['lista_menus'])){
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
                <h1 class="m-0">Asignar Módulos a Usuarios</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item active">Asignar Módulos a Usuarios</li>
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
                <table id="tbl_usuarios_asignar_modulos" class="display nowrap table-striped w-100 shadow rounded">
                    <thead class="bg-info text-left">
                        <tr>
                            <th></th>
                            <th></th>
                            <th>Usuario</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>Estado</th>
                            <th></th>
                            <th class="text-center">Modulos</th>
                            <th class="text-center">Permiso Modulos</th>
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

<!-- Ventana modal para Gestionar la asignacion de modulos a perfiles -->
<div class="modal fade" id="mdlAsignarModulosUsuarios" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <!-- Contenido modal -->
        <div class="modal-content">
            <!-- Cabecera del modal -->
            <div class="modal-header bg-gray py-2">
                <h5 class="modal-title" id="titulo_modal_stock">
                    <i class="fas fa-laptop"></i>
                    Módulos del Sistema
                </h5>
                <button type="button" class="btn btn-outline-primary text-white border-0 fs-5" data-bs-dismiss="modal" aria-label="Close"
                    id="btnCerrarModalAsigModPerf">
                    <i class="fas fa-times-circle"></i>
                </button>
            </div>
            <!-- Cuerpo del modal -->
            <div class="modal-body" id="card_body_modulos">
                <div class="row m-2">
                    <div class="col-md-6">
                        <button class="btn btn-primary btn-small m-0 p-0 w-100" id="marcar_modulos">Marcar todo</button>
                    </div>
                    <div class="col-md-6">
                    <button class="btn btn-danger btn-small m-0 p-0 w-100" id="desmarcar_modulos">Desmarcar todo</button>
                    </div>
                </div>
                <!-- AQUI SE CARGAN TODOS LOS MODULOS DEL SISTEMA -->
                <div id="modulos" class="demo"></div>
                <div class="row m-2">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Seleccione el modulo de inicio</label>
                            <select class="custom-select" id="select_modulos"></select>
                        </div>
                    </div>
                </div>
                <div class="row m-2">
                    <div class="col-md-12 text-center">
                        <button class="btn addNewRecord btn-small w-50" id="asignar_modulos">Asignar</button>
                    </div>
                </div>
            </div>
            <!-- Footer del modal -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal" id="btnCerrarModalAsigModPerf">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Ventana modal para agregar permiso que tendra el usuario a cada uno de los modulos que tenga permisos -->
<div class="modal fade" id="mdlValidarPermisosAModulos" data-row-index="">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header py-1 aling-items-center">
                <h3 class="modal-title">
                    <i class="fas fa-edit"></i>
                    Permisos a cada uno de los modulos
                </h3>
                <button type="button" class="btn btn-outline-secondary border-0 fs-5" data-bs-dismiss="modal"
                    id="btnCerrarModal">
                    <i class="fas fa-times-circle"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <table id="tbl_modal_asignar_permisos_modulos" class="table table-striped w-100 shadow">
                            <thead class="bg-info">
                                <tr style="font-size: 15px;">
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th>Modulo</th>
                                    <th>Crear</th>
                                    <th>Editar</th>
                                    <th>Eliminar</th>
                                </tr>
                            </thead>
                            <tbody class="text-small">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <!-- Creacion de botones para cancelar y guardar cambios de productos -->
                <button type="button" class="btn btn-secondary mt-3 mx-2" style="width: 170px" data-bs-dismiss="modal" id="btnCancelarRegistro">
                    Cerrar
                </button>
                <button type="submit" class="btn addNewRecord mt-3 mx-2" style="width: 170px" id="btnGuardarCambiosPermisosModulosModal">
                    Actualizar permisos
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    /*===================================================================*/
    // VARIABLES GLOBALES
    /*===================================================================*/
    var tbl_usuarios_asignar_modulos,tbl_modal_asignar_permisos_modulos,selectElemts,rowData,idUsuario,id_menu_asignacion_modulo,id_sub_menu_asingacion_modulo,modulos_asignados_usuario;
    $(document).ready(function(res){
        /*===================================================================*/
        // FUNCIONDES PARA LAS CARGAS INICIALES, ARBOL DE MODULOS Y REAJUSTE DE CABECERAS DE DATATABLES
        /*===================================================================*/
        iniciarArbolModulos();
        cargarInfModuloQAsignaModulosAUsers();
        cargarModulosDeLosUsuariosInJS();

        tbl_usuarios_asignar_modulos = $('#tbl_usuarios_asignar_modulos').DataTable({
            pageLength: 10,
            ajax:{
                async: false,
                url: 'ajax/usuarios.ajax.php',
                type: 'POST',
                dataType: 'json',
                dataSrc: '',
                data: {
                    accion: 1
                }
            },
            columnDefs:[
                {
                    targets: 0,
                    visible: false
                },
                {
                    targets: 1,
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
                    targets: 9,
                    visible: false
                },
                {
                    targets: 10,
                    sortable: false,
                    render: function(data, type, full, meta){
                        return "<center>" +
                                    "<span data-row-index='"+meta.row+"' id='btnSeleccionarUsuario' class='text-primary px-1' style='cursor:pointer;' data-bs-toggle='tooltip' data-bs-placement='top' title='Seleccionar perfil'>" +
                                        "<i class='fas fa-check fs-5'></i>" +
                                    "</span>" +
                                "</center>"
                    }
                },
                {
                    targets: 11,
                    sortable: false,
                    render: function(data, type, full, meta){
                        return "<center>" +
                                    "<span data-row-id-usuario='"+full.id_usuario+"' id='btnAsignarPermisosModulos' class='text-info px-1' style='cursor:pointer;' data-bs-toggle='tooltip' data-bs-placement='top' title='Dar permisos'>" +
                                        "<i class='fas fa-lock fs-5'></i>" +
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

        /*===================================================================*/
        // INICIALIZAR LA TABLA MODAL PARA DAR PERMISOS A USERS DE LOS MOULOS ASIGNADOS
        /*===================================================================*/
        tbl_modal_asignar_permisos_modulos = $('#tbl_modal_asignar_permisos_modulos').DataTable({
            searching: false,
            paging: false,
            order: [[1, 'asc']],
            columns: [{
                    "data": "id_modulo"
                },
                {
                    "data": "id_usuario"
                },
                {
                    "data": "user_create"
                },
                {
                    "data": "user_write"
                },
                {
                    "data": "user_delete"
                },
                {
                    "data": "modulo"
                },
                {
                    "data": "input_check_create"
                },
                {
                    "data": "input_check_write"
                },
                {
                    "data": "input_check_delete"
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
                    sortable: false,
                }, {
                    targets: 6,
                    width: '10%',
                    sortable: false,
                    render: function(data, type, full, meta){
                        let checked_create = parseInt(full.user_create) === 1 ? 'checked' : '';
                        return '<input data-row-index="'+meta.row+'" aria-label="Select row" class="inputCheckCreate dt-select-checkbox" type="checkbox" '+checked_create+'>';
                    }
                }, {
                    targets: 7,
                    width: '10%',
                    sortable: false,
                    render: function(data, type, full, meta){
                        let checked_write = parseInt(full.user_write) === 1 ? 'checked' : '';
                        return '<input data-row-index="'+meta.row+'" aria-label="Select row" class="inputCheckWrite dt-select-checkbox" type="checkbox" '+checked_write+'>';
                    }
                }, {
                    targets: 8,
                    width: '10%',
                    sortable: false,
                    render: function(data, type, full, meta){
                        let checked_delete = parseInt(full.user_delete) === 1 ? 'checked' : '';
                        return '<input data-row-index="'+meta.row+'" aria-label="Select row" class="inputCheckDelete dt-select-checkbox" type="checkbox" '+checked_delete+'>';
                    }
                }
            ],
            scrollCollapse: true,
            scrollX: true,
            scrollY: 400,
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
        // EVENTO AL SELECCIONAR UN USUARIO DE LA TABLA
        /*===================================================================*/
        $('#tbl_usuarios_asignar_modulos tbody').on('click','#btnSeleccionarUsuario', function(e){
            const rowIndex = $(this).data('rowIndex'); // OBTENER EL ARRAY CON LOS DATOS DE LA COLUMNA SELECCIONADA EN EL DATATABLE
            rowData = tbl_usuarios_asignar_modulos.row(rowIndex).data();
            tbl_usuarios_asignar_modulos.$('tr.selected').removeClass('selected');
            $(this).parents('tr').addClass('selected');
            idUsuario = rowData.id_usuario;
            modulos_asignados_usuario.filter(mod => mod.id_usuario === idUsuario).forEach(function(data){
                if(parseInt(data.cel) === 1){
                    $('#modulos').jstree('select_node', data.id_modulo);
                }
                if(parseInt(idUsuario) === 1 && (id_menu_asignacion_modulo === data.id_modulo || id_sub_menu_asingacion_modulo === data.id_modulo)){
                    $('#modulos').jstree().disable_node(data.id_modulo);
                }
            });
            $('#modulos').jstree(this).show_all();
            $('#mdlAsignarModulosUsuarios').modal('show');
            $('#select_modulos').find('option').each(function(){
                if (this.value == rowData.id_modulo_inicio) {
                    $(this).prop("selected", true);
                }
            });
        });

        /*===================================================================*/
        // EVENTO AL SELECCIONAR UN USUARIO DE LA TABLA PARA ASIGNAR PERMISOS A MODULOS
        /*===================================================================*/
        $('#tbl_usuarios_asignar_modulos tbody').on('click','#btnAsignarPermisosModulos', function(e){
            let id_user = $(this).data('rowIdUsuario');
            modalTableAsigPermisosDModulosUser(id_user);
        });

        /*===================================================================*/
        // EVENTO AL CERRAR LA VENTANA DEL ASIGNAR MODULOS A USUARIOS
        /*===================================================================*/
        $('#mdlAsignarModulosUsuarios').on('hidden.bs.modal', function(event) {
            tbl_usuarios_asignar_modulos.$('tr.selected').removeClass('selected');
            $('#modulos').jstree('deselect_all', false);
            $('#modulos li.jstree-node').each(function() {
                $('#modulos').jstree("enable_node", this.id)
            });
            $('#select_modulos option').remove();
        });

        /*===================================================================*/
        // EVENTO AL HACER UN CAMBIO EN EL ARBOL DE LOS MODULOS LEA LOS MODULOS MARCADOS
        /*===================================================================*/
        $('#modulos').on('changed.jstree', function(event, data) {
            $('#select_modulos option').remove();
            selectElemts = $('#modulos').jstree('get_selected', true);
            if(selectElemts.length > 0) {
                selectElemts.forEach(function(dat){
                    if(dat.original.vista){
                        $('#select_modulos').append($('<option>', {
                            value: dat.id,
                            text: dat.text
                        }));
                    }
                });
            } else {
                $('#select_modulos').append($('<option>', {
                    value: 0,
                    text: '--No hay modulos seleccionados--'
                }));
            }
        });

        /*===================================================================*/
        // EVENTO PARA MARCAR TODOS LOS CHECKBOX DEL ARBOL DE MODULOS
        /*===================================================================*/
        $('#marcar_modulos').on('click', function(event) {
            $('#modulos').jstree('select_all');
        });

        /*===================================================================*/
        // EVENTO PARA DESMARCAR TODOS LOS CHECKBOX DEL ARBOL DE MODULOS
        /*===================================================================*/
        $('#desmarcar_modulos').on('click', function(event) {
            $('#modulos').jstree('deselect_all');
            if(idUsuario === 1){
                $('#modulos').jstree('select_node', id_sub_menu_asingacion_modulo);
            } else{
                $('#select_modulos option').remove();
                $('#select_modulos').append($('<option>', {
                    value: 0,
                    text: '--No hay modulos seleccionados--'
                }));   
            }
        });

        /*===================================================================*/
        // EVENTO PARA REGISTRAR LOS MODULOS SELECCIONADOS AL PERFIL
        /*===================================================================*/
        $('#asignar_modulos').on('click', function(event) {
            registrarModulosDeUser();
        });
        $('#tbl_modal_asignar_permisos_modulos tbody').on('change','.inputCheckCreate', function() {
            const rowIndex = $(this).data('rowIndex'); // OBTENER EL ARRAY CON LOS DATOS DE LA COLUMNA SELECCIONADA EN EL DATATABLE
            let rowDataModulo = tbl_modal_asignar_permisos_modulos.row(rowIndex).data();
            rowDataModulo.user_create = $(this).is(":checked") ? 1 : 0;
            tbl_modal_asignar_permisos_modulos.row(rowIndex).data(rowDataModulo);
        });
        $('#tbl_modal_asignar_permisos_modulos tbody').on('change','.inputCheckWrite', function() {
            const rowIndex = $(this).data('rowIndex'); // OBTENER EL ARRAY CON LOS DATOS DE LA COLUMNA SELECCIONADA EN EL DATATABLE
            let rowDataModulo = tbl_modal_asignar_permisos_modulos.row(rowIndex).data();
            rowDataModulo.user_write = $(this).is(":checked") ? 1 : 0;
            tbl_modal_asignar_permisos_modulos.row(rowIndex).data(rowDataModulo);
        });
        $('#tbl_modal_asignar_permisos_modulos tbody').on('change','.inputCheckDelete', function() {
            const rowIndex = $(this).data('rowIndex'); // OBTENER EL ARRAY CON LOS DATOS DE LA COLUMNA SELECCIONADA EN EL DATATABLE
            let rowDataModulo = tbl_modal_asignar_permisos_modulos.row(rowIndex).data();
            rowDataModulo.user_delete = $(this).is(":checked") ? 1 : 0;
            tbl_modal_asignar_permisos_modulos.row(rowIndex).data(rowDataModulo);
        });
        $('#btnGuardarCambiosPermisosModulosModal').on('click', function() {
            let json_modulos = tbl_modal_asignar_permisos_modulos.rows().data();
            if(json_modulos.length){
                let array_values = Object.values(json_modulos);
                let update_permisos_modulos = array_values.map(row => ({
                    id_modulo: row.id_modulo,
                    id_usuario: row.id_usuario,
                    user_create: row.user_create,
                    user_write: row.user_write,
                    user_delete: row.user_delete
                })).filter(mod => mod.id_modulo != undefined && mod.id_usuario != undefined);
                let data = {
                    accion: 2,
                    datos: update_permisos_modulos,
                }
                $(".content-header").addClass("loader");
                $.ajax({
                    url: 'ajax/usuario_modulos.ajax.php',
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
                            $('#mdlValidarPermisosAModulos').modal('hide');
                            setTimeout(function() {
                                window.location = "./index.php";
                            }, 1000);
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
                    icon:'warning',
                    title: 'No tiene acceso a ningun modulo!',
                });
            }
        });
    })
    function iniciarArbolModulos() {
        $.ajax({
            async: false,
            url: 'ajax/modulos.ajax.php',
            type: 'POST',
            dataType: 'json',
            dataSrc: '',
            data: {
                accion: 1
            },
            success: function (respuesta) {
                $('#modulos').jstree({
                    'core': {
                        'check_callback': true,
                        'data': respuesta
                    },
                    'checkbox': {
                        'keep_selected_style': true
                    },
                    'types': {
                        'default': {
                            'icon': 'fas fa-laptop text-warning'
                        }
                    },
                    'plugins': ['wholerow', 'checkbox', 'types', 'changed']
                }).bind('loaded.jstree', function(event, data){
                    $(this).jstree('open_all');
                });
            },
        })
    }
    /*===================================================================*/
    // CARGAR INFORMACION DEL APARTADO DE ASIGNAR MODULOS A USUARIOS
    /*===================================================================*/
    function cargarInfModuloQAsignaModulosAUsers() {
        $.ajax({
            url: "ajax/modulos.ajax.php",
            type: "POST",
            data: {
                'accion': 3
            },
            cache: false,
            dataType: 'json',
            success: function(respuesta) {
                id_menu_asignacion_modulo = respuesta[0].padre_id
                id_sub_menu_asingacion_modulo = respuesta[0].id_modulo
            }
        });
    }
    function cargarModulosDeLosUsuariosInJS() {
        return $.ajax({
            url: 'ajax/modulos.ajax.php',
            type: 'POST',
            data: {
                accion: 2
            },
            dataType: 'json',
            success: function(modulos_usuario){
                modulos_asignados_usuario = modulos_usuario;
            }
        });
    }
    async function registrarModulosDeUser(){
        let select_elms_ids = [];
        if(selectElemts.length > 0) {
            selectElemts.forEach(function(dat){
                select_elms_ids.push(dat.id);
                if(dat.parent != '#'){
                    select_elms_ids.push(dat.parent);
                }
            });
            select_elms_ids = [...new Set(select_elms_ids)];
            let datos = {
                accion: 1,
                ids_select_elms: select_elms_ids,
                id_usuario: idUsuario,
                id_modulo_inicio: $('#select_modulos').val()
            }
            $(".content-header").addClass("loader");
            let result = await $.ajax({
                url: 'ajax/usuario_modulos.ajax.php',
                method: 'POST',
                data: JSON.stringify(datos),
                contentType: 'application/json;charset=utf-8',
                dataType: 'json',
                success: function(objeto){
                    $(".content-header").removeClass("loader");
                    return objeto;
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
            if(result.estado){
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: result.mensaje+': '+result.datos,
                    showConfirmButton: false,
                    timer: 2000
                });
                $('#mdlAsignarModulosUsuarios').modal('hide');
                await cargarModulosDeLosUsuariosInJS();
                modalTableAsigPermisosDModulosUser(idUsuario);
            } else if(!result.estado) {
                Swal.fire({
                    position: 'center',
                    icon:'error',
                    title: result.error,
                });
            }
        } else {
            Swal.fire({
                position: 'center',
                icon: 'warning',
                title: 'Es necesario seleccionar un modulo a ' + rowData.nombre
            });
        }
    }
    function modalTableAsigPermisosDModulosUser(id_usuario){
        tbl_modal_asignar_permisos_modulos.clear();
        let modulos = modulos_asignados_usuario.filter(mod => mod.id_usuario === id_usuario && mod.cel > 0);
        modulos.forEach(function(data){
            let row = tbl_modal_asignar_permisos_modulos.row.add({
                'id_modulo': data.id_modulo,
                'id_usuario': id_usuario,
                'user_create': data.user_create,
                'user_write': data.user_write,
                'user_delete': data.user_delete,
                'modulo': data.modulo,
            });
        });
        $('#mdlValidarPermisosAModulos').modal('show');
        setTimeout(function() {
            tbl_modal_asignar_permisos_modulos.draw();
        }, 175);
    }
</script>
<?php else:?>
    <script>
        window.location = "./index.php";
    </script>
<?php endif; ?>