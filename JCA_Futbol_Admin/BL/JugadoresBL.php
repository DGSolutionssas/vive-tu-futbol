<?php

/**
 * Controla la logica de Negocio de los Equipos
 * @author Sebastian Melo
 * @created 12/01/2017
 * @copyright DG Solutions sas
 */
if (isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];
    require_once('../DA/JugadoresDA.php');
    $db = new JugadoresDA();
    switch ($action) {
        case 'obtenerJugadores' :
            $Jugadores = $db->obtenerJugadores();
            $arrayJugadores = array();
            for ($i = 0; $i < count($Jugadores); $i++) {
                $arrayJugadores[$i]['IdJugador'] = $Jugadores[$i]['IdJugador'];
                $arrayJugadores[$i]['NombreJugador'] = $Jugadores[$i]['NombreJugador'];
                $arrayJugadores[$i]['Documento'] = $Jugadores[$i]['Documento'];
                $arrayJugadores[$i]['CorreoElectronico'] = $Jugadores[$i]['CorreoElectronico'];
                $arrayJugadores[$i]['Celular'] = $Jugadores[$i]['Celular'];
                $arrayJugadores[$i]['DT'] = $Jugadores[$i]['DT'];
                $arrayJugadores[$i]['Delegado'] = $Jugadores[$i]['Delegado'];
                $arrayJugadores[$i]['RepresentanteLegal'] = $Jugadores[$i]['RepresentanteLegal'];
                //$arrayJugadores[$i]['Url'] = $Jugadores[$i]['Url'];
            }
            echo json_encode($arrayJugadores);
            break;   
        case 'eliminarJugador':
            $Jugadores = $db->eliminarJugador($_POST['idJugadorEliminar']);
            echo '{"error": "2", "descripcion": "Se elimino correctamente el Jugador"}';
            break;
        case 'registrarJugador':
            $Jugadores = $db->registrarJugador($_POST['NombreJugador'], $_POST['Documento'], $_POST['CorreoElectronico'], $_POST['Celular'], $_POST['DT'], $_POST['Delegado'], $_POST['RepresentanteLegal'], $_POST['Url']);
            break;
    }
}