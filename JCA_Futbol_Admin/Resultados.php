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
                        <div class='input-result'>
                            <label class='control-label'>Equipo 2:</label>
                            <input autocomplete="off" type="text" id="txtIdEquipo2" name="txtIdEquipo2" data-parsley-required data-parsley-required-message="Dato Requerido." data-parsley-group="block1" class="form-control">
                        </div>
                        <div class='input-score'>
                            <label class='control-label'>Goles:</label>
                            <input autocomplete="off" type="number" id="txtGoles2" name="txtGoles2" data-parsley-required data-parsley-required-message="Dato Requerido." data-parsley-group="block1" class="form-control">
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
                                    <th>T. AMARILLA</th>
                                    <th>T. AZUL</th>
                                    <th>T. ROJA</th>
                                    <th></th>
                                    </tr>
                                </thead>
                            </table>
                            <div></div>
                        </div>

                        <br>
                        <div class="modal-footer">
                            <div class='form-row'>
                                <a id="btnContinue" class="btn btn-success" onclick = "cargartablaJL1()">Siguiente</a>
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
                            <div align="center"><h2><input id='txtcargaequipo2' readonly='readonly' style="border:none"></h2></div><table id="tableJL1" class="display table table-hover table-bordered jambo_table">
                                <thead>
                                    <tr>
                                    <th>ID</th>
                                    <th>NOMBRE</th>
                                    <th>GOLES</th>
                                    <th>T. AMARILLA</th>
                                    <th>T. AZUL</th>
                                    <th>T. ROJA</th>
                                    <th></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                        <br>
                        <div class="modal-footer">
                            <div class='form-row'>
                                <a id="btnGuardar" class="btn btn-success" name="btnGuardar" onclick = "terminarregistro()"> Terminar</a>
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


        