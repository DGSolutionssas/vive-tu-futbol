<?php
/**
 * Vista de los Campeonatos
 * @author Diego Saavedra
 * @created 25/12/2016
 * @copyright DG Solutions sas
 */
session_start();
include_once './Header.php';
if (!empty($_SESSION['autenticado']) && $_SESSION['autenticado'] == true) {
    ?>
    <div>   
        <br><br><br>
        <div class="jumbotron">
            <button type="button" class="btn btn-success" onclick="generarReporte();"> Generar Reporte</button>
            <script type="text/javascript" src="js/custom/reportes.js"></script>
            </br></br>
            <div id="divResultado" name="divResultado">
            </div>
        </div>
    </div>
    <?php
} else {
    ?><script type='text/javascript'>redireccionarInicio();</script>
    <?php
}
include_once './Footer.php';


