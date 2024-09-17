<?php if(session_status() === PHP_SESSION_NONE) session_start(); ?>
<script>
    var validarUrl = window.location.toString().search('productos');
    if(validarUrl > 0) { window.location = "../index.php"; }
</script>
<?php
    $existe = false;
    if(isset($_SESSION['lista_menus']) && isset($_SESSION['usuario'])){
        if(in_array("productos.php", $_SESSION['lista_menus'])){
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
                <h1 class="m-0">Administrar Productos</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item active">Administrar Productos</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content" id="id_user_div"
    data-update_precios_productos="<?php echo $_SESSION['usuario']->update_precios_productos; ?>">
    <div class="container-fluid">
        <!-- row Tarjetas Informativas -->
        <div class="row">
            <nav class="w-100">
                <div class="nav nav-tabs" id="product-tab" role="tablist">
                    <a class="nav-item nav-link active" id="product-list-tab" data-toggle="tab" href="#product-list" role="tab" aria-controls="product-list" aria-selected="true">Lista</a>
                    <a class="nav-item nav-link" id="product-kanban-tab" data-toggle="tab" href="#product-kanban" role="tab" aria-controls="product-kanban" aria-selected="false">Kanban</a>
                </div>
            </nav>
            <div class="tab-content p-3" id="nav-tabContent">
                <div class="tab-pane fade active show" id="product-list" role="tabpanel" aria-labelledby="product-list-tab">
                    <!-- row para listado de productos -->
                    <div class="row">
                        <div class="col-lg-12">
                            <table id="tbl_productos" class="table table-striped w-100 shadow">
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
                                        <th>Nombre</th>
                                        <th>Marca</th>
                                        <th>Codigo de barras</th>
                                        <th>Talla</th>
                                        <th>Color</th>
                                        <th>Precio</th>
                                        <th>Costo</th>
                                        <th>Categoria</th>
                                        <th>Cantidad a mano</th>
                                        <th>Unidad de medida</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th class="text-center">Opciones</th>
                                    </tr>
                                </thead>
                                <tbody class="text-small">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="product-kanban" role="tabpanel" aria-labelledby="product-kanban-tab">
                    <div class="row">
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->

<!-- Ventana modal para Ingresar o Modificar Productos -->
<form id="form_productos" novalidate>
    <div class="modal fade" id="mdlGestionarProductos">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <!-- Contenido modal -->
            <div class="modal-content">
                <!-- Cabecera del modal -->
                <div class="modal-header bg-gray py-1 aling-items-center">
                    <h5 class="modal-title" id="titulo_modal_gestionar_productos">Ingresar Productos</h5>
                    <button type="button" class="btn btn-outline-primary text-white border-0 fs-5" data-bs-dismiss="modal"
                        id="btnCerrarModal">
                        <i class="fas fa-times-circle"></i>
                    </button>
                </div>
                <!-- Cuerpo del modal -->
                <div class="modal-body">
                    <input type="hidden" id="idProducto" />
                    <!-- Abrimos una fila -->
                    <div class="row">
                        <!-- Columna para el registro del Nombre -->
                        <div class="col-lg-12">
                            <div class="form-group mb-2">
                                <label class="" for="iptNombre">
                                    <i class="fas fa-file-signature fs-6"></i>
                                    <span class="small">Nombre</span>
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control"
                                    id="iptNombre" placeholder="Nombre" required />
                                <div class="invalid-feedback">Debe ingresar el nombre del producto</div>
                            </div>
                        </div>
                        <!-- Columna para el registro de la Categoria -->
                        <div class="col-lg-12">
                            <div class="form-group mb-2">
                                <label class="" for="selCategoria">
                                    <i class="fas fa-dumpster fs-6"></i>
                                    <span class="small">Categoria</span>
                                    <span class="text-danger">*</span>
                                </label>
                                <select type="text" class="form-select form-select-sm"
                                    aria-label=".form-select-sm example" id="selCategoria">
                                </select>
                                <div class="invalid-feedback">Debe seleccionar la categoria del producto</div>
                            </div>
                        </div>
                        <!-- Columna para el registro de la Unidad de Medida -->
                        <div class="col-lg-6">
                            <div class="form-group mb-2">
                                <label class="" for="selUdm">
                                    <i class="fas fa-dumpster fs-6"></i>
                                    <span class="small">Unidad de Medida</span>
                                    <span class="text-danger">*</span>
                                </label>
                                <select type="text" class="form-select form-select-sm"
                                    aria-label=".form-select-sm example" id="selUdm" required>
                                </select>
                                <div class="invalid-feedback">Debe seleccionar la unidad de medida del producto</div>
                            </div>
                        </div>
                        <!-- Columna para el registro de la Unidad de Medida de Compra -->
                        <div class="col-lg-6">
                            <div class="form-group mb-2">
                                <label class="" for="selUdmCompra">
                                    <i class="fas fa-dumpster fs-6"></i>
                                    <span class="small">Unidad de Medida Compra</span>
                                    <span class="text-danger">*</span>
                                </label>
                                <select type="text" class="form-select form-select-sm"
                                    aria-label=".form-select-sm example" id="selUdmCompra" required>
                                </select>
                                <div class="invalid-feedback">Debe seleccionar la unidad de medida compra del producto</div>
                            </div>
                        </div>
                        <!-- Columna para el registro de Marca -->
                        <div class="col-lg-4">
                            <div class="form-group mb-2">
                                <label class="" for="selMarca">
                                    <i class="fas fa-dumpster fs-6"></i>
                                    <span class="small">Marca</span>
                                    <span class="text-danger"></span>
                                </label>
                                <select type="text" class="form-select form-select-sm"
                                    aria-label=".form-select-sm example" id="selMarca">
                                </select>
                                <div class="invalid-feedback">Debe seleccionar la marca del producto</div>
                            </div>
                        </div>
                        <!-- Columna para el registro de Talla -->
                        <div class="col-lg-4 fields_talla_ocultar_por_categoria">
                            <div class="form-group mb-2">
                                <label class="" for="selTalla">
                                    <i class="fas fa-dumpster fs-6"></i>
                                    <span class="small">Talla</span>
                                    <span class="text-danger">*</span>
                                </label>
                                <select type="text" class="form-select form-select-sm"
                                    aria-label=".form-select-sm example" id="selTalla" required>
                                </select>
                                <div class="invalid-feedback">Debe seleccionar la talla del producto</div>
                            </div>
                        </div>
                        <!-- Columna para el registro de Color -->
                        <div class="col-lg-4 fields_color_ocultar_por_categoria">
                            <div class="form-group mb-2">
                                <label class="" for="selColor">
                                    <i class="fas fa-dumpster fs-6"></i>
                                    <span class="small">Color</span>
                                    <span class="text-danger">*</span>
                                </label>
                                <select type="text" class="form-select form-select-sm"
                                    aria-label=".form-select-sm example" id="selColor" required>
                                </select>
                                <div class="invalid-feedback">Debe seleccionar el color del producto</div>
                            </div>
                        </div>
                        <!-- Columna para el registro de Precio de Venta -->
                        <div class="col-lg-4 div_update_precios">
                            <div class="form-group mb-2">
                                <label class="" for="iptPrecio">
                                    <i class="fas fa-dollar-sign fs-6"></i>
                                    <span class="small">Precio de Venta</span>
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="number" class="form-control" id="iptPrecio"
                                    step="0.01" placeholder="Precio de Venta" required />
                                <div class="invalid-feedback">Debe ingresar el precio de venta</div>
                            </div>
                        </div>
                        <!-- Columna para el registro de Precio de Compra -->
                        <div class="col-lg-4 div_update_precios">
                            <div class="form-group mb-2">
                                <label class="" for="iptCosto">
                                    <i class="fas fa-dollar-sign fs-6"></i>
                                    <span class="small">Costo</span>
                                    <span class="text-danger"></span>
                                </label>
                                <input type="number" class="form-control" id="iptCosto"
                                    step="0.01" placeholder="Precio de Compra" required/>
                                <div class="invalid-feedback">Debe ingresar el costo</div>
                            </div>
                        </div>
                        <!-- Columna para el registro de la Utilidad -->
                        <div class="col-lg-4">
                            <div class="form-group mb-2">
                                <label class="" for="iptUtilidad">
                                    <i class="fas fa-dollar-sign fs-6"></i>
                                    <span class="small">Ganancias</span>
                                </label>
                                <input type="number" class="form-control"
                                    id="iptUtilidad" placeholder="Ganancias" disabled />
                            </div>
                        </div>
                        <!-- Columna para el registro del Stock del Producto -->
                        <div class="col-lg-6 div_stock">
                            <div class="form-group mb-2">
                                <label class="" for="iptStock">
                                    <i class="fas fa-plus-circle fs-6"></i> <span class="small">Stock</span><span
                                        class="text-danger"></span>
                                </label>
                                <input type="number" min="0" value="1" class="form-control"
                                    id="iptStock" placeholder="Stock"/>
                                <div class="invalid-feedback">Debe ingresar el stock del producto</div>
                            </div>
                        </div>
                        <!-- Columna para el registro del Minimo Stock del Producto -->
                        <div class="col-lg-6 div_min_stock">
                            <div class="form-group mb-2">
                                <label class="" for="iptMinStock">
                                    <i class="fas fa-plus-circle fs-6"></i> <span class="small">Minimo Stock</span><span
                                        class="text-danger"></span>
                                </label>
                                <input type="number" min="0" class="form-control"
                                    id="iptMinStock" placeholder="Minimo Stock" />
                                <div class="invalid-feedback">Debe ingresar el mínimo stock del producto</div>
                            </div>
                        </div>
                        <!-- Columna para el registro de Codigo de Barras -->
                        <div class="col-lg-4">
                            <div class="form-group mb-2">
                                <label class="" for="iptCodigoBarras">
                                    <i class="fas fa-file-signature fs-6"></i>
                                    <span class="small">Codigo de Barras</span>
                                </label>
                                <input type="number" min="0" class="form-control"
                                    id="iptCodigoBarras" placeholder="Codigo de Barras" />
                                <div class="invalid-feedback">Debe ingresar el codigo de barras</div>
                            </div>
                        </div>
                        <!-- Columna para visualizar la imagen -->
                        <div class="col-lg-4">
                            <div class="form-group mb-2">
                                <label class="" for="iptImgPrincipal">
                                <i class="fas fa-file-signature fs-6"></i>
                                    <span class="small">Imagen</span>
                                    <input type="file" class="form-control"
                                        id="iptImgPrincipal" accept="image/jpeg,image/jpg,image/png" />
                                    <div class="invalid-feedback">Debe agregar una imgagen</div>
                                </label>
                                <img id="visualizar_imagen" alt="user-avatar" style="object-fit: cover;" width="130" height="130"/>
                                <input type="hidden" id="iptNameImagenExistente" />
                            </div>
                        </div>
                        <!-- Columna para el qr Producto -->
                        <div class="col-lg-4">
                            <div class="form-group mb-2">
                                <div class="custom-control custom-switch">
                                    <!-- <br/>
                                    <input type="checkbox" class="custom-control-input" id="checkQrBase64"> -->
                                    <label class="" for="checkQrBase64"
                                        style="color: #28a745;">
                                        Al darle guardar se genera un QR
                                    </label>
                                    <div id="contenedor_qr">
                                        <img id="img_qr_base64"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Footer del modal -->
                <div class="modal-footer">
                    <!-- Creacion de botones para cancelar y guardar el producto -->
                    <button type="button" class="btn btn-secondary mt-3 mx-2" style="width: 170px" data-bs-dismiss="modal" id="btnCancelarRegistro">
                        Cancelar
                    </button>
                    <button type="submit" class="btn addNewRecord mt-3 mx-2" style="width: 170px" id="btnGuardarProducto">
                        Guardar Producto
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Ventana modal para Imprimir Etiquetas de Productos -->
<form id="form_print_etiquetas" novalidate>
    <div class="modal fade" id="mdlImprimirEtiquetasProductos">
        <div class="modal-dialog modal-lg ">
            <div class="modal-content">
                <div class="modal-header bg-gray py-1 aling-items-center">
                    <h5 class="modal-title">Imprimir etiquetas de productos</h5>
                    <button type="button" class="btn btn-outline-primary text-white border-0 fs-5" data-bs-dismiss="modal"
                        id="btnCerrarModal">
                        <i class="fas fa-times-circle"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Columna para el registro de la Cant a Imprimir por Producto -->
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <button type="button" class="btn btn-default">
                                Cantidad
                                <span class="text-danger">*</span>
                            </button>
                        </div>
                        <input type="number" min="0" value="1" class="form-control" id="iptCantidadImprimir"
                            placeholder="Ingrese la cantidad a imprimir por producto">
                        <div class="invalid-feedback">Debe ingresar la cantidad a imprimir por producto</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- Creacion de botones para cancelar e imprimir etiquetas de productos -->
                    <button type="button" class="btn btn-secondary mt-3 mx-2" style="width: 170px" data-bs-dismiss="modal" id="btnCancelarRegistro">
                        Cancelar
                    </button>
                    <button type="submit" class="btn addNewRecord mt-3 mx-2" style="width: 170px" id="btnImprimirEtiquetas">
                        Imprimir
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    var accion,tbl_productos,listado_categorias;
    var update_stock_productos = 0; // SE USA PARA VALIDAR EL UPDATE DE PRECIOS
    var update_precios_productos = false; // SE USA PARA VALIDAR EL UPDATE DE PRECIOS
    $(document).ready(function() {
        recargarTablaDataActual();
        cargarProductosListKanban();
        cargarDataInSelections();
        cargarDataCategorias();
        getUpdateStockProductos();
        /*===================================================================*/
        // CARGA DEL LISTADO CON EL PLUGIN DATATABLE JS
        /*===================================================================*/
        tbl_productos = $("#tbl_productos").DataTable({
            pageLength: 10,
            dom: 'Bfrtip',
            buttons: [{
                    text: 'Agregar Producto',
                    className: 'addNewRecord',
                    action: function(e, dt, node, config) {
                        $('.div_stock input').prop('readonly', false);
                        $('.div_min_stock input').prop('readonly', false);
                        $('.div_update_precios input').prop('readonly', false);
                        fieldsOcultarPorCategoria(0);
                        //EVENTO PARA LEVENTAR LA VENTA MODAL
                        stateBtnClickAddProduct = true;
                        accion = 2;
                        $('#mdlGestionarProductos').modal('show');
                        $('#titulo_modal_gestionar_productos').html('Ingresar Producto'); // CAMBIAR EL TITULO DE LA VENTANA MODAL
                        $('#btnGuardarProducto').html('Guardar Producto'); // CAMBIAR EL TITULO DEL BOTON DE GUARDAR
                    }
                },{
                    text: 'Imprimir Etiquetas',
                    className: 'imprimirQrsRecord d-none',
                    action: function(e, dt, node, config) {
                        $("#iptCantidadImprimir").val('1')
                        $('#mdlImprimirEtiquetasProductos').modal('show');
                    }
                },
                'pageLength'
            ],
            ajax: {
                url: "ajax/productos.ajax.php",
                dataSrc: '',
                type: "POST",
                data: {
                    'accion': 1,
                    'domain': JSON.stringify(domain_productos),
                },
                dataType: 'json',
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
                    targets: 19,
                    createdCell: function(td, cellData, rowData, row, col) {
                        if (parseFloat(rowData[18]) <= parseFloat(rowData[21])) {
                            $(td).parent().css('background', '#FF5733')
                        }
                    }
                },
                {
                    targets: 21,
                    visible: false
                },
                {
                    targets: 22,
                    visible: false
                },
                {
                    targets: 23,
                    visible: false
                },
                {
                    targets: 24,
                    visible: false
                },
                {
                    targets: 25,
                    visible: false
                },
                {
                    targets: 26,
                    orderable: false,
                    render: function(data, type, full, meta) {
                        return "<center>" +
                            "<span data-row-index='"+meta.row+"' id='btnEditarProducto' class='text-primary px-4' style='cursor:pointer;'>" +
                            "<i class='fas fa-pencil-alt fs-1'></i>" +
                            "</span>" +
                            "<span data-row-index='"+meta.row+"' id='btnEliminarProducto' class='text-danger px-4' style='cursor:pointer;'>" +
                            "<i class='fas fa-trash fs-1'></i>" +
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
        // EVENTO AL DAR CLICK EN EL MENU DE DETALLES DE VENTA
        /*===================================================================*/
        $('#product-list-tab, #product-kanban-tab').on('click', function() {
            recargarTablaDataActual();
        });

        /*===================================================================*/
        // EVENTO AL DETECTAR CAMBIOS DE TAMAÑO DE NAVEGADOR PARA RECARGAR DATA
        // DE LAS TABLAS Y NO SE DISTORCIONE LA INF DEL ENCABEZADO
        /*===================================================================*/
        $(window).resize(function() {
            recargarTablaDataActual();
        });

        tbl_productos.on('deselect', function (e, dt, type, indexes) {
            hideShowBtnImprimirEtiquetas(type, indexes);
        });

        tbl_productos.on('select', function (e, dt, type, indexes) {
            hideShowBtnImprimirEtiquetas(type, indexes);
        });

        $('#selCategoria').change(function() {
            fieldsOcultarPorCategoria(parseInt(this.value));
        });

        $("#iptCosto, #iptPrecio").keyup(function() {
            calcular_utilidad();
        })

        $("#iptCosto, #iptPrecio").change(function() {
            $("#iptCosto").val(parseFloat($("#iptCosto").val() || '0.00').toFixed(2));
            $("#iptPrecio").val(parseFloat($("#iptPrecio").val() || '0.00').toFixed(2));
            calcular_utilidad();
        })

        $("#iptStock").change(function() {
            $("#iptStock").val(parseInt($("#iptStock").val() || '0'));
        })

        $("#iptMinStock").change(function() {
            $("#iptMinStock").val(parseInt($("#iptMinStock").val() || '0'));
        })

        $("#iptImgPrincipal").change(function() {
            const archivo = $(this).prop('files')[0];
            if (archivo.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#visualizar_imagen').attr('src',e.target.result);
                };
                reader.readAsDataURL(archivo);
            } else {
                alert('Por favor, seleccione una imagen');
            }
        })

        /*===================================================================*/
        // EVENTO AL ABRIR LA VENTANA DEL FORMULARIO DE PRODUCTOS
        /*===================================================================*/
        $('#mdlGestionarProductos').on('shown.bs.modal', function(event) {
            if(accion === 2){
                limpiar_campos_form();
            }
        });

        /*===================================================================*/
        // EVENTO AL CERRAR LA VENTANA DEL FORMULARIO DE PRODUCTOS
        /*===================================================================*/
        $('#mdlGestionarProductos').on('hidden.bs.modal', function(event) {
            stateBtnClickAddProduct = false;
            limpiar_campos_form();
        });

        /*===================================================================*/
        // EVENTO AL DAR CLICK EN EL BOTON DE EDITAR PRODUCTO
        /*===================================================================*/
        $('#tbl_productos tbody').on('click', '#btnEditarProducto', function(){
            stateBtnClickAddProduct = false;
            $('.div_stock input').prop('readonly', true);
            $('.div_min_stock input').prop('readonly', update_stock_productos === 1 ? false : true);
            let user_update_precios_productos = $('#id_user_div').data('update_precios_productos');
            if(parseInt(update_precios_productos) === 0){
                $('.div_update_precios input').prop('readonly', true);
            } else if(parseInt(user_update_precios_productos) === 0){
                $('.div_update_precios input').prop('readonly', true);
            } else {
                $('.div_update_precios input').prop('readonly', false);
            }
            modalEditarProducto($(this).data('rowIndex'));
        })

        /*===================================================================*/
        // EVENTO AL DAR CLICK EN EL BOTON DE ELIMINAR PRODUCTO
        /*===================================================================*/
        $('#tbl_productos tbody').on('click', '#btnEliminarProducto', function(){
            accion = 4; //Accion para Eliminar Producto
            const data = tbl_productos.row($(this).data('rowIndex')).data();
            let id_producto = data.id_producto;
            Swal.fire({
                title: 'Está seguro de eliminar el producto?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonClass: 'btn-danger',
                confirmButtonText: 'Si, deseo eliminarlo!',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    if(!Number.isInteger(parseInt(id_producto))){
                        Swal.fire({
                            position: 'center',
                            icon:'error',
                            title: 'Error al eliminar el producto, no se pudo obtener el id del registro',
                        });
                        return;
                    }
                    var datos = new FormData();
                    datos.append("accion", accion);
                    datos.append("id_producto", id_producto);
                    datos.append("name_img_existente", data.img_principal);
                    $(".content-header").addClass("loader");
                    $.ajax({
                        url: 'ajax/productos.ajax.php',
                        type: 'POST',
                        data: datos,
                        cache: false,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        success: function(objeto){
                            $(".content-header").removeClass("loader");
                            if(objeto.estado){
                                Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: objeto.mensaje,
                                    showConfirmButton: false,
                                    timer: 2000
                                });
                                tbl_productos.ajax.reload();
                                cargarProductosListKanban();
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
                                title: 'Ocurrio un error al eliminar el producto: '+error+'!',
                            });
                        }
                    });
                }
            });
        })

        /*===================================================================*/
        // FUNCION PARA VALIDAR LOS CAMPOS REQUERIDOS EN EL FORM
        /*===================================================================*/
        $('#form_productos').on('submit', function(e) {
            e.preventDefault();
            const form_producto = $('#form_productos');
            let validation = Array.prototype.filter.call(form_producto, function(form) {
                if (form.checkValidity() === true) {
                    if(!calcular_utilidad())
                    return
                    if($("#iptPrecio").val() <= 0){
                        Swal.fire({
                            position: 'center',
                            icon:'error',
                            title: 'El precio del producto debe ser mayor a 0!',
                        });
                        return;
                    }
                    /*===================================================================*/
                    // FUNCION PARA MANDAR A REGISTRAR Y ACTUALIZAR EL PRODUCTO
                    /*===================================================================*/
                    let title_swal_fire = '';
                    let confirmButtonTextswalfire = '';
                    if(accion === 2){
                        title_swal_fire = 'Está seguro de registrar el producto?';
                        confirmButtonTextswalfire = 'Si, deseo registrarlo!';
                    }
                    if(accion === 3){
                        title_swal_fire = 'Está seguro de actualizar el producto?';
                        confirmButtonTextswalfire = 'Si, deseo actualizarlo!';
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
                            let id_producto = parseInt($('#idProducto').val());
                            if(accion === 3){
                                if(!Number.isInteger(id_producto)){
                                    Swal.fire({
                                        position: 'center',
                                        icon:'error',
                                        title: 'Error al actualizar el producto, no se pudo obtener el id del registro',
                                    });
                                    return;
                                }
                            }
                            var datos = new FormData();
                            datos.append("accion", accion);
                            datos.append("id_producto", id_producto);
                            datos.append("nombre", $("#iptNombre").val());
                            datos.append("id_categoria", $("#selCategoria").val());
                            datos.append("id_udm", $("#selUdm").val());
                            datos.append("id_udm_compra", $("#selUdmCompra").val());
                            datos.append("id_marca", $("#selMarca").val());
                            datos.append("id_talla", $("#selTalla").val());
                            datos.append("id_color", $("#selColor").val());
                            datos.append("precio", $("#iptPrecio").val());
                            datos.append("costo", $("#iptCosto").val());
                            datos.append("utilidad", $("#iptUtilidad").val());
                            datos.append("stock", $("#iptStock").val());
                            datos.append("min_stock", $("#iptMinStock").val());
                            datos.append("codigo_barras", $("#iptCodigoBarras").val());
                            datos.append("img_principal", $('#iptImgPrincipal')[0].files[0]);
                            datos.append("name_img_existente", $("#iptNameImagenExistente").val());

                            $(".content-header").addClass("loader");
                            $.ajax({
                                url: 'ajax/productos.ajax.php',
                                type: 'POST',
                                data: datos,
                                cache: false,
                                contentType: false,
                                processData: false,
                                dataType: 'json',
                                success: function(objeto){
                                    $(".content-header").removeClass("loader");
                                    if(objeto.estado){
                                        Swal.fire({
                                            position: 'center',
                                            icon: 'success',
                                            title: objeto.mensaje,
                                            showConfirmButton: false,
                                            timer: 2000
                                        });
                                        tbl_productos.ajax.reload();
                                        $('#mdlGestionarProductos').modal('hide');
                                        cargarProductosListKanban();
                                    } else if(!objeto.estado) {
                                        Swal.fire({
                                            position: 'center',
                                            icon:'error',
                                            title: objeto.mensaje+': ' + objeto.error,
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
                        }
                    });
                } else {
                    console.log('no paso la validación');
                }
                form.classList.add('was-validated');
            });
        });

        /*===================================================================*/
        // FUNCION PARA VALIDAR LOS CAMPOS AL IMPRIMIR LAS ETIQUETAS DE LOS PRODUCTOS EN EL FORM
        /*===================================================================*/
        $('#form_print_etiquetas').on('submit', function(e) {
            e.preventDefault();
            const form_print_etiquetas = $('#form_print_etiquetas');
            let validation = Array.prototype.filter.call(form_print_etiquetas, function(form) {
                if (form.checkValidity() === true) {
                    if($("#iptCantidadImprimir").val() <= 0){
                        Swal.fire({
                            position: 'center',
                            icon:'error',
                            title: 'Ingrese una cantidad de etiquetas a imprimir por cada producto!',
                        });
                        return;
                    }
                    $(".content-header").addClass("loader");
                    let lista = []
                    tbl_productos.rows({ selected: true }).data().each(function (data) {
                        let obj = {
                            nombre: data.nombre,
                            precio: data.precio_concat,
                            qr: get_generar_qr(data.id_producto),
                        }
                        lista.push(obj)
                    });
                    let cantidad = $("#iptCantidadImprimir").val();
                    $.ajax({
                        url: 'ajax/productos.ajax.php',
                        type: 'POST',
                        data: {
                            productos : lista,
                            cantidad: cantidad,
                            accion: 6,
                        },
                        xhrFields: {
                            responseType: 'blob'
                        },
                        success: function(json) {
                            if(json.type == 'application/pdf'){
                                Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: 'Ok',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                $('#mdlImprimirEtiquetasProductos').modal('hide');
                                var a = document.createElement('a');
                                var url = window.URL.createObjectURL(json);
                                a.href = url;
                                a.download = 'etiquetas.pdf';
                                a.click();
                                window.URL.revokeObjectURL(url);
                            } else {
                                Swal.fire({
                                    position: 'center',
                                    icon:'error',
                                    title: 'Error al imprimir las etiquetas',
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
                } else {
                    console.log('no paso la validación');
                }
                form.classList.add('was-validated');
            });
        });
    }); // FIN DOCUMENTO READY
    /*===================================================================*/
    // CARGAR LISTADO DE PRODUCTOS EN KANBAN
    /*===================================================================*/
    function cargarProductosListKanban() {
        $.ajax({
            url: "ajax/productos.ajax.php",
            type: "POST",
            data: {
                'accion': 1,
                'domain': JSON.stringify(domain_productos),
            },
            dataType: 'json',
            success: function(productos) {
                $('#product-kanban > .row').html('');
                let row = 0;
                for (var i = 0; i < productos.length; i++) {
                    let img_principal = productos[i].img_principal;
                    if(productos[i].img_principal.length > 0){
                        if (!existeImagen('vistas/assets/dist/img/' + productos[i].img_principal)) {
                            img_principal = 'AdminLTELogo.png';
                        }
                    } else {
                        img_principal = 'AdminLTELogo.png';
                    }
                    $('#product-kanban > .row').append(
                        '<div class="col-lg-3 col-6">'+
                            '<a onClick="modalEditarProducto('+row+')" style="cursor: pointer;">'+
                                '<div class="small-box">'+
                                    '<div class="text-center">'+
                                        '<img src="vistas/assets/dist/img/' + img_principal + '" alt="user-avatar" style="object-fit: cover;" width="130" height="130">'+
                                        '<div class="inner">'+
                                            '<h5>' + productos[i].nombre_concat + '</h5>'+
                                            '<h5><b>' + productos[i].precio_concat + '</b></h5>'+
                                            'Stock: '+productos[i].stock + ' ' + productos[i].udm +
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</a>'+
                        '</div>'
                    );
                    row++;
                }
            }
        });
    }
    /*===================================================================*/
    // CARGAR LISTADO DE UNIDADES DE MEDIDA PARA REFERENCIA EN EL FORM
    /*===================================================================*/
    function cargarDataInSelections() {
        $.ajax({
            url: "ajax/productos.ajax.php",
            type: "POST",
            data: {
                'accion': 5
            },
            cache: false,
            dataType: 'json',
            success: function(datas) {
                let categorias = datas.filter(data => data.tabla === 'categorias')
                let unidades_medida = datas.filter(data => data.tabla === 'unidades_medida')
                let marcas = datas.filter(data => data.tabla === 'marcas')
                let tallas = datas.filter(data => data.tabla === 'tallas')
                let colores = datas.filter(data => data.tabla === 'colores')

                var categoria_option = '<option selected value="">Seleccione la categoria</option>';
                var unidades_medida_option = '<option selected value="">Seleccione la unidad de medida</option>';
                var marcas_option = '<option selected value="">Seleccione la marca</option>';
                var tallas_option = '<option selected value="">Seleccione la talla</option>';
                var colores_option = '<option selected value="">Seleccione el color</option>';

                for (var i = 0; i < categorias.length; i++) {
                    categoria_option = categoria_option + '<option value="' + categorias[i].id_registro + '">' + categorias[i].nombre +
                    '</option>';
                }
                for (var i = 0; i < unidades_medida.length; i++) {
                    unidades_medida_option = unidades_medida_option + '<option value="' + unidades_medida[i].id_registro + '">' + unidades_medida[i].nombre +
                    '</option>';
                }
                for (var i = 0; i < marcas.length; i++) {
                    marcas_option = marcas_option + '<option value="' + marcas[i].id_registro + '">' + marcas[i].nombre +
                    '</option>';
                }
                for (var i = 0; i < tallas.length; i++) {
                    tallas_option = tallas_option + '<option value="' + tallas[i].id_registro + '">' + tallas[i].nombre +
                    '</option>';
                }
                for (var i = 0; i < colores.length; i++) {
                    colores_option = colores_option + '<option value="' + colores[i].id_registro + '">' + colores[i].nombre +
                    '</option>';
                }

                $('#selCategoria').html(categoria_option);
                $('#selUdm').html(unidades_medida_option);
                $('#selUdmCompra').html(unidades_medida_option);
                $('#selMarca').html(marcas_option);
                $('#selTalla').html(tallas_option);
                $('#selColor').html(colores_option);
            }
        });
    }
    /*===================================================================*/
    // CARGAR LISTADO DE CATEGORIAS
    /*===================================================================*/
    function cargarDataCategorias() {
        $.ajax({
            url: "ajax/categorias.ajax.php",
            type: "POST",
            data: {
                'accion': 5
            },
            cache: false,
            dataType: 'json',
            success: function(respuesta) {
                listado_categorias = respuesta;
            }
        });
    }
    /*===================================================================*/
    // FUNCION PARA CALCULAR LA UTILIDAD
    /*===================================================================*/
    function calcular_utilidad() {
        var costo = parseFloat($("#iptCosto").val());
        var precio = parseFloat($("#iptPrecio").val());
        if(precio < costo){
            Toast.fire({
                icon: 'error',
                title: 'El costo del producto debe ser menor o igual a precio de venta!',
            });
            $("#iptUtilidad").val('');
            return false;
        }
        var utilidad = (costo > 0 && precio >= costo ? precio - costo : 0).toFixed(2)
        $("#iptUtilidad").val(utilidad);
        return true;
    }
    /*===================================================================*/
    // FUNCION PARA LIMPIAR LOS CAMPOS Y REMOVER LOS ESTILOS DE LAS VALIDACIONES DE LOS INPUTS MARCADOS EN EL FORM DEL REGISTRO DE PRODUCTOS
    /*===================================================================*/
    function limpiar_campos_form() {
        $('#idProducto').val('');
        $('#iptNombre').val('');
        $('#selCategoria').val('');
        $('#selUdm').val('');
        $('#selUdmCompra').val('');
        $('#selMarca').val('');
        $('#selTalla').val('');
        $('#selColor').val('');
        $('#iptPrecio').val('0.00');
        $('#iptCosto').val('0.00');
        $('#iptUtilidad').val('0.00');
        $('#iptStock').val('0');
        $('#iptMinStock').val('0');
        $('#iptCodigoBarras').val('');
        $('#iptImgPrincipal').val('');
        $('#visualizar_imagen').attr('src','vistas/assets/dist/img/AdminLTELogo.png');
        $('#iptNameImagenExistente').val('');
        $('#img_qr_base64').attr('src','');

        $('#form_productos').removeClass('was-validated');
    }
    /*===================================================================*/
    // FUNCION PARA MOSTRAR EL REGISTRO A EDITAR EN UN MODAL
    /*===================================================================*/
    function modalEditarProducto(row_index){
        accion = 3; //Accion para Editar
        $('#mdlGestionarProductos').modal('show');

        $('#titulo_modal_gestionar_productos').html('Editar Producto'); // CAMBIAR EL TITULO DE LA VENTANA MODAL
        $('#btnGuardarProducto').html('Actualiza Producto'); // CAMBIAR EL TITULO DEL BOTON DE GUARDAR

        const data = tbl_productos.row(row_index).data();

        fieldsOcultarPorCategoria(data.id_categoria)

        let img_principal = data.img_principal;
        if(data.img_principal.length > 0){
            if (!existeImagen('vistas/assets/dist/img/' + data.img_principal)) {
                img_principal = 'AdminLTELogo.png';
            }
        } else {
            img_principal = 'AdminLTELogo.png';
        }
        let id_producto = data.id_producto;

        $('#idProducto').val(id_producto);
        $('#iptNombre').val(data.nombre);
        $('#selCategoria').val(data.id_categoria);
        $('#selUdm').val(data.id_udm);
        $('#selUdmCompra').val(data.id_udm_compra);
        $('#selMarca').val(data.id_marca);
        $('#selTalla').val(data.id_talla);
        $('#selColor').val(data.id_color);
        $('#iptPrecio').val(data.precio);
        $('#iptCosto').val(data.costo);
        $('#iptUtilidad').val(data.utilidad);
        $('#iptStock').val(data.stock);
        $('#iptMinStock').val(data.min_stock);
        $('#iptCodigoBarras').val(data.codigo_barras);
        // $('#iptImgPrincipal').val('');
        $('#visualizar_imagen').attr('src','vistas/assets/dist/img/'+img_principal);
        $('#iptNameImagenExistente').val(data.img_principal);
        $('#img_qr_base64').attr('src',get_generar_qr(id_producto));
        $("#iptCosto, #iptPrecio").change();
        $("#iptStock, #iptMinStock").change();
    }
    /*===================================================================*/
    // FUNCION PARA MOSTRAR O OCULTAR EL BOTON DE IMPRIMIR ETIQUETAS
    /*===================================================================*/
    function hideShowBtnImprimirEtiquetas(type, indexes){
        if(type === 'row') {
            let len_rows_select = tbl_productos.$('tr.selected').length;
            if(len_rows_select > 0){
                $(".imprimirQrsRecord").removeClass('d-none');
            } else  {
                $(".imprimirQrsRecord").addClass('d-none');
            }
        }
    }
    function get_generar_qr(id_producto) {
        var elem = document.createElement('div');
        elem.id = "elem";
        var qrcodjs = new QRCode(elem, {
            text: id_producto,
            width: 150,
            height: 150,
            colorDark: "#000000",
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.H
        });
        var imgBase64Data = qrcodjs._oDrawing._elCanvas.toDataURL("image/png")
        return imgBase64Data
    }
    function fieldsOcultarPorCategoria(id_categoria=0) {
        let categoria = listado_categorias.find(cat => cat.id_categoria === parseInt(id_categoria));
        if(categoria && categoria.tipo_negocio === 1){
            $('.fields_talla_ocultar_por_categoria select').prop('required', true);
            $('.fields_color_ocultar_por_categoria select').prop('required', true);
            $('.fields_talla_ocultar_por_categoria').css({'display': ''});
            $('.fields_color_ocultar_por_categoria').css({'display': ''});
        } else {
            $('.fields_talla_ocultar_por_categoria select').prop('required', false);
            $('.fields_color_ocultar_por_categoria select').prop('required', false);
            $('.fields_talla_ocultar_por_categoria').css({'display': 'none'});
            $('.fields_color_ocultar_por_categoria').css({'display': 'none'});
        }
    }
    /*===================================================================*/
    // FUNCION PARA SABER SI SE VALIDARA EL STOCK
    /*===================================================================*/
    function getUpdateStockProductos() {
        $.ajax({
            url: "ajax/configuracion.ajax.php",
            type: "POST",
            data: {
                'accion': 1 // listar informacion de configuracion
            },
            dataType: "json",
            success: function(res) {
                update_stock_productos = parseInt(res.update_stock_productos);
                update_precios_productos = parseInt(res.update_precios_productos);
            }
        });
    }
    function existeImagen(url) {
        var xhr = new XMLHttpRequest();
        xhr.open('HEAD', url, false);
        xhr.send();
        return xhr.status === 200;
    }
    /*===================================================================*/
    // FUNCION PARA RECARGAR LA TABLA DE PRODUCTOS PARA QUE RECARGUE LOS ESTILOS DE CADA TABLA
    /*===================================================================*/
    function recargarTablaDataActual(){
        setTimeout(function() {
            tbl_productos.draw();
        }, 175);
    }
</script>
<?php else:?>
    <script>
        window.location = "./index.php";
    </script>
<?php endif; ?>