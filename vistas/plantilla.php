<?php
    session_start();
    if(isset($_GET['cerrar_sesion']) && $_GET['cerrar_sesion'] == 1){
        session_destroy();
        echo '
            <script>
                window.location = "./index.php";
            </script>
        ';
    }
?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LORET JUVENIL</title>

    <link rel="shortcut icon" href="vistas/assets/dist/img/AdminLTELogo.png" type="image/x-icon">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="vistas/assets/css/fonts_googleapis.css">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="vistas/assets/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="vistas/assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- Jquery CSS -->
    <link href="vistas/assets/plugins/jquery-ui/css/jquery-ui.css" rel="stylesheet">
    <!-- Bootstrap 5 -->
    <link href="vistas/assets/css/bootstrap.min.css" rel="stylesheet">
    <!-- JSTREE CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" />
    <!-- ============================================================
    =ESTILOS PARA USO DE DATATABLES JS
    ===============================================================-->
    <link href="https://cdn.datatables.net/2.1.3/css/dataTables.dataTables.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/3.1.1/css/buttons.dataTables.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/fixedcolumns/5.0.1/css/fixedColumns.dataTables.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/fixedheader/4.0.1/css/fixedHeader.dataTables.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.dataTables.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/searchbuilder/1.7.1/css/searchBuilder.dataTables.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/searchpanes/2.3.1/css/searchPanes.dataTables.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/select/2.0.4/css/select.dataTables.css" rel="stylesheet">

    <!-- <link rel="stylesheet" href="vistas/assets/css/jquery.dataTables.min.css"> -->
    <!-- <link rel="stylesheet" href="vistas/assets/css/responsive.dataTables.min.css"> -->
    <!-- <link rel="stylesheet" href="vistas/assets/css/buttons.dataTables.min.css"> -->
    <!-- Theme style -->
    <link rel="stylesheet" href="vistas/assets/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="vistas/assets/dist/css/plantilla.css">

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="vistas/assets/plugins/jquery/jquery.min.js"></script>
    <!-- ChartJS -->
    <script src="vistas/assets/plugins/chart.js/Chart.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="vistas/assets/plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- Jquery UI js -->
    <script src="vistas/assets/plugins/jquery-ui/js/jquery-ui.js"></script>
    <!-- Bootstrap 4 -->
    <script src="vistas/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- JS Bootstrap 5 -->
    <script src="vistas/assets/js/bootstrap.bundle.min.js"></script>
    <!-- JSTREE JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script>
    <!-- ============================================================
    =LIBRERIAS PARA USO DE DATATABLES JS
    ===============================================================-->
    <script src="https://cdn.datatables.net/2.1.3/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.1/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/fixedcolumns/5.0.1/js/dataTables.fixedColumns.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/4.0.1/js/dataTables.fixedHeader.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.js"></script>
    <script src="https://cdn.datatables.net/searchbuilder/1.7.1/js/dataTables.searchBuilder.js"></script>
    <script src="https://cdn.datatables.net/searchpanes/2.3.1/js/dataTables.searchPanes.js"></script>
    <script src="https://cdn.datatables.net/select/2.0.4/js/dataTables.select.js"></script>

    <!-- <script src="vistas/assets/js/jquery.dataTables.min.js"></script> -->
    <!-- <script src="vistas/assets/js/dataTables.responsive.min.js"></script> -->
    <!-- ============================================================
    =LIBRERIAS PARA EXPORTAR A ARCHIVOS
    ===============================================================-->
    <script src="vistas/assets/js/dataTables.buttons.min.js"></script>
    <script src="vistas/assets/js/jszip.min.js"></script>
    <script src="vistas/assets/js/buttons.html5.min.js"></script>
    <script src="vistas/assets/js/buttons.print.min.js"></script>
    <!-- AdminLTE App -->
    <script src="vistas/assets/dist/js/adminlte.min.js"></script>
    <script src="vistas/assets/dist/js/plantilla.js"></script>
    <!-- QRCode -->
    <script src="vistas/assets/dist/js/QRCode.js"></script>
