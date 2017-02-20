<?php

/**
 * Conexion a la BD para generar las Plantillas
 * @author Diego Saavedra
 * @created 07/01/2017
 * @copyright DG Solutions sas
 */
class PlantillasDA {

    private $db;

    function __construct() {
        require_once 'Connect.php';
        $this->db = new Connect();
    }

    function obtenerJugadores($idCampeonato, $idEquipo1, $idEquipo2) {
        $query = "SELECT J.idJugador as IdJugador, J.Documento as Cedula, J.NombreJugador as Nombre, E.Nombre as Equipo
		FROM tblequiposjugadores EJ
		INNER JOIN equipos E ON EJ.IdEquipo=E.idEquipo
		INNER JOIN jugador J ON EJ.idJugador=J.IdJugador
        WHERE E.idCampeonato=$idCampeonato AND E.idEquipo IN ($idEquipo1,$idEquipo2) ORDER BY E.idEquipo DESC;";
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
