<?php
/**
 * Vista de los Campeonatos
 * @author Diego Saavedra
 * @created 26/12/2016
 * @copyright DG Solutions sas
 */
session_start();

require_once "Header.php";
if (!empty($_SESSION['autenticado']) && $_SESSION['autenticado'] == true) {
    ?>
    <div>   
        <br><br><br><br>
        <div class="jumbotron">
            <button type="button" class="btn btn-success" onclick="limpiar();" data-toggle="modal" data-target="#VentanaRegistro"> Registrar Resultado </button>
            <script type="text/javascript" src="js/custom/Resultados.js"></script>
            <br><br>
            <table id="tableResultados" class="display table table-hover table-bordered jambo_table">
                <thead>
                    <tr>
                    <th>ID</th>
                    <th>FECHA</th>
                    <th>CAMPEONATO</th>
                    <th>EQUIPO 1</th>
                    <th>EQUIPO 2</th>
                    <th>GOLES E1</th>
                    <th>GOLES E2</th>
                    <th>W</th>
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
                            <p>REGISTRAR RESULTADO</p>
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-row">
                            <label class='control-label'>Fecha:</label>
                            <input autocomplete="off" type="text" id="txtIdFecha" name="txtIdFecha" data-parsley-required data-parsley-required-message="Dato Requerido." data-parsley-group="block1" class="form-control">
                        </div>
                        <div class="form-row">
                            <label class='control-label'>Campeonato:</label>
                            <input autocomplete="off" type="text" id="txtIdCampeonato" name="txtIdCampeonato"  data-parsley-required data-parsley-required-message="Dato Requerido." data-parsley-group="block1" class="form-control">
                        </div>
                        <div class='input-result'>
                            <label class='control-label'>Equipo 1:</label>
                            <input autocomplete="off" type="text" id="txtIdEquipo1" name="txtIdEquipo1" data-parsley-required data-parsley-required-message="Dato Requerido." data-parsley-group="block1" class="form-control">
                        </div>
                        <div class='input-score'>
                            <label class='control-label'>Goles:</label>
                            <input autocomplete="off" type="number" id="txtGoles1" name="txtGoles1" data-parsley-required data-parsley-required-message="Dato Requerido." data-parsley-group="block1" class="form-control">
                        </div>
                        <div class='input-w'>
                            <label class='control-label'>Gana W:</label>
                            <input autocomplete="off" type="checkbox" id="chkw1" name="chkw1" data-parsley-group="block1" class="form-control">
                        </div>
                        <div class='input-result'>
                            <label class='control-label'>Equipo 2:</label>
                            <input autocomplete="off" type="text" id="txtIdEquipo2" name="txtIdEquipo2" data-parsley-required data-parsley-required-message="Dato Requerido." data-parsley-group="block1" class="form-control">
                        </div>
                        <div class='input-score'>
                            <label class='control-label'>Goles:</label>
                            <input autocomplete="off" type="number" id="txtGoles2" name="txtGoles2" data-parsley-required data-parsley-required-message="Dato Requerido." data-parsley-group="block1" class="form-control">
                        </div>
			<div class='input-w'>
                            <label class='control-label'>Gana W:</label>
                            <input autocomplete="off" type="checkbox" id="chkw2" name="chkw2" data-parsley-group="block1" class="form-control">
                        </div>
                    </div>
                    <br><br><br><br><br><br><br>
                    <div class="modal-footer">
                        <div class='form-row'>
                            <a id="btnContinuar" class="btn btn-success" onclick = "guardarResultado()"> Continuar </a>
                            </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="VentanaJL" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">
                                <span aria-hidden="true">&times;</span>
                                <span class="sr-only">Cancelar</span>
                            </button>
                            <h4 class="modal-title" id="H3">
                                REGISTRAR DETALLES
                            </h4>
                        </div>
                        <div class="modal-body">
                            <div align="center"><h2><input id='txtcargaequipo1' readonly='readonly' style="border:none"></h2></div>
                            <table id="tableJL" class="display table table-hover table-bordered jambo_table">
                                <thead>
                                    <tr>
                                    <th>ID</th>
                                    <th>NOMBRE</th>
                                    <th>GOLES</th>
                                    <th>AMARILLA</th>
                                    <th>AZUL</th>
                                    <th>ROJA</th>
                                    </tr>
                                </thead>
                            </table>
                            <div></div>
                        </div>

                        <br>
                        <div class="modal-footer">
                            <div class='form-row'>
                                <a id="btnContinue" class="btn btn-success" onclick = "registrardetalle()">Siguiente</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
        <div id="VentanaJL1" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">
                                <span aria-hidden="true">&times;</span>
                                <span class="sr-only">Cancelar</span>
                            </button>
                            <h4 class="modal-title" id="H3">
                                REGISTRAR DETALLES
                            </h4>
                        </div>
                        <div class="modal-body">
                            <div align="center"><h2><input id='txtcargaequipo2' readonly='readonly' style="border:none"></h2></div>
                            <table id="tableJL1" class="display table table-hover table-bordered jambo_table">
                                <thead>
                                    <tr>
                                    <th>ID</th>
                                    <th>NOMBRE</th>
                                    <th>GOLES</th>
                                    <th>AMARILLA</th>
                                    <th>AZUL</th>
                                    <th>ROJA</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                        <br>
                        <div class="modal-footer">
                            <div class='form-row'>
                                <a id="btnGuardar" class="btn btn-success" name="btnGuardar" onclick = "registrardetalle1()"> Terminar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
        <div id="VentanaEditarRegistro" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Cancelar</span>
                        </button>
                        <h4 class="modal-title" id="H3">
                            <p>EDITAR RESULTADO</p>
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-row">
                            <label class='control-label'>Fecha:</label>
                            <input autocomplete="off" type="text" id="txtIdFechaEditar" data-parsley-required-message="Dato Requerido." data-parsley-group="blockeditar" class="form-control">
                        </div>
                        <div class="form-row">
                            <label class='control-label'>Campeonato:</label>
                            <input autocomplete="off" type="text" id="txtIdCampeonatoEditar" disabled="disabled" data-parsley-required-message="Dato Requerido." data-parsley-group="blockeditar" class="form-control">
                        </div>
                        <div class='input-result'>
                            <label class='control-label'>Equipo 1:</label>
                            <input autocomplete="off" type="text" id="txtIdEquipo1Editar" disabled="disabled" data-parsley-required-message="Dato Requerido." data-parsley-group="blockeditar" class="form-control">
                        </div>
                        <div class='input-score'>
                            <label class='control-label'>Goles:</label>
                            <input autocomplete="off" type="number" id="txtGoles1Editar" disabled="disabled" data-parsley-required-message="Dato Requerido." data-parsley-group="blockeditar" class="form-control">
                        </div>
                        <div class='input-w'>
                            <label class='control-label'>Gana W:</label>
                            <input autocomplete="off" type="checkbox" id="chkw1editar" name="chkw1editar" data-parsley-group="blockeditar" class="form-control">
                        </div>
                        <div class='input-result'>
                            <label class='control-label'>Equipo 2:</label>
                            <input autocomplete="off" type="text" id="txtIdEquipo2Editar" disabled="disabled" data-parsley-required-message="Dato Requerido." data-parsley-group="blockeditar" class="form-control">
                        </div>
                        <div class='input-score'>
                            <label class='control-label'>Goles:</label>
                            <input autocomplete="off" type="number" id="txtGoles2Editar"  disabled="disabled" data-parsley-required-message="Dato Requerido." data-parsley-group="blockeditar" class="form-control">
                        </div>
                        <div class='input-w'>
                            <label class='control-label'>Gana W:</label>
                            <input autocomplete="off" type="checkbox" id="chkw2editar" name="chkw2editar" data-parsley-group="blockeditar" class="form-control">
                        </div>
                    </div>
                    <br><br><br><br><br><br><br>
                    <div class="modal-footer">
                        <div class='form-row'>
                            <button id="ContinuaEdicion" disabled="disabled" class="btn btn-success" onclick = "actualizarresultado()">Siguiente</button>
                            </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div id="VentanaJLEditar" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">
                                <span aria-hidden="true">&times;</span>
                                <span class="sr-only">Cancelar</span>
                            </button>
                            <h4 class="modal-title" id="H3">
                                REGISTRAR DETALLES
                            </h4>
                        </div>
                        <div class="modal-body">
                            <div align="center"><h2><input id='txtcargaequipo1Editar' readonly='readonly' style="border:none"></h2></div>
                            <table id="tableJLEditar" class="display table table-hover table-bordered jambo_table">
                                <thead>
                                    <tr>
                                    <th>ID</th>
                                    <th>NOMBRE</th>
                                    <th>GOLES</th>
                                    <th>AMARILLA</th>
                                    <th>AZUL</th>
                                    <th>ROJA</th>
                                    <th></th>
                                    </tr>
                                </thead>
                            </table>
                            <div></div>
                        </div>

                        <br>
                        <div class="modal-footer">
                            <div class='form-row'>
                                <a id="btnContinue" class="btn btn-success" onclick = "registrardetalleeditado()">Siguiente</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
        <div id="VentanaJL1Editar" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">
                                <span aria-hidden="true">&times;</span>
                                <span class="sr-only">Cancelar</span>
                            </button>
                            <h4 class="modal-title" id="H3">
                                REGISTRAR DETALLES
                            </h4>
                        </div>
                        <div class="modal-body">
                            <div align="center"><h2><input id='txtcargaequipo2Editar' readonly='readonly' style="border:none"></h2></div>
                            <table id="tableJL1Editar" class="display table table-hover table-bordered jambo_table">
                                <thead>
                                    <tr>
                                    <th>ID</th>
                                    <th>NOMBRE</th>
                                    <th>GOLES</th>
                                    <th>AMARILLA</th>
                                    <th>AZUL</th>
                                    <th>ROJA</th>
                                    <th></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                        <br>
                        <div class="modal-footer">
                            <div class='form-row'>
                                <a id="btnGuardar" class="btn btn-success" name="btnGuardar" onclick = "registrardetalleeditado1()"> Terminar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
        <div id="VerDetalles" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Cancelar</span>
                        </button>
                        <h4 class="modal-title" id="H3" align="center">
                            <p>DETALLES</p>
                        </h4>
                    </div>
                    <table id="tabledetalles" class="display table table-hover table-bordered jambo_table">
                        <thead align="center">
                            <tr>
                            <th colspan="2" align="center" id="CampeonatoDetalle"></th>
                            <th colspan="2" align="center" id="FechaDetalle"></th>
                            </tr>
                        </thead>
                        <tr>
                        <th><h2 align="center"><input id="Equipo1Detalle" readonly style="border:none" type="text" align="center"></h2></th>
                        <th><h2 align="center"><input id="GolesE1Detalle" readonly style="border:none" type="text" align="center" size="2"></h2></th>
                        <th><h2 align="center"><input id="GolesE2Detalle" readonly style="border:none" type="text" align="center" size="2"></h2></th>
                        <th><h2 align="center"><input id="Equipo2Detalle" readonly style="border:none" type="text" align="center"></h2></th>
                        </tr>
                        <tr>
                        <th colspan="2">
                        
                        <table id="tabledetallesgolese1" class="display table table-hover table-bordered jambo_table">
                            <thead>
                                <th>NOMBRE</th>
                                <th>GOLES</th>
                                <th>AMARILLA</th>
                                <th>AZUL</th>
                                <th>ROJA</th>
                            </thead>
                        </table>
                        </th>
                        <th colspan="2">
                        
                        <table id="tabledetallesgolese2" class="display table table-hover table-bordered jambo_table">
                            <thead>
                                <th>NOMBRE</th>
                                <th>GOLES</th>
                                <th>AMARILLA</th>
                                <th>AZUL</th>
                                <th>ROJA</th>
                            </thead>
                        </table>
                        </th>
                        </tr>
                    </table> 
                    <br><br><br><br><br><br><br>
                    <div class="modal-footer">
                        <div class='form-row'>
                            <a id="btnContinuar" class="btn btn-success" onclick = "terminarconsulta()"> Salir </a>
                            </div>
                    </div>
                </div>
            </div>
        </div>

        
            <div id="dvResultado"></div>
            <?php
        } else {
            ?><script type='text/javascript'>redireccionarInicio();</script>
            <?php
        }
        include("Footer.php");


        