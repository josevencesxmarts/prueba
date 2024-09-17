<?php if(session_status() === PHP_SESSION_NONE) session_start(); ?>
<script>
    var validarUrl = window.location.toString().search('ventas');
    if(validarUrl > 0) { window.location = "../index.php"; }
</script>
<?php
    $existe = false;
    if(isset($_SESSION['lista_menus']) && isset($_SESSION['usuario'])){
        if(in_array("ventas.php", $_SESSION['lista_menus'])){
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
                <h1 class="m-0">Punto de venta</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item active">Ventas</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content" id="id_user_div"
    data-id-user="<?php echo $_SESSION['usuario']->id_usuario; ?>"
    data-nombre-user="<?php echo $_SESSION['usuario']->nombre.' '.$_SESSION['usuario']->apellido; ?>">
    <div class="container-fluid">
        <!-- row Tarjetas Informativas -->
        <div class="row">
            <nav class="w-100">
                <div class="nav nav-tabs" id="ventas-tab" role="tablist">
                    <a class="nav-item nav-link" id="plus-tab" href="#plus-list"><i class="fas fa-plus"></i></a>
                </div>
            </nav>
            <div class="tab-content p-3" id="nav-tabContent">
                <div class="tab-pane fade active show" id="venta-list" role="tabpanel" aria-labelledby="venta-tab">
                    <!-- row para listado de productos -->
                    <div class="row">
                        <!-- INPUT PARA INGRESO DEL CODIGO DE BARRAS O DESCRIPCION DEL PRODUCTO -->
                        <div class="col-md-12">
                            <div class="form-group mb-4">
                                <label class="col-form-label" for="iptCodigoVenta">
                                    <i class="fas fa-barcode fs-6"></i>
                                    <span class="small">Productos</span>
                                </label>
                                <input type="text" class="form-control form-control-sm" id="iptCodigoVenta"
                                    placeholder="Ingrese el código de barras o el nombre de producto">
                            </div>
                        </div>
                        <!-- LISTADO QUE CONTIENE LOS PRODUCTOS QUE SE VAN AGREGANDO PARA LA COMPRA -->
                        <div class="col-lg-12">
                            <table id="lstProductosVenta" class="table table-striped w-100 shadow">
                                <thead class="bg-info">
                                    <tr style="font-size: 15px;">
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>Producto</th>
                                        <th>Cant.</th>
                                        <th>Precio</th>
                                        <th>Total</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody class="text-small">
                                </tbody>
                            </table>
                        </div>
                        <!-- BOTONE PARA VACIAR LISTADO DE LA VENTA -->
                        <div class="col-lg-12 text-right">
                            <button class="btn btn-danger" id="btnVaciarListado">
                                <i class="fas fa-trash-alt"></i> Vaciar venta
                            </button>
                        </div>
                        <!-- ETIQUETA QUE MUESTRA LA SUMA TOTAL DE LOS PRODUCTOS AGREGADOS AL LISTADO -->
                        <div class="col-md-6">
                            <h1>Total: <span class="fw-bold text-danger">$</span> <span class="fw-bold text-danger" id="totalVenta">0.00</span></h1>
                        </div>
                        <!-- BOTONE PARA COMPLETAR LA VENTA -->
                        <div class="col-md-12 mb-3">
                            <button class="btn addNewRecord btn-lg w-100" data-bs-toggle="modal" data-bs-target="#btnIniciarVenta">
                                <i class="fas fa-shopping-cart"></i> Cobrar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->

<div class="modal fade" id="btnIniciarVenta" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header py-1 bg-primary text-white">
                <h3 class="text-center">
                    Total: $ <span id="totalVentaRegistrar">0.00</span>
                </h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-1 text-center">
                        <h1 class="fw-bold text-danger">
                            $ <span id="ticketTotal">0.00</span>
                        </h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label for="iptEfectivoRecibido" class="form-label">Efectivo recibido</label>
                        <input type="number" min="0" name="iptEfectivo" id="iptEfectivoRecibido" class="form-control"
                            placeholder="Cantidad de efectivo recibido">
                        <h4 class=text-center">
                            <label id="chgEfectAEntrgr">Debe $ 0.00</label>
                        </h4>
                    </div>
                </div>
                <div class="form-group">
                    <input type="checkbox" value="" name="iptEfectivo" id="chkEfectivoExacto">
                    <label for="chkEfectivoExacto">Efectivo Exacto</label>
                </div>
                <div class="row" style="display:none;">
                    <div class="col-7">
                        <h4 class="text-start fw-bold">TOTAL</h4>
                    </div>
                    <div class="col-5 text-right">
                        <h4 class="text-start text-danger fw-bold">
                            $ <span id="ticketTotal">0.00</span>
                        </h4>
                    </div>
                </div>
                <div class="row" style="display:none;">
                    <div class="col-7">
                        <h4 class="text-start fw-bold">PAGO CON:</h4>
                    </div>
                    <div class="col-5 text-right">
                        <h4 class="text-start text-danger fw-bold">
                            $ <span id="efectivoEntregado">0.00</span>
                        </h4>
                    </div>
                </div>
                <div class="row" style="display:none;">
                    <div class="col-7">
                        <h4 class="text-start fw-bold">SU CAMBIO:</h4>
                    </div>
                    <div class="col-5 text-right">
                        <h4 class="text-start text-danger fw-bold">
                            $ <span id="vuelto">0.00</span>
                        </h4>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Cerrar
                </button>
                <button class="btn addNewRecord" id="btnRealizarVenta">
                    <i class="fas fa-shopping-cart"></i> Cobrar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    this.product_by_id = {}
    this.product_by_barcode = {}
    function save_productos(lista_productos){
        for(var i = 0, len = lista_productos.length; i < len; i++){
            var data = lista_productos[i];
            this.product_by_barcode[data.codigo_barras] = data
            this.product_by_id[data.id_producto] = data
        }
    }
    function get_product_by_barcode(barcode){
        return this.product_by_barcode[barcode];
    }
    function get_product_by_id(id_producto){
        return this.product_by_id[id_producto];
    }
    // function set_update_product(producto){
    //     this.product_by_id[producto.id_producto] = producto;
    //     this.product_by_barcode[producto.codigo_barras] = producto
    // }

    var table;
    var items = []; // SE USA PARA EL INPUT DE AUTOCOMPLETE
    var venta_actual = {}; // SE USA PARA EL INPUT DE AUTOCOMPLETE
    var validar_stock = false; // SE USA PARA VALIDAR EL STOCK

    function initLocalStorages(){
        localStorage.setItem('ventas', JSON.stringify([]));
    }
    function setNewVentaLocalStorages(new_venta){
        const lista = getVentasLocalStorages();
        lista.push(new_venta);
        localStorage.setItem('ventas', JSON.stringify(lista));
    }
    function getVentasLocalStorages(){
        const lista = JSON.parse(localStorage.getItem('ventas'));
        return lista;
    }
    function updateListaVentaLocalStorages(index_venta, id_producto, cantidad){
        const ventas = getVentasLocalStorages();
        const venta = ventas.find(venta => venta.venta === index_venta);
        if(venta){
            let linea = venta.lineas.find(line => line.id_producto === id_producto);
            if(linea){
                linea.cantidad = cantidad;
            } else {
                venta.lineas.push({
                    id_producto: id_producto,
                    cantidad: cantidad,
                });
            }
            localStorage.setItem('ventas', JSON.stringify(ventas));
        }
    }
    function limpiarLineasVentaLocalStorages(index_venta){
        const ventas = getVentasLocalStorages();
        const venta = ventas.find(venta => venta.venta === index_venta);
        if(venta){
            venta.lineas = [];
            localStorage.setItem('ventas', JSON.stringify(ventas));
        }
    }
    function deleteLinesVentaLocalStorages(index_venta, lista_productos=[]){
        const ventas = getVentasLocalStorages();
        const venta = ventas.find(venta => venta.venta === index_venta);
        if(venta){
            let lineas_restantes = venta.lineas.filter(line => !lista_productos.includes(line.id_producto));
            venta.lineas = lineas_restantes;
            localStorage.setItem('ventas', JSON.stringify(ventas));
        }
    }
    function deleteVentasLocalStorages(lista=[]){
        const ventas = getVentasLocalStorages();
        const ventas_restantes = ventas.filter(venta => !lista.includes(venta.venta));
        localStorage.setItem('ventas', JSON.stringify(ventas_restantes));
    }
    // function deleteLocalStorages(){
    //     localStorage.setItem('ventas', JSON.stringify([]));
    // }

    var Toast = Swal.mixin({
        toast: true,
        position: 'top',
        showConfirmButton: false,
        timer: 3000
    });

    $(document).ready(function() {
        // deleteLocalStorages();
        /*===================================================================*/
        // INICIALIZAR LA TABLA DE VENTAS
        /*===================================================================*/
        table = $('#lstProductosVenta').DataTable({
            searching: false,
            columns: [{
                    "data": "venta"
                },
                {
                    "data": "id_producto"
                },
                {
                    "data": "cantidad"
                },
                {
                    "data": "descripcion_producto"
                },
                {
                    "data": "cantidad_editable"
                },
                {
                    "data": "precio_venta_producto"
                },
                {
                    "data": "total"
                },
                {
                    "data": "btn_aumentar_cantidad"
                },
                {
                    "data": "btn_disminuir_cantidad"
                },
                {
                    "data": "btn_eliminar_linea"
                },
                {
                    "data": "index"
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
                }, {
                    targets: 4,
                    width: '10%'
                }, {
                    targets: 5,
                    width: '10%'
                }, {
                    targets: 6,
                    width: '10%'
                }, {
                    targets: 7,
                    width: '10%',
                    render: function(data, type, full, meta) {
                        return "<center>" +
                            "<span data-index='"+meta.row+"' class='btnAumentarCantidad text-success px-2' style='cursor:pointer;' data-bs-toggle='tooltip' data-bs-placement='right'>" +
                            "<i class='fas fa-cart-plus fs-1'></i>" +
                            "</span>" +
                            "</center>"
                    }
                }, {
                    targets: 8,
                    width: '10%',
                    render: function(data, type, full, meta) {
                        return "<center>" +
                            "<span data-index='"+meta.row+"' class='btnDisminuirCantidad text-warning px-2' style='cursor:pointer;' data-bs-toggle='tooltip' data-bs-placement='right'>" +
                            "<i class='fas fa-cart-arrow-down fs-1'></i>" +
                            "</span>" +
                            "</center>"
                    }
                }, {
                    targets: 9,
                    width: '10%',
                    render: function(data, type, full, meta) {
                        return "<center>" +
                            "<span data-index='"+meta.row+"' class='btnEliminarProducto text-danger px-2' style='cursor:pointer;' data-bs-toggle='tooltip' data-bs-placement='right'>" +
                            "<i class='fas fa-trash fs-1'></i>" +
                            "</span>" +
                            "</center>"
                    }
                }, {
                    targets: 10,
                    visible: false
            }],
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
        // EVENTO AL DETECTAR CAMBIOS DE TAMAÑO DE NAVEGADOR PARA RECARGAR DATA
        // DE LAS TABLAS Y NO SE DISTORCIONE LA INF DEL ENCABEZADO
        /*===================================================================*/
        $(window).resize(function() {
            setTimeout(function() {
                table.draw();
            }, 175);
        });
        cargarProductosJS().then(function(data){
            loadVistaPdV();
            $("#ventas-tab").on('click','a#venta-tab',function(){
                $('.venta-tab').not(this).removeClass('active');
                $(this).attr('aria-selected', true);
                let row_venta = $(this).data('rowVenta');
                let venta = getVentasLocalStorages().find(line => line.venta === row_venta) || {};
                if(venta.venta){
                    setCargarVenta(venta.venta);
                }
            });
        });
        getValidStock();
        getProductosAutocomplete();
        /*===================================================================*/
        // EVENTO PARA AUMENTAR LA CANTIDAD DE UN PRODUCTO DEL LISTADO
        /*===================================================================*/
        $("#lstProductosVenta tbody").on('click', '.btnAumentarCantidad', function() {
            let row_linea = table.row($(this).data('index')).data();
            let venta = getVentasLocalStorages().find(venta => venta.venta === row_linea.venta);
            if(venta){
                let linea = venta.lineas.find(line => line.id_producto === row_linea.id_producto);
                if(linea){
                    let cantidad_nueva = parseFloat(linea.cantidad) + 1;
                    if(validarStock(cantidad_nueva, get_product_by_id(linea.id_producto))){
                        updateListaVentaLocalStorages(row_linea.venta, linea.id_producto, cantidad_nueva);
                        setCargarVenta(venta.venta);
                    }
                }
            }
        });
        /*===================================================================*/
        // EVENTO PARA AUMENTAR LA CANTIDAD DE UN PRODUCTO DEL LISTADO
        /*===================================================================*/
        $("#lstProductosVenta tbody").on('click', '.btnAumentCantMasiva', function() {
            Swal.fire({
                title: "",
                text: "Cantidad de productos a vender",
                input: "number",
                width: 300,
                confirmButtonText: "Agregar",
                showCancelButton: true
            }).then((result) => {
                if (result.value) {
                    if(result.value <= 0){
                        Swal.fire({
                            position: 'center',
                            icon: 'warning',
                            title: 'La cantidad del producto debe ser mayor a 0!',
                            showConfirmButton: false,
                            timer: 2000
                        });
                        return;
                    }
                    let row_linea = table.row($(this).data('index')).data();
                    let venta = getVentasLocalStorages().find(venta => venta.venta === row_linea.venta);
                    if(venta){
                        let linea = venta.lineas.find(line => line.id_producto === row_linea.id_producto);
                        if(linea){
                            row_linea.cantidad = parseFloat(result.value);
                            if(validarStock(row_linea.cantidad, get_product_by_id(row_linea.id_producto))){
                                updateListaVentaLocalStorages(row_linea.venta, row_linea.id_producto, row_linea.cantidad);
                                setCargarVenta(venta.venta);
                            }
                        }
                    }
                }
            });
        });
        /*===================================================================*/
        // EVENTO PARA DISMINUIR LA CANTIDAD DE UN PRODUCTO DEL LISTADO
        /*===================================================================*/
        $("#lstProductosVenta tbody").on('click', '.btnDisminuirCantidad', function() {
            let row_linea = table.row($(this).data('index')).data();
            let venta = getVentasLocalStorages().find(venta => venta.venta === row_linea.venta);
            if(venta.lineas){
                let linea = venta.lineas.find(line => line.id_producto === row_linea.id_producto);
                if(linea.cantidad && linea.cantidad >= 2){
                    let cantidad_nueva = parseFloat(linea.cantidad) - 1;
                    if(validarStock(cantidad_nueva, get_product_by_id(linea.id_producto))){
                        updateListaVentaLocalStorages(row_linea.venta, linea.id_producto, cantidad_nueva);
                        setCargarVenta(venta.venta);
                    }
                }
            }
        })
        /*===================================================================*/
        // EVENTO QUE ELIMINARA EL PRODUCTO DEL LISTADO
        /*===================================================================*/
        $("#lstProductosVenta tbody").on('click', '.btnEliminarProducto', function() {
            let linea = table.row($(this).data('index')).data();
            deleteLinesVentaLocalStorages(linea.venta, [linea.id_producto]);
            setCargarVenta(linea.venta);
        })
        /*===================================================================*/
        // EVENTO QUE REGISTRA EL PRODUCTO EN EL LISTADO CUANDO SE INGRESE EL CODIGO DE BARRAS
        /*===================================================================*/
        $("#btnVaciarListado").on('click', function() {
            let venta = getVentasLocalStorages().find(venta => venta.venta === venta_actual.venta);
            if(venta){
                let ids_productos = venta.lineas.map(line => (line.id_producto));
                deleteLinesVentaLocalStorages(venta.venta, ids_productos);
                setCargarVenta(venta_actual.venta);
            }
        })
        $("#plus-tab").on('click',function(){
            let new_name_venta = 1;
            let ventas = getVentasLocalStorages();
            if(ventas.length){
                let ids_ventas = ventas.map(venta => (venta.venta));
                new_name_venta = Math.max(...ids_ventas) + 1;
            }
            $('.venta-tab').removeClass('active');
            setNewVentaLocalStorages({
                venta: new_name_venta,
                lineas: [],
            });
            setCargarNuevaPestañaVenta('active',true,new_name_venta);
            $('a#venta-tab.active').click();
        });
        /*===================================================================*/
        // EVENTO QUE REGISTRA EL PRODUCTO EN EL LISTADO CUANDO SE INGRESE EL CODIGO DE BARRAS
        /*===================================================================*/
        $("#iptCodigoVenta").change(function() {
            setInsertNewProductoVenta($('#iptCodigoVenta').val());
        })
        /*===================================================================*/
        // EVENTO QUE PERMITE CHECKEAR EL EFECTIVO CUANDO ES EXACTO
        /*===================================================================*/
        $("#chkEfectivoExacto").change(function() {
            var totalVenta = $("#totalVenta").html().replace(',', '');
            var finTotalVenta = format_currency_amount(totalVenta).replace('$', '');
            $('#chgEfectAEntrgr').removeClass('text-success text-danger');
            $('#iptEfectivoRecibido').removeClass('is-valid is-invalid');
            if ($("#chkEfectivoExacto").is(":checked")) {
                var vuelto = 0;
                $('#iptEfectivoRecibido').addClass('is-valid');
                $('#iptEfectivoRecibido').val(totalVenta);
                $('#efectivoEntregado').html(finTotalVenta);
                vuelto = parseFloat(totalVenta) - parseFloat(totalVenta)
                $("#vuelto").html(vuelto.toFixed(2));
                $('#chgEfectAEntrgr').addClass('text-success');
                $('#chgEfectAEntrgr').html('Su cambio es de $ 0.00');
            } else {
                $('#chgEfectAEntrgr').addClass('text-danger');
                $('#chgEfectAEntrgr').html('Debe $ ' + String(finTotalVenta));
                $('#iptEfectivoRecibido').addClass('is-invalid');
                $('#iptEfectivoRecibido').val('');
                $('#efectivoEntregado').html('0.00');
                $("#vuelto").html('0.00');
            }
        })
        /*===================================================================*/
        // EVENTO QUE SE DISPARA AL DIGITAR EL MONTO EN EFECTIVO ENTREGADO POR EL CLIENTE
        /*===================================================================*/
        $("#iptEfectivoRecibido").keyup(function() {
            var totalVenta = $("#totalVenta").html().replace(',', '');
            $("#chkEfectivoExacto").prop("checked", false);
            var efectivoRecibido = $('#iptEfectivoRecibido').val();
            if (efectivoRecibido > 0) {
                var finEfectivoEngregado = format_currency_amount(parseFloat(efectivoRecibido).toFixed(2)).replace('$', '');
                $('#efectivoEntregado').html(finEfectivoEngregado);
                var totalVenta_ = parseFloat(totalVenta)
                var efectivoRecibido_ = parseFloat(efectivoRecibido)
                var vuelto = (efectivoRecibido_ - totalVenta_).toFixed(2);
                var tf = (totalVenta_ - efectivoRecibido_).toFixed(2);
                var finVuelto = format_currency_amount(vuelto).replace('$', '');
                var fintf = format_currency_amount(tf).replace('$', '');
                $('#chgEfectAEntrgr').removeClass('text-danger text-success');
                $('#iptEfectivoRecibido').removeClass('is-valid is-invalid');
                if(tf == 0){
                    $('#iptEfectivoRecibido').addClass('is-valid');
                    $('#chgEfectAEntrgr').addClass('text-success');
                    $('#chgEfectAEntrgr').html('Su cambio es de $ 0.00');
                }else if(tf > 0) {
                    $('#iptEfectivoRecibido').addClass('is-invalid');
                    $('#chgEfectAEntrgr').addClass('text-danger');
                    $('#chgEfectAEntrgr').html('Debe $ ' + String(fintf));
                }else{
                    $('#iptEfectivoRecibido').addClass('is-valid');
                    $('#chgEfectAEntrgr').addClass('text-success');
                    $('#chgEfectAEntrgr').html('Su cambio es de $ ' + String(finVuelto));
                }
                $("#vuelto").html(finVuelto);
            } else {
                $('#iptEfectivoRecibido').addClass('is-invalid');
                $('#chgEfectAEntrgr').html('Debe $ ' + String(totalVenta));
                $('#efectivoEntregado').html('0.00');
                $("#vuelto").html('0.00');
            }
        })
        /*===================================================================*/
        // EVENTO PARA REALIZAR EL REGISTRO DE LA VENTA EN LA BD
        /*===================================================================*/
        $('#btnRealizarVenta').on('click', function() {
            realizarVenta();
        });
        $('#btnIniciarVenta').on('shown.bs.modal', function(event) {
            $('#iptEfectivoRecibido').focus();
        });
    });
    function loadVistaPdV(){
        $('#ventas-tab').children().not('#plus-tab').remove();
        if(!getVentasLocalStorages()){
            initLocalStorages();
        }
        if(getVentasLocalStorages().length === 0){
            setCargarNuevaPestañaVenta('active',true,1);
            let venta1 = {
                venta: 1,
                lineas: [],
            }
            setNewVentaLocalStorages(venta1);
            venta_actual = venta1;
            setCargarVenta(1);
        } else {
            let contar = 1;
            getVentasLocalStorages().forEach(function(venta){
                let estado = '';
                let selected = false;
                if(contar === 1){
                    estado = 'active';
                    selected = true;
                    setCargarVenta(venta.venta);
                }
                setCargarNuevaPestañaVenta(estado,selected,venta.venta);
                contar+=1;
            });
        }
    }
    /*===================================================================*/
    // FUNCION PARA LISTAR PRODUCTOS POR SU CODIGO DE BARRAS PARA FILTRAR DESDE JS CUANDO SE REALIZE BUSQUEDAS
    /*===================================================================*/
    function cargarProductosJS() {
        return $.ajax({
            'url': 'ajax/productos.ajax.php',
            'method': 'POST',
            'data': {
                'accion': 8, // FILTRAR PRODUCTOS POR SU CODIGO DE BARRAS
            },
            'dataType': 'json',
            'async': true,
            'success': function(respuesta) {
                save_productos(respuesta)
            },
            error: function (respuesta) {
                Swal.fire({
                    position: 'center',
                    icon:'error',
                    title: 'Ocurrio un error, cheque su conexion a internet!',
                });
            }
        });
    }
    /*===================================================================*/
    // FUNCION PARA SABER SI SE VALIDARA EL STOCK
    /*===================================================================*/
    function getValidStock() {
        $.ajax({
            url: "ajax/configuracion.ajax.php",
            type: "POST",
            data: {
                'accion': 1 // listar informacion de configuracion
            },
            dataType: "json",
            success: function(res) {
                if(res.validar_stock == "1"){
                    validar_stock = true;
                }
            }
        });
    }
    /*===================================================================*/
    // TRAER LISTADO DE PRODUCTOS PARA INPUT DE AUTOCOMPLETADO
    /*===================================================================*/
    function getProductosAutocomplete() {
        $.ajax({
            async: false,
            url: 'ajax/productos.ajax.php',
            method: 'POST',
            data: {
                'accion': 7
            },
            dataType: 'json',
            success: function(respuesta) {
                for (let i = 0; i < respuesta.length; i++) {
                    items.push({ value : respuesta[i]['id_producto'], label : respuesta[i]['descripcion_producto']});
                }
                $('#iptCodigoVenta').autocomplete({
                    source: items,
                    minLength: 1,
                    // autoFocus: true,
                    select: function(event, ui) {
                        setInsertNewProductoVenta(ui.item.value);
                        return false;
                    }
                });
            }
        });
    }
    function setCargarNuevaPestañaVenta(estado='',selected=false,venta=0){
        let etiqueta_a = '<a class="nav-item nav-link venta-tab '+estado+'" data-row-venta="'+venta+'" id="venta-tab" data-toggle="tab" href="#venta-list" role="tab" aria-controls="venta-list" aria-selected="'+selected+'">Venta '+venta+'</a>';
        $(etiqueta_a).insertBefore('#plus-tab');
    }
    function setCargarVenta(index_venta){
        let cont_lines_ventas = 0
        table.clear();
        $('#totalVenta').html('0.00');
        $('#totalVentaRegistrar').html('0.00');
        $('#ticketTotal').html('0.00');
        $('#chgEfectAEntrgr').html('Debe $ 0.00');
        let search_venta = getVentasLocalStorages().find(venta => venta.venta === index_venta);
        if(search_venta.venta){
            let validar_productos_existen = true;
            search_venta.lineas.forEach(function(data){
                let product_db = get_product_by_id(data.id_producto);
                if(product_db){
                    let precio = parseFloat(product_db.precio).toFixed(2);
                    let cantidad = parseFloat(data.cantidad).toFixed(2);
                    let subtotal = cantidad * precio;
                    table.row.add({
                        'venta': search_venta.venta,
                        'id_producto': product_db.id_producto,
                        'cantidad': data.cantidad,
                        'descripcion_producto': product_db.descripcion_producto,
                        'cantidad_editable': '<span data-index="'+cont_lines_ventas+'" class="btnAumentCantMasiva fw-bold text-primary px-1 fs-1" style="cursor:pointer;">'+data.cantidad+'</span> '+product_db.udm || '',
                        'precio_venta_producto':  format_currency_amount(precio),
                        'total': format_currency_amount(subtotal),
                        'index': cont_lines_ventas
                    });
                    cont_lines_ventas += 1
                } else {
                    validar_productos_existen = false;
                }
            });
            if(!validar_productos_existen){
                Swal.fire({
                    title: "No se encuentra el producto que se tenia agregado en el carrito",
                    icon: 'error',
                    confirmButtonText: "Limpiar Venta",
                    showCancelButton: true,
                    cancelButtonText: 'Cancelar',
                    // width: 300,
                }).then((result) => {
                    if(result.isConfirmed){
                        limpiarLineasVentaLocalStorages(search_venta.venta);
                        loadVistaPdV();
                    }
                });
            }
            recalcularTotales(search_venta);
            venta_actual = search_venta;
        }
        table.draw();
    }
    function setInsertNewProductoVenta(search){
        // $('.loader').fadeIn(1000);
        let product_db = '';
        if (search != "") {
            // EVENTO CUANDO SE INGRESE EL CODIGO DE BARRAS AL PRESIONAR ENTER
            product_db = get_product_by_barcode(search);
            // EVENTO CUANDO SE SELECCIONE UNA OPCION DEL LISTADO DE BUSQUEDA
            if(product_db === undefined) {
                product_db = get_product_by_id(search);
            }
        }
        $('#iptCodigoVenta').val('');
        $('#iptCodigoVenta').focus();
        if(product_db === undefined){
            Toast.fire({
                icon: 'warning',
                title: 'No existe el producto',
            });
            var snd = new Audio("vistas/assets/sounds/error.wav");
            snd.play();
            return;
        }
        let search_venta = getVentasLocalStorages().find(venta => venta.venta === venta_actual.venta);
        if(search_venta){
            let hay_stock = true;
            let valid_existe_product = search_venta.lineas.find(line => line.id_producto === product_db.id_producto);
            if(valid_existe_product){
                let find_index_line_update = search_venta.lineas.findIndex(line => line.id_producto === product_db.id_producto);
                if(find_index_line_update !== -1){
                    let cant_antes = search_venta.lineas[find_index_line_update].cantidad;
                    cant_antes = parseFloat(cant_antes) + 1;
                    if(validarStock(cant_antes, get_product_by_id(product_db.id_producto))){
                        updateListaVentaLocalStorages(venta_actual.venta, product_db.id_producto, cant_antes);
                    } else {
                        hay_stock = false;
                    }
                }
            } else {
                if(validarStock(1, get_product_by_id(product_db.id_producto))){
                    updateListaVentaLocalStorages(venta_actual.venta, product_db.id_producto, 1);
                } else {
                    hay_stock = false;
                }
            }
            if(hay_stock){
                var snd = new Audio("vistas/assets/sounds/bell.wav");
                snd.play();
                setCargarVenta(search_venta.venta);
            }
        }
    }
    /*===================================================================*/
    // FUNCION PARA RECALCULAR LOS TOTALES DE LA VENTA
    /*===================================================================*/
    function recalcularTotales(venta) {
        if(venta.lineas){
            let totalVenta = 0;
            venta.lineas.forEach(function(line){
                let product_db = get_product_by_id(line.id_producto);
                totalVenta += parseFloat(line.cantidad) * parseFloat(product_db.precio);
            });
            let round_total_venta = Math.round(totalVenta.toFixed(2));
            var finTotalVenta = format_currency_amount(round_total_venta).replace('$', '')
            $('#totalVenta').html('');
            $('#totalVenta').html(finTotalVenta);
            $('#totalVentaRegistrar').html(finTotalVenta);
            $('#ticketTotal').html(finTotalVenta);

            $('#chgEfectAEntrgr').removeClass('text-success');
            $('#chgEfectAEntrgr').removeClass('text-danger');
            if(totalVenta.toFixed(2) > 0){
                $('#chgEfectAEntrgr').addClass('text-danger');
                $('#chgEfectAEntrgr').html('Debe $ ' + String(finTotalVenta));
            }else {
                $('#chgEfectAEntrgr').addClass('text-success');
                $('#chgEfectAEntrgr').html('Su cambio es de $ 0.00');
            }
            $('#iptEfectivoRecibido').removeClass('is-valid is-invalid');
            $('#iptEfectivoRecibido').val('');
            $("#chkEfectivoExacto").prop("checked", false);
            $('#efectivoEntregado').html('0.00');
            $("#vuelto").html('0.00');
            // window.navigator.vibrate(300);
        }
    }
    /*===================================================================*/
    // FUNCION PARA REALIZAR VENTA
    /*===================================================================*/
    async function realizarVenta() {
        let search_venta = getVentasLocalStorages().find(venta => venta.venta === venta_actual.venta);
        if(search_venta){
            if(search_venta.lineas.length == 0){
                Toast.fire({
                    icon: 'warning',
                    title: 'No hay productos en el listado'
                });
                return false;
            }
            if(parseFloat($('#iptEfectivoRecibido').val()) < 0 || $('#iptEfectivoRecibido').val() == ""){
                Toast.fire({
                    icon: 'warning',
                    title: 'Ingrese el monto en efectivo'
                });
                return false;
            }
            let id_user = $('#id_user_div').data('idUser');
            let usuario = $('#id_user_div').data('nombreUser');
            if((id_user === undefined || id_user === null) && (usuario == undefined || usuario === null)){
                Toast.fire({
                    icon: 'warning',
                    title: 'No se puede leer la informacion del usuario loguiado, intente recargando la pagina'
                });
                return false;
            }
            let arr = [];
            let det_venta_ticket = [];
            let total_venta = 0.00;
            let count_products = 0;
            let validar_stock_producto = true;
            if(validar_stock){
                console.log('recargar stock base de datos');
                await cargarProductosJS();
            }
            search_venta.lineas.forEach(function(line, index, array){
                let product_db = get_product_by_id(line.id_producto);
                if(validar_stock){
                    if(!validarStock(line.cantidad, product_db)){
                        validar_stock_producto = false;
                    }
                }
                let precio = product_db.precio;
                let cantidad = line.cantidad;
                let utilidad = product_db.utilidad;
                let stock = product_db.stock;
                let subtotal = cantidad * precio;
                let utilidad_total = cantidad * utilidad;
                let stock_actualizado = stock - cantidad
                arr[index] = product_db.id_producto + ',' +
                            line.cantidad + ',' + 
                            precio + ',' +
                            utilidad_total + ',' +
                            subtotal + ',' +
                            stock_actualizado
                det_venta_ticket[index] = {
                    producto: product_db.descripcion_producto,
                    cantidad: line.cantidad,
                    precio_unitario_concat: format_currency_amount(precio),
                    subtotal_concat: format_currency_amount(subtotal)
                }
                total_venta += subtotal;
                count_products += line.cantidad;
            });
            if(!validar_stock_producto){
                return false;
            }
            let round_total_venta = Math.round(total_venta);
            var cambio = (parseFloat($('#iptEfectivoRecibido').val()) - round_total_venta).toFixed(2);
            if(parseFloat($('#iptEfectivoRecibido').val()) < round_total_venta){
                Toast.fire({
                    icon: 'warning',
                    title: 'El efectivo es menor al costo total de la venta'
                });
                return false;
            }
            $(".content-header").addClass("loader");
            $.ajax({
                type: 'POST',
                url: 'ajax/ventas.ajax.php',
                xhrFields: {
                    responseType: 'blob'
                },
                data: {
                    'accion': 3,
                    'cant_productos': count_products,
                    'total_venta': round_total_venta,
                    'total_concat': format_currency_amount(round_total_venta),
                    'cambio': cambio,
                    'cambio_concat': format_currency_amount(cambio),
                    'arr': arr,
                    'det_venta_ticket': det_venta_ticket,
                    'id_usuario': id_user,
                    'usuario': usuario,
                },
                success: function (json) {
                    if(validar_stock){
                        cargarProductosJS();
                    }
                    if(json.type == 'application/pdf'){
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Ok',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $('#btnIniciarVenta').modal('hide');
                        deleteVentasLocalStorages([venta_actual.venta]);
                        loadVistaPdV();
                        $('#iptEfectivoRecibido').val('');
                        $("#chkEfectivoExacto").prop("checked", false);
                        $('#efectivoEntregado').html('0.00');
                        $("#vuelto").html('0.00');
                        $(".content-header").removeClass("loader");
                        var a = document.createElement('a');
                        var url = window.URL.createObjectURL(json);
                        a.href = url;
                        a.download = 'ticket.pdf';
                        a.click();
                        window.URL.revokeObjectURL(url);
                    } else {
                        $(".content-header").removeClass("loader");
                        Swal.fire({
                            position: 'center',
                            icon:'error',
                            title: 'Error al registrar la venta',
                        });
                    }
                },
                error: function (respuesta) {
                    Swal.fire({
                        position: 'center',
                        icon:'error',
                        title: 'Ocurrio un error, cheque su conexion a internet!',
                    });
                    $(".content-header").removeClass("loader");
                }
            });
        }
        $('#iptCodigoVenta').focus();
    }
    /*===================================================================*/
    // FUNCION PARA DAR FORMATO DE MONEDA A UN MONTO
    /*===================================================================*/
    function format_currency_amount(amount=0){
        const options = { style: 'currency', currency: 'USD' };
        const numberFormat = new Intl.NumberFormat('en-US', options);
        return numberFormat.format(amount);
    }
    /*===================================================================*/
    // FUNCION PARA VALIDAR EL STOCK
    /*===================================================================*/
    function validarStock(cantidad=0, product_db={}){
        if(!validar_stock) return true;
        if(product_db.stock == 0){
            Toast.fire({
                icon: 'warning',
                title: 'PRODUCTO AGOTADO',
            });
            var snd = new Audio("vistas/assets/sounds/error.wav");
            snd.play();
            return false;
        }
        if(cantidad > product_db.stock){
            Toast.fire({
                icon: 'warning',
                title: 'No existe suficiente stock del producto ' + product_db.descripcion_producto + ', solo existen ' + product_db.stock + ' productos',
            });
            var snd = new Audio("vistas/assets/sounds/error.wav");
            snd.play();
            return false;
        } else {
            return true;
        }
    }
</script>
<?php else:?>
    <script>
        window.location = "./index.php";
    </script>
<?php endif; ?>