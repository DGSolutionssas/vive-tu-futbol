<!DOCTYPE html>
<html lang="es">

    <head>
        <title>JCA Futbol</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="JCA Futbol">

        <link rel="shortcut icon" href="img/indice.ico"/>
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"/>
        <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css"/>
        <link rel="stylesheet" type="text/css" href="css/animate.min.css"/>
        <link rel="stylesheet" type="text/css" href="css/custom.css"/>
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <script type="text/javascript" src="js/parsley/parsley.min.js"></script>
        <script type="text/javascript" src="js/datatables/js/jquery.dataTables.js"></script>
        <script type="text/javascript" src="js/datatables/tools/js/dataTables.tableTools.js"></script>
        <script type="text/javascript" src="js/Chart.min.js"></script>
        <script type="text/javascript" src="js//switch/bootstrap-switch.js"></script>
        <script type="text/javascript" src="js/jquery-ui.js"></script>
        <link rel="stylesheet" type="text/css" href="css/jqueryui/jquery-ui.css">
        <link href="css/buttons.dataTables.min.css" rel="stylesheet" type="text/css"/>
        <link href="css/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>

        <!-- Calendar -->
        <link rel="stylesheet" type="text/css" href="css/bootstrap-datepicker.min.css"/>
        <link rel="stylesheet" type="text/css" href="css/bootstrap-datepicker3.min.css"/>

        <!--[if lt IE 9]>
        <script src="../assets/js/ie8-responsive-file-warning.js"></script>
        <![endif]-->
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
              <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
              <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
            <![endif]-->

        <noscript>Tu navegador no soporta JavaScript!</noscript>

        <script type='text/javascript'>
            function redireccionarInicio()
            {
                location.href = "Index.html";
            }
        </script>
    </head>
    <body class="nav-md">

        <form id="form1" runat="server">
            <div class="container body">
                <div class="main_container">
                    <div class="col-md-3 left_col">
                        <div class="left_col scroll-view">
                            <div class="navbar nav_title" style="border: 0;">
                                <a class="site_title">
                                    <img  width="50" height="50" src="img/Logo.png" alt="..."><span> JCA Futbol</span></a>
                            </div>
                            <div class="clearfix">
                            </div>
                            <!-- menu prile quick info -->
                            <div class="profile">
                                <div class="profile_pic">
                                    <img src="img/user.png" alt="..." class="img-circle profile_img">
                                </div>
                                <div class="profile_info">
                                    <span>Bienvenido,</span>
                                    <h2>Administrador</h2>
                                </div>
                            </div>
                            <!-- /menu prile quick info -->
                            <br />
                            <!-- sidebar menu -->
                            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                                <div class="menu_section">
                                    <h3>ADMINISTRADOR</h3>
                                    <ul class="nav side-menu" id="listaCampanas">
                                        <li><a href="Inicio.php"><i class="fa fa-home"></i>Inicio <span class="fa fa-chevron-right"></span></a></li>
                                        <li><a href="./Campeonatos.php"><i class="fa fa-futbol-o"></i>Campeonatos<span class="fa fa-chevron-right"></span></a></li>
                                        <li><a href="./Equipos.php"><i class="fa fa-users"></i>Equipos<span class="fa fa-chevron-right"></span></a></li>
                                        <li><a href="Jugadores.php"><i class="fa fa-user"></i>Jugadores<span class="fa fa-chevron-right"></span></a></li>
                                        <li><a href="./Fechas.php"><i class="fa fa-calendar-o"></i>Fechas<span class="fa fa-chevron-right"></span></a></li>
                                        <li><a href="./Resultados.php"><i class="fa fa-table"></i>Resultados<span class="fa fa-chevron-right"></span></a></li>
                                        <li><a href="./Plantillas.php"><i class="fa fa-newspaper-o"></i>Plantillas<span class="fa fa-chevron-right"></span></a></li>
                                        <li><a href="#"><i class="fa fa-bar-chart-o"></i>Reportes<span class="fa fa-chevron-right"></span></a>
                                            <ul class="nav child_menu">
                                                <li><a href="./Reportes.php">Campeonatos</a></li>
                                                <li><a href="./Reportes.php">Equipos</a></li>
                                                <li><a href="./Reportes.php">Jugadores</a></li>
                                                <li><a href="./Reportes.php">Carnets</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div>  
                            <!-- /sidebar menu -->
                            <!-- /menu footer buttons -->
                            <!-- /menu footer buttons -->
                        </div>
                    </div>
                    <!-- top navigation -->
                    <div class="top_nav">
                        <div class="nav_menu">
                            <nav class="" role="navigation">
                                <div class="nav toggle">
                                    <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                                </div>

                                <ul class="nav navbar-nav navbar-right">
                                    <li class="">
                                        <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                            <img src="img/user.png" alt="">Administrador
                                            <span class=" fa fa-angle-down"></span>
                                        </a>
                                        <ul class="dropdown-menu dropdown-usermenu animated fadeInDown pull-right">
                                            <li><a href="Logout.php"><span class="fa fa-power-off"></span> Cerrar Sesion</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <div class="right_col" role="main">
