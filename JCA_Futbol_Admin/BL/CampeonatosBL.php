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
            }
            echo json_encode($arrayCampeonatos);
            break;
        case 'registrarCampeonato':
            $dtoCampeonato->setCampeonato($_POST['campeonato']);
            $dtoCampeonato->setDescripcion($_POST['descripcion']);
            $dtoCampeonato->setGrupos($_POST['grupos']);
            $dtoCampeonato->setEquipos($_POST['equipos']);
            $campeonatos = $db->guardarCampeonato($dtoCampeonato);
            break;
    }
}
