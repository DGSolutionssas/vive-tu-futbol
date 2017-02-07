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
            <table width=100% cellpadding=10>
                <tr>
                    <td>
                         <label >Campeonato:</label><br>
                        <input autocomplete="off" style="width:50%;" type="text" id="txtCampeonato" name="txtCampeonato"> 
                    </td>
                     <td>
                         <label >Equipo:</label><br>
                        <input autocomplete="off" style="width:50%;" type="text" id="txtEquipo" name="txtEquipo"> 
                    </td>
                </tr>
            </table>

              
            <br><br><br>
                                    
            <button id="btnRegistrar" name="btnRegistrar" disabled= "true" type="button" class="btn btn-success" onclick="limpiar();" data-toggle="modal" data-target="#VentanaRegistro"> Registrar Jugador</button>
            <script type="text/javascript" src="js/custom/jugadores.js"></script>
            <br>
			<div class="row">
            <table id="tableJugadores" class="display" width="100%" cellspacing="0">
                <thead>
                    <tr>
                    <th></th>
                    <th>ID</th>
                    <th>NOMBRE</th>
                    <th>DOCUMENTO</th>
                    <th>E-MAIL</th>
                    <th>CELULAR</th>
                    <th>DT</th>
                    <th>DELEGADO</th>
                    <th>REPRESENTANTE</th>
                    <th></th>
                    <th></th>
                    </tr>
                </thead>
            </table>
			</div>
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
						<br>
						<div class="form-group">
							<label><input type="checkbox" id="chkDirectorTecnico" name="chkDirectorTecnico"  /> Director Tecnico</label>
						</div>
						<div class="form-group">
							<label><input type="checkbox" id="chkDelegado" name="chkDelegado" /> Delegado</label>
						</div>
						<div class="form-group">
							<label><input type="checkbox" id="chkRepresentanteLegal" name="chkRepresentanteLegal" /> Representante Legal</label>
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
         <div id="VentanaEditar" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Cancelar</span>
                        </button>
                        <h4 class="modal-title" id="H3">
                            <p>EDITAR JUGADOR</p>
                        </h4>
                    </div>
                    <div class="modal-body">
                      <div class="form-row">
                            <label class='control-label'>Nombre Jugador:</label><input autocomplete="off" type="text" id="txtIdJugadorEditar" name="txtIdJugadorEditar" style=" visibility: hidden;">
                            <input autocomplete="off" type="text" id="txtNombreJugadorEditar" name="txtNombreJugadorEditar"  data-parsley-required data-parsley-required-message="Dato Requerido." data-parsley-minlength="4" data-parsley-minlength-message="Minimo 4 Caracateres" data-parsley-group="block2" class="form-control">
                        </div>
                        <div class="form-row">
                            <label class='control-label'>Documento:</label>
                            <input autocomplete="off" type="text" id="txtDocumentoEditar" name="txtDocumentoEditar" data-parsley-required data-parsley-required-message="Dato Requerido." data-parsley-minlength="4" data-parsley-minlength-message="Minimo 4 Caracateres" data-parsley-type="number" data-parsley-error-message="el dato ingresado debe ser numerico" data-parsley-group="block2" class="form-control">
                        </div>
                        <div class="form-row">
                            <label class='control-label'>E-Mail:</label>
                            <input autocomplete="off" type="text" id="txtCorreoElectronicoEditar" name="txtCorreoElectronicoEditar" data-parsley-required data-parsley-required-message="Dato Requerido." data-parsley-type="email" data-parsley-error-message="No es un E-mail Valido" data-parsley-group="block2" 
                            class="form-control">
                        </div>
                         <div class="form-row">
                            <label class='control-label'>Celular:</label>
                            <input autocomplete="off" type="text" id="txtCelularEditar" name="txtCelularEditar" data-parsley-required data-parsley-required-message="Dato Requerido." data-parsley-type="number" data-parsley-error-message="El dato ingresado no esta en el formato corrrecto"  data-parsley-minlength="10" data-parsley-maxlength="10" data-parsley-minlength-message="No es un número de celular valido"  data-parsley-maxlength-message="No es un número de celular valido" data-parsley-group="block2" class="form-control">
                        </div>
                        <div class="form-row">
                            <label class='control-label'>Director Tecnico:</label>
                            <input type="checkbox"id="chkDirectorTecnicoEditar" name="chkDirectorTecnicoEditar" class="form-control">
                            
                        </div>
                        <div class="form-row" >
                            <label class='control-label'>Delegado:</label>
                            <input type="checkbox"id="chkDelegadoEditar" name="chkDelegadoEditar" class="form-control">
                            
                        </div>
                        <div class="form-row" >
                            <label class='control-label'>Representante Legal:</label>
                            <input type="checkbox"id="chkRepresentanteLegalEditar" name="chkRepresentanteLegalEditar" class="form-control">
                         </div>

                        <div class="form-row">
                        <label class='control-label'>Foto:</label>
                        <input type="file"  class="btn btn-warning"  name="archivoImageEditar" id="archivoImageEditar" />
                        <a id="btnCargar" type="submit" class="btn btn-success" name="btnCargar" onclick="uploadAjax();">
                            <span class="fa fa-cloud-upload"></span> Cargar Imagen</a>
                        </div>    
                                
                    </div>
                    <div class="modal-footer">
                        <div class='form-row'>
                            <a id="btnActualizar" type="submit" class="btn btn-success" name="btnActualizar" onclick="actualizarJugador();">Actualizar</a>
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


