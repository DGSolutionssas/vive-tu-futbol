<?php

/**
 * Controla la logica de Negocio de los Campeonatos
 * @author Diego Saavedra
 * @created 25/12/2016
 * @copyright DG Solutions sas
 */
if (isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];
    require_once('../DA/CampeonatosDA.php');
    require_once('../DTO/CampeonatosDTO.php');
    $db = new CampeonatosDA();
    $dtoCampeonato = new CampeonatosDTO();

    switch ($action) {
        case 'obtenerCampeonatos' :
            $campeonatos = $db->obtenerCampeonatos();
            $arrayCampeonatos = array();
            for ($i = 0; $i < count($campeonatos); $i++) {
                $arrayCampeonatos[$i]['IdCampeonato'] = $campeonatos[$i]['IdCampeonato'];
                $arrayCampeonatos[$i]['Campeonato'] = $campeonatos[$i]['Campeonato'];
                $arrayCampeonatos[$i]['Descripcion'] = $campeonatos[$i]['Descripcion'];
                $arrayCampeonatos[$i]['Grupos'] = $campeonatos[$i]['Grupos'];
                $arrayCampeonatos[$i]['Equipos'] = $campeonatos[$i]['Equipos'];
                $arrayCampeonatos[$i]['CantidadJugadores'] = $campeonatos[$i]['CantidadJugadores'];
            }
            echo json_encode($arrayCampeonatos);
            break;
        case 'registrarCampeonato':
            $dtoCampeonato->setCampeonato($_POST['campeonato']);
            $dtoCampeonato->setDescripcion($_POST['descripcion']);
            $dtoCampeonato->setGrupos($_POST['grupos']);
            $dtoCampeonato->setEquipos($_POST['equipos']);
            $dtoCampeonato->setCantidadJugadores($_POST['cantidadjugadores']);
            $campeonatos = $db->guardarCampeonato($dtoCampeonato);
            break;
        case 'consultarGruposCampeonato':
            $gruposCampeonatos = $db->obtenerGruposCampeonato($_POST['idCampeonato']);
            $arrayGrupos = array();
            for ($i = 0; $i < count($gruposCampeonatos); $i++) {
                $arrayGrupos[$i]['Grupos'] = $gruposCampeonatos[$i]['Grupos'];
            }
            echo json_encode($arrayGrupos, JSON_FORCE_OBJECT);
            break;
        case 'autoCompletarCampeonato':
            $campeonato = $_POST['term'];
            $list = $db->autocompletarCampeonato($campeonato);
            echo json_encode($list);
            break;
        case 'eliminarCampeonato':
            $campeonatos = $db->eliminarCampeonato($_POST['IdCampeonato']);
            echo '{"error": "2", "descripcion": "Se elimino correctamente el Campeonato"}';
            break;
        case 'editarCampeonato':
            $dtoCampeonato->setIdCampeonato($_POST['idCampeonato']);
            $dtoCampeonato->setCampeonato($_POST['campeonato']);
            $dtoCampeonato->setDescripcion($_POST['descripcion']);
            $dtoCampeonato->setGrupos($_POST['grupos']);
            $dtoCampeonato->setEquipos($_POST['equipos']);
            $dtoCampeonato->setCantidadJugadores($_POST['cantidadJugadores']);
            $campeonatos=$db->actualizarCampeonato($dtoCampeonato);
            break;
    }
}
