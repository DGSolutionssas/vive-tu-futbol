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
        <div class="jumbotron x_panel personalColor">
            <button type="button" class="btn btn-success" onclick="limpiar();" data-toggle="modal" data-target="#VentanaRegistro"> Registrar Equipo</button>
            <script type="text/javascript" src="js/custom/equipos.js"></script>
            <br>
            <div class="x_content">
            <div class="table-responsive">
            <table id="tableEquipos" class="display table table-hover table-bordered jambo_table">
                <thead>
                    <tr>
                    <th>ID</th>
                    <th>IDC</th>
                    <th>CAMPEONATO</th>
                    <th>NOMBRE</th>
                    <th>DESCRIPCION</th>
                    <th>PUNTOS</th>
                    <th>GRUPOS</th>
                    <th></th><th></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
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
                            <p>REGISTRAR EQUIPO</p>
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-row">
                            <label class='control-label'>Campeonato:</label>
                            <input autocomplete="off" type="text" id="txtCampeonato" name="txtCampeonato" data-parsley-required data-parsley-required-message="Dato Requerido." data-parsley-minlength="4" data-parsley-minlength-message="Minimo 4 Caracateres" data-parsley-group="blockRegistro" class="form-control">
                      </div>
                        <div class="form-row">
                            <label class='control-label'>Nombre Equipo:</label>
                            <input autocomplete="off" type="text" id="txtNombreEquipo" name="txtNombreEquipo"  data-parsley-required data-parsley-required-message="Dato Requerido." data-parsley-minlength="4" data-parsley-minlength-message="Minimo 4 Caracateres" data-parsley-group="blockRegistro" class="form-control">
                        </div>
                        <div class="form-row">
                            <label class='control-label'>Descripcion Equipo:</label>
                            <input autocomplete="off" type="text" id="txtDescripcionEquipo" name="txtDescripcionEquipo" data-parsley-required data-parsley-required-message="Dato Requerido." data-parsley-minlength="4" data-parsley-minlength-message="Minimo 4 Caracateres" data-parsley-group="blockRegistro" class="form-control">
                        </div>
                        <div class="form-row" id="divGrupo">
                            <label class='control-label'>Grupo:</label>
                            <select id="ddlGrupoEquipo" name="ddlGrupoEquipo" class="form-control">
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class='form-row'>
                            <a id="btnGuardar" type="submit" class="btn btn-success" name="btnGuardar" onclick="guardarEquipo();">Guardar</a>
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
                            <p>EDITAR EQUIPO</p>
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-row">
                            <label class='control-label'>Campeonato:</label>
                            <input autocomplete="off" type="text" disabled id="txtCampeonatoEditar" name="txtCampeonatoEditar" class="form-control">
                      </div>
                        <div class="form-row">
                            <label class='control-label'>Nombre Equipo:</label>
                            <input autocomplete="off" type="text" id="txtNombreEquipoEditar" name="txtNombreEquipoEditar"  data-parsley-required data-parsley-required-message="Dato Requerido." data-parsley-minlength="4" data-parsley-minlength-message="Minimo 4 Caracateres" data-parsley-group="block1" class="form-control">
                        </div>
                        <div class="form-row">
                            <label class='control-label'>Descripcion Equipo:</label>
                            <input autocomplete="off" type="text" id="txtDescripcionEquipoEditar" name="txtDescripcionEquipoEditar" data-parsley-required data-parsley-required-message="Dato Requerido." data-parsley-minlength="4" data-parsley-minlength-message="Minimo 4 Caracateres" data-parsley-group="block1" class="form-control">
                        </div>
                        <div class="form-row" id="divGrupo">
                            <label class='control-label'>Grupo:</label>
                            <select id="ddlGrupoEquipoEditar" name="ddlGrupoEquipoEditar" class="form-control">
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class='form-row'>
                            <a id="btnActualizar" type="submit" class="btn btn-success" name="btnActualizar" onclick="actualizarEquipo();">Actualizar</a>
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
