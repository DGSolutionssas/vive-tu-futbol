<?php

/**
 * Clase Validacion de Inicio Sesion
 * @author Diego Saavedra
 * @created 25/12/2016
 * @copyright DG Solutions sas
 */
session_start();
include_once './Header.php';
if (!empty($_SESSION['autenticado']) && $_SESSION['autenticado'] == true) {
    ?>
    <div>
    </div>
    <?php
} else {
    ?>
    <script type='text/javascript'>redireccionarInicio();</script>
    <?php
}
include_once './Footer.php';
