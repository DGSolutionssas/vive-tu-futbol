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
	<script type="text/javascript" src="js/custom/reportes.js"></script>
    <div>   
        <br><br><br>
        <div class="jumbotron">
			<div class="form-row">
                <button type="button" class="btn btn-warning" onclick="limpiarReporte();"> Limpiar</button>
            </div>
			<div class="form-row">    
                <label class='control-label'>Campeonato:</label>
                <input autocomplete="off" type="text" id="txtCampeonato" name="txtCampeonato" data-parsley-required data-parsley-required-message="Dato Requerido." data-parsley-minlength="4" data-parsley-minlength-message="Minimo 4 Caracateres" data-parsley-group="block1" class="form-control">
            </div>
			</br>
			<div>
				<button type="button" class="btn btn-success" onclick="generarReporteCampeonato();"> Generar Reporte</button>
            </div>
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


