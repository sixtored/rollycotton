<?php
    $us_session = session() ;
?>


<!DOCTYPE html>
<html lang="sp">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>SIXTORED</title>
    <!--
    <link href="<?php echo base_url(); ?>/css/table_style.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>/css/select.bootstrap5.min.css" rel="stylesheet" />
-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/datatables/Bootstrap-5-5.1.3/css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/datatables/DataTables-1.12.1/css/dataTables.bootstrap5.min.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/datatables/Buttons-2.2.3/css/buttons.bootstrap5.min.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/datatables/ColReorder-1.5.6/css/colReorder.bootstrap5.min.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/datatables/Responsive-2.3.0/css/responsive.bootstrap5.min.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/datatables/Scroller-2.0.7/css/scroller.bootstrap5.min.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/datatables/Select-1.4.0/css/select.bootstrap5.min.css"/>

    <link href="<?php echo base_url(); ?>/css/styles.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>/js/jquery-ui/jquery-ui.min.css" rel="stylesheet" />
    <script src="<?php echo base_url(); ?>/js/all.min.js"></script>
    <!--
    <script src="<?php echo base_url(); ?>/js/jquery.min.js"></script>
-->
    <script src="<?php echo base_url(); ?>/js/jquery-ui/external/jquery/jquery.js"></script>
    <script src="<?php echo base_url(); ?>/js/jquery-ui/jquery-ui.min.js"></script>
    <script src="<?php echo base_url(); ?>/js/Chart.min.js"></script>
</head>

<style>
    /*estilos para la tabla*/
table th {
    background-color: #337ab7 !important;
    color: white;
}
table>tbody>tr>td {
    vertical-align: middle !important;
}

</style>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="<?php echo base_url(); ?>/inicio">SIXTORED</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>

        <!-- Navbar
        <ul class="navbar-nav ms-auto me-3 me-0 me-md-3 my-2 my-md-0">
            <li class="nav-item">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><?php echo $us_session->nombre ;?><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#!"><i class="fas fa-user-alt"></i> Perfil</a></li>
                    <li><a class="dropdown-item" href="<?php echo base_url();?>/usuarios/cambiar_contrasenia"><i class="fas fa-key"></i> Cambiar Contraseña</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="<?php echo base_url(); ?>/usuarios/logout"><i class="fas fa-sign-out-alt"></i> Cerrar sesion</a></li>
                </ul>
            </li>
        </ul>
-->
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <!--
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-shopping-basket"></i></div>
                            Productos
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="<?php echo base_url(); ?>/productos">Productos</a>
                                <a class="nav-link" href="<?php echo base_url(); ?>/unidades">Unidades</a>
                                <a class="nav-link" href="<?php echo base_url(); ?>/categorias">Categorias</a>
                            </nav>
                        </div>
-->
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseclientes" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                            Clientes
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseclientes" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="<?php echo base_url(); ?>/clientes">Clientes</a>
                                <a class="nav-link" href="<?php echo base_url(); ?>/grupos">Grupos</a>
                                <a class="nav-link" href="<?php echo base_url(); ?>/campos">Campos</a>
                            </nav>
                        </div>

                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsecompras" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-truck"></i></div>
                            Laboreos
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapsecompras" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="<?php echo base_url(); ?>/rlaboreos/index">Registro de labores</a>
                               
                            </nav>
                        </div>
<!--
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsecompras" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-truck"></i></div>
                            Compras
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapsecompras" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="<?php echo base_url(); ?>/compras/nuevo">Nueva compra</a>
                                <a class="nav-link" href="<?php echo base_url(); ?>/compras">Compras</a>
                            </nav>
                        </div>



                        <a class="nav-link" href="<?php echo base_url(); ?>/ventas/nueva">
                            <div class="sb-nav-link-icon"><i class="fas fa-cash-register"></i></div>
                            Caja
                        </a>

                        <a class="nav-link" href="<?php echo base_url(); ?>/ventas">
                            <div class="sb-nav-link-icon"><i class="fas fa-cash-register"></i></div>
                            Ventas
                        </a>
-->

                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseinformes" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-receipt"></i></div>
                            Informes
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseinformes" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="<?php echo base_url(); ?>/productos/muestrastockminimo">Informe de stock minimo</a>
                                <a class="nav-link" href="<?php echo base_url(); ?>/informes/productos">Informe de productos</a>
                            </nav>
                        </div>

                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseusuarios" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-user fa-fw"></i></div>
                            usuarios
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseusuarios" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="<?php echo base_url(); ?>/usuarios/perfil/<?=$us_session->id_usuario?>"><i class="fas fa-user-alt"></i> Perfil</a>
                                <a class="nav-link" href="<?php echo base_url(); ?>/usuarios/cambiar_contrasenia/<?=$us_session->id_usuario?>"><i class="fas fa-key"></i> Cambiar Contraseña</a>
                                <a class="nav-link" href="<?php echo base_url(); ?>/usuarios/logout"><i class="fas fa-sign-out-alt"></i> Cerrar sesion</a>
                            </nav>
                        </div>

                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseconfig" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-wrench"></i></div>
                            Administracion
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseconfig" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="<?php echo base_url(); ?>/configuracion">Configuracion</a>
                                <a class="nav-link" href="<?php echo base_url(); ?>/usuarios">Usuarios</a>
                                <a class="nav-link" href="<?php echo base_url(); ?>/roles">Roles</a>
                                <a class="nav-link" href="<?php echo base_url(); ?>/toperacion">Tipo Operaciones</a>
                                <a class="nav-link" href="<?php echo base_url(); ?>/logs">Auditoria</a>

                                <!--
                                <a class="nav-link" href="<?php echo base_url(); ?>/cajas">Cajas</a>
                                <a class="nav-link" href="<?php echo base_url(); ?>/respaldo">Respaldo</a>
-->
                            </nav>
                        </div>


                    </div>

                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    <?php echo $us_session->nombre ;?>
                </div>
            </nav>
        </div>