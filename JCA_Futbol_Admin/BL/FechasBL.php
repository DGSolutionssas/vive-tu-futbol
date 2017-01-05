<?php

/**
 * Controla la logica de Negocio de las Fechas
 * @author Diego Saavedra
 * @created 25/12/2016
 * @copyright DG Solutions sas
 */
if (isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];
    require_once('../DA/FechasDA.php');
    $db = new FechasDA();
    switch ($action) {
        case 'obtenerFechas' :
            $fechas = $db->obtenerFechas();
            $arrayfechas = array();
            for ($i = 0; $i < count($fechas); $i++) {
                $arrayfechas[$i]['idfecha'] = $fechas[$i]['idfecha'];
                $arrayfechas[$i]['nombrefecha'] = $fechas[$i]['nombrefecha'];
                $arrayfechas[$i]['fecha'] = $fechas[$i]['fecha'];
                $arrayfechas[$i]['Campeonato'] = $fechas[$i]['Campeonato'];
            }
            echo json_encode($arrayfechas);
            break;
        case 'registrarFecha':
            $equipo = $db->registrarFecha($_POST['idCampeonato'], $_POST['nombreFecha'],$_POST['fecha']);
        break;
		case 'eliminarFecha':
            $fechas = $db->eliminarFecha($_POST['idFechaEliminar']);
            echo '{"error": "2", "descripcion": "Se elimino correctamente la Fecha"}';
        break;
    }
}