</head>
<?php if(isset($_SESSION['usuario'])): ?>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">
        <?php
        include "modulos/navbar.php";
        include "modulos/aside.php";
        ?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <input type="hidden" id='pagina_recargada' value="<?php echo $_SESSION['usuario']->vista_inicio; ?>">
            <?php
                $lista_menus = $_SESSION['lista_menus'];
                if(isset($lista_menus)){
                    if(in_array($_SESSION['usuario']->vista_inicio, $lista_menus)){
                        include "vistas/".$_SESSION['usuario']->vista_inicio;
                    }
                }
            ?>
        </div>
        <!-- /.content-wrapper -->
        <?php include "modulos/footer.php"; ?>
    </div>
    <!-- ./wrapper -->
    <script>
        var Toast = Swal.mixin({
            toast: true,
            position: 'top',
            showConfirmButton: false,
            timer: 3000
        });
        var codigo_de_barras = ''; // SE USA PARA GUARDAR EL CODIGO DE BARRAS DEL LECTOR
        var pagina_actual = '' // PARA SABER EN QUE PAGINA SE ENCUENTRA ACTUALMENTE
        var stateBtnClickAddProduct = false; // ESTADO PARA SABER SI SE ENCUENTRA ABIERTO EL MODAL DE PRODUCTOS
        let domain_productos = [];
        $(document).ready(function() {
            pagina_actual = $('#pagina_recargada').val();
        });
        function CargarContenido(pagina_php, contenedor) {
            $(".content-header").addClass("loader");
            codigo_de_barras = '';
            pagina_actual = '';
            if(pagina_php == 'vistas/productos.php'){
                domain_productos = [];
                pagina_actual = 'productos.php';
            } else if(pagina_php == 'vistas/punto_de_venta.php'){
                pagina_actual = 'punto_de_venta.php';
            }
            $('.' + contenedor).load(pagina_php,
                function(response, status, xhr) {
                    if(status == "error") {
                        Swal.fire({
                            position: 'center',
                            icon:'error',
                            title: 'Ocurrio un error, cheque su conexion a internet!',
                        });
                    }
                    $(".content-header").removeClass("loader");
                }
            );
        }
        $(document).keypress(function(e) {
            if(pagina_actual == 'punto_de_venta.php'){
                if(e.target.tagName.toLowerCase() !== 'input'){
                    if(e.which != 13){
                        codigo_de_barras += e.key.toString();
                        return;
                    }
                    $('#iptCodigoVenta').val('');
                    $('#iptCodigoVenta').focus();
                    setInsertNewProductoVenta(codigo_de_barras);
                    codigo_de_barras = '';
                }
            } else if(pagina_actual == 'productos.php'){
                if(e.target.tagName.toLowerCase() !== 'input'){
                    if(stateBtnClickAddProduct)
                        return;
                    $('#mdlGestionarProductos').modal('hide');
                    if(e.which != 13){
                        codigo_de_barras += e.key.toString();
                        return;
                    }
                    $("#dt-search-1").val('');
                    $("#dt-search-1").val(codigo_de_barras);
                    tbl_productos.column(12).search(codigo_de_barras).draw();
                    if(codigo_de_barras){
                        const count_rows = tbl_productos['context'][0]['aiDisplay'].length;
                        if(count_rows === 1){
                            tbl_productos.rows().data().each(function (data, index) {
                                var res = data.codigo_barras.toString().search(codigo_de_barras)
                                if(res === 0){
                                    modalEditarProducto(index);
                                }
                            });
                        }
                        codigo_de_barras = '';
                    }
                }
            }
        });
    </script>
</body>
<?php else: ?>
    <body>
        <?php include "vistas/login.php"; ?>
    </body>
<?php endif;?>
</html>