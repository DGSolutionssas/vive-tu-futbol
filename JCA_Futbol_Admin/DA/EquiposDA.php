<?php

/**
 * Conexion a la BD para el objeto Equipos
 * @author Diego Saavedra
 * @created 25/12/2016
 * @copyright DG Solutions sas
 */
class EquiposDA {

    private $db;

    function __construct() {
        require_once 'Connect.php';
        $this->db = new Connect();
    }

    function obtenerEquipos() {
        $query = "SELECT E.idEquipo AS IdEquipo, C.Campeonato AS Campeonato, E.Nombre AS Nombre, E.Descripcion AS Descripcion, E.Puntos AS Puntos, E.Grupo AS Grupo FROM equipos E INNER JOIN campeonatos C ON E.idCampeonato=C.idCampeonato";
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

}
