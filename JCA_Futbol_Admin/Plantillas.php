<?php
/**
 * Vista de las plantillas
 * @author Diego Saavedra
 * @created 07/01/2016
 * @copyright DG Solutions sas
 */
session_start();
include_once './Header.php';
if (!empty($_SESSION['autenticado']) && $_SESSION['autenticado'] == true) {
    ?>
    <script type="text/javascript" src="js/custom/plantillas.js"></script>
    <div>
        <br><br><br>
        <div class="jumbotron">
            <div class="form-row">
                <button type="button" class="btn btn-warning" onclick="limpiarPlantilla();"> Limpiar</button>
            </div>
            <div class="form-row">    
                <label class='control-label'>Campeonato:</label>
                <input autocomplete="off" type="text" id="txtCampeonato" name="txtCampeonato" data-parsley-required data-parsley-required-message="Dato Requerido." data-parsley-minlength="4" data-parsley-minlength-message="Minimo 4 Caracateres" data-parsley-group="block1" class="form-control">
            </div>
            <div class="form-row" id="divEquipo1">
                <label class='control-label'>Equipo1:</label>
                <input autocomplete="off" type="text" id="txtEquipo1" name="txtEquipo1" data-parsley-required data-parsley-required-message="Dato Requerido." data-parsley-minlength="4" data-parsley-minlength-message="Minimo 4 Caracateres" data-parsley-group="block1" class="form-control">
            </div>
            <div class="form-row" id="divEquipo2">
                <label class='control-label'>Equipo2:</label>
                <input autocomplete="off" type="text" id="txtEquipo2" name="txtEquipo2" data-parsley-required data-parsley-required-message="Dato Requerido." data-parsley-minlength="4" data-parsley-minlength-message="Minimo 4 Caracateres" data-parsley-group="block1" class="form-control">
            </div>
            <div class="form-row" id="divTipoPlantilla">
                <label class='control-label'>Tipo Plantilla:</label>
                <select id="ddlTipoPlantilla" name="ddlTipoPlantilla" class="form-control">
                    <option value="1">Planilla Futbol5</option>
                    <option value="2">Planilla Futbol8</option>
                    <option value="3">Planilla Futbol5 Empresas</option>
                </select>
            </div>
            </br>
            <div class="form-row" id="divBtnPlantilla">
                <button type="button" class="btn btn-success" onclick="generarPlantilla();"> Generar Plantilla</button>
            </div>
        </div>
        <?php
    } else {
        ?><script type='text/javascript'>redireccionarInicio();</script>
        <?php
    }
    include_once './Footer.php';


    