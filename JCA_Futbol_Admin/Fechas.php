<?php
/**
 * Vista de los Campeonatos
 * @author Diego Saavedra
 * @created 26/12/2016
 * @copyright DG Solutions sas
 */
session_start();
require_once "./Header.php";
if (!empty($_SESSION['autenticado']) && $_SESSION['autenticado'] == true) {
    ?>
    <div>   
        <br><br><br>
        <div class="jumbotron">
            <button type="button" class="btn btn-success" onclick="limpiar();" data-toggle="modal" data-target="#VentanaRegistro"> Nueva Fecha</button>
            <script type="text/javascript" src="js/custom/Fechas.js"></script>
            <br>
            <table id="tableFechas" class="display table table-hover table-bordered jambo_table">
                <thead>
                    <tr>
                    <th>ID</th>
					<th>NOMBRE</th>
                    <th>FECHA</th>
                    <th>CAMPEONATO</th>
                    <th></th>
                    </tr>
                </thead>
            </table>
            </br>
        </div>

        <div id="VentanaRegistro" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Cancelar</span>
                        </button>
                        <h4 class="modal-title" id="H3">
                            <p>NUEVA FECHA</p>
                        </h4>
                    </div>
                    <div class="modal-body">
					<div class="form-row">
                            <label class='control-label'>Campeonato:</label>
                            <input autocomplete="off" type="text" id="txtCampeonato" name="txtCampeonato" data-parsley-required data-parsley-required-message="Dato Requerido." data-parsley-minlength="4" data-parsley-minlength-message="Minimo 4 Caracateres" data-parsley-group="block1" class="form-control">
                      </div>
                        <div class="form-row">
                            <label class='control-label'>Nombre Fecha:</label>
                            <input autocomplete="off" type="text" id="txtNombreFecha" name="txtNombreFecha" data-parsley-required data-parsley-required-message="Dato Requerido." data-parsley-minlength="4" data-parsley-minlength-message="Minimo 4 Caracateres" data-parsley-group="block1" class="form-control">
                      </div>
                        <div class="form-row">
                            <label class='control-label'>Fecha:</label>
                            <input type="text" class="form-control" id="dtFecha" name="dtFecha"  data-parsley-required data-parsley-required-message="Dato Requerido." data-parsley-minlength="4" data-parsley-minlength-message="Minimo 4 Caracateres" data-parsley-group="block1">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class='form-row'>
                            <a id="btnGuardar" type="submit" class="btn btn-success" name="btnGuardar" onclick="guardarFecha();">Guardar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="dvResultado"></div>
    </div>
    <?php
} else {
    ?><script type='text/javascript'>redireccionarInicio();</script>
    <?php
}
require_once './Footer.php';


