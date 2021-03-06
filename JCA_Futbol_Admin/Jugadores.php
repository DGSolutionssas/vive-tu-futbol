<?php
/**
 * Vista de los Campeonatos
 * @author Sebastian Melo
 * @created 11/01/2017
 * @copyright DG Solutions sas
 */
session_start();

if (!empty($_SESSION['autenticado']) && $_SESSION['autenticado'] == true && $_SESSION['idPerfil'] != "JUGADOR")
{
    require_once "./Header.php";
    ?>

<script type="text/javascript">
    <?php echo 'var SessionPerfil = '.json_encode($_SESSION['idPerfil']).';';
    ?>
</script>

    <div>
         <script type="text/javascript" src="js/custom/jugadores.js"></script>
        <br><br><br>
        <div class="jumbotron">
            <table width=100% cellpadding=10>
                <tr>
                    <td>
                         <label >Campeonato:</label><br>
                        <input autocomplete="off" style="width:50%;" type="text"  id="txtCampeonato" name="txtCampeonato">
                    </td>
                     <td>
                         <label >Equipo:</label><br>
                        <input autocomplete="off" style="width:50%;" type="text" id="txtEquipo" name="txtEquipo">
                    </td>
                </tr>
            </table>
            <?php
}
elseif (!empty($_SESSION['autenticado']) && $_SESSION['autenticado'] == true && $_SESSION['idPerfil'] == "JUGADOR")
{

    require_once './HeaderJugador.php';
    ?>
   <script type="text/javascript">
    <?php echo 'var SessionPerfil = '.json_encode($_SESSION['idPerfil']).';';
    ?>
</script>
<script type="text/javascript">
    <?php echo 'var idEquipoSession = '.json_encode($_SESSION['idEquipo']).';';
    ?>
</script>
<?php
 ?>
    <div>
         <script type="text/javascript" src="js/custom/jugadores.js"></script>
         <script type="text/javascript">
            <?php echo 'cargarTablaFiltrada(idEquipoSession);';
            ?>
            </script>
        <br><br><br>
        <div class="jumbotron">
            <table width=100% cellpadding=10>
                <tr>
                    <td>
                        <label >Campeonato:</label><br>
                        <input autocomplete="off" style="width:50%;" disabled type="text" value="<?php echo $_SESSION['NombreCampeonato'];?>" id="txtCampeonato" name="txtCampeonato">
                    </td>
                     <td>
                         <label >Equipo:</label><br>
                        <input autocomplete="off" style="width:50%;" disabled type="text" value="<?php echo $_SESSION['NombreEquipo'];?>" id="txtEquipo" name="txtEquipo">
                    </td>
                </tr>
            </table>
            <?php
}
if (!empty($_SESSION['autenticado']) && $_SESSION['autenticado'] == true) {

?>
            <br><br>
            <button id="btnRegistrar" name="btnRegistrar" disabled= "true" type="button" class="btn btn-success" onclick="limpiar();" data-toggle="modal" data-target="#VentanaRegistro"> Registrar Jugador</button>
            <br>
			<div class="row">    
            <div class="x_content">
            <div class="table-responsive">
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
                    <th></th>
                    </tr>
                </thead>
            </table>
            </div>
            </div>
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
                         <?php
                        if ($_SESSION['idPerfil'] == "JUGADOR"){
                            ?>
						<div class="form-group">
							<label><input type="checkbox" disabled id="chkDelegado" name="chkDelegado" /> Delegado</label>
						</div>
                        <?php
                        }else 
                        {
                            ?>
                            <div class="form-group">
							<label><input type="checkbox" id="chkDelegado" name="chkDelegado" /> Delegado</label>
						    </div>
                            <?php
                        }
                        ?>
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
                         <?php
                        if ($_SESSION['idPerfil'] == "JUGADOR"){
                            ?>
                        <div class="form-row" >
                            <label class='control-label'>Delegado:</label>
                            <input type="checkbox"id="chkDelegadoEditar" disabled name="chkDelegadoEditar" class="form-control">

                        </div>
                         <?php
                        }else 
                        {
                            ?>
                             <div class="form-row" >
                            <label class='control-label'>Delegado:</label>
                            <input type="checkbox"id="chkDelegadoEditar" name="chkDelegadoEditar" class="form-control">

                        </div>
                            <?php
                        }
                        ?>
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
		
		
		
		 <div id="VentanaGenerarCarnet" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Cancelar</span>
                        </button>
                        <h4 class="modal-title" id="H3">
                            <p>GENERACION CARNET</p>
                        </h4>
                    </div>
                    <div id="divCarnet" name="divCarnet" class="modal-body">
                       

                    </div>
                </div>
            </div>
        </div>
		
		
        <div id="divResultado" name="divResultado">
        </div>
		
		
		
    </div>
    <?php if (!empty($_SESSION['autenticado']) && $_SESSION['autenticado'] == true && $_SESSION['idPerfil'] == "JUGADOR")
    {
       echo '<script type="text/javascript">cargarCantidadJugadores('.json_encode($_SESSION['idEquipo']).');</script>';
    }
    ?>
    <?php
} else {
    ?><script type='text/javascript'>redireccionarInicio();</script>
    <?php
}
require_once './Footer.php';
