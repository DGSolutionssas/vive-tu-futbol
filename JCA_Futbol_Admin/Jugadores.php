<?php
/**
 * Vista de los Campeonatos
 * @author Sebastian Melo
 * @created 11/01/2017
 * @copyright DG Solutions sas
 */
session_start();
require_once "./Header.php";
if (!empty($_SESSION['autenticado']) && $_SESSION['autenticado'] == true) {
    ?>
    <div>   
        <br><br><br>
        <div class="jumbotron">
            <button type="button" class="btn btn-success" onclick="limpiar();" data-toggle="modal" data-target="#VentanaRegistro"> Registrar Jugador</button>
            <script type="text/javascript" src="js/custom/jugadores.js"></script>
            <br>
            <table id="tableJugadores" class="display table table-hover table-bordered jambo_table">
                <thead>
                    <tr>
                    <th>ID</th>
                    <th>NOMBRE</th>
                    <th>DOCUMENTO</th>
                    <th>E-MAIL</th>
                    <th>CELULAR</th>
                    <th>DT</th>
                    <th>DELEGADO</th>
                    <th>REPRESENTANTE</th>
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
                            <p>REGISTRAR JUGADOR</p>
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-row">
                            <label class='control-label'>Nombre Jugador:</label>
                            <input autocomplete="off" type="text" id="txtNombreJugador" name="txtNombreJugador"  data-parsley-required data-parsley-required-message="Dato Requerido." data-parsley-minlength="4" data-parsley-minlength-message="Minimo 4 Caracateres" data-parsley-group="block1" class="form-control">
                        </div>
                        <div class="form-row">
                            <label class='control-label'>Documento:</label>
                            <input autocomplete="off" type="text" id="txtDocumento" name="txtDocumento" data-parsley-required data-parsley-required-message="Dato Requerido." data-parsley-minlength="4" data-parsley-minlength-message="Minimo 4 Caracateres" data-parsley-type="number" data-parsley-error-message="el dato ingresado debe ser numerico" data-parsley-group="block1" class="form-control">
                        </div>
                        <div class="form-row">
                            <label class='control-label'>E-Mail:</label>
                            <input autocomplete="off" type="text" id="txtCorreoElectronico" name="txtCorreoElectronico" data-parsley-required data-parsley-required-message="Dato Requerido." data-parsley-type="email" data-parsley-error-message="No es un E-mail Valido" data-parsley-group="block1" 
                            class="form-control">
                        </div>
                         <div class="form-row">
                            <label class='control-label'>Celular:</label>
                            <input autocomplete="off" type="text" id="txtCelular" name="txtCelular" data-parsley-required data-parsley-required-message="Dato Requerido." data-parsley-type="number" data-parsley-error-message="El dato ingresado no esta en el formato corrrecto"  data-parsley-minlength="10" data-parsley-maxlength="10" data-parsley-minlength-message="No es un número de celular valido"  data-parsley-maxlength-message="No es un número de celular valido" data-parsley-group="block1" class="form-control">
                        </div>
                        <div class="form-row">
                            <label class='control-label'>Director Tecnico:</label>
                            <input type="checkbox"id="chkDirectorTecnico" name="chkDirectorTecnico" class="form-control">
                            
                        </div>
                        <div class="form-row" >
                            <label class='control-label'>Delegado:</label>
                            <input type="checkbox"id="chkDelegado" name="chkDelegado" class="form-control">
                            
                        </div>
                        <div class="form-row" >
                            <label class='control-label'>Representante Legal:</label>
                            <input type="checkbox"id="chkRepresentanteLegal" name="chkRepresentanteLegal" class="form-control">
                         </div>

                        <div class="form-row">
                        <label class='control-label'>Foto:</label>
                        <input type="file"  class="btn btn-warning"  name="archivoImage" id="archivoImage" />
                        <a id="btnCargar" type="submit" class="btn btn-success" name="btnCargar" onclick="uploadAjax();">
                            <span class="fa fa-cloud-upload"></span> Cargar Imagen</a>
                        </div>    
                                
                    </div>
                    <div class="modal-footer">
                        <div class='form-row'>
                            <a id="btnGuardar" type="submit" class="btn btn-success" name="btnGuardar" onclick="guardarJugador();">Guardar</a>
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


