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
            <button type="button" class="btn btn-success" onclick="limpiar();" data-toggle="modal" data-target="#VentanaRegistro"> Registrar Campeonato</button>
            <script type="text/javascript" src="js/custom/campeonatos.js"></script>
            <br>
            <table id="tableCampeonatos" class="display nowrap table table-hover table-bordered jambo_table">
                <thead>
                    <tr>
                    <th>ID</th>
                    <th>CAMPEONATO</th>
                    <th>DESCRIPCION</th>
                    <th>GRUPOS</th>
                    <th>EQUIPOS</th>
                    <th># JUGADORES</th>
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
                            <p>REGISTRAR CAMPEONATO</p>
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-row">
                            <label class='control-label'>Campeonato:</label>
                            <input autocomplete="off" type="text" id="txtCampeonato" name="txtCampeonato" data-parsley-required data-parsley-required-message="Dato Requerido." data-parsley-minlength="4" data-parsley-minlength-message="Minimo 4 Caracateres" data-parsley-group="block1" class="form-control">
                        </div>
                        <div class="form-row">
                            <label class='control-label'>Descripcion:</label>
                            <input autocomplete="off" type="text" id="txtDescripcion" name="txtDescripcion"  data-parsley-required data-parsley-required-message="Dato Requerido." data-parsley-minlength="4" data-parsley-minlength-message="Minimo 4 Caracateres" data-parsley-group="block1" class="form-control">
                        </div>
                        <div class="form-row">
                            <label class='control-label'>Grupos:</label>
                            <input autocomplete="off" type="text" id="txtGrupos" name="txtGrupos" data-parsley-required data-parsley-required-message="Dato Requerido." data-parsley-type="integer" data-parsley-type-message="Solo N�meros"  data-parsley-group="block1" class="form-control">
                        </div>
                        <div class="form-row">
                            <label class='control-label'>Equipos:</label>
                            <input autocomplete="off" type="text" id="txtEquipos" name="txtEquipos" data-parsley-required data-parsley-required-message="Dato Requerido." data-parsley-type="integer" data-parsley-type-message="Solo N�meros" data-parsley-group="block1" class="form-control">
                        </div>
                        <div class="form-row">
                            <label class='control-label'>Cantidad Jugadores:</label>
                            <input autocomplete="off" type="text" id="txtCantidadJugadores" name="txtCantidadJugadores" data-parsley-required data-parsley-required-message="Dato Requerido." data-parsley-type="integer" data-parsley-type-message="Solo Numeros"  data-parsley-group="block1" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class='form-row'>
                            <a id="btnGuardar" type="submit" class="btn btn-success" name="btnGuardar" onclick="guardarCampeonato();">Guardar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="VentanaRegistroEquipo" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Cancelar</span>
                        </button>
                        <h4 class="modal-title" id="H3">
                            <p>REGISTRAR EQUIPO</p>
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-row">
                            <label class='control-label'>Campeonato:</label>
                            <input autocomplete="off" type="text" id="txtCampeonatoRegistro"  disabled name="txtCampeonatoRegistro" data-parsley-required data-parsley-required-message="Dato Requerido." data-parsley-group="block2" class="form-control">
                        </div>
                        <div class="form-row">
                            <label class='control-label'>Nombre Equipo:</label>
                            <input autocomplete="off" type="text" id="txtNombreEquipoRegistro" name="txtNombreEquipoRegistro"  data-parsley-required data-parsley-required-message="Dato Requerido." data-parsley-group="block2" class="form-control">
                        </div>
                        <div class="form-row">
                            <label class='control-label'>Descripcion Equipo:</label>
                            <input autocomplete="off" type="text" id="txtDescripcionEquipoRegistro" name="txtDescripcionEquipoRegistro" data-parsley-required data-parsley-required-message="Dato Requerido." data-parsley-group="block2" class="form-control">
                        </div>
                        <div class="form-row">
                            <label class='control-label'>Grupo:</label>
                            <select id="ddlGrupoEquipo" name="ddlGrupoEquipo" class="form-control">
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class='form-row'>
                            <a id="btnGuardar" type="submit" class="btn btn-success" name="btnGuardar" onclick="registrarEquipoCampeonato();">Guardar</a>
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
include_once './Footer.php';


