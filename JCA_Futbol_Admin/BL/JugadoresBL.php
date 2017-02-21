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
                $arrayJugadores[$i]['DT'] = "<input type='checkbox' id='cbox0'  ".$Jugadores[$i]['DT']." disabled readonly>";
                //$arrayJugadores[$i]['DT'] = "<input type='checkbox' id='cbox0'  disabled readonly>";
                $arrayJugadores[$i]['Delegado'] = "<input type='checkbox' id='cbox1'  ".$Jugadores[$i]['Delegado']." disabled readonly>";
                $arrayJugadores[$i]['RepresentanteLegal'] = "<input type='checkbox' id='cbox2'  ".$Jugadores[$i]['RepresentanteLegal']." disabled readonly>";
                //$arrayJugadores[$i]['DT'] = $Jugadores[$i]['DT'];
                //$arrayJugadores[$i]['Delegado'] = $Jugadores[$i]['Delegado'];
                //$arrayJugadores[$i]['RepresentanteLegal'] = $Jugadores[$i]['RepresentanteLegal'];
                if(strlen($Jugadores[$i]['Url']) > 0)
                {
                     $arrayJugadores[$i]['Url'] = "<img src='Uploads/".$Jugadores[$i]['Url']."' class='img-circle profile_img2'>";
                }
                else
                {
                    $arrayJugadores[$i]['Url'] = "<img src='img/user.png' class='img-circle profile_img2'>";
                }

            }
            echo json_encode($arrayJugadores);
            break;
        case 'eliminarJugador':
            $Jugadores = $db->eliminarJugador($_POST['idJugadorEliminar']);
            echo '{"error": "2", "descripcion": "Se elimino correctamente el Jugador"}';
            break;
        case 'ActualizarJugador':
            $Jugadores = $db->ActualizarJugador($_POST['idJugadorEditar'], $_POST['NombreJugadorEditar'], $_POST['DocumentoEditar'], $_POST['CorreoElectronicoEditar'], $_POST['CelularEditar'], $_POST['DTEditar'], $_POST['DelegadoEditar'], $_POST['RepresentanteLegalEditar'], $_POST['UrlEditar']);
            break;
        case 'registrarJugador':
            $Jugadores = $db->registrarJugador($_POST['NombreJugador'], $_POST['Documento'], $_POST['CorreoElectronico'], $_POST['Celular'], $_POST['DT'], $_POST['Delegado'], $_POST['RepresentanteLegal'], $_POST['Url'],$_POST['idEquipoSeleccionado']);
            break;
        case 'AutoCompletarEquipos':
            $Equipo = $_POST['term'];
            $Equipos = $db->AutoCompletarEquipos($_POST['idCampeonato'],$Equipo);
            echo json_encode($Equipos);
            break;
        case 'consultarEquipos':
            $Equipos = $db->ConsultarEquipos($_POST['idCampeonato']);
            echo json_encode($Equipos);
            break;
        case 'obtenerJugadoresFlitro' :

            $Jugadores = $db->obtenerJugadoresFiltro($_POST['idEquipo']);
            $arrayJugadores = array();
            for ($i = 0; $i < count($Jugadores); $i++) {
                $arrayJugadores[$i]['IdJugador'] = $Jugadores[$i]['IdJugador'];
                $arrayJugadores[$i]['NombreJugador'] = $Jugadores[$i]['NombreJugador'];
                $arrayJugadores[$i]['Documento'] = $Jugadores[$i]['Documento'];
                $arrayJugadores[$i]['CorreoElectronico'] = $Jugadores[$i]['CorreoElectronico'];
                $arrayJugadores[$i]['Celular'] = $Jugadores[$i]['Celular'];
                $arrayJugadores[$i]['DT'] = "<input type='checkbox' id='cbox0'  ".$Jugadores[$i]['DT']." disabled readonly>";
                //$arrayJugadores[$i]['DT'] = "<input type='checkbox' id='cbox0'  disabled readonly>";
                $arrayJugadores[$i]['Delegado'] = "<input type='checkbox' id='cbox1'  ".$Jugadores[$i]['Delegado']." disabled readonly>";
                $arrayJugadores[$i]['RepresentanteLegal'] = "<input type='checkbox' id='cbox2'  ".$Jugadores[$i]['RepresentanteLegal']." disabled readonly>";
                //$arrayJugadores[$i]['DT'] = $Jugadores[$i]['DT'];
                //$arrayJugadores[$i]['Delegado'] = $Jugadores[$i]['Delegado'];
                //$arrayJugadores[$i]['RepresentanteLegal'] = $Jugadores[$i]['RepresentanteLegal'];
                if(strlen($Jugadores[$i]['Url']) > 0)
                {
                     $arrayJugadores[$i]['Url'] = "<img src='Uploads/".$Jugadores[$i]['Url']."' class='img-circle profile_img2'>";
                }
                else
                {
                    $arrayJugadores[$i]['Url'] = "<img src='img/user.png' class='img-circle profile_img2'>";
                }

            }
            echo json_encode($arrayJugadores);
            break;
            case 'cantidadJugadores':
                $cantidadJugadores = $db->cantidadJugadores($_POST['idEquipoSeleccionado']);
                $arrayCantidadJugadores = array();
                for ($i = 0; $i < count($cantidadJugadores); $i++) {
                    $arrayCantidadJugadores[$i]['CantidadRegistrados'] = $cantidadJugadores[$i]['CantidadRegistrados'];
                    $arrayCantidadJugadores[$i]['CantidadMaxima'] = $cantidadJugadores[$i]['CantidadMaxima'];
                }
                echo json_encode($arrayCantidadJugadores, JSON_FORCE_OBJECT);
                break;
    }
}
