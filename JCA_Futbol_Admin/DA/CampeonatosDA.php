<?php

/**
 * Conexion a la BD para el objeto Campeonatos
 * @author Diego Saavedra
 * @created 25/12/2016
 * @copyright DG Solutions sas
 */
class CampeonatosDA {

    private $db;

    function __construct() {
        require_once 'Connect.php';
        $this->db = new Connect();
    }

    function obtenerCampeonatos() {
        $query = "SELECT IdCampeonato, Campeonato, Descripcion, Grupos, Equipos FROM Campeonatos";

        mysqli_set_charset($this->db->Connect(), "utf8");
        $resul = mysqli_query($this->db->Connect(), $query);
        $nrows = mysqli_num_rows($resul);

        $jsonData = array();
        if ($nrows > 0) {
            while ($row = mysqli_fetch_array($resul)) {
                $jsonData[] = $row;
            }
            return $jsonData;
        } else {
            return "";
        }
    }

    function guardarCampeonato($dtoCampeonato) {
        $resul = mysqli_query($this->db->Connect(), "INSERT INTO Campeonatos (Campeonato, Descripcion, Grupos, Equipos) VALUES ("
                . "'" . $dtoCampeonato->getCampeonato() . "',"
                . "'" . $dtoCampeonato->getDescripcion() . "',"
                . "" . $dtoCampeonato->getGrupos() . ","
                . $dtoCampeonato->getEquipos() . ")"
        );
    }

}
