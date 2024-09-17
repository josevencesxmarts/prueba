<?php
    $menusPerfil = UsuariosControlador::ctrGetMenuPerfil($_SESSION['usuario']->id_usuario);
?>
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index.php" class="brand-link">
        <img src="vistas/assets/dist/img/AdminLTELogo.png" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">LORET JUVENIL</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <img src="vistas/assets/dist/img/user1-128x128.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
            <a href="#" class="d-block"><?php echo $_SESSION['usuario']->nombre.' '.$_SESSION['usuario']->apellido ?></a>
        </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
                <?php 
                    $lista_menus = array();
                    $lista_acceso_modulos = array();
                ?>
                <?php foreach($menusPerfil as $menu): ?>
                    <?php
                        array_push($lista_menus, $menu->vista);
                        array_push($lista_acceso_modulos, $menu);
                    ?>
                    <li class="nav-item">
                        <a style='cursor: pointer;'
                            class="nav-link <?php if($menu->vista === $_SESSION['usuario']->vista_inicio){ echo 'active';}?>"
                            <?php if(!empty($menu->vista)):?>
                                onclick="CargarContenido('vistas/<?php echo $menu->vista; ?>','content-wrapper')"
                            <?php endif;?>
                            >
                            <i class="nav-icon <?php echo $menu->icon_menu; ?>"></i>
                            <p>
                                <?php echo $menu->modulo; ?>
                                <?php if(empty($menu->vista)): ?>
                                    <i class="right fas fa-angle-left"></i>
                                <?php endif;?>
                            </p>
                        </a>
                        <?php if(empty($menu->vista)): ?>
                            <?php
                                $subMenuPerfil = UsuariosControlador::ctrGetSubMenuPerfil($menu->id_modulo, $_SESSION['usuario']->id_usuario);
                            ?>
                            <?php foreach($subMenuPerfil as $subMenu): ?>
                                <?php
                                    array_push($lista_menus, $subMenu->vista);
                                    array_push($lista_acceso_modulos, $subMenu);
                                ?>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a style='cursor: pointer;'
                                            class="button nav-link <?php if($subMenu->vista === $_SESSION['usuario']->vista_inicio){ echo 'active';}?>"
                                            onclick="CargarContenido('vistas/<?php echo $subMenu->vista; ?>','content-wrapper')">
                                            <i class="nav-icon <?php echo $subMenu->icon_menu; ?>"></i>
                                            <p><?php echo $subMenu->modulo; ?></p>
                                        </a>
                                    </li>
                                </ul>
                            <?php endforeach; ?>
                        <?php endif;?>
                    </li>
                <?php endforeach; ?>
                <?php $_SESSION['lista_menus'] = $lista_menus; ?>
                <?php $_SESSION['lista_acceso_modulos'] = $lista_acceso_modulos; ?>
                <li class="nav-item">
                    <a href="index.php?cerrar_sesion=1" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>
                            Cerrar Sesión
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
    <script>
        $('.nav-link').on('click',function() {
            $('.nav-link').removeClass('active');
            $(this).addClass('active');
        })
    </script>
</aside>