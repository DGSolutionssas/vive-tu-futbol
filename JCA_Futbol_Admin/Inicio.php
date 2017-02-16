<?php

/**
 * Clase Validacion de Inicio Sesion
 * @author Diego Saavedra
 * @created 25/12/2016
 * @copyright DG Solutions sas
 */
session_start();
if (!empty($_SESSION['autenticado']) && $_SESSION['autenticado'] == true && $_SESSION['idPerfil'] != "JUGADOR") {
    include_once './Header.php';
    ?>
    <div>
    </div>
    <?php
} elseif (!empty($_SESSION['autenticado']) && $_SESSION['autenticado'] == true && $_SESSION['idPerfil'] == "JUGADOR")
{
 include_once './HeaderJugador.php';
    ?>
    <div>
    </div>
    <?php
}else{
    ?>
    <script type='text/javascript'>redireccionarInicio();</script>
    <?php
}
include_once './Footer.php';
